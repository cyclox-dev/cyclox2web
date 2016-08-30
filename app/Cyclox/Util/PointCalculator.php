<?php

App::uses('EntryRacer', 'Model');
App::uses('RacerResultStatus', 'Cyclox/Const');

/*
 *  created at 2015/08/16 by shun
 */

/**
 * Description of PointCalculator
 *
 * @author shun
 */
class PointCalculator extends Object
{
	public static $JCX_156;
	public static $KNS_156;
	
	public static $TABLE_JCX156_GRADE1 = array(
		300, 240, 210, 180, 165, 150, 135, 120, 105, 90, 
		87,  84,  81,  78,  75,  72,  69,  66,  63, 60,
		58,  56,  54,  52,  50,  48,  46,  44,  42, 40,
		39,  38,  37,  36,  35,  34,  33,  32,  31, 30,
		29,  28,  27,  26,  25,  24,  23,  22,  21, 20,
	);
	const RUN_PT_JCX156_GRACE1 = 10; // 51位以下のポイント
	public static $TABLE_JCX156_GRADE2 = array(
		200, 160, 140, 120, 110, 100, 90,  80,  70,  60,
		58,  56,  54,  52,  50,  48,  46,  44,  42,  40,
		39,  38,  37,  36,  35,  34,  33,  32,  31,  30,
		29,  28,  27,  26,  25,  24,  23,  22,  21,  20,
		19,  18,  17,  16,  15,  14,  13,  12,  11,  10,
	);
	const RUN_PT_JCX156_GRACE2 = 5; // 51位以下のポイント
	const JCX156_BONUS_TO156 = 20;
	const JCX156_BONUS_167TO = 10;
	
	public static $TABLE_KNS156 = array(
		200, 160, 140, 120, 110, 100, 90,  80,  70,  60,
		58,  56,  54,  52,  50,  48,  46,  44,  42,  40,
		39,  38,  37,  36,  35,  34,  33,  32,  31,  30,
		29,  28,  27,  26,  25,  24,  23,  22,  21,  20,
		19,  18,  17,  16,  15,  14,  13,  12,  11,  10,
	);
	const RUN_PT_KNS156 = 5;
	
	private static $calculators;
	
	public static function calculators()
	{
		return self::$calculators;
	}
	
	public static function init()
	{
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_JCX156_GRADE1); $i++) {
			$str .= ' ' . self::$TABLE_JCX156_GRADE1[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$str2 = '';
		for ($i = 0; $i < count(self::$TABLE_JCX156_GRADE2); $i++) {
			$str2 .= ' ' . self::$TABLE_JCX156_GRADE2[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str2 .= '</br>';
			}
		}
		$text = '2015-16シーズンの JCX シリーズにて採用されたポイント付与ルール。</br>'
			. 'シリーズレース設定では必ずグレードを指定すること。グレードは 1 もしくは 2 を指定する。</br>'
			. '---</br>'
			. 'Grade1 のポイントテーブルは以下のとおり</br>'
			. $str
			. (count(self::$TABLE_JCX156_GRADE1) + 1) . '位以下:' . self::RUN_PT_JCX156_GRACE1 . '</br>'
			. '---</br>Grade2 のポイントテーブルは以下のとおり</br>'
			. $str2
			. (count(self::$TABLE_JCX156_GRADE2) + 1) . '位以下:' . self::RUN_PT_JCX156_GRACE2 . '</br>'
			. '---</br>'
			. 'また、レースのトップ選手と同一集会で完走した場合、2015-16シーズンは' . self::JCX156_BONUS_TO156
			. 'pt、2016-17シーズン以降は' . self::JCX156_BONUS_167TO . 'pt のボーナスポイントが付与される。'
			;
		self::$JCX_156 = new PointCalculator(1, 'JCX-156', '2015-16 JCX で使用するポイントテーブル。', $text);
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_KNS156); $i++) {
			$str .= ' ' . self::$TABLE_KNS156[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$text = '2015-16シーズンの関西クロス C1, CM1, CL1 で採用されたポイント付与ルール。'
			. '2015-16 JCX シリーズの Grade2 と同じポイントテーブルである。ただし同一周回ボーナスは無し。'
			. 'Grade の指定は必要ない。</br>'
			. '---</br>'
			. 'ポイントテーブル</br>' . $str;
		self::$KNS_156 = new PointCalculator(2, 'KNS-156', '2015-16 関西クロスで使用するポイントテーブル。配点は JCX ポイントと同じ。完走ボーナスは無し。', $text);
		
		self::$calculators = array(
			self::$JCX_156,
			self::$KNS_156,
		);
	}
	
	private $val;
	private $name;
	private $description;
	private $text;
	
	public function __construct($v, $n, $d, $t)
		// private にしたかったが、Object 継承すると public でなければならない。
	{
		parent::__construct();
		
		$this->val = $v;
		$this->name = $n;
		$this->description = $d;
		$this->text = $t;
	}
	
	/** @return int DB 上の記録値 */
    public function val() { return $this->val; }
    /** @return string 名前 */
    public function name() { return $this->name; }
    /** @return string 計算方法詳細 */
    public function description() { return $this->description; }
	/** @return string 内容詳細 */
    public function text() { return $this->text; }
	
	/**
	 * 計算オブジェクトをかえす。
	 * @param int $v DB 上の値
	 * @return PointCalculator 計算者。見つからない場合 null をかえす。
	 */
	public static function getCalculator($v) {
		foreach (self::$calculators as $calc) {
			if ($calc->val() == $v) return $calc;
		}
		return null;
	}
	
	/**
	 * 
	 * @param type $result
	 * @param type $grade
	 * @param int $raceLapCount レーストップの周回数
	 * @param int $raceStartedCount レース出走人数
	 * @param date $meetDate 大会開催日
	 * @return int 点数配列 array('point' => point, 'bonus' => bonus)。付与するポイントが皆無の場合、null をかえす。
	 */
	public function calc($result, $grade, $raceLapCount, $raceStartedCount, $meetDate) {
		$pt = null;
		switch ($this->val()) {
			case self::$JCX_156->val(): $pt = $this->__calcJCXElite156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$KNS_156->val(): $pt = $this->__calcKNS156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
		}
		
		if (empty($pt['point']) && empty($pt['bonus'])) {
			return null;
		}
		
		return $pt;
	}
	
	/**
	 * 2015-16シーズンに設定された JCX ポイントをかえす。16-17 のボーナスポイント変更(20->10)も適用済み。
	 * @param type $result 選手ごとリザルト
	 * @param type $grade グレードはこのポイントテーブルでは関係しない。
	 * @param type $raceLapCount レーストップの周回数
	 * @param int $raceStartedCount レース出走人数
	 * @param date $meetDate 大会開催日
	 * @return int ポイント。取得ポイントがない場合は null をかえす。
	 */
	private function __calcJCXElite156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($result['rank'])) return null;
		
		// grade -> points
		$set = array();
		$set[1] = array(
			'rank_pt' => self::$TABLE_JCX156_GRADE1,
			'run_pt' => self::RUN_PT_JCX156_GRACE1,
		);
		$set[2] = array(
			'rank_pt' => self::$TABLE_JCX156_GRADE2,
			'run_pt' => self::RUN_PT_JCX156_GRACE2,
		);
		
		if (empty($set[$grade])) {
			$this->log('指定グレード[' . $grade . ']のポイント設定がありません。', LOG_ERR);
			return null;
		}
		
		$pointMap = array();
		
		$rankIndex = $result['rank'] - 1;
		if (!empty($set[$grade]['rank_pt'][$rankIndex])) {
			$pointMap['point'] = $set[$grade]['rank_pt'][$rankIndex];
		} else if (!empty($set[$grade]['run_pt'])) {
			$pointMap['point'] = $set[$grade]['run_pt'];
		}
		
		//$this->log('result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		
		// 同一周回ならば +20pt
		if ($result['lap'] >= $raceLapCount && $result['status'] == RacerResultStatus::$FIN->val()) {
			$pointMap['bonus'] = $this->_isSeasonBefore1617($meetDate) ?
					self::JCX156_BONUS_TO156 : self::JCX156_BONUS_167TO; // 16-17 から 10pt に変更
		}

		return $pointMap;
	}
	
	/**
	 * 出走カテゴリーのトップの周回数をかえす
	 * @param EntryCategory-data $ecat 出走カテゴリー
	 * @return int 周回数。エラーがある場合 null をかえす。
	 */
	private function __pullTopLap($ecat) {
		if (empty($ecat)) return null;
		$this->log('ecat:', LOG_DEBUG);
		$this->log($ecat, LOG_DEBUG);
		
		$erModel = new EntryRacer();
		$erModel->actsAs = array('Utils.SoftDelete');
		$cdt = array('EntryRacer.entry_category_id' => $ecat['id'], 'RacerResult.rank' => 1);
		$resultLap = $erModel->find('first', array('conditions' => $cdt, 'fields' => 'RacerResult.lap'));
		
		//$this->log($eracers, LOG_DEBUG);
		
		if (empty($resultLap['RacerResult']['lap'])) return null;
		
		return $resultLap['RacerResult']['lap'];
	}
	
	/**
	 * 2015-16シーズンの関西クロスのポイントをかえす。配点は 15-16 の AJOCC ポイントと同じ。
	 * @param type $result 選手ごとリザルト
	 * @param type $grade グレードはこのポイントテーブルでは関係しない。
	 * @param type $raceLapCount レーストップの周回数
	 * @param int $raceStartedCount レース出走人数
	 * @param date $meetDate 大会開催日
	 * @return int ポイント。取得ポイントがない場合は null をかえす。
	 */
	private function __calcKNS156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate) {
		
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($result['rank'])) return null;
		
		$pointSet = array(
			'rank_pt' => self::$TABLE_KNS156,
			'run_pt' => self::RUN_PT_KNS156, // 順位付いたらもらえるポイント（51位以下）
		);
		
		$rankIndex = $result['rank'] - 1;
		
		$point = 0;
		if (isset($pointSet['rank_pt'][$rankIndex])) {
			$point = $pointSet['rank_pt'][$rankIndex];
		} else {
			$point = $pointSet['run_pt'];
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。20151120 by クマモトさん
		
		return $pointMap;
	}
	
	/**
	 * 2016-17 シーズンより前のシーズンであるかをかえす
	 * @param date $date 日付
	 * @return boolean 
	 */
	private function _isSeasonBefore1617($date)
	{
		if (empty($date)) {
			return false; // unlikely... 本メソッドを作成したのが1617なので巻き戻りはなしので false かえす。
		}
		
		return ($date < '2016-04-01');
	}

}
PointCalculator::init();
