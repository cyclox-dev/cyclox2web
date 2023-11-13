<?php

/*
 *  created at 2015/10/11 by shun
 */

class RankingPointUnit
{
	// MEMO 無効な数値として例えば PHP_INT_MIN などを使用すると、compare() 関メソッド内で演算があったときにオーバーフローして正しい結果にならないため、99999 を利用する。
	
	public $code = null; // string
	public $rank = 99999; // int
	public $rankPt = array(); // int array 集計値を順に持つ
	
	public $reqPt = -99999;
	public $reqRank = 99999;
	public $maxPtNonReq = -99999;
	public $maxPt = -99999;
	public $maxPtDate = null;
	public $maxRank = 99999;
	public $lastResultDate = null;
	public $lastResultPt = -99999;
	public $lastResultRank = -99999;
	
	public $points = array(); // array of int. index は大会インデックス, value['pt'], value['bonus']
}

/**
 * Description of PointSeriesSumUpRule
 *
 * @author shun
 */
class PointSeriesSumUpRule extends CakeObject
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
	public static $JCX_212;
	public static $JCF_234;
	
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
		
		$keyTitle = self::KEY_JCX201_SUMUP_RACE_PER;
		$str = '2020-21シーズンの JCX シリーズにて採用された集計方法。</br>'
				. 'シリーズレース設定の hint に ' . self::KEY_REQUIRED . ' が入力されているレースでのポイントは必ず獲得ポイントとなる。</br>'
				. self::KEY_REQUIRED . ' は1つのみに設定すること（同日開催レースで選手が複数のレースに出場不可能な場合は除く。全日本のエリート、U23など。）</br>'
				. 'その他の、対象レース数のx%にあたるレースのポイントが獲得ポイントとされる。x の値はシリーズ設定の hint において key 値 '
				. $keyTitle . 'で指定された値である（小数点は切り上げ）。</br>'
				. '例）60%戦ならば ' . $keyTitle . self::HINT_KVDIV . '60 と入力</br>'
				. 'ただし ' . self::KEY_REQUIRED . ' を除くレースの数がy以下の場合は集計対象は100%となる。</br>'
				. 'また、未来にある大会の数を集計対象としたい場合（上の例だと60％の母数に含めたい場合）は、ポイントの開始日を大会翌日ではなく、ポイントシリーズが所属するシーズンのはじめの日(4/1)に設定すること。</br>'
			. 'y の値はシリーズ設定の hint において key 値' . self::KEY_JCX201_SUMUP_RACE_COUNT_MIN . 'で指定された値である。</br>'
			. '例）60%戦、最低3レースならば' . $keyTitle . self::HINT_KVDIV . '60' . self::HINT_DIV . self::KEY_JCX201_SUMUP_RACE_COUNT_MIN . self::HINT_KVDIV . '3 と入力</br>'
				. '以下の順に判断される。それでも判断できない場合は同順位。</br>'
				. '・獲得ポイント</br>'
				. '・' . self::KEY_REQUIRED . ' レースでの獲得ポイント</br>'
				. '・' . self::KEY_REQUIRED . ' でないレースでの最高獲得ポイント</br>'
				. '・最終獲得レース日が近い方。そのレースが同じ日付の場合、そのレースでの獲得ポイント';
		self::$JCX_212 = new PointSeriesSumUpRule(4, 'JCX21-22'
				, 'hint:' . self::KEY_REQUIRED . ' とそれ以外のx%戦のポイントを採用する。合計->最高点数で比較する。', $str);
				
		$str = '2023-24シーズンの JCF シリーズで採用された集計方法。</br>'
				. 'シリーズ戦として指定された全ての大会の獲得ポイントを合計する。同点の場合は既に得た成績を下記の優先順で比較する。</br>'
				. '1.　より高いポイントを得ている</br>'
				. '2.　1をより高い順位で得ている</br>'
				. '3.　1をより直近の大会で得ている</br>';
		self::$JCF_234 = new PointSeriesSumUpRule(5, 'JCF23-24' , '全戦の合計ポイントで集計する。合計->ポイント->順位->直近の大会成績で比較。', $str);
		
		self::$rules = array(
			self::$JCX_156,
			self::$KNS_156,
			self::$JCX_201,
			self::$JCX_212,
			self::$JCF_234,
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
			case self::$JCX_212->val(): $ranking = $this->__calcJCX212($racerPointMap, $hints, $seriesHint, $helds); break;
			case self::$JCF_234->val(): $ranking = $this->__calcJCF234($racerPointMap, $hints, $seriesHint, $helds); break;
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
				
				// lastXXX を更新
				$rpUnit->lastResultDate = $point['at'];
				$rpUnit->lastResultPt = $point['pt'] + $point['bonus'];
				$rpUnit->lastResultRank = $point['rank'];
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
		
		// 順位付け（同順位は無いため、純増で順位を付与する。）
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
	
	/**
	 * ならびかえ用。ポイントの高い順に並び替える。
	 * @param type $pointA
	 * @param type $pointB
	 * @return int
	 */
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

	/**
	 * ならびかえ用。順位の高い順に並び替える。
	 * @param type $pointA
	 * @param type $pointB
	 * @return int
	 */
	static function __compareRank($pointA, $pointB)
	{
		if (empty($pointA['rank'])) {
			return -1;
		}
		if (empty($pointB['rank'])) {
			return 1;
		}
		
		return ($pointA['rank']) - ($pointB['rank']);
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
		
		// 最近の成績がある方が上
		
		// 日付近い方
		if ($a->lastResultDate != $b->lastResultDate) {
			return ($b->lastResultDate > $a->lastResultDate) ? 1 : -1;
		}
		
		// ポイントでの比較
		if ($b->lastResultPt != $a->lastResultPt) {
			return $b->lastResultPt - $a->lastResultPt; 
		}

		// 順位での比較
		if (empty($a->lastResultRank)) {
			if (empty($b->lastResultRank)) {
				return 0;
			} else {
				return 1;
			}
		} else if (empty($b->lastResultRank)) {
			return -1;
		}

		return $a->lastResultRank - $b->lastResultRank;
	}
	
	static function __compareOfJCX201(RankingPointUnit $a, RankingPointUnit $b)
	{
		// 合計点比較
		if ($a->rankPt[0] != $b->rankPt[0])
		{
			return $b->rankPt[0] - $a->rankPt[0];
		}
		
		// required 大会のポイントで比較
		if ($a->reqPt !== $b->reqPt) 
		{
			return $b->reqPt - $a->reqPt;
		}
		
		// required 大会の順位で比較
		if (empty($a->reqRank)) {
			if (empty($b->reqRank)) {
				if ($a->reqRank != $b->reqRank) {
					return $a->reqRank - $b->reqRank;
				} // else continue to next(unlikely)
			} else {
				return 1;
			}
		} else if (empty($b->reqRank)) {
			return -1;
		}
		
		// 一番近い成績での比較
		
		// 最近の成績がある方が上
		
		// 日付近い方
		if ($a->lastResultDate != $b->lastResultDate) {
			return ($b->lastResultDate > $a->lastResultDate) ? 1 : -1;
		}
		
		// ポイントでの比較
		if ($b->lastResultPt != $a->lastResultPt) {
			return $b->lastResultPt - $a->lastResultPt; 
		}

		// 順位での比較
		if (empty($a->lastResultRank)) {
			if (empty($b->lastResultRank)) {
				return 0;
			} else {
				return 1;
			}
		} else if (empty($b->lastResultRank)) {
			return -1;
		}

		return $a->lastResultRank - $b->lastResultRank;
	}
	
	static function __compareOfJCX212(RankingPointUnit $a, RankingPointUnit $b)
	{
		// 合計点比較
		if ($a->rankPt[0] != $b->rankPt[0])
		{
			return $b->rankPt[0] - $a->rankPt[0];
		}
		
		// required 大会のポイントで比較
		if ($a->reqPt != $b->reqPt) 
		{
			return $b->reqPt - $a->reqPt;
		}
		
		// 最大ポイントで比較
		if ($a->maxPtNonReq !== $b->maxPtNonReq)
		{
			return $b->maxPtNonReq - $a->maxPtNonReq;
		}
		
		// 一番近い成績での比較
		
		if ($a->lastResultDate == $b->lastResultDate) {
			return $b->lastResultPt - $a->lastResultPt; // 順位は考慮しない
		}
		
		// 最近の成績がある方が上
		return ($b->lastResultDate > $a->lastResultDate) ? 1 : -1;
	}

	static function __compareOfJCF234(RankingPointUnit $a, RankingPointUnit $b)
	{
		// 合計点比較
		if ($a->rankPt[0] != $b->rankPt[0])
		{
			return $b->rankPt[0] - $a->rankPt[0];
		}
		
		// 最大ポイントで比較
		if ($a->maxPt !== $b->maxPt)
		{
			return $b->maxPt - $a->maxPt;
		}

		// 最大順位で比較
		if ($a->maxRank !== $b->maxRank)
		{
			return $a->maxRank - $b->maxRank;
		}
		
		// 最大ポイントを獲得した日付で比較
		return ($b->maxPtDate > $a->maxPtDate) ? 1 : -1;
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
					$rpUnit->reqPt = $point['pt'] + $point['bonus'];
					$rpUnit->reqRank = $point['rank'];
				} else {
					$outReqs[] = $point;
				}
				
				// lastXXX を更新
				$rpUnit->lastResultDate = $point['at'];
				$rpUnit->lastResultPt = $point['pt'] + $point['bonus'];
				$rpUnit->lastResultRank = $point['rank'];
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
		
		// 順位付け（同順位は無いため、純増で順位を付与する。）
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

	/**
	 * JCX2021-22 ランキングを集計する
	 * @param array(string=>array(int)) $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 * @param array(string) $hints ポイントシリーズ大会設定ごとのヒントテキストが入っている
	 * @param string $seriesHint ポイントシリーズのヒントテキストが入っている
	 * @param array(boolean) 
	 */
	public function __calcJCX212($racerPointMap = array(), $hints = array(), $seriesHint = "", $helds = array())
	{
		// required 大会を1つのみと前提していることに注意。
		
		// 変数内容は
		// $this->log('sumup:' . $actMeet, LOG_DEBUG);
		// といった感じで出力してみましょう！
		
		/* 引数の内容
		 * $racerPointMap = array(
		 *		'STK-189-0002' => { 86, 50,   , 50},
		 *		'KNT-201-0021' => {  3, 12,  2, 20,  0},
		 * );
		 * というように、選手コードをキーとして、獲得ポイントの入った配列が格納されている。
		 * ポイント配列は開催大会順にならんでおり、引数 $helds のインデックスとも対応する。
		 */
		
		$requiredIndices = array(); // 大会のインデックスに応じて、required（集計が必要な）大会であるかどうかが boolean で格納する。
		$actMeet = 0; // 中止として設定されていないレースの数（required を除く）
		
		// 開催数、requred 大会対応などを集計する。
		for ($i = 0; $i < count($hints); $i++) {
			$isreq = $this->_requiredMeetPS($hints[$i]);
			$requiredIndices[] = $isreq;
			if (!$isreq && $helds[$i]) {
				++$actMeet;
			}
		}
		//$this->log('act meet num:' . $actMeet, LOG_DEBUG);
		//$this->log('req indicies:' . print_r($requiredIndices, true), LOG_DEBUG);
		
		// ポイントシリーズのヒント string より設定値の取得 --> 集計大会数の決定
		
		$shint = self::getSeriesHints($seriesHint);  // ヒント string の切り分け
		$maxSumupRacePer = $this->__getJcxMaxRacePer($shint); // ヒントより得られた集計大会数のパーセント
		$minSumupRaceCount = $this->__getJcxMinRaceCountMin($shint); // ヒントより得られた集計対象最低大会数
		
		$sumupLimit = ceil($actMeet * $maxSumupRacePer * 0.01); // パーセントよりカウント対象大会数を取得
		if ($sumupLimit < $minSumupRaceCount) {
			$sumupLimit = $minSumupRaceCount; // 集計最小数により修正
		}
		//$this->log('act meet per:' . $maxSumupRacePer . ' min race num:' . $minSumupRaceCount . ' sumupLimit:' . $sumupLimit, LOG_DEBUG);
		
		// 選手ごとのポイント集計
		
		$rankPtUits = array(); // RankingPointUnit の配列。選手コード、ポイントやらを格納。
		
		foreach ($racerPointMap as $rcode => $points) {
			$rpUnit = new RankingPointUnit();
			$rpUnit->code = $rcode;
			
			$pt = 0; // 集計点用
			$nonReqs = array(); // required でないやつらのポイントをカウント
			
			// 配列の last index から実長さ取得
			// {1=>99, 2=>55} の場合、要素数が2だが、走査したいのは0〜2の3つである。よって count() は不可。
			end($points);
			$pointsLen = key($points) + 1;
			reset($points);
			
			// ひとまずポイント集計
			for ($i = 0; $i < $pointsLen; $i++) {
				if (empty($points[$i])) {
					continue;
				}
				$point = $points[$i];
				if ($requiredIndices[$i]) {
					$pt += $point['pt'] + $point['bonus']; // required を先に取得
					$rpUnit->reqPt = $point['pt'] + $point['bonus'];
				} else {
					$nonReqs[] = $point;
				}
				
				// lastXXX を更新
				$rpUnit->lastResultDate = $point['at'];
				$rpUnit->lastResultPt = $point['pt'] + $point['bonus'];
			}
			
			// required でないポイントを高い順にならびかえ
			usort($nonReqs, array($this, '__comparePoint'));
			
			//$this->log('racer:'. $rcode . ' nonReqs:' . print_r($nonReqs, true), LOG_DEBUG);
			
			// ポイント高い順に集計大会数まで加算
			for ($i = 0; $i < count($nonReqs) && $i < $sumupLimit; $i++) {
				$point = $nonReqs[$i];
				$pt += $point['pt'] + $point['bonus'];
			}
			
			$rpUnit->rankPt[] = $pt; // index:0 にポイント合計値を格納 <-- '集計点'にあたる。
			
			// nonReq な最大点を格納
			if (!empty($nonReqs[0])) {
				$rpUnit->maxPtNonReq = $nonReqs[0]['pt'] + $nonReqs[0]['bonus'];
			}
			
			$rpUnit->points = $points; // usort 用にセット
			$rankPtUits[] = $rpUnit;
			
			//$this->log('racer:'. $rcode . ' rpUnit:' . print_r($rpUnit, true), LOG_DEBUG);
		}
		
		// 集計値、requred 獲得ポイント、最高点での並び替え
		usort($rankPtUits, array($this, '__compareOfJCX212'));
		
		// 順位付け
		$rank = 0;
		$currPt = PHP_INT_MIN; // 同順位判定用
		$currReqPt = PHP_INT_MIN; // 同順位判定用（合計点）
		$currMaxPt = PHP_INT_MIN; // 同順位判定用（最高点）
		$currDate = '1900-01-01'; // 直近大会リザルト比較用
		$currLastResultPt = PHP_INT_MIN; // 同上
		$skipCount = 0; // 同順位時 skip
		
		for ($i = 0; $i < count($rankPtUits); $i++) {
			$rpUnit = $rankPtUits[$i];
			
			$isSameRank = false;
			if ($rpUnit->rankPt[0] == $currPt
					&& $rpUnit->reqPt == $currReqPt
					&& $rpUnit->maxPtNonReq == $currMaxPt)
			{
				$isSameRank = true;
			}
			
			//$this->log(print_r($rpUnit, true), LOG_DEBUG);
			
			// 直近リザルトでのチェック
			if ($isSameRank)
			{
				if ($rpUnit->lastResultDate == $currDate) {
					// 最近の成績ポイントが上の方が上
					$isSameRank = $currLastResultPt == $rpUnit->lastResultPt;
				} else {
					// 最近の成績がある方が上
					$isSameRank = false;
				}
			}
			
			if ($isSameRank) {
				++$skipCount; // rank を変えず skip 蓄積
			} else {
				$currPt = $rpUnit->rankPt[0];
				$currReqPt = $rpUnit->reqPt;
				$currMaxPt = $rpUnit->maxPtNonReq;
				$currDate = $rpUnit->lastResultDate;
				$currLastResultPt = $rpUnit->lastResultPt;
				
				$rank += 1 + $skipCount;
				$skipCount = 0;
			}
			
			$rpUnit->rank = $rank;
		}
		
		$rMap = array();
		$rMap['rank_pt_title'] = array('集計点'); // ランキング表示時用タイトル
		$rMap['ranking'] = $rankPtUits;
		
		return $rMap;
	}

	/**
	 * JCX2023-24 ランキングを集計する
	 * @param array(string=>array(int)) $racerPointMap 選手コードをキー値として、大会獲得順に並んでいる。
	 * @param array(string) $hints ポイントシリーズ大会設定ごとのヒントテキストが入っている
	 * @param string $seriesHint ポイントシリーズのヒントテキストが入っている
	 * @param array(boolean) 
	 */
	public function __calcJCF234($racerPointMap = array(), $hints = array(), $seriesHint = "")
	{
		// 変数内容は
		// $this->log('sumup:' . $actMeet, LOG_DEBUG);
		// といった感じで出力してみましょう！
		
		/* 引数の内容
		 * $racerPointMap = array(
		 *		'STK-189-0002' => { 86, 50,   , 50},
		 *		'KNT-201-0021' => {  3, 12,  2, 20,  0},
		 * );
		 * というように、選手コードをキーとして、獲得ポイントの入った配列が格納されている。
		 * ポイント配列は開催大会順にならんでおり、引数 $helds のインデックスとも対応する。
		 */
		

		 // 選手ごとのポイント集計
		$rankPtUits = array(); // RankingPointUnit の配列。選手コード、ポイントやらを格納。
		foreach ($racerPointMap as $rcode => $points) {
			$rpUnit = new RankingPointUnit();
			$rpUnit->code = $rcode;
			
			$pt = 0; // 集計点用
			$work = array(); // ポイントカウント用のワーキング変数
			
			// 配列の last index から実長さ取得
			// {1=>99, 2=>55} の場合、要素数が2だが、走査したいのは0〜2の3つである。よって count() は不可。
			end($points);
			$pointsLen = key($points) + 1;
			reset($points);
			
			// 合計ポイント集計
			foreach ($points as $point) {
				$pt += $point['pt'] + $point['bonus'];
			}
			$rpUnit->rankPt[] = $pt; // index:0 にポイント合計値を格納 <-- '集計点'にあたる。

			for ($i = 0; $i < $pointsLen; $i++) {
				if (empty($points[$i])) {
					continue;
				}
				$point = $points[$i];
				$work[] = $point; // 最高ポイント,順位比較用 ワーキング変数
			}
			
			// 獲得ポイントを高い順にならびかえ
			usort($work, array($this, '__comparePoint'));
			// 最高ポイントを格納
			if (!empty($work[0])) {
				$rpUnit->maxPt = $work[0]['pt'] + $work[0]['bonus'];
				$rpUnit->maxPtDate = $work[0]['at'];
			}
			//$this->log('racer:'. $rcode . ' work:' . print_r($work, true), LOG_DEBUG);

			// 獲得順位を高い順にならびかえ
			usort($work, array($this, '__compareRank'));
			// 最高ポイントを格納
			if (!empty($work[0])) {
				$rpUnit->maxRank = $work[0]['rank'];
			}
			//$this->log('racer:'. $rcode . ' work:' . print_r($work, true), LOG_DEBUG);
			
			$rpUnit->points = $points; // usort 用にセット
			$rankPtUits[] = $rpUnit;
			//$this->log('racer:'. $rcode . ' rpUnit:' . print_r($rpUnit, true), LOG_DEBUG);
		}
		
		// 集計値、最高点、最高順位での並び替え
		usort($rankPtUits, array($this, '__compareOfJCF234'));
		
		// 順位付け
		$rank = 0;
		for ($i = 0; $i < count($rankPtUits); $i++) {
			$rpUnit = $rankPtUits[$i];
			$rank += 1;
			$rpUnit->rank = $rank;
		}
		
		$rMap = array();
		$rMap['rank_pt_title'] = array('集計点'); // ランキング表示時用タイトル
		$rMap['ranking'] = $rankPtUits;
		
		return $rMap;
	}
}
PointSeriesSumUpRule::init();
