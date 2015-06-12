<?php

/* 
 *  created at 2015/06/12 by shun
 */

/**
 * ライセンス必要フラグ
 */
class LicenseNecessity
{
	public static $NOT_NEED;
    public static $NEED;
    public static $NEED_AND_OPN;
    public static $NOT_BUT_RECOMMEND;
    public static $UNKNOWN;
	
	private static $necessities;
	
	public static function necessities()
	{
		return self::$necessities;
	}
	
	public static function init()
	{
		self::$NOT_NEED = new LicenseNecessity(0, '不要');
		self::$NEED = new LicenseNecessity(1, '必要');
		self::$NEED_AND_OPN = new LicenseNecessity(2, '必要/OPN参加可');
		self::$NOT_BUT_RECOMMEND = new LicenseNecessity(3, '不要/推奨');
		self::$UNKNOWN = new LicenseNecessity(-1, '不明');
		
		self::$necessities = array(
			self::$NOT_NEED,
			self::$NEED,
			self::$NEED_AND_OPN,
			self::$NOT_BUT_RECOMMEND,
			self::$UNKNOWN
		);
	}
	
	private $val;
	private $msg;
	
	private function __construct($v, $m)
	{
		$this->val = $v;
		$this->msg = $m;
	}
	
	/** @return int DB 値 */
	public function val() { return $this->val; }
	/** @return string 表現 */
	public function msg() { return $this->msg; }
}
LicenseNecessity::init();
