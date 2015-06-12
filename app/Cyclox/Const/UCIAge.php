<?php

App::uses('Constant', 'Cyclox/Const');

/* 
 *  created at 2015/06/12 by shun
 */

/**
 * UCI 年齢区分に関するクラス
 */
class UCIAge
{
	public static $UNKNOWN;
	public static $YOUTH;
	public static $JUNIOR;
	public static $U23;
	public static $ELITE;
	public static $MASTERS;
	
	private static $ages;
	
	public static function uciAges()
	{
		return self::$ages;
	}
	
	public static function init()
	{
		self::$UNKNOWN = new UCIAge('X', 'Unknown', '不明', '???', 0, 0, false, 'X');
		
		self::$YOUTH = new UCIAge(  'Y', 'Youth',    'ユース',       'Y',  Constant::AGE_NO_MIN_LIMIT, 16,	false, 'Y');
		self::$JUNIOR = new UCIAge( 'J', 'Jniors',   'ジュニア',     'J',  17, 18,							true,  'J');
		self::$U23 = new UCIAge(    'U', 'Under23s', 'アンダー23',   'U23',19, 22,							true,  'U');
		self::$ELITE = new UCIAge(  'E', 'Elite',    'エリート',     'E',  23, Constant::AGE_NO_MAX_LIMIT,	true,  'E');
		self::$MASTERS = new UCIAge('M', 'Masters',  'マスターズ',   'M',  30, Constant::AGE_NO_MAX_LIMIT,	true,  'M');
		
		self::$ages = array(
			self::$YOUTH,
			self::$JUNIOR,
			self::$U23,
			self::$ELITE,
			self::$MASTERS
		);
	}
	
	private $code;
	private $name;
	private $nameJp;
	private $shortName;
	private $ageMin;
	private $ageMax;
	private $needsLicense;
	private $ageExp;
	
	private function __construct($c, $n, $j, $s, $min, $max, $needs, $exp)
	{
		$this->code = $c;
		$this->name = $n;
		$this->nameJp = $j;
		$this->shortName = $s;
		$this->ageMin = $min;
		$this->ageMax = $max;
		$this->needsLicense = $needs;
		$this->ageExp = $exp;
	}
	
	public function code() { return $this->code; }                                                          
	public function name() { return $this->name; }
    public function nameJp() { return $this->nameJp; }
    public function shortName() { return $this->shortName; }
    public function ageMin() { return $this->ageMin; }
    public function ageMax() { return $this->ageMax; }
    public function needsLicense() { return $this->needsLicense; }
    public function ageExp() { return $this->ageExp; }
}
UCIAge::init();
