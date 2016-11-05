<?php

/*
 *  created at 2016/11/03 by shun
 */

/**
 * Description of EntryCatLimit
 *
 * @author shun
 */
class EntryCatLimit
{
	public static $ELITE;
	public static $MASTERS;
	public static $NONE;
	
	private static $limits;
	
	public static function limits()
	{
		return self::$limits;
	}
	
	public static function init()
	{
		// BETAG
		self::$ELITE = new EntryCatLimit(1, 'Elite', 'e');
		self::$MASTERS = new EntryCatLimit(2, 'Masters', 'm');
		self::$NONE = new EntryCatLimit(-1, 'None', 'n');
		
		self::$limits = array(
			self::$ELITE,
			self::$MASTERS,
			self::$NONE,
		);
	}
	
	private $catGroupId;
	private $name;
	private $charVal;
	
	private function __construct($c, $n, $r)
	{
		$this->catGroupId = $c;
		$this->name = $n;
		$this->charVal = $r;
	}
	
	/**
	 * 指定値の EntryCatLimit をかえす
	 * @param string $val 1文字の制限値
	 * @return EntryCatLimit 
	 */
	public static function catLimitAt($val)
	{
		foreach (self::$limits as $l) {
			if ($l->charVal() == $val) {
				return $l;
			}
		}
		
		return self::$NONE;
	}
	
	public function catGroupId() { return $this->catGroupId; }
	public function name() { return $this->name; }
	public function charVal() { return $this->charVal; }
}
EntryCatLimit::init();
