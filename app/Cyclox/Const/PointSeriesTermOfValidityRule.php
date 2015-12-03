<?php

/*
 *  created at 2015/11/16 by shun
 */

/**
 * Description of PointSeriesTermOfValidityRule
 *
 * @author shun
 */
class PointSeriesTermOfValidityRule
{
	public static $ENDLESS;
	public static $ONE_YEAR;
	
	private static $__rules;
	
	public static function rules()
	{
		return self::$__rules;
	}
	
	public static function init()
	{
		self::$ENDLESS = new PointSeriesTermOfValidityRule(1, '無期限有効', '獲得日（レース日）の翌日からポイントが有効になる。失効しない。');
		self::$ONE_YEAR = new PointSeriesTermOfValidityRule(2, '1年間有効', '獲得日（レース日）の翌日からポイントが有効になる。翌年の獲得日前日まで有効。');
		
		self::$__rules = array(
			self::$ENDLESS,
			self::$ONE_YEAR,
		);
	}
	
	/**
	 * 指定値のルールをかえす
	 * @param int $val 固有値（DB 値）
	 * @return PointSeriesSumUpRule 該当値がない場合、null をかえす。
	 */
	public static function ruleAt($val)
	{
		foreach (self::$__rules as $rule) {
			if ($rule->val() == $val) {
				return $rule;
			}
		}
		
		return null;
	}
	
	private $__val;
	private $__title;
	private $__description;
	
	private function __construct($v, $t, $d) 
	{
		$this->__val = $v;
		$this->__title = $t;
		$this->__description = $d;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->__val; }
    /** @return string タイトル */                                                                    
    public function title() { return $this->__title; }
    /** @return string ルール内容 */                                            
    public function description() { return $this->__description; }
	
	/**
	 * ポイント有効期間をかえす
	 * @param date $date ポイント獲得の基準となる日。一般には大会日。
	 * @return array array('begin' => date, 'end' => date) の形式
	 */
	public function calc($date = null)
	{
		$dt = $date;
		if (empty($date)) {
			$dt = date('Ymd'); // 本日日付
		}
		
		$term = array();
		switch ($this->val()) {
			case self::$ENDLESS->val(): $term = $this->__calcEndless($date); break;
			case self::$ONE_YEAR->val(): $term = $this->__calc1year($date); break;
		}
		
		return $term;
	}
	
	private function __calcEndless($date) {
		$dt = new DateTime($date);
		$dt->modify('+1 day');
		
		return array('begin' => $dt->format('Y-m-d'));
	}
	
	private function __calc1year($date) {
		$begin = new DateTime($date);
		$begin->modify('+1 day');
		
		$end = new DateTime($date);
		$end->modify('-1 day');
		$end->modify('+1 year');
		return array(
			'begin' => $begin->format('Y-m-d'),
			'end' => $end->format('Y-m-d')
		);
	}
	
}
PointSeriesTermOfValidityRule::init();