<?php

/*
 *  created at 2015/10/11 by shun
 */

/**
 * Description of PointSeriesPointTo
 *
 * @author shun
 */
class PointSeriesPointTo
{
	public static $TO_TEAM;
	public static $TO_RACER;
	public static $RACER_AND_TEAM;
	
	private static $pointToList;
	
	public static function pointToList()
	{
		return self::$pointToList;
	}
	
	public static function init()
	{
		self::$TO_RACER = new PointSeriesPointTo(1, '個人に付与');
		self::$TO_TEAM = new PointSeriesPointTo(2, 'チームに付与');
		self::$RACER_AND_TEAM = new PointSeriesPointTo(3, '個人とチームに付与');
		
		self::$pointToList = array(
			self::$TO_RACER,
			self::$TO_TEAM,
			self::$RACER_AND_TEAM
		);
	}
	
	/**
	 * 指定値のポイント宛先をかえす
	 * @param int $val 固有値（DB 値）
	 * @return PointSeriesPointTo 該当値がない場合、null をかえす。
	 */
	public static function pointToAt($val)
	{
		foreach (self::$pointToList as $to)
		{
			if ($to->val() == $val)
			{
				return $to;
			}
		}
		
		return null;
	}
	
	private $val;
	private $title;
	
	private function __construct($v, $t) 
	{
		$this->val = $v;
		$this->title = $t;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->val; }
    /** @return string タイトル */                                                                    
    public function title() { return $this->title; }
}
PointSeriesPointTo::init();
