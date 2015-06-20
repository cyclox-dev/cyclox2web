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
}
