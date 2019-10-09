<?php

/*
 *  created at 2019/10/01 by shun
 */

/**
 * レースごとの行なった、中止したなどのステータス
 *
 * @author shun
 */
class RaceStatus
{
	static $NORMAL;
	static $CANCELED;
	static $CANCELED_AT_MID; // 途中で中止
	
	private static $statusList;
	
	public static function statusList()
	{
		return self::$statusList;
	}
	
	public static function init()
	{
		self::$NORMAL = new RaceStatus(1, '開催', '開催されました。', '開催予定');
		self::$CANCELED = new RaceStatus(2, '中止', '中止されました。', '中止予定');
		self::$CANCELED_AT_MID = new RaceStatus(3, '途中中止', 'レース途中で中止されました。。', '（中止予定）');
		
		self::$statusList = array(
			self::$NORMAL->ID() => self::$NORMAL,
			self::$CANCELED->ID() => self::$CANCELED,
			self::$CANCELED_AT_MID->ID() => self::$CANCELED_AT_MID,
		);
	}
	
	public static function statusAt($id)
	{
		if (!isset(self::$statusList[$id])) return self::$NORMAL;
		
		$ret = self::$statusList[$id];
		return $ret ? $ret : self::$NORMAL;
	}
	
	private $ID;
	private $name;
	private $doneMsg;
	private $expectedMsg;
	
	private function __construct($id, $n, $d, $e)
	{
		$this->ID = $id;
		$this->name = $n;
		$this->doneMsg = $d;
		$this->expectedMsg = $e;
	}
	
	public function ID() { return $this->ID; }
	public function name() { return $this->name; }
	public function doneMsg() { return $this->doneMsg; }
	public function expectedMsg() { return $this->expectedMsg; }
}
RaceStatus::init();