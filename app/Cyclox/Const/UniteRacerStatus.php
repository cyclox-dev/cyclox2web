<?php

/*
 *  created at 2017/03/31 by shun
 */

/**
 * 選手統合ログのステータス
 *
 * @author shun
 */
class UniteRacerStatus
{
	static $UNKNOWN;
	static $DONE;
	static $REVERTED;
	
	private static $statuses;
	
	public static function statuses()
	{
		return self::$statuses;
	}
	
	public static function init()
	{
		self::$UNKNOWN = new UniteRacerStatus(0, '不明', 'ステータス不明');
		self::$DONE = new UniteRacerStatus(1, 'Done', '統合済み');
		self::$REVERTED = new UniteRacerStatus(2, 'REVERTED', '統合をCancelし選手データを元に戻した');
		
		self::$statuses = array(
			self::$UNKNOWN,
			self::$DONE,
			self::$REVERTED,
		);
	}
	
	public static function statusAt($id)
	{
		if (!isset(self::$statuses[$id])) return self::$UNKNOWN;
		
		return self::$statuses[$id];
	}
	
	private $ID;
	private $name;
	private $description;
	
	private function __construct($i, $n, $d)
	{
		$this->ID = $i;
		$this->name = $n;
		$this->description = $d;
	}
	
	public function ID() { return $this->ID; }
	public function name() { return $this->name; }
	public function description() { return $this->description; }
}

UniteRacerStatus::init();
