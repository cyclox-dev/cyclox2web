<?php

/*
 *  created at 2015/10/11 by shun
 */

class RankingPointUnit
{
	public $code = null; // string
	public $rank = 999; // int
	public $rankPt = array(); // int array 集計値を順に持つ
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
	public static $TOTAL_UP;
	
	private static $rules;
	
	public static function rules()
	{
		return self::$rules;
	}
	
	public static function init()
	{
		self::$JCX_156 = new PointSeriesSumUpRule(1, 'JCX156', 'grade2の上位6戦とgrade1のポイントを採用する。合計->自乗和->最近の成績で比較する。');
		self::$KNS_156 = new PointSeriesSumUpRule(2, '合計のみ', '合計点のみ。全戦の成績を採用する。同点の場合は同順位。');
		self::$TOTAL_UP = new PointSeriesSumUpRule(3, '合計のみ', '合計点のみ。全戦の成績を採用する。同点の場合は同順位。');
		
		self::$rules = array(
			self::$JCX_156,
			self::$KNS_156,
			self::$TOTAL_UP
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
	 * @return ランキングと集計ポイント（メソッド冒頭参照）
	 */
	public function calc($racerPointMap = array())
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
			case self::$JCX_156->val(): $ranking = $this->__calcJCX156($racerPointMap); break;
			case self::$KNS_156->val(): $ranking = $this->__calcKNS156($racerPointMap); break;
			case self::$TOTAL_UP->val(): $ranking = $this->__calcTotalUp($racerPointMap); break;
		}
		
		return $ranking;
	}
	
	/**
	 * JCX2015-16 ランキングを集計する
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 */
	public function __calcJCX156($racerPointMap = array())
	{
		
	}
	
	/**
	 * 
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 */
	public function __calcKNS156($racerPointMap = array())
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
	
	public function __calcTotalUp($racerPointMap = array())
	{
		// 2015-1116 に作成した関西の処理で良いかも。
	}
}
PointSeriesSumUpRule::init();