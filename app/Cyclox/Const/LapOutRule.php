<?php

/* 
 *  created at 2015/06/12 by shun
 */

class LapOutRule
{
	public static $NONE;
	public static $LAPOUT;
	public static $RULE80PER;
	
	private static $rules;
	
	public static function rules()
	{
		return self::$rules;
	}
	
	public static function init()
	{
		self::$NONE = new LapOutRule(0, 'None', 'ラップアウト無し');
		self::$LAPOUT = new LapOutRule(1, 'LapOut', '周回遅れを除外');
		self::$RULE80PER = new LapOutRule(2, '80%Rule', '80%ルール適用');
		
		self::$rules = array(
			self::$NONE,
			self::$LAPOUT,
			self::$RULE80PER
		);
	}
	
	private $val;
	private $name;
	private $expressJp;
	
	private function __construct($v, $n, $e)
	{
		$this->val = $v;
		$this->name = $n;
		$this->expressJp = $e;
	}
	
	/**
	 * 指定値の Rule をかえす
	 * @param int $value val 値
	 * @return LapOutRule ルール。該当するものがない場合、NONE をかえす。
	 */
	public static function ofVal($value)
	{
		foreach (self::$rules as $r) {
			if ($r->val() == $value) {
				return $r;
			}
		}
		return self::$NONE;
	}
	
	/** @return int DB 値 */
	public function val() { return $this->val; }
    /** @return string 名称 */
	public function name() { return $this->name; }
    /** @return string 日本語表現 */
	public function expressJp() { return $this->expressJp; }
}
LapOutRule::init();
