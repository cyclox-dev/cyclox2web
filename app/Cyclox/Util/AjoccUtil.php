<?php

/*
 *  created at 2015/06/16 by shun
 */

App::uses('ParmVar', 'Model');
App::uses('Constant', 'Cyclox/Const');

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
	public static function seasonExp()
	{
		$y = (int)date('Y');
		$m = (int)date('n');
		
		if ($m < 3) {
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
		$pkeySeason = Constant::CONFKEY_PREFIX_MEET_SEASON_EXP_PREFIX . $meetGroupCode;
		$seasonNo = '000';
		$seasonNoObj = $pv->find('first', array('conditions' => array('ParmVar.pkey' => $pkeySeason)));
		debug($seasonNoObj);
		if ($seasonNoObj) {
			$seasonNo = $seasonNoObj['ParmVar']['value'];
		}
		
		$pvn = new ParmVar();
		$pkeyNo = Constant::CONFKEY_PREFIX_MEET_MASTER_NUMBER . $meetGroupCode;
		$number = 0;
		$numberObj = $pvn->find('first', array('conditions' => array('ParmVar.pkey' => $pkeyNo)));
		debug($numberObj);
		if ($numberObj) {
			$number = $numberObj['ParmVar']['value'];
		}
		
		$currSeasonNo = self::seasonExp();
		
		if (!$seasonNoObj || $currSeasonNo !== $seasonNo) {
			debug('1st route');
			$seasonNo = $currSeasonNo;
			$data = array(
				'pkey' => $pkeySeason,
				'value' => $seasonNo
			);
			if ($seasonNoObj) {
				//$data['id'] = $seasonNoObj['ParmVar']['id'];
				$pv->set('id', $seasonNoObj['ParmVar']['id']);
			} else {
				$pv->create();
			}
			
			if (!is_array($pv->save($data))) {
				throw new InternalErrorException('大会 code のためのシーズン表現値の保存に失敗しました。');
			}
			$number = 1; // MEMO: 1から開始とする。
		} else {
			$number++;
		}
		
		debug($number);
		
		$data = array(
			'pkey' => $pkeyNo,
			'value' => $number
		);
		if ($numberObj) {
			$pv->set('id', $numberObj['ParmVar']['id']);
		} else {
			$pv->create();
		}
		
		if (!is_array($pv->save($data))) {
			throw new InternalErrorException('大会 code のための末尾番号値の保存に失敗しました。');
		}
		
		Configure::write(Constant::CONFKEY_PREFIX_MEET_MASTER_NUMBER . $meetGroupCode, $number);
		
		return $meetGroupCode . '-' . $currSeasonNo . '-' . sprintf('%03d', $number);
	}
	
	
	
	
}
