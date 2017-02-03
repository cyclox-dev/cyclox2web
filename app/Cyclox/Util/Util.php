<?php

/*
 *  created at 2015/06/20 by shun
 */

/**
 * Description of Util
 *
 * @author shun
 */
class Util
{
	/**
	 * is_date
	 * http://www.php.net/manual/ja/function.checkdate.php#89773
	 *
	 * @param string $date
	 * @param string $opt
	 * @return boolean
	 */
	static function is_date($date, $opt = 'iso')
	{
		$date   = str_replace(array('\'', '-', '.', ',', ' '), '/', $date);
		$dates  = array_merge(array_diff((explode('/', $date)), array('')));

		if ( count($dates) != 3 ) return false;

		switch ( $opt ) {
			case 'iso'  :
				$year   = $dates[0];
				$month  = $dates[1];
				$day    = $dates[2];
			break;

			case 'usa'  :
				$year   = $dates[2];
				$month  = $dates[0];
				$day    = $dates[1];
			break;

			case 'eng'  :
				$year   = $dates[2];
				$month  = $dates[1];
				$day    = $dates[0];
			break;

			default     :
				return false;
		}

		if ( !is_numeric($month) || !is_numeric($day) || !is_numeric($year) ) {
			return false;
		} elseif ( !checkdate($month, $day, $year) ) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * ミリ秒を時間フォーマットしたもの（H:m:s.SSS など）をかえす。
	 * @param int $milliSec ミリ秒
	 * @param bool $fillsAllHms 1時間にみたない場合でも H:m;s まですべて埋めるか。
	 */
	public static function milli2Time($milliSec, $fillsAllHms = false)
	{
		$milli = $milliSec % 1000;
		$sec = floor($milliSec / 1000);
		
		if (!$fillsAllHms) {
			if ($sec < 60) {
				return $sec . '.' . sprintf('%03d', $milli);
			} else if ($sec < 3600) {
				$secInMin = $sec % 60;
				$min = floor($sec / 60);
				return $min . ':' . sprintf('%02d', $secInMin) . '.' . sprintf('%03d', $milli);
			}
		}
		
		$secInMin = $sec % 60;
		$min = floor($sec / 60);
		$minInHour = $min % 60;
		$hour = floor($min / 60);
		
		return $hour . ':' . sprintf('%02d', $minInHour) . ':' . sprintf('%02d', $secInMin) . '.' . sprintf('%03d', $milli);
	}
	
	/**
	 * 生年月日から年齢をかえす
	 * @param DateTime $birth 生年月日
	 * @param DateTime $atDate 判定日
	 * @return int 年齢。引数が無効な場合、-1 をかえす。
	 */
	public static function ageAt($birth, $atDate = null)
	{
		if (empty($birth)) {
			return -1;
		}
		
		if (!($birth instanceof DateTime)) {
			return -1;
		}
		
		if (empty($atDate)) {
			$atDate = new DateTime('now');
		} else {
			if (!($atDate instanceof DateTime)) {
				return -1;
			}
		}
		
		return (int)(($atDate->format('Ymd') - $birth->format('Ymd')) / 10000);
	}
	
	/**
	 * 生年月日から判定される UCI シクロクロス年齢をかえす
	 * @param DateTime $birth 生年月日
	 * @param DateTime $atDate 判定日
	 * @return int UCI 年齢。引数が無効な場合、-1 をかえす。
	 */
	public static function uciCXAgeAt($birth, $atDate = null)
	{
		if (empty($birth)) {
			return -1;
		}
		
		if (!($birth instanceof DateTime)) {
			return -1;
		}
		
		if (empty($atDate)) {
			$atDate = new DateTime('now');
		} else {
			if (!($atDate instanceof DateTime)) {
				return -1;
			}
		}
		
		if ($birth > $atDate) {
			return -1;
		}
		
		$year = (int)$atDate->format('Y');
		$month = (int)$atDate->format('m');
		if ($month >= 4) {
			++$year;
		}
		
		return $year - $birth->format('Y');
	}
	
	/**
	 * 2015-16 シーズンをゼロとするシーズンインデックスをかえす
	 * @param date $date 日付 not null
	 * @return boolean 2015-16 シーズンより前の場合 false をかえす
	 */
	public static function cxSeasonIndex($date)
	{
		$datetime = new DateTime($date);
		
		$y = $datetime->format('Y');
		if ($datetime->format('m') < 4) {
			--$y;
		}
		
		$index = $y - 2015;
		if ($index < 0) return false;
		
		return $index;
	}
	
	/**
	 * 2015-16 シーズンをゼロとするシーズンインデックスからシーズン表現をかえす
	 * @param int $seasonIndex シーズンインデックス
	 * @return string 2015-16 シーズンならば '2015-16' をかえす
	 */
	public static function cxSeasonExp($seasonIndex)
	{
		return '20' . (15 + $seasonIndex) . '-' . (16 + $seasonIndex);
	}
}
