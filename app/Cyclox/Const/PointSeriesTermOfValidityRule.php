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
	
	
	// TODO: meet_point_series に期間設定を行なうメソッドを追加して配置
	
}
PointSeriesTermOfValidityRule::init();