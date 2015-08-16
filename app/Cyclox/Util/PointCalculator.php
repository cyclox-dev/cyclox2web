<?php

/*
 *  created at 2015/08/16 by shun
 */

/**
 * Description of PointCalculator
 *
 * @author shun
 */
class PointCalculator
{
	public static $JCX_ELITE_156;
	public static $JCX_LADY_156;
	
	private static $calculators;
	
	public static function calculators()
	{
		return self::$calculators;
	}
	
	public static function init()
	{
		self::$JCX_ELITE_156 = new PointCalculator(1, 'JCX-E-156', '2015-16 JCX（男子エリート）で使用するポイントテーブル。');
		self::$JCX_LADY_156 = new PointCalculator(1, 'JCX-L-156', '2015-16 JCX（女子）で使用するポイントテーブル。');
		
		self::$calculators = array(
			self::$JCX_ELITE_156,
			self::$JCX_LADY_156
		);
	}
	
	private $val;
	private $name;
	private $description;
	
	private function __construct($v, $n, $d)
	{
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
	
	public function calc() {
		$pt = null;
		switch ($this->val()) {
			case 1: $pt = $this->__calcJCXElite156();
			case 2: $pt = $this->__calcJCXLady156();
		}
		
		return $pt;
	}
	
	private function __calcJCXElite156() {
		return 111;
	}
	
	private function __calcJCXLady156() {
		return 222;
	}
}
PointCalculator::init();
