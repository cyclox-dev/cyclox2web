<?php

/*
 *  created at 2016/02/05 by shun
 */

App::uses('Component', 'Controller');
App::uses('Util', 'Cyclox/Util');
App::uses('Constant', 'Cyclox/Const');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('CategoryReason', 'Cyclox/Const');
App::uses('PointCalculator', 'Cyclox/Util');
App::uses('TransactionManager', 'Model');
App::uses('Racer', 'Model');
App::uses('EntryCategory', 'Model');
App::uses('EntryGroup', 'Model');
App::uses('HoldPoint', 'Model');
App::uses('CategoryRacer', 'Model');
App::uses('RacesCategory', 'Model');
App::uses('PointSeriesRacer', 'Model');
App::uses('MeetPointSeries', 'Model');
App::uses('RacerResult', 'Model');

/**
 * リザルトを計算するコンポーネント
 *
 * @author shun
 */
class ResultParamCalcComponent extends Component
{
	private $__topLapCount;
	private $__started;
	private $__finished;
	private $__atDate;
	private $__meetCode;
	
	private $__rankUpMap;
	private $__rule0111 = array(
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule0123 = array(
		array('racer_count' => 50, 'up' => 3),
		array('racer_count' => 20, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule0112 = array(
		array('racer_count' => 50, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	
	private $TransactionManager;
	private $Racer;
	private $EntryCategory;
	private $EntryGroup;
	private $HoldPoint;
	private $CategoryRacer;
	private $RacesCategory;
	private $PointSeriesRacer;
	private $MeetPointSeries;
	private $RacerResult;
	
	public function reCalcResults($ecatId = null)
	{
		$this->EntryCategory = new EntryCategory();
		
		$this->EntryCategory->Behaviors->load('Containable');
		
		$options = array(
			'conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $ecatId),
			'contain' => array(
				'EntryRacer' => array(
					'RacerResult'
				)
			)
		);
		$ecat = $this->EntryCategory->find('first', $options);
		
		//$this->log('ecat:', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($ecat['EntryRacer'])) {
			return Constant::RET_NO_ACTION;
		} else {
			$ers = array();
			foreach ($ecat['EntryRacer'] as $eracer) {
				if (!empty($eracer['RacerResult'])) {
					$er = array();
					$er['EntryRacer'] = $eracer;
					$er['RacerResult'] = $eracer['RacerResult'];

					$ers[] = $er;
				}
			}
			
			if (count($ers) == 0) {
				$this->Session->setFlash(__('リザルトが設定されていません。'));
			} else {
				$ret = $this->__doReCalcResults($ers, $ecat['EntryCategory']);
				
				if ($ret === Constant::RET_ERROR || !$ret) {
					return Constant::RET_FAILED;
				}
			}
		}
		
		return Constant::RET_SUCCEED;
	}
	
	/**
	 * 出走カテゴリーごとのリザルトを再計算する。
	 * @param array $results リザルト配列。それぞれの要素に EntryRacer, RacerResult の key-value を持つ。
	 * @param array $ecat 出走カテゴリー。EntryCategory 以下の key-value を持つ。
	 * @return Constant::RET_xxx 処理ステータス
	 */
	private function __doReCalcResults($results, $ecat)
	{
		if (empty($results) || empty($ecat)) {
			return Constant::RET_ERROR;
		}
		
		$this->__setupParams($results);
		$this->__setupMeetParams($ecat);
		$this->__setupRankUpRules();
		
		// ajocc point の適用
		foreach ($results as $result) {
			$r = $result['RacerResult'];
			
			$ajoccPt = 0; // デフォルトでゼロに設定
			
			if ($ecat['applies_ajocc_pt']) {
				$isOpenRacer = ($result['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
				if (!$isOpenRacer && isset($r['rank'])) {
					$ajoccPt = $this->calcAjoccPt($r['rank'], $this->__started);
					//$this->log('ajocc pt:' . $ajoccPt, LOG_DEBUG);
					if ($ajoccPt == -1) {
						$this->log('AjoccPoint が計算できません。rank:' . $r['rank'] . ' --> ptゼロに設定します。', LOG_ERR);
						$ajoccPt = 0;
					}
				}
			}
			
			$this->RacerResult->id = $r['id'];
			$param = array('ajocc_pt' => $ajoccPt);
			if (!$this->RacerResult->save($param)) {
				$this->log('result[id:' . $r['id'] . '] の ajocc point 書換えに失敗しました。', LOG_DEBUG);
				// not break
			}
		}
		
		if (empty($this->__atDate) || empty($this->__meetCode)) {
			return Constant::RET_ERROR;
		}
		
		usort($results, array($this, '__compare_results_rank'));
		
		try {
			$transaction = $this->TransactionManager->begin();
			$ret = $this->__reCalcResults($results, $ecat);
			
			if ($ret) {
				$this->TransactionManager->commit($transaction);
			} else {
				$this->TransactionManager->rollback($transaction);
			}
			
			return $ret;
		} catch (Exception $ex) {
			$this->log('exception:' . $ex.message, LOG_DEBUG);
			return false;
		}
	}
	
	/**
	 * AJOCC Point を計算する
	 * @param type $rank リザルト順位
	 * @param type $startedCount 出走人数
	 * @return int ポイント。エラーの場合 -1 をかえす。
	 */
	public function calcAjoccPt($rank, $startedCount)
	{
		if ($startedCount <= 0) {
			return -1;
		}
		
		if (empty($rank)) {
			return 0;
		}
		
		$map = array(
			array(
				'started_over' => 40, 'points' => array(
					56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
					16, 14, 13, 12, 11, 10,  9,  9,  8,  8,
					 7,  7,  7,  6,  6,  6,  5,  5,  5,  5,
					 4,  4,  4,  4,  3,  3,  3,  3,  3,  3,
					 2,  2,  2,  2,  2,  2,  2,  1,  1,  1,
					 1,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				'started_over' => 20, 'points' => array(
					42, 34, 28, 24, 21, 18, 15, 13, 11, 10,
					9,  8,  7,  6,  6,  5,  5,  4,  4,  4,
					3,  3,  3,  3,  2,  2,  2,  2,  2,  2,
					2,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				'started_over' => 0, 'points' => array(
					28, 20, 15, 12, 10, 8,  6,  5,  4,  3,
					3,  2,  2,  2,  1,  1,  1,  1,  1,  1,
				)
			)
		);
		
		// ポイントの決定
		$point = 0;
		foreach ($map as $item) {
			if ($startedCount > $item['started_over']) {
				$rankIndex = $rank - 1;
				
				if (isset($item['points'][$rankIndex])) {
					$point = $item['points'][$rankIndex];
					break;
				}
			}
		}
		
		//$this->log('ajocc pt is: ' . $point, LOG_DEBUG);
		return $point;
	}
	
	/**
	 * リザルトに関するポイントなどを再計算する。Transaction 処理はこのメソッドの外部で行なうこと。
	 * @param array $results リザルト
	 * @param array $ecat 出走カテゴリー
	 * @return boolean 処理に成功したか
	 */
	private function __reCalcResults($results, $ecat)
	{
		foreach ($results as $result) {
			$r = $result['RacerResult'];
			$er = $result['EntryRacer'];
			unset($er['RacerResult']); // メモリ節約

			$isOpenRacer = ($er['entry_status'] == RacerEntryStatus::$OPEN->val());
			if ($isOpenRacer) {
				continue;
			}

			// 残留ポイントの再計算
			$ret = $this->__resetHoldPoint($er['racer_code'], $r, $ecat);
			if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
				$this->log($er['racer_code'] . ' の残留ポイントの設定処理に失敗しました。', LOG_ERR);
				// continue
			}

			// シリーズポイントの再計算
			$ret = $this->__resetSeriesPoints($er['racer_code'], $r, $ecat['name']);
			if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
				$this->log($er['racer_code'] . ' のポイント計算に失敗しました。', LOG_ERR);
				// continue
			}
		}

		$racesCat = $ecat['races_category_code'];

		if ($ecat['applies_rank_up'] == 1) {
			if ($racesCat === 'CM1+2+3') {
				// M1+2+3 は勝利したら CM1 表彰台で CM2（降格なし）
				foreach ($results as $result) {
					$er = $result['EntryRacer'];
					$r = $result['RacerResult'];

					$isOpenRacer = ($result['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
					if ($isOpenRacer) {
						continue;
					}
					
					if (empty($r['rank'])) {
						continue;
					}

					if ($r['rank'] == 1) {
						$this->__applyRankUp2CM($er['racer_code'], 'CM1', $r);
					} else if ($r['rank'] < 4) {
						$this->__applyRankUp2CM($er['racer_code'], 'CM2', $r);
					}
				}
			} else {
				// 昇格する人数の決定
				$rankUpCount = $this->__rankUpRacerCount($racesCat);
				$count = $rankUpCount;

				// ループで先頭から順に昇格を与える。昇格年齢制限があった場合は繰り上げ。
				foreach ($results as $result) {
					$isOpenRacer = ($result['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
					if ($isOpenRacer) {
						// リザルトに基づく昇格は削除する(↑)
						continue;
					}

					$r = $result['RacerResult'];
					
					if ($count > 0) {
						$ret = $this->__setupCatRacerCancel($result['EntryRacer']['racer_code'], $this->__rankUpMap[$racesCat]['needs']);
						if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
							$this->log('選手[coce:' . $result['EntryRacer']['racer_code'] . '] のカテゴリー所属の cancel_date 設定に失敗しました。', LOG_ERR);
							// continue
						}

						$ret = $this->__applyRankUp($result['EntryRacer']['racer_code'], $racesCat, $r, $rankUpCount);
						if ($ret != Constant::RET_NO_ACTION) {
							--$count; // failed, error でも繰り上げしない
						}
						if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
							$this->log('昇格適用に失敗しました。');
							return false;
						}
					}
				}
			}
		}
		
		return true;
	}
	
	/**
	 * CM1 or CM2 への昇格を適用する
	 * @param string $racerCode 選手コード
	 * @param string $newCatCode 新しいカテゴリーコード 'CM1' or 'CM2'
	 * @param array $result リザルト
	 * @return Constant::RET_xxx 処理ステータス
	 */
	private function __applyRankUp2CM($racerCode, $newCatCode, $result)
	{
		if (emptY($racerCode)) {
			$this->log('__applyRankUp2CM() の引数が不正です。', LOG_ERR);
			return Constant::RET_ERROR;
		}
		
		if ($newCatCode != 'CM1' && $newCatCode != 'CM2') {
			$this->log('想定しないカテゴリーへの昇格です。', LOG_ERR);
			return Constant::RET_ERROR;
		}
		
		$applyDate = date('Y/m/d', strtotime($this->__atDate . ' +1 day'));
		
		// 同じ大会で同じ昇格をしているデータがあるなら、リザルトは除去されていると推測されるので、削除する。
		
		$conditions = array(
			'racer_code' => $racerCode,
			'meet_code' => $this->__meetCode,
			'category_code' => $newCatCode,
			'apply_date' => $applyDate,
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
		);
		$this->CategoryRacer->deleteAll($conditions);
		
		// 昇格元カテゴリーへの cancel date の設定
		
		$oldCats = array(
			'CM1' => array('CM2', 'CM3'),
			'CM2' => array('CM3'),
		);
		if ($this->__setupCatRacerCancel($racerCode, $oldCats[$newCatCode])) {
			$this->log('旧所属カテゴリーの終了日設定に失敗しました。', LOG_DEBUG);
			// not break
		}
		
		// 現在所属カテゴリーの取得
		
		$conditions = array(
			'racer_code' => $racerCode,
			array('OR' => array(
				array('cancel_date' => null),
				array('cancel_date >=' => $this->__atDate)
			)),
			'apply_date <=' => $this->__atDate,
		);
		$catBinds = $this->CategoryRacer->find('all', array('conditions' => $conditions, 'recursive' => -1));
		
		// 新しいカテゴリー所属の登録
		
		$hasNewCat = false;
		$hasCM1 = false;
		foreach ($catBinds as $cr) {
			if ($cr['CategoryRacer']['category_code'] == $newCatCode) {
				$hasNewCat = true;
			}
			if ($cr['CategoryRacer']['category_code'] == 'CM1') {
				$hasCM1 = true;
			}
		}
		
		$rStatus = Constant::RET_SUCCEED; // 新しいカテゴリー設定状況とする。古い方はエラーとしてはかえさずログのみ。
		
		if ($hasNewCat) {
			$this->log('選手[code:' . $racerCode . ']はすでに' . $newCatCode . 'に所属しています。', LOG_DEBUG);
		} else if ($hasCM1) {
			$this->log('選手[code:' . $racerCode . ']はすでに CM1 に所属しています。', LOG_DEBUG);
		} else {
			// 登録処理
			$cr = array();
			$cr['CategoryRacer'] = array();
			$cr['CategoryRacer']['racer_code'] = $racerCode;
			$cr['CategoryRacer']['category_code'] = $newCatCode;
			$cr['CategoryRacer']['apply_date'] = $applyDate;
			$cr['CategoryRacer']['reason_id'] = CategoryReason::$RESULT_UP->ID();
			$cr['CategoryRacer']['reason_note'] = "";
			$cr['CategoryRacer']['racer_result_id'] = $result['id'];
			$cr['CategoryRacer']['meet_code'] = $this->__meetCode;
			$cr['CategoryRacer']['cancel_date'] = null;

			$this->CategoryRacer->create();
			if (!$this->CategoryRacer->save($cr)) {
				$this->log('昇格の選手カテゴリー Bind の保存に失敗しました。', LOG_ERR);
				$rStatus = Constant::RET_FAILED;
				// not break
			} else {
				$this->log('選手[code:' . $racerCode . ']に' . $newCatCode . 'を付与しました。', LOG_DEBUG);
			}

			//$this->log('(with rank-up) will give give hold point to:' . $newCategory, LOG_DEBUG);
			$hp = array();
			$hp['HoldPoint'] = array();
			$hp['HoldPoint']['racer_result_id'] = $result['id'];
			$hp['HoldPoint']['point'] = 3;
			$hp['HoldPoint']['category_code'] = $newCatCode;

			$this->HoldPoint->create();
			if (!$this->HoldPoint->save($hp)) {
				$this->log('新カテゴリーに対する残留ポイントの保存に失敗しました。', LOG_ERR);
				$rStatus = Constant::RET_FAILED;
			} else {
				$this->log('選手[code:' . $racerCode . ']に残留ポイント3/' . $newCatCode . 'を付与しました。', LOG_DEBUG);
			}
		}
		
		return $rStatus;
	}
	
	/**
	 * 昇格を適用する
	 * @param string $racerCode 選手コード
	 * @param string $racesCat レースカテゴリー
	 * @param array $result リザルト
	 * @param int $rankUpCount 昇格者数
	 * @return Constant.RET_xxx 処理ステータス
	 */
	private function __applyRankUp($racerCode, $racesCat, $result, $rankUpCount)
	{
		if (empty($racerCode) || empty($racesCat)) {
			return Constant::RET_ERROR;
		}
		
		if (empty($result['rank'])) {
			return Constant::RET_NO_ACTION;
		}
		
		if (!$this->__isProperAgeForCat($racerCode, $racesCat)) {
			return Constant::RET_NO_ACTION;
		}
		
		// 新しいカテゴリー所属の保存
		// 現在所属しているかは見ない。不整合の場合は手動での修正とする。
		
		$applyDate = date('Y/m/d', strtotime($this->__atDate . ' +1 day'));
		
		$conditions = array(
			'racer_code' => $racerCode,
			'meet_code' => $this->__meetCode,
			'category_code' => $this->__rankUpMap[$racesCat]['to'],
			'apply_date' => $applyDate,
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
		);
		$this->CategoryRacer->deleteAll($conditions);
		
		$cr = array();
		$cr['CategoryRacer'] = array();
		$cr['CategoryRacer']['racer_code'] = $racerCode;
		$cr['CategoryRacer']['category_code'] = $this->__rankUpMap[$racesCat]['to'];
		$cr['CategoryRacer']['apply_date'] = $applyDate;
		$cr['CategoryRacer']['reason_id'] = CategoryReason::$RESULT_UP->ID();
		if ($result['rank'] > $rankUpCount) {
			$cr['CategoryRacer']['reason_note'] = "繰り上げ昇格";
		} else {
			$cr['CategoryRacer']['reason_note'] = "";
		}
		$cr['CategoryRacer']['racer_result_id'] =  $result['id'];
		$cr['CategoryRacer']['meet_code'] = $this->__meetCode;
		$cr['CategoryRacer']['cancel_date'] = null;

		$this->CategoryRacer->create();
		if (!$this->CategoryRacer->save($cr)) {
			$this->log('昇格の選手カテゴリー Bind の保存に失敗しました。', LOG_ERR);
			return Constant::RET_FAILED;
		}
		
		$this->log('Racer[code:' . $racerCode . '] にカテゴリー:' . $cr['CategoryRacer']['category_code']
				. 'を適用 cr.id:' . $this->CategoryRacer->id, LOG_DEBUG);

		//$this->log('(with rank-up) will give give hold point to:' . $map[$rcatCode]['to'], LOG_DEBUG);
		$hp = array();
		$hp['HoldPoint'] = array();
		$hp['HoldPoint']['racer_result_id'] = $result['id'];
		$hp['HoldPoint']['point'] = 3;
		$hp['HoldPoint']['category_code'] = $this->__rankUpMap[$racesCat]['to'];
		
		$this->HoldPoint->create();
		if (!$this->HoldPoint->save($hp)) {
			$this->log('新カテゴリーに対する残留ポイントの保存に失敗しました。', LOG_ERR);
			return Constant::RET_FAILED;
		}
		
		return Constant::RET_SUCCEED;
	}
	
	/**
	 * ある選手についてレースカテゴリーの昇格先カテゴリーに適用する年齢であるかをかえす
	 * @param type $racerCode 選手コード
	 * @param type $racesCat レースカテゴリー
	 * @return boolean 正しい年齢であるか。誕生日が不明な場合も true をかえす。
	 */
	private function __isProperAgeForCat($racerCode, $racesCat)
	{
		if (empty($racerCode) || empty($racesCat)) {
			$this->log('__isProperAgeForCat の引数が不正です。暫定として true を返します。', LOG_ERR);
			return true;
		}
		
		// 昇格に該当するかをチェック
		if ($racesCat == 'C2' || $racesCat == 'C3' || $racesCat == 'C4' || $racesCat == 'C3+4') {
			$conditions = array('code' => $racerCode);
			$racer = $this->Racer->find('first', array('conditions' => $conditions, 'recursive' => -1));
			
			if (!empty($racer['Racer']['birth_date'])) {
				$birth = $racer['Racer']['birth_date'];
				// uci cx age をチェック
				$meetDate = new DateTime($this->__atDate);
				$uciCxAge = Util::uciCXAgeAt(new DateTime($birth), $meetDate);
				//$this->log('uciCxAge:' . $uciCxAge, LOG_DEBUG);
				
				$isBadAge = false;
				$catTo = $this->__rankUpMap[$racesCat]['to'];
				
				if ($catTo == 'C1') {
					// U23 以上
					$isBadAge = ($uciCxAge < 19);
				} else if ($catTo == 'C2') {
					// Junior 以上
					$isBadAge = ($uciCxAge < 17);
				} else if ($catTo == 'C3') {
					// Youth? 以上
					$isBadAge = false;// ($uciCxAge < 15); 2015/12 の AJOCC 会議にて Youth でも C3 に昇格 OK とする
				}
				// TODO: カテゴリーの設定から引き出すように。（DB 上データを修正してから）
				
				if ($isBadAge) {
					$this->log('選手:' . $racerCode . 'について、対象年齢外のため、昇格なしとしました。', LOG_NOTICE);
					$this->log('$uciCxAge:' . $uciCxAge, LOG_DEBUG);
					
					return false;
				}
			} else {
				$this->log('昇格処理において選手の生年月日が不明でした。選手コード:' . $racerCode
					. ' --> 昇格は適用しますが、チェックが必要です。', LOG_WARNING);
			}
		}
		
		return true;
	}
	
	/**
	 * 指定カテゴリーの所属に cancel_date を設定する
	 * @param string $racerCode 選手コード
	 * @param string $racesCat レースカテゴリー
	 * @param array $catList cancel の対象となるカテゴリー code の配列
	 */
	private function __setupCatRacerCancel($racerCode, $catList)
	{
		// 既存のカテゴリー所属を削除
		
		$conditions = array(
			'racer_code' => $racerCode,
			'OR' => array(
				array('cancel_date' => null),
				array('cancel_date >=' => $this->__atDate)
			),
			'apply_date <=' => $this->__atDate
		);
		
		$catBinds = $this->CategoryRacer->find('all', array('conditions' => $conditions, 'recursive' => -1));
		
		$rStatus = Constant::RET_SUCCEED;
		
		foreach ($catBinds as $catBind) {
			if (in_array($catBind['CategoryRacer']['category_code'], $catList)) {
				
				$cr = array(
					'id' => $catBind['CategoryRacer']['id'],
					'cancel_date' => $this->__atDate
				);
				
				if (!$this->CategoryRacer->save($cr)) {
					$this->log('CategoryRacer の cancel_date 設定->保存に失敗', LOG_ERR);
					$rStatus = Constant::RET_FAILED;
					// continue
				} else {
					$this->log('catRacer[id:' . $catBind['CategoryRacer']['id'] . ' に cancel date:'
							. $this->__atDate . ' を適用', LOG_DEBUG);
				}
			}
		}
		
		return $rStatus;
	}
	
	/**
	 * 昇格する人数をかえす
	 * @param string $racesCat レースカテゴリー Code
	 * @return int 昇格する人数 
	 */
	private function __rankUpRacerCount($racesCat)
	{
		if (empty($this->__rankUpMap[$racesCat])) {
			return -1;
		}
	
		$rule = $this->__rankUpMap[$racesCat]['rule'];
		
		// 人数と順位についてチェック
		$rankUpCount = 0;
		$baseCount = $this->_isSeasonBefore1617() ? $this->__finished : $this->__started;
		// 2016-17 から出走人数に
		for ($i = 0; $i < count($rule); $i++) {
			$racerCount = $rule[$i]['racer_count'];
			if ($baseCount >= $racerCount) {
				$rankUpCount = $rule[$i]['up'];
				break;
			}
		}
		
		$this->log('rank up count:' . $rankUpCount, LOG_DEBUG);
		
		return $rankUpCount;
	}
	
	/**
	 * 大会に設定されたポイントを計算し、適用する。
	 * @param string $racerCode 選手コード
	 * @param int $result リザルト
	 * @param string $ecatName 出走カテゴリー名前
	 * @return int Constant.RET_ のいずれか
	 */
	private function __resetSeriesPoints($racerCode, $result, $ecatName)
	{
		if (empty($racerCode) || empty($result) || empty($ecatName)
				|| empty($this->__topLapCount) || empty($this->__started)) {
			return Constant::RET_ERROR;
		}
		
		// 既存のシリーズポイントの削除
		if (!$this->PointSeriesRacer->deleteAll(array('racer_result_id' => $result['id']))) {
			return Constant::RET_FAILED;
		}
		
		$conditions = array(
			'meet_code' => $this->__meetCode,
			'entry_category_name' => $ecatName
		);
		$pts = $this->MeetPointSeries->find('all', array('conditions' => $conditions));
		
		$rStatus = Constant::RET_SUCCEED;
		
		foreach ($pts as $ptSetting) {
			//$this->log('pt setting:', LOG_DEBUG);
			//$this->log($ptSetting, LOG_DEBUG);
			
			$calc = PointCalculator::getCalculator($ptSetting['PointSeries']['calc_rule']);
			if (empty($calc)) return;
			
			$pt = $calc->calc($result, $ptSetting['MeetPointSeries']['grade'], $this->__topLapCount, $this->__started);
			if (!empty($pt)) {
				$psr = array();
				$psr['PointSeriesRacer'] = array(
					'racer_code' => $racerCode,
					'point_series_id' => $ptSetting['PointSeries']['id'],
					'racer_result_id' => $result['id'],
					'meet_point_series_id' => $ptSetting['MeetPointSeries']['id'],
				);
				
				$this->log('series point to racer:' . $racerCode . ' ptSeries:' . $ptSetting['PointSeries']['id']
						. ' toResult:' . $result['id'] . ' mps:' . $ptSetting['MeetPointSeries']['id'], LOG_DEBUG);
				
				if (!empty($pt['point'])) {
					$psr['PointSeriesRacer']['point'] = $pt['point'];
					$this->log('point:' . $pt['point'], LOG_DEBUG);
				}
				if (!empty($pt['bonus'])) {
					$psr['PointSeriesRacer']['bonus'] = $pt['bonus'];
					$this->log('bonus:' . $pt['bonus'], LOG_DEBUG);
				}
				
				$this->PointSeriesRacer->create();
				if (!$this->PointSeriesRacer->save($psr)) {
					$this->log('ポイントシリーズ' . $ptSetting['PointSeries']['name'] . 'のポイント計算に失敗しました。', LOG_ERR);
					$rStatus = Constant::RET_FAILED;
				}
			}
		}
		
		return $rStatus;
	}
	
	/**
	 * 残留ポイントを計算し、設定する。
	 * @param string $racerCode 選手コード
	 * @param int $result リザルト
	 * @param string $ecat 出走カテゴリー
	 * @return boolean ???
	 */
	private function __resetHoldPoint($racerCode, $result, $ecat)
	{
		if (empty($racerCode) || empty($result) || empty($ecat)) {
			return Constant::RET_ERROR;
		}
		
		// 既存データの削除
		if (!$this->HoldPoint->deleteAll(array('racer_result_id' => $result['id']))) {
			return Constant::RET_FAILED;
		}
		
		if ($ecat['applies_hold_pt'] != 1) {
			return Constant::RET_NO_ACTION;
		}
		
		if (!(isset($result['rank_per']) && $result['rank_per'] === 0)) { // ゼロパーセントはポイントあり
			if (empty($result['rank_per'])) {
				return Constant::RET_NO_ACTION;
			}
		}
		if ($result['rank_per'] > 66) {
			return Constant::RET_NO_ACTION;
		}
		
		$point = ($result['rank_per'] <= 25) ? 3 : 1;
		
		// 付与先カテゴリーの取得
		$asCat = $this->__asCategory($racerCode, $ecat, $this->__atDate);
		if (empty($asCat)) {
			return Constant::RET_ERROR;
		}
		
		// TODO: 残留ポイントを付けるカテゴリーであるかをパラメタから
		$holdPointCats = array('C1', 'C2', 'C3', 'C4', 'CM1', 'CM2', 'CM3');
		
		if (!in_array($asCat, $holdPointCats)) {
			return Constant::RET_NO_ACTION;
		}
		
		$hp = array();
		$hp['HoldPoint'] = array();
		$hp['HoldPoint']['racer_result_id'] = $result['id'];
		$hp['HoldPoint']['point'] = $point;
		$hp['HoldPoint']['category_code'] = $asCat;
		
		$this->HoldPoint->create();
		if (!$this->HoldPoint->save($hp)) {
			return Constant::RET_FAILED;
		}
		
		$this->log('残留ポイント save toResult:' . $result['id'] . ' pt:' . $point . ' as ' . $asCat, LOG_DEBUG);
		
		return Constant::RET_SUCCEED;
	}
	
	/**
	 * レース時に「どのカテゴリーの選手として出走したか」をかえす
	 * @param string $racerCode 選手 Code
	 * @param array $ecat レースの出走カテゴリー
	 * @param date $atDate 判定日
	 * @return string カテゴリー Code
	 */
	public function asCategory($racerCode, $ecat, $atDate)
	{
		$this->CategoryRacer = new CategoryRacer();
		$this->CategoryRacer ->Behaviors->load('Utils.SoftDelete');
		$this->RacesCategory = new RacesCategory();
		$this->RacesCategory->Behaviors->load('Utils.SoftDelete');
		
		return $this->__asCategory($racerCode, $ecat, $atDate);
	}
	
	/**
	 * レース時に「どのカテゴリーの選手として出走したか」をかえす
	 * @param string $racerCode 選手 Code
	 * @param array $ecat レースの出走カテゴリー
	 * @param date $atDate 判定日
	 * @return string カテゴリー Code
	 */
	private function __asCategory($racerCode, $ecat, $atDate)
	{
		if (empty($racerCode) || empty($ecat)) {
			$this->log('as category 取得に必要な引数が不足しています。', LOG_ERR);
			return null;
		}
		
		$opt = array(
			'conditions' => array(
				'racer_code' => $racerCode,
				'AND' => array(
					'NOT' => array('apply_date' => null), 
					'apply_date <=' => $atDate
				),
				array('OR' => array(
					array('cancel_date' => null),
					array('cancel_date >=' => $atDate),
				)),
			),
			'recursive' => 1,
		);
		//$this->log('condition:', LOG_DEBUG);
		//$this->log($opt, LOG_DEBUG);
		$cats = $this->CategoryRacer->find('all', $opt);
		
		$opt = array(
			'conditions' => array('code' => $ecat['races_category_code']),
			'recursive' => 2
		);
		$rcat = $this->RacesCategory->find('first', $opt);
		
		/*$this->log('rcat:', LOG_DEBUG);
		$this->log($rcat, LOG_DEBUG);
		$this->log('cats:', LOG_DEBUG);
		$this->log($cats, LOG_DEBUG);//*/
		
		// デフォルト値は ecat.races_cat_code とする
		$ret = $ecat['races_category_code'];
		$isSingleCat = false;
		
		// レースに設定されたカテゴリー（rank の低い方）とする
		if (!empty($rcat)) {
			$catsOnRace = array();
			foreach ($rcat['CategoryRacesCategory'] as $crc) {
				if (!empty($crc['Category'])) {
					$catsOnRace[] = $crc['Category'];
				}
			}
			
			if (!empty($catsOnRace)) {
				if (count($catsOnRace) == 1) {
					$ret = $catsOnRace[0]['code'];
					$isSingleCat = true;
				} else {
					$ret = $this->__getLowRankedCatCode($catsOnRace);
				}
			}
		}
		
		if (!$isSingleCat && !empty($cats)) {
			// 所持しているカテゴリーのうち、レースに設定されていて、高い方とする。
			$catCodesOnRace = array();
			foreach ($rcat['CategoryRacesCategory'] as $crc) {
				if (!empty($crc['Category'])) {
					$catCodesOnRace[] = $crc['Category']['code'];
				}
			}
			
			//$this->log('$catCodesOnRace:', LOG_DEBUG);
			//$this->log($catCodesOnRace, LOG_DEBUG);
			
			$catCodes = array();
			foreach ($cats as $c) {
				$code = $c['CategoryRacer']['category_code'];
				if (in_array($code, $catCodesOnRace)) {
					$catCodes[] = $c['Category'];
				}
			}
			
			//$this->log('$catCodes', LOG_DEBUG);
			//$this->log($catCodes, LOG_DEBUG);
			
			if (!empty($catCodes)) {
				$ret = $this->__getHighRankedCatCode($catCodes);
			}
		}
		
		return $ret;
	}
	
	/**
	 * 高い順位（=低い rank 値）が設定されたカテゴリーの Code をかえす。
	 * @param type $cats カテゴリー配列
	 * @return string カテゴリー Code。比較ができない場合は第1要素をかえす。エラーの場合 null をかえす。
	 */
	private function __getHighRankedCatCode($cats = array()) {
		if (empty($cats)) {
			return null;
		}
		
		$highCat = $cats[0];
		
		for ($i = 1; $i < count($cats); $i++) {
			$cat = $cats[$i];
			
			if (!empty($cat['rank'])) {
				if (empty($highCat['rank']) || $cat['rank'] < $highCat['rank']) {
					$highCat = $cat;
				}
			}
		}
		
		return $highCat['code'];
	}
	
	/**
	 * 低い順位（=高い rank 値）が設定されたカテゴリーの Code をかえす。
	 * @param type $cats カテゴリー配列
	 * @return string カテゴリー Code。比較ができない場合は第1要素をかえす。エラーの場合 null をかえす。
	 */
	private function __getLowRankedCatCode($cats = array()) {
		if (empty($cats)) {
			return null;
		}
		
		$lowerCat = $cats[0];
		
		for ($i = 1; $i < count($cats); $i++) {
			$cat = $cats[$i];
			
			if (!empty($cat['rank'])) {
				if (empty($lowerCat['rank']) || $cat['rank'] > $lowerCat['rank']) {
					$lowerCat = $cat;
				}
			}
		}
		
		return $lowerCat['code'];
	}
	
	/**
	 * 計算に必要な値をセットする。
	 * @param array $results 出走選手の配列 array(array('id' => 123, 'body' => 246,,,), array('id' => ,,,))
	 * @return boolean ただしく計算できたか
	 */
	private function __setupParams($results)
	{	
		$this->TransactionManager = new TransactionManager();
		
		$this->Racer = new Racer();
		$this->Racer->Behaviors->load('Utils.SoftDelete');
		$this->EntryGroup = new EntryGroup();
		$this->EntryGroup->Behaviors->load('Utils.SoftDelete');
		$this->EntryCategory = new EntryGroup();
		$this->EntryCategory->Behaviors->load('Utils.SoftDelete');
		$this->CategoryRacer = new CategoryRacer();
		$this->CategoryRacer ->Behaviors->load('Utils.SoftDelete');
		$this->RacesCategory = new RacesCategory();
		$this->RacesCategory->Behaviors->load('Utils.SoftDelete');
		$this->MeetPointSeries = new MeetPointSeries();
		$this->MeetPointSeries->Behaviors->load('Utils.SoftDelete');
		$this->RacerResult = new RacerResult();
		$this->RacerResult->Behaviors->load('Utils.SoftDelete');
		
		$this->HoldPoint = new HoldPoint();
		$this->PointSeriesRacer = new PointSeriesRacer();
		
		if (empty($results)) {
			$this->__topLapCount = 0;
			$this->__started = 0;
			$this->__finished = 0;
			return false;
		}
		
		foreach ($results as $result) {
			$r = $result['RacerResult'];
			
			if (!empty($r['lap'])) {
				$lap = $r['lap'];
				if ($lap > $this->__topLapCount) {
					$this->__topLapCount = $lap;
				}
			}
			
			if (empty($result['EntryRacer'])) {
				continue;
			}
			
			if ($result['EntryRacer']['entry_status'] != RacerEntryStatus::$OPEN->val()) {
				$rstatus = $r['status'];
				if ($rstatus != RacerResultStatus::$DNS->val()) {
					++$this->__started;
					if ($rstatus == RacerResultStatus::$FIN->val()
							|| $rstatus == RacerResultStatus::$LAPOUT->val()
							|| $rstatus == RacerResultStatus::$LAPOUT80->val()) {
						++$this->__finished;
					}
				}
			}
		}
		
		$this->log('started:' . $this->__started . ' fin:' . $this->__finished . ' topLap:' . $this->__topLapCount, LOG_DEBUG);
		
		return true;
	}
	
	/**
	 * 昇格ルールパラメタを作成する
	 */
	private function __setupRankUpRules()
	{	
		// BETAG
		
		// 文字列で判断する
		// パラメタから処理したいが、複雑なのでやめておく。
		// racesCatCode => array('needs' => 必要な所属, 'to' =>昇格先)
		$this->__rankUpMap = array(
			'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $this->__rule0111),
			'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $this->__rule0123),
			'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $this->__rule0123),
			'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $this->__rule0123),
			'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $this->__rule0111),
			'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $this->__rule0123),
			'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $this->__rule0111),
		);
		
		if ($this->_isSeasonBefore1617()) {
			// 2015-16 シーズンは C2, CM2 ともに昇格人数が1人に制限される前だった
			$this->__rankUpMap['C2']['rule'] = $this->__rule0123;
			$this->__rankUpMap['CM2']['rule'] = $this->__rule0112;
			$this->__rankUpMap['C2+3']['rule'] = $this->__rule0112;
		}
	}
	
	/**
	 * 2016-17 シーズンより前のシーズンであるかをかえす
	 * @return boolean 
	 */
	private function _isSeasonBefore1617()
	{
		if (empty($this->__atDate)) {
			return true; // unlikely... 本メソッドを作成したのが1617なので巻き戻りはなしので true かえす。
		}
		
		return ($this->__atDate < '2016-04-01');
	}
	
	/**
	 * $atDate メンバをセットする
	 * @param array $ecat 出走カテゴリー情報 key 'EntryCategory' 以下の配列
	 */
	private function __setupMeetParams($ecat) {
		$this->__atDate = null;
		$this->__meetCode = null;

		if (empty($ecat) || empty($ecat['entry_group_id'])) {
			return;
		}
		
		$egroup = $this->EntryGroup->find('first', array('conditions' => array('EntryGroup.id' => $ecat['entry_group_id'])));
		if (!empty($egroup)) {
			if (!empty($egroup['Meet']['at_date'])) {
				$this->__atDate = $egroup['Meet']['at_date'];
				$this->__meetCode = $egroup['Meet']['code'];
			}
		}
		
		$this->log('param __atDate:' . $this->__atDate . ' meetCode:' . $this->__meetCode, LOG_DEBUG);
	}
	
	/**
	 * 昇格処理用ソートコールバック。 ['RacerResult']['rank'] の値を比較する。順位順にならべる。null は最後。
	 * @param type $a
	 * @param type $b
	 * @return int 順序
	 */
	public static function __compare_results_rank($a, $b)
	{
		if (empty($a['RacerResult']['rank'])) {
			if (empty($b['RacerResult']['rank'])) {
				return 0;
			}
			return 1;
		} else if (empty($b['RacerResult']['rank'])) {
			return -1;
		}
		
		return $a['RacerResult']['rank'] - $b['RacerResult']['rank'];
	}
}
