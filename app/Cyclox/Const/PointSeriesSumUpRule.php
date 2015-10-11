<?php

/*
 *  created at 2015/10/11 by shun
 */

/**
 * Description of PointSeriesSumUpRule
 *
 * @author shun
 */
class PointSeriesSumUpRule
{
	public static $THIS_SEASON;
	public static $ONE_YEAR;
	public static $WEEK52;
	public static $TOTAL_UP;
	
	private static $rules;
	
	public static function rules()
	{
		return self::$rules;
	}
	
	public static function init()
	{
		self::$THIS_SEASON = new PointSeriesSumUpRule(1, 'シーズン', '指定シーズンのみ有効。');
		self::$ONE_YEAR = new PointSeriesSumUpRule(2, '1年間', 'ポイント取得日から次年同日の前日まで有効。集計の時は-1年の次日からのポイントを合算する。');
		self::$WEEK52 = new PointSeriesSumUpRule(3, '52週', '取得日から52週間（364日）有効。ポイント取得日を含む。');
		self::$TOTAL_UP = new PointSeriesSumUpRule(4, '積算', 'ポイントの期限切れがなく、ひたすら合計する。');
		
		self::$rules = array(
			self::$THIS_SEASON,
			self::$ONE_YEAR,
			self::$WEEK52,
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
	
	private function __construct($v, $t, $d) 
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
}
PointSeriesSumUpRule::init();
