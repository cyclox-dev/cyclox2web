<?php

/*
 *  created at 2015/06/16 by shun
 */

App::uses('ParmVar', 'Model');
App::uses('Season', 'Model');
App::uses('Util', 'Cyclox/Util');
App::uses('Constant', 'Cyclox/Const');
App::uses('UCIAge', 'Cyclox/Const');

/**
 * Description of AjoccUtil
 *
 * @author shun
 */
class AjoccUtil
{
	/**
	 * 現在での3桁のシーズンの表現番号をかえす
	 * @return string 3桁のシーズンの表現番号
	 */
	public static function seasonExp($date = null)
	{
		$ts = !is_null($date) ? strtotime($date) : time();
		
		$y = (int)date('Y', $ts);
		$m = (int)date('n', $ts);
		
		if ($m < 4) {
			$y--;
			$y += 100; // マイナス防止
		}
		$y %= 100;
		
		$end = ($y + 1) % 10;
		
		if ($y < 10) {
			return '0' . $y . $end;
		} else {
			return $y . $end;
		}
	}
	
	public static function nextMeetCode($meetGroupCode = null)
	{
		if (!$meetGroupCode) {
			throw new InvalidArgumentException('arg meetGroupCode should be not null.');
		}
		
		$pv = new ParmVar();
		$pkeySeason = Constant::PKEY_MEET_SEASON_EXP_PREFIX . $meetGroupCode;
		$seasonNo = '000';
		$seasonNoObj = $pv->find('first', array('conditions' => array('ParmVar.pkey' => $pkeySeason)));
		//debug($seasonNoObj);
		if ($seasonNoObj) {
			$seasonNo = $seasonNoObj['ParmVar']['value'];
		}
		
		$pvn = new ParmVar();
		$pkeyNo = Constant::PKEY_MEET_MASTER_NUMBER_PREFIX . $meetGroupCode;
		$number = 0;
		$numberObj = $pvn->find('first', array('conditions' => array('ParmVar.pkey' => $pkeyNo)));
		//debug($numberObj);
		if ($numberObj) {
			$number = $numberObj['ParmVar']['value'];
		}
		
		$currSeasonNo = self::seasonExp();
		
		if (!$seasonNoObj || $currSeasonNo !== $seasonNo) {
			//debug('1st route');
			$seasonNo = $currSeasonNo;
			$data = array(
				'pkey' => $pkeySeason,
				'value' => $seasonNo
			);
			if ($seasonNoObj) {
				$pv->set('id', $seasonNoObj['ParmVar']['id']);
			} else {
				$pv->create();
			}
			
			// season 番号の更新
			if (!is_array($pv->save($data))) {
				throw new InternalErrorException('大会 code のためのシーズン表現値の保存に失敗しました。');
			}
			$number = 1; // MEMO: 1から開始とする。
		} else {
			$number++;
		}
		
		//debug($number);
		
		$data = array(
			'pkey' => $pkeyNo,
			'value' => $number
		);
		if ($numberObj) {
			$pv->set('id', $numberObj['ParmVar']['id']);
		} else {
			$pv->create();
		}
		
		// number の更新
		if (!is_array($pv->save($data))) {
			throw new InternalErrorException('大会 code のための末尾番号値の保存に失敗しました。');
		}
		
		return $meetGroupCode . '-' . $currSeasonNo . '-' . sprintf('%03d', $number);
	}
	
	/**
	 * 払い出し可能な選手コードのリスト一覧をかえす
	 * @param type $meetGroup
	 * @param type $date シーズン番号用の日付
	 * @param int $limit 一度に取得する数の制限値（処理速度対応用）
	 * @return array 選手コードのリスト
	 */
	public static function nextRacerCodesAt($meetGroup, $date, $limit = 500)
	{
		$prefix = $meetGroup['code'] . '-' . self::seasonExp($date) . '-';
		CakeLog::write(LOG_DEBUG, $prefix);
		// 既存コードを取得
		App::import('Model','ConnectionManager');
		$db = ConnectionManager::getDataSource('default');
		$fed = $db->fetchAll('SELECT code FROM racers WHERE code LIKE "' . $prefix . '%"'
				. ' and cast(replace(code, "' . $prefix . '" ,"") as signed) >= ' . $meetGroup['racer_code_4num_min']
				. ' and cast(replace(code, "' . $prefix . '" ,"") as signed) <= ' . $meetGroup['racer_code_4num_max']
				. ' order by code ASC limit ' . $limit . ';');
		//CakeLog::write(LOG_DEBUG, '$fed:');
		//CakeLog::write(LOG_DEBUG, print_r($fed, true));
		
		// 検索しやすいようにパック
		$codes = array();
		foreach ($fed as $f) {
			$codes[] = $f['racers']['code'];
		}
		
		$nextCodes = array();
		for ($i = $meetGroup['racer_code_4num_min']; $i <= $meetGroup['racer_code_4num_max']; $i++) {
			$cd = $prefix . sprintf("%'.04d", $i);
			if (!in_array($cd, $codes)) {
				$nextCodes[] = $cd;
			}
		}
		
		return $nextCodes;
	}
	
	/**
	 * 次の新規選手 code を取得する。
	 */
	public static function nextRacerCode()
	{
		$pv = new ParmVar();
		$pkeySeason = Constant::PKEY_RACER_SEASON_EXP;
		$seasonNo = null;
		$seasonNoObj = $pv->find('first', array('conditions' => array('ParmVar.pkey' => $pkeySeason)));
		//debug($seasonNoObj);
		if ($seasonNoObj) {
			$seasonNo = $seasonNoObj['ParmVar']['value'];
		}
		
		$pvn = new ParmVar();
		$pkeyNo = Constant::PKEY_RACER_MASTER_NUMBER;
		$number = 0;
		$numberObj = $pvn->find('first', array('conditions' => array('ParmVar.pkey' => $pkeyNo)));
		//debug($numberObj);
		if ($numberObj) {
			$number = $numberObj['ParmVar']['value'];
		}
		
		$currSeasonNo = self::seasonExp();
		
		if (!$seasonNoObj || $currSeasonNo !== $seasonNo) {
			//debug('1st route');
			$seasonNo = $currSeasonNo;
			$data = array(
				'pkey' => $pkeySeason,
				'value' => $seasonNo
			);
			if ($seasonNoObj) {
				$pv->set('id', $seasonNoObj['ParmVar']['id']);
			} else {
				$pv->create();
			}
			
			// season 番号の更新
			if (!is_array($pv->save($data))) {
				throw new InternalErrorException('選手 code のためのシーズン表現値の保存に失敗しました。');
			}
			$number = 1; // MEMO: 1から開始とする。
		} else {
			$number++;
		}
		
		//debug($number);
		
		$data = array(
			'pkey' => $pkeyNo,
			'value' => $number
		);
		if ($numberObj) {
			$pv->set('id', $numberObj['ParmVar']['id']);
		} else {
			$pv->create();
		}
		
		// number の更新
		if (!is_array($pv->save($data))) {
			throw new InternalErrorException('選手 code のための末尾番号値の保存に失敗しました。');
		}
		
		$mgCode = Configure::read('SVR_MEET_GROUP_CODE');
		
		return $mgCode . '-' . $currSeasonNo . '-' . sprintf('%04d', $number);
	}
	
	/**
	 * UCI Elite 未満の年齢であるかをかえす
	 * @param date $birth 生年月日
	 * @param int $seasonID 年齢判定シーズン ID。null 指定、もしくは無効なシーズン ID 指定ならば現在日時で判定する。
	 * @return boolean Elite 未満の年齢であるか
	 */
	public static function isLessElite($birth, $seasonID)
	{
		if (empty($birth)) return false;
		
		$atDate = date('Y-m-d');
		if (!empty($seasonID)) {
			$Season = new Season();
			$season = $Season->find('first', array('conditions' => array('id' => $seasonID), 'recurive' => 0));
			
			if (!empty($season['Season']['end_date'])) {
				$atDate = $season['Season']['end_date'];
			}
		}
		
		return self::isLessEliteDate($birth, $atDate);
	}
	
	/**
	 * UCI Elite 未満の年齢であるかをかえす
	 * @param date $birth 生年月日
	 * @param date $seasonEndDate 年齢判定シーズン の最終日。null 指定ならば現在日時で判定する。
	 * @return boolean Elite 未満の年齢であるか
	 */
	public static function isLessEliteDate($birth, $seasonEndDate)
	{
		if (empty($birth)) return false;
		
		$atDate = new DateTime('now');
		if (!empty($seasonEndDate)) {
			$atDate = new DateTime($seasonEndDate);
		}
		
		$uciAge = Util::uciCXAgeAt(new DateTime($birth), $atDate);
		
		return $uciAge < UCIAge::$ELITE->ageMin();
	}
}
