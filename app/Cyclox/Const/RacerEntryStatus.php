<?php

/* 
 *  created at 2015/06/12 by shun
 */

/**
 * 出走選手ステータス
 */
class RacerEntryStatus
{
	public static $NORMAL;
	public static $OPEN;
	
	private static $statuses;
	
	public static function statuses()
	{
		return self::$statuses;
	}
	
	public static function init()
	{
		self::$NORMAL = new RacerEntryStatus(0, 'Normal');
		self::$OPEN = new RacerEntryStatus(1, 'オープン');
		
		self::$statuses = array(
			self::$NORMAL,
			self::$OPEN
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
RacerEntryStatus::init();
