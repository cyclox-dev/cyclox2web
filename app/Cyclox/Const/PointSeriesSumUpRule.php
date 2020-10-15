<?php

/*
 *  created at 2015/10/11 by shun
 */

class RankingPointUnit
{
	public $code = null; // string
	public $rank = 999; // int
	public $rankPt = array(); // int array 集計値を順に持つ
	public $reqIdx = null; // int/nullで未入力
	
	public $points = array(); // array of int. index は大会インデックス, value['pt'], value['bonus']
}

/**
 * Description of PointSeriesSumUpRule
 *
 * @author shun
 */
class PointSeriesSumUpRule extends Object
{
	const HINT_DIV = ',';
	const HINT_KVDIV = ':';
	const KEY_JCX156_SUMUP_RACE_COUNT = 'race_count';
	const KEY_JCX201_SUMUP_RACE_PER = 'race_per';
	const KEY_JCX201_SUMUP_RACE_COUNT_MIN = 'race_count_min';
	const KEY_REQUIRED = 'required';
	
	public static $JCX_156;
	public static $KNS_156;
	public static $JCX_201;
	
	private static $rules;
	
	public static function rules()
	{
		return self::$rules;
	}
	
	public static function init()
	{
		$keyTitle = self::KEY_JCX156_SUMUP_RACE_COUNT;
		$str = '2015-16シーズンの JCX シリーズにて採用された集計方法。</br>'
				. 'シリーズレース設定の hint に required が入力されているレースでのポイントは必ず獲得ポイントとなる。</br>'
				. 'その他の上位x戦のポイントが獲得ポイントとされる。x の値はシリーズ設定の hint において key 値 '
				. $keyTitle . 'で指定された値である。</br>'
				. '例）上位3戦ならば ' . $keyTitle . self::HINT_KVDIV . '3 と入力</br>'
				. '順位付けで同順位は無く、以下の順に判断される。</br>'
				. '・獲得ポイント</br>'
				. '・自乗点</br>'
				. '・出場しポイントを獲得したレースがより最近であるか</br>'
				. '・最近のポイント獲得レースでの獲得ポイント</br>'
				. '・最近のポイント獲得レースでの順位';
		self::$JCX_156 = new PointSeriesSumUpRule(1, 'JCX-156'
				, 'hint:' . self::KEY_REQUIRED . ' とそれ以外の上位x戦のポイントを採用する。合計->自乗和->最近の成績で比較する。'
				, $str);
		
		$str = '2015-16シーズンに関西クロスで採用された集計方法</br>'
				. '全ての大会の獲得ポイントを合計する。同点の場合には同じ順位となる。';
		self::$KNS_156 = new PointSeriesSumUpRule(2, '全戦合計のみ'
				, '合計点のみ。全戦の成績を採用する。同点の場合は同順位。', $str);
		
		$keyTitle = self::KEY_JCX201_SUMUP_RACE_PER;
		$str = '2020-21シーズンの JCX シリーズにて採用された集計方法。</br>'
				. 'シリーズレース設定の hint に required が入力されているレースでのポイントは必ず獲得ポイントとなる。</br>'
				. 'required は1つのみに設定すること（同日開催レースで選手が複数のレースに出場不可能な場合は除く。全日本のエリート、U23など。）</br>'
				. 'その他の、対象レース数のx%にあたるレースのポイントが獲得ポイントとされる。x の値はシリーズ設定の hint において key 値 '
				. $keyTitle . 'で指定された値である（小数点は切り上げ）。</br>'
				. '例）60%戦ならば ' . $keyTitle . self::HINT_KVDIV . '60 と入力</br>'
				. 'ただし required を除くレースの数がy以下の場合は集計対象は100%となる。</br>'
			. 'y の値はシリーズ設定の hint において key 値' . self::KEY_JCX201_SUMUP_RACE_COUNT_MIN . 'で指定された値である。</br>'
			. '例）60%戦、最低3レースならば' . $keyTitle . self::HINT_KVDIV . '60' . self::HINT_DIV . self::KEY_JCX201_SUMUP_RACE_COUNT_MIN . self::HINT_KVDIV . '3 と入力</br>'
				. '順位付けで同順位は無く、以下の順に判断される。</br>'
				. '・獲得ポイント</br>'
				. '・required レースのポイント、順位</br>'
				. '・出場しポイントを獲得したレースがより最近であるか</br>'
				. '・最近のポイント獲得レースでの獲得ポイント</br>'
				. '・最近のポイント獲得レースでの順位';
		self::$JCX_201 = new PointSeriesSumUpRule(3, 'JCX2021'
				, 'hint:' . self::KEY_REQUIRED . ' とそれ以外のx%戦のポイントを採用する。合計->自乗和->最近の成績で比較する。', $str);
		
		self::$rules = array(
			self::$JCX_156,
			self::$KNS_156,
			self::$JCX_201
		);
	}
	
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
	private $text;
	
	public function __construct($v, $t, $d, $text) 
	{
		parent::__construct();
		
		$this->val = $v;
		$this->title = $t;
		$this->description = $d;
		$this->text = $text;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->val; }
    /** @return string タイトル */                                                                    
    public function title() { return $this->title; }
    /** @return string ルール内容 */                                            
    public function description() { return $this->description; }
	/** @return string ルール内容詳細 */                                            
    public function text() { return $this->text; }
	
	/**
	 * 集計する
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 * @param array $hints $racerPointMap の中のインデックスに対応したヒント
	 * @param string $seriesHint ポイントシリーズに設定されたヒント
	 * @param int $helds 実際に開催されたか。インデックスは $hints とそろう。
	 * @return ランキングと集計ポイント（メソッド冒頭参照）
	 */
	public function calc($racerPointMap = array(), $hints = array(), $seriesHint = "", $helds = array())
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
			case self::$JCX_156->val(): $ranking = $this->__calcJCX156($racerPointMap, $hints, $seriesHint); break;
			case self::$KNS_156->val(): $ranking = $this->__calcKNS156($racerPointMap, $hints, $seriesHint); break;
			case self::$JCX_201->val(): $ranking = $this->__calcJCX201($racerPointMap, $hints, $seriesHint, $helds); break;
		}
		
		return $ranking;
	}
	
	/**
	 * JCX2015-16 ランキングを集計する
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 */
	public function __calcJCX156($racerPointMap = array(), $hints = array(), $seriesHint = "")
	{
		$requiredIndices = array();
		for ($i = 0; $i < count($hints); $i++) {
			$hint = $hints[$i];
			$requiredIndices[] = $this->_requiredMeetPS($hint);
		}
		
		$shint = self::getSeriesHints($seriesHint);
		$maxSumupRaceCount = $this->__getJcxMaxRaceCount($shint);
		
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
			
			for ($i = 0; $i < count($outReqs) && $i < $maxSumupRaceCount; $i++) {
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
	 * ヒント文字列からヒント配列を得る
	 * @param string $str ヒント文字列 key1:value1,key2:value2,,, と並んでいる
	 * @return $str を配列化したもの
	 */
	public static function getSeriesHints($str)
	{
		if (empty($str)) {
			return array();
		}
		
		$list = explode(self::HINT_DIV, $str);
		$rList = array();
		
		foreach ($list as $val) {
			$vals = explode(self::HINT_KVDIV, $val);
			if (count($vals) > 1) {
				$rList[$vals[0]] = $vals[1];
			} else {
				$rList[] = $vals[0];
			}
		}
		
		return $rList;
	}
	
	/**
	 * series hint から JCX の集計最大レース数（require を除く）をかえす。
	 * @param array $seriesHint 
	 * @return int もし最大レース数が見つからない場合、int の最大値をかえす。
	 */
	private function __getJcxMaxRaceCount($seriesHint)
	{
		$maxCount = PHP_INT_MAX;
		
		if (is_array($seriesHint)) {
			if (array_key_exists(self::KEY_JCX156_SUMUP_RACE_COUNT, $seriesHint)) {
				$val = $seriesHint[self::KEY_JCX156_SUMUP_RACE_COUNT];
				if (is_numeric($val)) { // <-- is_int() は使えない
					$maxCount = intval($val);
				}
			}
		}
		
		return $maxCount;
	}
	
	/**
	 * series hint から JCX の集計最大レース数パーセント（require を除く）をかえす。
	 * @param array $seriesHint 
	 * @return int もし最大レース数が見つからない場合、100をかえす。
	 */
	private function __getJcxMaxRacePer($seriesHint)
	{
		$maxCount = 100;
		
		if (is_array($seriesHint)) {
			if (array_key_exists(self::KEY_JCX201_SUMUP_RACE_PER, $seriesHint)) {
				$val = $seriesHint[self::KEY_JCX201_SUMUP_RACE_PER];
				if (is_numeric($val)) { // <-- is_int() は使えない
					$maxCount = intval($val);
				}
			}
		}
		
		return $maxCount;
	}
	
	/**
	 * series hint から JCX の集計最小レース数をかえす。
	 * @param array $seriesHint 
	 * @return int もし最小レース数が見つからない場合、0をかえす。
	 */
	private function __getJcxMinRaceCountMin($seriesHint)
	{
		$minCount = 0;
		
		if (is_array($seriesHint)) {
			if (array_key_exists(self::KEY_JCX201_SUMUP_RACE_COUNT_MIN, $seriesHint)) {
				$val = $seriesHint[self::KEY_JCX201_SUMUP_RACE_COUNT_MIN];
				if (is_numeric($val)) { // <-- is_int() は使えない
					$minCount = intval($val);
				}
			}
		}
		
		return $minCount;
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
			if ($s === self::KEY_REQUIRED) {
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
	
	static function __compareOfJCX201(RankingPointUnit $a, RankingPointUnit $b)
	{
		// 合計点比較
		if ($a->rankPt[0] != $b->rankPt[0])
		{
			return $b->rankPt[0] - $a->rankPt[0];
		}
		
		// required 大会のポイント、順位比較（同日エリート,U23 の場合には単純に順位比較できない）
		if (!is_null($a->reqIdx)) {
			if (is_null($b->reqIdx)) {
				return -1;
			} else {
				$pta = $a->points[$a->reqIdx]['pt'];
				$ptb = $b->points[$b->reqIdx]['pt'];
				if ($pta == $ptb) {
					// ポイント同じ場合には順位が上
					return $a->points[$a->reqIdx]['rank'] - $b->points[$b->reqIdx]['rank'];
				} else {
					return $b->points[$b->reqIdx]['pt'] - $a->points[$a->reqIdx]['pt'];
				}
			}
		} else if (!is_null($b->reqIdx)) {
			return 1;
		}
		
		// 一番近い成績での比較
		
		end($a->points);
		$keyA = key($a->points);
		end($b->points);
		$keyB = key($b->points);
		
		$ret = 0;
		
		if ($keyA == $keyB) {
			if ($b->points[$keyB]['pt'] == $a->points[$keyA]['pt']) {
				// 最近の成績位置Bが等しく、ポイントも同じならば最近成績が上の方が上
				$ret = $a->points[$keyA]['rank'] - $b->points[$keyB]['rank'];
			} else {
				// 最近の成績ポイントが上の方が上
				$ret = $b->points[$keyB]['pt'] - $a->points[$keyA]['pt'];
			}
		} else {
			// 最近の成績がある方が上
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
	public function __calcKNS156($racerPointMap = array(), $hints = array(), $seriesHint = "")
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
	
	/**
	 * JCX2020-21 ランキングを集計する
	 * @param type $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 * @param array $hints ポイントシリーズ大会設定ごとのヒントテキストが入っている
	 */
	public function __calcJCX201($racerPointMap = array(), $hints = array(), $seriesHint = "", $helds = array())
	{
		// required 大会を1つのみと前提していることに注意。
		
		$requiredIndices = array();
		$reqs = 0;
		$actMeet = 0; // 実際に開催されたレース数（required を除く）
		for ($i = 0; $i < count($hints); $i++) {
			$hint = $hints[$i];
			$isreq = $this->_requiredMeetPS($hint);
			$requiredIndices[] = $isreq;
			if ($isreq) {
				$reqs++;
			} else {
				if ($helds[$i]) ++$actMeet;
			}
		}
		
		$shint = self::getSeriesHints($seriesHint);
		$maxSumupRacePer = $this->__getJcxMaxRacePer($shint);
		$minSumupRaceCount = $this->__getJcxMinRaceCountMin($shint);
		
		$sumupLimit = ceil($actMeet * $maxSumupRacePer * 0.01);
		if ($sumupLimit < $minSumupRaceCount) $sumupLimit = $minSumupRaceCount;
		$this->log('sumup' . $actMeet, LOG_DEBUG);
		$rankPtUits = array();
		
		foreach ($racerPointMap as $rcode => $points) {
			$rpUnit = new RankingPointUnit();
			$rpUnit->code = $rcode;
			
			$pt = 0;
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
					$rpUnit->reqIdx = $i;
				} else {
					$outReqs[] = $point;
				}
			}
			
			usort($outReqs, array($this, '__comparePoint'));
			
			for ($i = 0; $i < count($outReqs) && $i < $sumupLimit; $i++) {
				$point = $outReqs[$i];
				$pt += $point['pt'] + $point['bonus'];
			}
			
			$rpUnit->rankPt[] = $pt; // index:0 に合計値を格納
			
			$rpUnit->points = $points; // usort 用にセット
			$rankPtUits[] = $rpUnit;
		}
		
		usort($rankPtUits, array($this, '__compareOfJCX201'));
		
		// 順位付け
		$rank = 1;
		for ($i = 0; $i < count($rankPtUits); $i++) {
			$rpUnit = $rankPtUits[$i];
			$rpUnit->rank = $rank;
			++$rank;
		}
		
		$rMap = array();
		$rMap['rank_pt_title'] = array('集計点');
		$rMap['ranking'] = $rankPtUits;
		
		return $rMap;
	}
}
PointSeriesSumUpRule::init();