<?php

/* 
 *  created at 2015/06/12 by shun
 */

class Constant
{
	const AGE_NO_MAX_LIMIT = 999;
	const AGE_NO_MIN_LIMIT = 0;
	
	// 戻り値
	const RET_SUCCEED = 1;
	const RET_NO_ACTION = 2;
	const RET_FAILED = 0;
	const RET_ERROR = -1;
	
	//const DISTANCE_NOTSET = -999.0; // null に設定する
	
	/**
	 * 大会 code のシーズン表現位置についての最後に保存した番号を格納する。
	 * 実際には CONFKEY_MEET_SEASON_EXP-THK のようなキーとなる。
	 */
	const PKEY_MEET_SEASON_EXP_PREFIX = 'PKEY_MEET_SEASON_EXP-';
	
	/**
	 * 大会 code のマスターナンバー位置についての最後に保存した値を格納する。
	 * 実際には CONFKEY_MEET_MASTER_NUMBER-THK のようなキーとなる。
	 */
	const PKEY_MEET_MASTER_NUMBER_PREFIX = 'PKEY_MEET_MASTER_NUMBER-';
	
	/**
	 * 選手 code のシーズン表現位置について最後に保存した番号を格納する。
	 */
	const PKEY_RACER_SEASON_EXP = 'PKEY_RACER_SEASON_EXP';
	
	/**
	 * 選手 code のマスターナンバー位置について最後に保存した値を格納する。
	 */
	const PKEY_RACER_MASTER_NUMBER = 'PKEY_RACER_MASTER_NUMBER';
	
	
	const CONFKEY_RACER_SEASON_EXP = "CONFKEY_RACER_SEASON_EXP";
	const CONFKEY_RACER_MASTER_NUMBER = 'CONFKEY_RACER_MASTER_NUMBER';
}