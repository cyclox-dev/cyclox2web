<?php

/* 
 *  created at 2015/06/12 by shun
 */

class Gender
{
	public static $MALE;
	public static $FEMALE;
	public static $UNASSIGNED;
	
	private static $genders;
	
	public static function genders()
	{
		return self::$genders;
	}
	
	public static function init()
	{
		self::$MALE = new Gender(0, '男性', 'M');
		self::$FEMALE = new Gender(1, '女性', 'F');
		self::$UNASSIGNED = new Gender(-1, '未指定', 'X');
		
		self::$genders = array(
			self::$MALE,
			self::$FEMALE,
			self::$UNASSIGNED
		);
	}
	
	private $val;
	private $express;
	private $charExp;
	
	private function __construct($v, $e, $c)
	{
		$this->val = $v;
		$this->express = $e;
		$this->charExp = $c;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->val; }
    /** @return string 文字列表現*/                                                                    
    public function express() { return $this->express; }
    /** @return string アルファベット大文字1文字での表現 */                                            
    public function charExp() { return $this->charExp; }
}
Gender::init();
