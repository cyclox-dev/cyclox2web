<?php

App::uses('EntryRacer', 'Model');

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
	
	private static $calculators;
	
	public static function calculators()
	{
		return self::$calculators;
	}
	
	public static function init()
	{
		self::$JCX_156 = new PointCalculator(1, 'JCX-156', '2015-16 JCX で使用するポイントテーブル。');
		
		self::$calculators = array(
			self::$JCX_156,
		);
	}
	
	private $val;
	private $name;
	private $description;
	
	public function __construct($v, $n, $d)
		// private にしたかったが、Object 継承すると public でなければならない。
	{
		parent::__construct();
		
		$this->val = $v;
		$this->name = $n;
		$this->description = $d;
	}
	
	/** @return int DB 上の記録値 */
    public function val() { return $this->val; }
    /** @return string 名前 */
    public function name() { return $this->name; }
    /** @return string 計算方法詳細 */
    public function description() { return $this->description; }
	
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
	 * @param type $ecat
	 * @param type $grade
	 * @return int 点数配列 array('point' => point, 'bonus' => bonus)。エラーの場合は null をかえす。
	 */
	public function calc($result, $ecat, $grade) {
		$pt = null;
		switch ($this->val()) {
			case self::$JCX_156->val(): $pt = $this->__calcJCXElite156($result, $ecat, $grade); break;
		}
		
		return $pt;
	}
	
	private function __calcJCXElite156($result, $ecat, $grade) {
		
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($result['rank'])) return null;
		
		// grade -> points
		$set = array();
		$set[1] = array(
			'rank_pt' => array(
				300, 240, 210, 180, 165, 150, 135, 120, 105, 90, 
				 87,  84,  81,  78,  75,  72,  69,  66,  63, 60,
				 58,  56,  54,  52,  50,  48,  46,  44,  42, 40,
				 39,  38,  37,  36,  35,  34,  33,  32,  31, 30,
				 29,  28,  27,  26,  25,  24,  23,  22,  21, 20,
			),
			'run_pt' => 10,
		);
		$set[2] = array(
			'rank_pt' => array(
				200, 160, 140, 120, 110, 100, 90,  80,  70,  60,
				58,  56,  54,  52,  50,  48,  46,  44,  42,  40,
				39,  38,  37,  36,  35,  34,  33,  32,  31,  30,
				29,  28,  27,  26,  25,  24,  23,  22,  21,  20,
				19,  18,  17,  16,  15,  14,  13,  12,  11,  10,
			),
			'run_pt' => 5,
		);
		
		if (empty($set[$grade])) {
			$this->log('指定グレード[' . $grade . ']のポイント設定がありません。', LOG_ERR);
			return null;
		}
		
		$pointMap = array();
		
		$rankIndex = $result['rank'] - 1;
		if (!empty($set[$grade]['rank_pt'][$rankIndex])) {
			$pointMap['point'] = $set[$grade]['rank_pt'][$rankIndex];
		}
		else if (!empty($set[$grade]['run_pt'])) {
			$pointMap['point'] = $set[$grade]['run_pt'];
		}
		
		// 同一周回ならば +20pt
		$topLap = $this->__pullTopLap($ecat);
		if (!empty($topLap)) {
			if ($result['lap'] >= $topLap) {
				$pointMap['bonus'] = 20;
			}
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
}
PointCalculator::init();
