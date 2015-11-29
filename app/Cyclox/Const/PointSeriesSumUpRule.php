<?php

/*
 *  created at 2015/10/11 by shun
 */

class RankingPointUnit
{
	public $code = null; // string
	public $rank = 999; // int
	public $rankPt = array(); // int array 集計値を順に持つ
	
	public $points = array(); // array of int. index は大会インデックス, value['pt'], value['bonus']
}

/**
 * Description of PointSeriesSumUpRule
 *
 * @author shun
 */
class PointSeriesSumUpRule extends Object
{
	public static $JCX_156;
	public static $KNS_156;
	
	private static $rules;
	
	public static function rules()
	{
		return self::$rules;
	}
	
	public static function init()
	{
		self::$JCX_156 = new PointSeriesSumUpRule(1, 'JCX-156', 'hint:required とそれ以外の上位6戦のポイントを採用する。合計->自乗和->最近の成績で比較する。');
		self::$KNS_156 = new PointSeriesSumUpRule(2, '全戦合計のみ', '合計点のみ。全戦の成績を採用する。同点の場合は同順位。');
		
		self::$rules = array(
			self::$JCX_156,
			self::$KNS_156,
		);
	}
	
	//point to をオブジェクト化
	
	/**
	 * 指定値のルールをかえす
	 * @param int $val 固有値（DB 値）
	 * @return PointSeriesSumUpRule 該当値がない場合、null をかえす。
	 */
	public static function ruleAt($val)
	{
		foreach (self::$rules as $rule) {
			if ($rule->val() == $val) {
				return $rule;
			}
		}
		
		return null;
	}
	
	private $val;
	private $title;
	private $description;
	
	public function __construct($v, $t, $d) 
	{
		parent::__construct();
		
		$this->val = $v;
		$this->title = $t;
		$this->description = $d;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->val; }
    /** @return string タイトル */                                                                    
    public function title() { return $this->title; }
    /** @return string ルール内容 */                                            
    public function description() { return $this->description; }
	
	/**
	 * 集計する
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 * @param array $hints $racerPointMap の中のインデックスに対応したヒント
	 * @return ランキングと集計ポイント（メソッド冒頭参照）
	 */
	public function calc($racerPointMap = array(), $hints = array())
	{
		/* パラメタ $racerPointMap は以下の様な array
		array(
			'$code1' => array(array('pt' => 123, 'bonus' => 246), array('pt' => 22)),
			'$code2' => array('pt' => 123, 'bonus' => 246),,,
		);
		
		/* 以下の様な配列をかえす
		array(
			'rank_pt_title' => array(
				'合計', '自乗和'
			),
			'ranking' => array( // sorted
				new RankingPointUnit(),
				new RankingPointUnit(),
			)
		);
		*/
		
		$ranking = null;
		switch ($this->val()) {
			case self::$JCX_156->val(): $ranking = $this->__calcJCX156($racerPointMap, $hints); break;
			case self::$KNS_156->val(): $ranking = $this->__calcKNS156($racerPointMap, $hints); break;
			case self::$TOTAL_UP->val(): $ranking = $this->__calcTotalUp($racerPointMap, $hints); break;
		}
		
		return $ranking;
	}
	
	/**
	 * JCX2015-16 ランキングを集計する
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 */
	public function __calcJCX156($racerPointMap = array(), $hints = array())
	{
		$requiredIndices = array();
		for ($i = 0; $i < count($hints); $i++) {
			$hint = $hints[$i];
			$requiredIndices[] = $this->_requiredMeetPS($hint);
		}
		
		$rankPtUits = array();
		foreach ($racerPointMap as $rcode => $points) {
			$rpUnit = new RankingPointUnit();
			$rpUnit->code = $rcode;
			
			$pt = 0;
			$sq = 0;
			$outReqs = array(); // required でないやつら
			
			// 配列の last index から実長さ取得
			end($points);
			$pointsLen = key($points) + 1;
			reset($points);
			
			// required を先に取得
			for ($i = 0; $i < $pointsLen + 1; $i++) {
				if (empty($points[$i])) {
					continue;
				}
				$point = $points[$i];
				if ($requiredIndices[$i]) {
					$pt += $point['pt'] + $point['bonus'];
					$sq += ($point['pt'] + $point['bonus']) * ($point['pt'] + $point['bonus']);
				} else {
					$outReqs[] = $point;
				}
			}
			
			usort($outReqs, array($this, '__comparePoint'));
			
			for ($i = 0; $i < count($outReqs) && $i < 6; $i++) {
				$point = $outReqs[$i];
				$pt += $point['pt'] + $point['bonus'];
				$sq += ($point['pt'] + $point['bonus']) * ($point['pt'] + $point['bonus']);
			}
			
			$rpUnit->rankPt[] = $pt; // index:0 に合計値を格納
			$rpUnit->rankPt[] = $sq; // index:1 に自乗値を格納
			$rpUnit->points = $points; // usort 用にセット
			
			$rankPtUits[] = $rpUnit;
		}
		
		usort($rankPtUits, array($this, '__compareOfJCX156'));
		
		// 順位付け
		$rank = 1;
		for ($i = 0; $i < count($rankPtUits); $i++) {
			$rpUnit = $rankPtUits[$i];
			$rpUnit->rank = $rank;
			++$rank;
		}
		
		$rMap = array();
		$rMap['rank_pt_title'] = array('集計点', '自乗点');
		$rMap['ranking'] = $rankPtUits;
		
		return $rMap;
	}
	
	/**
	 * 集計されるべき meet point series であるかをかえす
	 * @param string $hints カンマで句切られたヒント文字列
	 * @return boolean 集計されるべき meet point series であるか
	 */
	private function _requiredMeetPS($hints)
	{
		if (empty($hints)) {
			return false;
		}
		
		$strs = explode(',', $hints);
		
		foreach ($strs as $s) {
			if ($s === 'required') {
				return true;
			}
		}
		
		return false;
	}
	
	static function __comparePoint($pointA, $pointB)
	{
		if (empty($pointA['pt'])) {
			return -1;
		}
		if (empty($pointB['pt'])) {
			return 1;
		}
		
		return ($pointB['pt'] + $pointB['bonus']) - ($pointA['pt'] + $pointA['bonus']);
	}
	
	static function __compareOfJCX156(RankingPointUnit $a, RankingPointUnit $b)
	{
		// 合計点比較
		if ($a->rankPt[0] != $b->rankPt[0])
		{
			return $b->rankPt[0] - $a->rankPt[0];
		}
		
		// 自乗点比較
		if ($a->rankPt[1] != $b->rankPt[1])
		{
			return $b->rankPt[1] - $a->rankPt[1];
		}
		
		// 一番近い成績での比較
		end($a->points);
		$keyA = key($a->points);
		end($b->points);
		$keyB = key($b->points);
		
		$ret = 0;
		
		// 最近の成績がある方が上
		
		if ($keyA == $keyB) {
			if ($b->points[$keyB]['pt'] == $a->points[$keyA]['pt']) {
				// 最近の成績位置Bが等しく、ポイントも同じならば最近成績が上の方が上
				$ret = $a->points[$keyA]['rank'] - $b->points[$keyB]['rank'];
			} else {
				// 最近の成績ポイントが上の方が上
				$ret = $b->points[$keyB]['pt'] - $a->points[$keyA]['pt'];
			}
		} else {
			$ret = $keyB - $keyA;
		}
		
		reset($a->points);
		reset($b->points);
		
		return $ret;
	}
	
	/**
	 * 
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 */
	public function __calcKNS156($racerPointMap = array(), $hints = array())
	{
		// 選手ごと合計値を計算
		$i = 0;
		$rankPtUits = array();
		foreach ($racerPointMap as $rcode => $points) {
			$rpUnit = new RankingPointUnit();
			$rpUnit->code = $rcode;
			
			//$this->log($points, LOG_DEBUG);
			
			$pt = 0;
			foreach ($points as $point) {
				$pt += $point['pt'] + $point['bonus'];
			}
			$rpUnit->rankPt[] = $pt; // index:0 に合計値を格納
			
			$rankPtUits[] = $rpUnit;
		}
		
		usort($rankPtUits, array($this, '__compareOfKNS156'));
		
		// 順位付け
		$rank = 0;
		$currPt = -999; // 同順位判定用
		$skipCount = 0;
		for ($i = 0; $i < count($rankPtUits); $i++) {
			$rpUnit = $rankPtUits[$i];
			
			if ($rpUnit->rankPt[0] != $currPt) {
				$currPt = $rpUnit->rankPt[0];
				$rank += 1 + $skipCount;
				$skipCount = 0;
			} else {
				++$skipCount;
			}
			
			$rpUnit->rank = $rank;
		}
		
		$rMap = array();
		$rMap['rank_pt_title'] = array('合計');
		$rMap['ranking'] = $rankPtUits;
		
		return $rMap;
	}
	
	static function __compareOfKNS156(RankingPointUnit $a, RankingPointUnit $b)
	{
		return $b->rankPt[0] - $a->rankPt[0];
	}
	
	public function __calcTotalUp($racerPointMap = array(), $hints = array())
	{
		// 2015-1116 に作成した関西の処理で良いかも。
	}
}
PointSeriesSumUpRule::init();