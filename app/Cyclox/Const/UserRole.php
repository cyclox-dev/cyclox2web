<?php

/*
 *  created at 2015/07/07 by shun
 */

/**
 * Description of UserRole
 *
 * @author shun
 */
class UserRole
{
	public static $ADMIN;
	public static $ORGANIZER;
	public static $TEAMDIRECTOR;
	public static $RACER;
	public static $GUEST;
	public static $API;
	
	public static $roles;
	
	public static function roles()
	{
		return self::$roles;
	}
	
	public static function init()
	{
		self::$ADMIN = new UserRole('admin', 'Admin', '最高位のデータ管理者', 100);
		self::$ORGANIZER = new UserRole('organizer', 'Organizer', 'レース主催者など', 70);
		self::$TEAMDIRECTOR = new UserRole('team_director', 'Team Director', 'チーム監督', 50);
		self::$RACER = new UserRole('racer', 'Racer', '選手', 35);
		self::$GUEST = new UserRole('guest', 'Guest', 'ゲスト', 20);
		self::$API = new UserRole('api', 'API', 'API 通信', 25);
		
		self::$roles = array(
			self::$ADMIN->val() => self::$ADMIN,
			self::$ORGANIZER->val() => self::$ORGANIZER,
			self::$TEAMDIRECTOR->val() => self::$TEAMDIRECTOR,
			self::$RACER->val() => self::$RACER,
			self::$GUEST->val() => self::$GUEST,
			self::$API->val() => self::$API,
		);
	}
	
	/**
	 * 指定値からの UserRole をかえす
	 * @param tstring $val UserRole を表す文字列
	 */
	public static function roleAt($val)
	{
		$r = self::$roles[$val];
		return empty($r) ? self::$GUEST : $r;
	}
	
	private $val; // string
	private $name;
	private $description;
	private $accessLv; // 0-100
	
	private function __construct($v, $n, $d, $a)
	{
		$this->val = $v;
		$this->name = $n;
		$this->description = $d;
		$this->accessLv = $a;
	}
	
	/** @@return string 文字値  */
	public function val() { return $this->val; }
	/** @@return */
	public function name() { return $this->name; }
	/** @@return */
	public function description() { return $this->description; }
	/** @@return */
	public function accessLv() { return $this->accessLv; }
}
UserRole::init();
