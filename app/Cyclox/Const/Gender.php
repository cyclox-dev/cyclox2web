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
		self::$MALE = new Gender(0, '男性', 'M', '男');
		self::$FEMALE = new Gender(1, '女性', 'F', '女');
		self::$UNASSIGNED = new Gender(-1, '未指定', 'X', '？');
		
		self::$genders = array(
			self::$MALE,
			self::$FEMALE,
			self::$UNASSIGNED
		);
	}
	
	/**
	 * 性別値から Gender をかえす
	 * @param int $val 性別を表す整数値
	 * @return string Gender クラスインスタンス not null
	 */
	public static function genderAt($val)
	{
		if ($val == self::$MALE->val()) return self::$MALE;
		if ($val == self::$FEMALE->val()) return self::$FEMALE;
		
		return self::$UNASSIGNED;
	}
	
	private $val;
	private $express;
	private $charExp;
	private $charExpJp;
	
	private function __construct($v, $e, $c, $j)
	{
		$this->val = $v;
		$this->express = $e;
		$this->charExp = $c;
		$this->charExpJp = $j;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->val; }
    /** @return string 文字列表現*/                                                                    
    public function express() { return $this->express; }
    /** @return string アルファベット大文字1文字での表現 */                                            
    public function charExp() { return $this->charExp; }
    /** @return string アルファベット大文字1文字での表現 */                                            
    public function charExpJp() { return $this->charExpJp; }
}
Gender::init();
