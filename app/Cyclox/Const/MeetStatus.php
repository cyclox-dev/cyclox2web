<?php

/*
 *  created at 2019/10/01 by shun
 */

/**
 * 大会を行なったか、中止したかなどのステータス
 *
 * @author shun
 */
class MeetStatus
{
	static $NORMAL;
	static $CANCELED;
	static $POSTPONED; // 延期
	
	private static $statusList;
	
	public static function statusList()
	{
		return self::$statusList;
	}
	
	public static function init()
	{
		self::$NORMAL = new MeetStatus(1, '開催', '開催されました。', '開催予定');
		self::$CANCELED = new MeetStatus(2, '中止', '中止されました。', '中止予定');
		self::$POSTPONED = new MeetStatus(3, '延期', '延期されました。', '延期予定');
		
		self::$statusList = array(
			self::$NORMAL->ID() => self::$NORMAL,
			self::$CANCELED->ID() => self::$CANCELED,
			self::$POSTPONED->ID() => self::$POSTPONED,
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
MeetStatus::init();
