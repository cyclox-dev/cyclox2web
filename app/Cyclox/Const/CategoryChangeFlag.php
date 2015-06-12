<?php

/* 
 *  created at 2015/06/12 by shun
 */

/**
 * カテゴリー適用フラグ
 */
class CategoryChangeFlag
{
	public static $UNKNOWN;
	public static $REGIST;
	public static $LANKUP;
	public static $LANKDOWN;
	public static $OTHER;
	
	private static $flags;
	
	public static function flags()
	{
		return self::$flags;
	}
	
	public static function init()
	{
		self::$UNKNOWN = new CategoryChangeFlag(0, '不明');
		self::$REGIST = new CategoryChangeFlag(1, '登録');
		self::$LANKUP= new CategoryChangeFlag(2, '昇格');
		self::$LANKDOWN = new CategoryChangeFlag(3, '降格');
		self::$OTHER = new CategoryChangeFlag(4, 'その他');
		
		self::$flags = array(
			self::$UNKNOWN,
			self::$REGIST,
			self::$LANKUP,
			self::$LANKDOWN,
			self::$OTHER
			);
	}
	
	private $val;
	private $msg;
	
	private function __construct($v, $m)
	{
		$this->val = $v;
		$this->msg = $m;
	}
	
	/**@return int DB での ID 値 */
	public function val() { return $this->val; }
	/** @return string 内容を表す名前 */
	public function msg() { return $this->msg; }
	
}
CategoryChangeFlag::init();
