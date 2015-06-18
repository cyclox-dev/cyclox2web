<?php

/* 
 *  created at 2015/06/12 by shun
 */

App::uses('CategoryChangeFlag', 'Cyclox/Const');

/**
 * カテゴリー適用理由
 */
class CategoryReason
{
	static $FIRST_REGIST;
    static $RESULT_UP;
    static $SEASON_UP;
    static $SEASON_DOWN;
    static $TO_SUPER_RACER;
    static $BY_AGE;
    static $BY_RULE;
    static $OTHER_UP;
    static $OTHER_DOWN;
    static $OTHER_CHANGE;
	
	private static $reasons;
	
	public static function reasons()
	{
		return self::$reasons;
	}
	
	public static function init()
	{
		self::$FIRST_REGIST = new CategoryReason(1, CategoryChangeFlag::$REGIST, '新規カテゴリー付け', '新規の登録・参加でのカテゴリー付け');                     
		self::$RESULT_UP = new CategoryReason(2, CategoryChangeFlag::$LANKUP, 'レース昇格', '下位カテゴリーでの上位入賞による昇格'); 
		self::$SEASON_UP = new CategoryReason(3, CategoryChangeFlag::$LANKUP, 'シーズン成績昇格', 'シーズンの基準（ポイントや順位）による昇格'); 
		self::$SEASON_DOWN = new CategoryReason(4, CategoryChangeFlag::$LANKDOWN, 'シーズン成績降格', 'シーズンの基準（ポイントや順位）による降格'); 
		self::$TO_SUPER_RACER = new CategoryReason(5, CategoryChangeFlag::$OTHER, '成績優秀者への特別付与', '他の種目などでの成績優秀者の特別付与'); 
		self::$BY_AGE = new CategoryReason(6, CategoryChangeFlag::$OTHER, '年齢によるカテゴリー変更', '年齢基準到達に伴うカテゴリー変更'); 
		self::$BY_RULE = new CategoryReason(7, CategoryChangeFlag::$OTHER, 'ルール変更に伴う付与', 'カテゴリー決定ルールの変更にともなうカテゴリー付与'); 
		self::$OTHER_UP = new CategoryReason(8, CategoryChangeFlag::$LANKUP, 'その他昇格', 'その他の理由による昇格'); 
		self::$OTHER_DOWN = new CategoryReason(9, CategoryChangeFlag::$LANKDOWN, 'その他降格', 'その他の理由による降格'); 
		self::$OTHER_CHANGE = new CategoryReason(10, CategoryChangeFlag::$OTHER, 'その他カテゴリー付与', 'その他の理由によるカテゴリー付与');
		
		self::$reasons = array(
			self::$FIRST_REGIST,
			self::$RESULT_UP,
			self::$SEASON_UP,
			self::$SEASON_DOWN,
			self::$TO_SUPER_RACER,
			self::$BY_AGE,
			self::$BY_RULE,
			self::$OTHER_UP,
			self::$OTHER_DOWN,
			self::$OTHER_CHANGE
		);
	}
	
	private $ID;
	private $flag;
	private $name;
	private $description;
	
	private function __construct($id, $f, $n, $desc)
	{
		$this->ID = $id;
		$this->flag = $f;
		$this->name = $n;
		$this->description = $desc;
	}
	
	/** @return int ID */                                                                               
	public function ID() { return $this->ID; }
    /** @return CategoryChangeFlag 変更フラグ */                                                    
	public function flag() { return $this->flag; }
    /** @return string name */                                                                      
	public function name() { return $this->name; }
    /** @return string 内容詳細 */                                                                                                                     
	public function description() { return $this->description; }
}
CategoryReason::init();
