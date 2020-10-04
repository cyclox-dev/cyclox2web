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
App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
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
	private $__rule0123_til167 = array( // 16-17 までのルール
		array('racer_count' => 50, 'up' => 3),
		array('racer_count' => 20, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule0123 = array(
		array('racer_count' => 40, 'up' => 3),
		array('racer_count' => 20, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule0112_til167 = array( // 16-17 までのルール
		array('racer_count' => 50, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule0112 = array(
		array('racer_count' => 40, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule011122 = array(
		array('racer_count' => 40, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule012345 = array(
		array('racer_count' => 50, 'up' => 5),
		array('racer_count' => 40, 'up' => 4),
		array('racer_count' => 30, 'up' => 3),
		array('racer_count' => 20, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	private $__rule012333 = array( // 20-21 rule
		array('racer_count' => 30, 'up' => 3),
		array('racer_count' => 20, 'up' => 2),
		array('racer_count' => 10, 'up' => 1),
	);
	
	private $TransactionManager;
	private $Racer;
	private $EntryRacer;
	private $EntryCategory;
	private $EntryGroup;
	private $HoldPoint;
	private $CategoryRacer;
	private $RacesCategory;
	private $PointSeriesRacer;
	private $MeetPointSeries;
	private $RacerResult;
	private $Meet;
	
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
				if (!empty($eracer['RacerResult']) && !$eracer['deleted']) {
					$er = array();
					$er['EntryRacer'] = $eracer;
					$er['RacerResult'] = $eracer['RacerResult'];

					$ers[] = $er;
				}
			}
			
			if (count($ers) == 0) {
				$this->Flash->set(__('リザルトが設定されていません。'));
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
			$isOpenRacer = ($result['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
			
			$point = empty($r['rank']) ? 0 : $this->calcAjoccPt($r['rank'], $this->__started, $this->__atDate);
			
			if ($ecat['applies_ajocc_pt']) {
				// 1920からは ajocc_pt = null 設定あり。null な箇所のポイントは平均に参入しない。出走レース数にも含めない。
				$ajoccPt = ($this->_isSeasonAfter1819()) ? null : 0;
				
				if (!$isOpenRacer
						&& !($this->_isSeasonAfter1819() && $r['status'] == RacerResultStatus::$DNS->val()))
						// DNS はポイント null @kgym@20190814
				{
					//$this->log('ajocc pt:' . $point, LOG_DEBUG);
					if ($point == -1) {
						$this->log('AjoccPoint が計算できません。result-id:' . $r['id'] . ' --> ptなしで続行します。', LOG_ERR);
					} else {
						$ajoccPt = $point;
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
	 * @param dateString $meetDate 大会日付
	 * @return int ポイント。エラーの場合 -1 をかえす。リザルトステータスは見ず、ポイントなしはゼロをかえす。
	 */
	public function calcAjoccPt($rank, $startedCount, $meetDate)
	{
		if ($startedCount <= 0) {
			return -1;
		}
		
		if (empty($rank)) {
			return 0;
		}
		
		$mtDate = new DateTime($meetDate);
		$divDate = new DateTime('2017-04-01');
		//$this->log('meet date is before 2016-17 ? :' . ($mtDate < $divDate) , LOG_DEBUG);
		
		// 2017-18 に若干変更
		if ($mtDate < $divDate) {
			//$this->log('is season before 17-18', LOG_DEBUG);
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
		} else {
			//$this->log('is season aftereq 17-18', LOG_DEBUG);
			$map = array(
				array(
					'started_over' => 39, 'points' => array(
						56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
						16, 14, 13, 12, 11, 10,  9,  9,  8,  8,
						 7,  7,  7,  6,  6,  6,  5,  5,  5,  5,
						 4,  4,  4,  4,  3,  3,  3,  3,  3,  3,
						 2,  2,  2,  2,  2,  2,  2,  1,  1,  1,
						 1,  1,  1,  1,  1,  1,  1,  1,  1,  1,
					)
				),
				array(
					'started_over' => 19, 'points' => array(
						42, 34, 28, 24, 21, 18, 15, 13, 11, 10,
						9,  8,  7,  6,  6,  5,  5,  4,  4,  4,
						3,  3,  3,  3,  2,  2,  2,  2,  2,  2,
						2,  1,  1,  1,  1,  1,  1,  1,  1,
					)
				),
				array(
					'started_over' => 0, 'points' => array(
						28, 20, 15, 12, 10, 8,  6,  5,  4,  3,
						3,  2,  2,  2,  1,  1,  1,  1,  1,
					)
				)
			);
		}
		
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
		$mt = $this->__getMeetInfoOfEcat($ecat['id']);
		
		foreach ($results as $result) {
			$r = $result['RacerResult'];
			$er = $result['EntryRacer'];
			unset($er['RacerResult']); // メモリ節約

			$isOpenRacer = ($er['entry_status'] == RacerEntryStatus::$OPEN->val());
			if ($isOpenRacer) {
				continue;
			}

			// 残留ポイントの再計算
			// 19-20からは計算しない（実際には18-19から計算しないが、比較計算などのためにおいておいた。）
			if (isset($mt['at_date']) && $mt['at_date'] < '2019-04-01') {
				$ret = $this->__resetHoldPoint($er['racer_code'], $r, $ecat);
				if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
					$this->log($er['racer_code'] . ' の残留ポイントの設定処理に失敗しました。', LOG_ERR);
					// continue
				}
			}

			// シリーズポイントの再計算
			$ret = $this->__resetSeriesPoints($er['racer_code'], $r, $ecat['name']);
			if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
				$this->log($er['racer_code'] . ' のポイント計算に失敗しました。', LOG_ERR);
				// continue
			}
		}

		$racesCat = $ecat['races_category_code'];

		if ($ecat['applies_rank_up'] == 0) {
			return true;
		}
		
		if ($racesCat === 'CM1+2+3') {
			// M1+2+3 は勝利したら CM1、表彰台で CM2（降格なし）
			
			$rankUpCount = 3;
			// 2017-18 から人数制限あり
			if ($this->_isSeasonAfter1617()) {
				$rankUpCount = 0;
				foreach ($this->__rule0123 as $rule) {
					if ($this->__started >= $rule['racer_count']) {
						$rankUpCount = $rule['up'];
						break;
					}
				}
			}

			if ($rankUpCount > 0) {
				foreach ($results as $result) {
					$isOpenRacer = ($result['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
					if ($isOpenRacer) {
						continue;
					}

					$er = $result['EntryRacer'];
					$r = $result['RacerResult'];

					if ($r['rank'] == 1) {
						$this->__applyRankUp2CM($er['racer_code'], 'CM1', $r);
					} else if ($r['rank'] > 1 && $r['rank'] <= $rankUpCount) {
						$this->__applyRankUp2CM($er['racer_code'], 'CM2', $r);
					}
				}
			}
		} else if ($this->__started >= 6 && ($racesCat == 'CL2' || $racesCat == 'CL2+3')) {
			// シリーズ2勝で昇格
			foreach ($results as $result) {
				$r = $result['RacerResult'];

				if ($r['rank'] != 1) continue;

				// 年齢チェック
				if (!$this->__isProperAgeForCat($result['EntryRacer']['racer_code'], 'CL1')) {
					break; // 1位は見つけているので処理終了
				}

				// そのシーズン、での成績を取得 -> 1位があるかチェック

				$mt = $this->__getMeetInfoOfEcat($ecat['id']);
				if ($mt == null) {
					$this->log('少人数昇格のための大会情報の取得に失敗しました。', LOG_ERR);
					break;
				}

				$ecatIds = $this->__getEcatIDsOfSameMeet($mt, array('CL2', 'CL2+3'), false);
				if ($ecatIds === null) {
					$this->log('少人数昇格のための出走カテゴリー ID 配列の取得に失敗しました。', LOG_ERR);
					break;
				}
				
				if (empty($ecatIds)) break; // 1位をチェックしたのでループ終了

				$opt = array('conditions' => array(
					'EntryCategory.id' => $ecatIds,
					'EntryRacer.racer_code' => $result['EntryRacer']['racer_code'],
					'RacerResult.deleted' => 0,
					'Racer.deleted' => 0,
					'EntryCategory.deleted' => 0,
				));

				$ers = $this->EntryRacer->find('all', $opt);
				//$this->log('ers:', LOG_DEBUG);
				//$this->log($ers, LOG_DEBUG);

				$rankUps = false;
				foreach ($ers as $entryRacer) {
					
					//$this->log('races cat:', LOG_DEBUG);
					//$this->log($entryRacer['EntryCategory']['races_category_code'], LOG_DEBUG);
					
					if (!empty($entryRacer['RacerResult']['rank']) && $entryRacer['RacerResult']['rank'] == 1) {
						// ただしその出走人数が6人以上であること
						$opt = array('conditions' => array(
							'entry_category_id' => $entryRacer['EntryCategory']['id'],
							'RacerResult.deleted' => 0,
						));
						$erInfos = $this->EntryRacer->find('all', $opt);
						//$this->log($erInfos, LOG_DEBUG);
						
						// 出走人数をカウント
						$startCount = 0;
						foreach ($erInfos as $erInfo) {
							if ($erInfo['RacerResult']['status'] != RacerResultStatus::$DNS->val()) {
								++$startCount;
							}
						}
						//$this->log('started:' . $startCount, LOG_DEBUG);

						if ($startCount >= 6) {
							$rankUps = true;
							break;
						}
					}
				}

				if ($rankUps) {
					$ret = $this->__execApplyRankUp($result['EntryRacer']['racer_code'], $r, 'シーズン2勝', 'CL1', false);

					if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
						$this->log('昇格適用に失敗しました。', LOG_ERR);
						return false;
					}

					if ($ret == Constant::RET_SUCCEED) {
						$ret = $this->__setupCatRacerCancel($result['EntryRacer']['racer_code'], array('CL2'));
						if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
							$this->log('選手[coce:' . $result['EntryRacer']['racer_code'] . '] のカテゴリー所属の cancel_date 設定に失敗しました。', LOG_ERR);
							// not return false
						}
					}
				}

				break; // 1位をチェックしたのでループ終了
			}
		} else {
			// 昇格する人数の決定
			$rankUpCount = $this->__rankUpRacerCount($racesCat);

			if ($rankUpCount > 0) {
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
						$ret = $this->__applyRankUp($result['EntryRacer']['racer_code'], $this->__rankUpMap[$racesCat]['to'], $r, $rankUpCount);
						if ($ret != Constant::RET_NO_ACTION) {
							--$count; // failed, error でも繰り上げしない
						}
						if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
							$this->log('昇格適用に失敗しました。', LOG_ERR);
							return false;
						}

						if ($ret == Constant::RET_SUCCEED) {
							$ret = $this->__setupCatRacerCancel($result['EntryRacer']['racer_code'], $this->__rankUpMap[$racesCat]['needs']);
							if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
								$this->log('選手[coce:' . $result['EntryRacer']['racer_code'] . '] のカテゴリー所属の cancel_date 設定に失敗しました。', LOG_ERR);
								// continue
							}
						}
					}
				}
			} else if ($this->__started >= 5 && $this->__started <= 9
					&& ($racesCat == 'C2' || $racesCat == 'C3' || $racesCat == 'C4' || $racesCat == 'C3+4')) { // BETAG
				// シリーズ少人数（5-9人）2勝で昇格
				foreach ($results as $result) {
					$r = $result['RacerResult'];
					
					if ($r['rank'] != 1) continue;
					
					// そのシーズン、同じシリーズでの成績を取得 -> 1位があるかチェック
					
					$mt = $this->__getMeetInfoOfEcat($ecat['id']);
					if ($mt == null) {
						$this->log('少人数昇格のための大会情報の取得に失敗しました。', LOG_ERR);
						break;
					}

					$needRacesCat = array($racesCat);
					if ($racesCat == 'C3' || $racesCat == 'C4') {
						// C3 レースで以前に C3+4 で勝っているなら昇格 to C2
						// C4 レースでも以前に C3+4 で勝っているなら昇格 to C3
						$needRacesCat[] = 'C3+4';
					} else if ($racesCat == 'C3+4') {
						$needRacesCat[] = 'C3';
						$needRacesCat[] = 'C4';
						/*
						// C3 所属しているなら以前の C3(orC3+4) レースがあるかチェックで C2 へ昇格
						// C3 所属していないなら C4(orC3+4) レースがあるかチェックで C3 へ昇格
						if ($this->__hasC3Cat($result['EntryRacer']['racer_code'])) {
							$catTo = 'C2';
							$needRacesCat[] = 'C3';
						} else {
							$catTo = 'C3';
							$needRacesCat[] = 'C4';
							$cancelCats = array('C4'); //C3 はキャンセルしない
						}//*/
					}
					
					$ecatIds = $this->__getEcatIDsOfSameMeet($mt, $needRacesCat);
					if ($ecatIds === null) {
						$this->log('少人数昇格のための出走カテゴリー ID 配列の取得に失敗しました。', LOG_ERR);
						break;
					}
					
					if (empty($ecatIds)) break; // 1位をチェックしたのでループ終了

					$opt = array('conditions' => array(
						'EntryCategory.id' => $ecatIds,
						'EntryRacer.racer_code' => $result['EntryRacer']['racer_code'],
						'RacerResult.rank' => 1,
						'RacerResult.deleted' => 0,
						'Racer.deleted' => 0,
						'EntryCategory.deleted' => 0,
					));

					$ers = $this->EntryRacer->find('all', $opt);
					//$this->log('ers:', LOG_DEBUG);
					//$this->log($ers, LOG_DEBUG);

					$catTo = $this->__rankUpMap[$racesCat]['to'];
					$cancelCats = $this->__rankUpMap[$racesCat]['needs'];
					
					$rankUps = false;
					$rankUpTo = null;
					foreach ($ers as $entryRacer) {
						// ただしその出走人数が5-9人であること
						$opt = array('conditions' => array(
							'entry_category_id' => $entryRacer['EntryCategory']['id'],
							'RacerResult.deleted' => 0,
							'NOT' => array('RacerResult.status' => RacerResultStatus::$DNS->val()),
						));

						$erCount = $this->EntryRacer->find('count', $opt);
							//$this->log('er count:' . $erCount . ' id:' . $entryRacer['EntryCategory']['id'], LOG_DEBUG);
							//$this->log($erCount, LOG_DEBUG);

						if ($erCount >= 5 && $erCount <= 9) {
							$rankUps = true;
							if ($racesCat == 'C3+4') { // 特殊処理
								if ($entryRacer['EntryCategory']['races_category_code'] == 'C3'
										|| $entryRacer['EntryCategory']['races_category_code'] == 'C3+4') {
									// 過去に C3 or C3+4 で少人数勝利しているなら C2 に昇格
									$rankUpTo = 'C2';
									$cancelCats = array('C3', 'C4');
								} else if ($entryRacer['EntryCategory']['races_category_code'] == 'C4') {
									// 過去に C4 で少人数勝利しているなら C3 に昇格
									if ($rankUpTo != 'C2') {
										$rankUpTo = 'C3';
										$cancelCats = array('C4'); // C3 はキャンセルしない
									}
								}
								// not break
							} else {
								break;
							}
						}
					}
					
					if (!is_null($rankUpTo)) {
						$catTo = $rankUpTo;
					}
					
					// 年齢チェック
					if ($rankUps) {
						if (!$this->__isProperAgeForCat($result['EntryRacer']['racer_code'], $catTo)) {
							break; // 1位は見つけているので処理終了
						}
					}
					
					if ($rankUps) {
						$ret = $this->__execApplyRankUp($result['EntryRacer']['racer_code'], $r, '少人数シーズン2勝', $catTo);
						
						if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
							$this->log('昇格適用に失敗しました。', LOG_ERR);
							return false;
						}

						if ($ret == Constant::RET_SUCCEED) {
							$ret = $this->__setupCatRacerCancel($result['EntryRacer']['racer_code'], $cancelCats);
							if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
								$this->log('選手[coce:' . $result['EntryRacer']['racer_code'] . '] のカテゴリー所属の cancel_date 設定に失敗しました。', LOG_ERR);
								// not return false
							}
						}
					}

					break; // 1位をチェックしたのでループ終了
				}
			}
		}
		
		return true;
	}
	
	/**
	 * 指定大会とシーズン、同じ大会グループである大会の出走カテゴリー ID の配列をかえす。
	 * @param type $meet 大会データ
	 * @param array $racesCats 抽出する対象のレースカテゴリーの配列
	 * @param boolean $limitsSameMtGroup 同じ大会グループに限定するか
	 * @return type エラーの場合 null をかえす
	 */
	private function __getEcatIDsOfSameMeet($meet, $racesCats, $limitsSameMtGroup = true)
	{
		if (empty($meet)) return null;
		
		$this->Meet->Behaviors->load('Containable');
							
		$opt = array('conditions' => array(
			'season_id' => $meet['season_id'],
			'NOT' => array('Meet.code' => $meet['code']), // 本大会を除外
			'at_date <' => $meet['at_date']
			),
			'contain' => array(
				'EntryGroup' => array(
					'fields' => array(),
					'EntryCategory' => array(
						'fields' => array('id', 'races_category_code'),
					)
				)
			)
		);
		
		if ($limitsSameMtGroup) {
			$opt['conditions']['meet_group_code'] = $meet['meet_group_code'];
		}

		$mts = $this->Meet->find('all', $opt);
		
		$ecatIds = array();
		foreach ($mts as $meet) {
			foreach ($meet['EntryGroup'] as $eg) {
				foreach ($eg['EntryCategory'] as $ecat) {
					if (in_array($ecat['races_category_code'], $racesCats)) {
						$ecatIds[] = $ecat['id'];
					}
				}
			}
		}
		/*
		$this->log('$ecatIds:', LOG_DEBUG);
		$this->log($ecatIds, LOG_DEBUG);
		//*/
		
		return $ecatIds;
	}
	
	/**
	 * 出走カテゴリー ID から大会情報を得る
	 * @param type $ecatId 出走カテゴリー ID
	 * @return 大会情報。エラーのある場合 null をかえす。
	 */
	private function __getMeetInfoOfEcat($ecatId)
	{
		if (empty($ecatId)) return null;
		
		$this->EntryCategory->Behaviors->load('Containable');
		$opt = array(
			'conditions' => array(
				'EntryCategory.id' => $ecatId
			),
			'contain' => array(
				'EntryGroup' => array(
					'fields' => array(),
					'Meet'
				)
			)
		);
		
		$ecat = $this->EntryCategory->find('first', $opt);
		$this->log($ecat, LOG_DEBUG);
		
		if (isset($ecat['EntryGroup']['Meet'])) {
			return $ecat['EntryGroup']['Meet'];
		}
		
		return null;
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
		if (empty($racerCode)) {
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
		//$this->CategoryRacer->deleteAll($conditions);
		$crs = $this->CategoryRacer->find('all', array('conditions' => $conditions, 'recursive' => -1));
		foreach ($crs as $key => $val) {
			if (!$this->CategoryRacer->delete($val['CategoryRacer']['id'])) {
				$this->log('選手カテゴリー所属の削除に失敗しました。', LOG_ERR);
				return Constant::RET_FAILED;
			}
		}
		
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
	 * @param string $catTo 昇格先カテゴリー
	 * @param array $result リザルト
	 * @param int $rankUpCount 昇格者数
	 * @return Constant.RET_xxx 処理ステータス
	 */
	private function __applyRankUp($racerCode, $catTo, $result, $rankUpCount)
	{
		if (empty($racerCode) || empty($catTo)) {
			return Constant::RET_ERROR;
		}
		
		if (empty($result['rank'])) {
			return Constant::RET_NO_ACTION;
		}
		
		if (!$this->__isProperAgeForCat($racerCode, $catTo)) {
			return Constant::RET_NO_ACTION;
		}
		
		$reasonNote = ($result['rank'] > $rankUpCount) ? "繰り上げ昇格" : "";
		
		return $this->__execApplyRankUp($racerCode, $result, $reasonNote, $catTo);
	}
	
	/**
	 * 昇格適用処理を実行する
	 * @param string $racerCode 選手コード
	 * @param array $result リザルト
	 * @param string $reasonNote 昇格理由 Note
	 * @param string $categoryTo 昇格先カテゴリーコード
	 * @param boolean $savesHoldPoints 昇格による残留ポイントを付加するか
	 * @return Constant.RET_xxx 処理ステータス
	 */
	private function __execApplyRankUp($racerCode, $result, $reasonNote, $categoryTo, $savesHoldPoints = true)
	{
		// 新しいカテゴリー所属の保存
		// 現在所属しているかは見ない。不整合の場合は手動での修正とする。
		
		// 過去の Result_up の昇格は削除する
		$applyDate = date('Y/m/d', strtotime($this->__atDate . ' +1 day'));
		
		$conditions = array(
			'racer_code' => $racerCode,
			'meet_code' => $this->__meetCode,
			'category_code' => $categoryTo,
			'apply_date' => $applyDate,
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
		);
		//$this->CategoryRacer->deleteAll($conditions);
		$crs = $this->CategoryRacer->find('all', array('conditions' => $conditions, 'recursive' => -1));
		foreach ($crs as $key => $val) {
			if (!$this->CategoryRacer->delete($val['CategoryRacer']['id'])) {
				$this->log('選手カテゴリー所属の削除に失敗しました。', LOG_ERR);
				return Constant::RET_FAILED;
			}
		}
		
		$cr = array();
		$cr['CategoryRacer'] = array();
		$cr['CategoryRacer']['racer_code'] = $racerCode;
		$cr['CategoryRacer']['category_code'] = $categoryTo;
		$cr['CategoryRacer']['apply_date'] = $applyDate;
		$cr['CategoryRacer']['reason_id'] = CategoryReason::$RESULT_UP->ID();
		$cr['CategoryRacer']['reason_note'] = $reasonNote;
		$cr['CategoryRacer']['racer_result_id'] =  $result['id'];
		$cr['CategoryRacer']['meet_code'] = $this->__meetCode;
		$cr['CategoryRacer']['cancel_date'] = null;

		$this->CategoryRacer->create();
		if (!$this->CategoryRacer->save($cr)) {
			$this->log('昇格の選手カテゴリー所属の保存に失敗しました。', LOG_ERR);
			return Constant::RET_FAILED;
		}
		
		$this->log('Racer[code:' . $racerCode . '] にカテゴリー:' . $cr['CategoryRacer']['category_code']
				. 'を適用 cr.id:' . $this->CategoryRacer->id, LOG_DEBUG);

		if ($savesHoldPoints) {
			//$this->log('(with rank-up) will give give hold point to:' . $map[$rcatCode]['to'], LOG_DEBUG);
			$hp = array();
			$hp['HoldPoint'] = array();
			$hp['HoldPoint']['racer_result_id'] = $result['id'];
			$hp['HoldPoint']['point'] = 3;
			$hp['HoldPoint']['category_code'] = $categoryTo;

			$this->HoldPoint->create();
			if (!$this->HoldPoint->save($hp)) {
				$this->log('新カテゴリーに対する残留ポイントの保存に失敗しました。', LOG_ERR);
				return Constant::RET_FAILED;
			}
		}
		
		return Constant::RET_SUCCEED;
	}
	
	/**
	 * ある選手について昇格先カテゴリーに適合する年齢であるかをかえす
	 * @param type $racerCode 選手コード
	 * @param type $catTo 昇格先カテゴリー
	 * @return boolean 正しい年齢であるか。誕生日が不明な場合も true をかえす。
	 */
	private function __isProperAgeForCat($racerCode, $catTo)
	{
		if (empty($racerCode) || empty($catTo)) {
			$this->log('__isProperAgeForCat の引数が不正です。暫定として true を返します。', LOG_ERR);
			return true;
		}
		
		$catMinAgeMap = array(
			'C1' => 19,
			'C2' => 17,
			'C3' => 15,
			'CL1' => 17,
		);
		
		if (!empty($catMinAgeMap[$catTo])) {
			$conditions = array('code' => $racerCode);
			$racer = $this->Racer->find('first', array('conditions' => $conditions, 'recursive' => -1));
			
			if (!empty($racer['Racer']['birth_date'])) {
				$birth = $racer['Racer']['birth_date'];
				// uci cx age をチェック
				$meetDate = new DateTime($this->__atDate);
				$uciCxAge = Util::uciCXAgeAt(new DateTime($birth), $meetDate);
				
				if ($uciCxAge < $catMinAgeMap[$catTo]) {
					$this->log('選手:' . $racerCode . 'について、対象年齢外です (CxAge:' . $uciCxAge . ')', LOG_NOTICE);
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
				|| !isset($this->__topLapCount) || empty($this->__started)) {
			return Constant::RET_ERROR;
		}
		
		// 既存のシリーズポイントの削除
		if (!$this->PointSeriesRacer->deleteAll(array('racer_result_id' => $result['id']))) {
			return Constant::RET_FAILED;
		}
		
		$conditions = array(
			'meet_code' => $this->__meetCode,
		);
		
		$pts = $this->MeetPointSeries->find('all', array('conditions' => $conditions));
		
		// ecat.name にワイルドカードを設定したいのでプログラム側で走査
		$tmpPts = array();
		foreach ($pts as $ptSetting) {
			$mpsName = $ptSetting['MeetPointSeries']['entry_category_name'];
			if ($mpsName === $ecatName) { // 実際の出走カテゴリー名に含まれるワイルドカード文字は考慮しない
				$tmpPts[] = $ptSetting;
			} else if ($this->__endsWith($mpsName, '*')) {
				$nameBody = substr($mpsName, 0, -1);
				if ($this->__startsWith($ecatName, $nameBody)) {
					//$this->log('match!', LOG_DEBUG);
					$tmpPts[] = $ptSetting;
				}
			}
		}
		$pts = $tmpPts;
		
		$rStatus = Constant::RET_SUCCEED;
		
		foreach ($pts as $ptSetting) {
			//$this->log('pt setting:', LOG_DEBUG);
			//$this->log($ptSetting, LOG_DEBUG);
			
			// ps.hint に cat_limit があったら所属チェック
			$seriesHints = PointSeriesSumUpRule::getSeriesHints($ptSetting['PointSeries']['hint']);
			foreach ($seriesHints as $key => $val) {
				if ($key === 'cat_limit') {
					$catLimits = explode("/", $val);
				}
			}
			if (!empty($catLimits)) {
				$hasCat = $this->__checkCatRacer($racerCode, $catLimits, $ptSetting['Meet']['at_date']);
				if (!$hasCat) {
					continue;
				}
			}
			
			$calc = PointCalculator::getCalculator($ptSetting['PointSeries']['calc_rule']);
			if (empty($calc)) return;
			
			$pt = $calc->calc($result, $ptSetting['MeetPointSeries']['grade'], $this->__topLapCount, $this->__started, $this->__atDate);
			if (!empty($pt)) {
				$psr = array();
				$psr['PointSeriesRacer'] = array(
					'racer_code' => $racerCode,
					'point_series_id' => $ptSetting['PointSeries']['id'],
					'racer_result_id' => $result['id'],
					'meet_point_series_id' => $ptSetting['MeetPointSeries']['id'],
				);
				
				/*$this->log('series point to racer:' . $racerCode . ' ptSeries:' . $ptSetting['PointSeries']['id']
						. ' toResult:' . $result['id'] . ' mps:' . $ptSetting['MeetPointSeries']['id'], LOG_DEBUG);*/
				
				if (!empty($pt['point'])) {
					$psr['PointSeriesRacer']['point'] = $pt['point'];
					//$this->log('point:' . $pt['point'], LOG_DEBUG);
				}
				if (!empty($pt['bonus'])) {
					$psr['PointSeriesRacer']['bonus'] = $pt['bonus'];
					//$this->log('bonus:' . $pt['bonus'], LOG_DEBUG);
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
	 * その選手が指定日にカテゴリーに所属しているかをかえす
	 * @param string $racerCode 選手コード
	 * @param array $catLimits カテゴリーコードの配列
	 * @param date $date 大会日
	 */
	private function __checkCatRacer($racerCode, $catLimits, $date)
	{
		//$this->log('check cat racer: ' . $racerCode . ' ' . print_r($catLimits, true) . ' at ' . $date);
		
		$opt = array('conditions' => array(
			'racer_code' => $racerCode,
			'category_code' => $catLimits,
			'apply_date <=' => $date,
			'OR' => array(
				array('cancel_date' => null),
				array('cancel_date >=' => $date),
			),
		));
		
		//$this->log(($this->CategoryRacer->find('count', $opt) > 0 ? 'has' : 'NOT has!!!'), LOG_DEBUG);
		
		return $this->CategoryRacer->find('count', $opt) > 0;
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
		
		// $result['rank_per'] は string 値である
		if (!(isset($result['rank_per']) && ($result['rank_per'] === 0 || $result['rank_per'] === '0'))) { // ゼロパーセントはポイントあり
			if (empty($result['rank_per'])) {
				return Constant::RET_NO_ACTION;
			}
		}
		if ($result['rank_per'] > 66) {
			return Constant::RET_NO_ACTION;
		}
		
		$point = ($result['rank_per'] <= 25) ? 3 : 1;
		
		// 付与先カテゴリーの取得
		$asCat = $this->__asCategory($racerCode, $ecat['races_category_code'], $this->__atDate);
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
		
		//$this->log('残留ポイント save toResult:' . $result['id'] . ' pt:' . $point . ' as ' . $asCat, LOG_DEBUG);
		
		return Constant::RET_SUCCEED;
	}
	
	private function __startsWith($haystack, $needle) {
		return substr($haystack, 0, strlen($needle)) === $needle;
	}
	
	private function __endsWith($haystack, $needle) {
		return substr($haystack, - strlen($needle)) === $needle;
	}
	
	/**
	 * レース時に「どのカテゴリーの選手として出走したか」をかえす
	 * @param string $racerCode 選手 Code
	 * @param array $racesCatCode レースの出走カテゴリーのレースカテゴリーコード
	 * @param date $atDate 判定日
	 * @return string カテゴリー Code
	 */
	public function asCategory($racerCode, $racesCatCode, $atDate, $newCats = false)
	{
		$this->CategoryRacer = new CategoryRacer();
		$this->CategoryRacer ->Behaviors->load('Utils.SoftDelete');
		$this->RacesCategory = new RacesCategory();
		$this->RacesCategory->Behaviors->load('Utils.SoftDelete');
		
		return $this->__asCategory($racerCode, $racesCatCode, $atDate, $newCats);
	}
	
	/**
	 * レース時に「どのカテゴリーの選手として出走したか」をかえす
	 * @param string $racerCode 選手 Code
	 * @param array $racesCatCode レースの出走カテゴリーのレースカテゴリーコード
	 * @param date $atDate 判定日
	 * @param array $newCats レース当日に与えられるカテゴリーの配列
	 * @return string カテゴリー Code
	 */
	private function __asCategory($racerCode, $racesCatCode, $atDate, $newCats = false)
	{
		if (empty($racesCatCode)) {
			$this->log('as category 取得に必要な引数が不足しています。', LOG_ERR);
			return null;
		}
		
		if (!empty($racerCode)) {
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
		}
		
		$this->RacesCategory->unbindModel(array('hasMany' => array('EntryCategory')), true);
		$opt = array(
			'conditions' => array('code' => $racesCatCode),
			'recursive' => 2
		);
		$rcat = $this->RacesCategory->find('first', $opt);
		
		/*$this->log('rcat:', LOG_DEBUG);
		$this->log($rcat, LOG_DEBUG);
		$this->log('cats:', LOG_DEBUG);
		$this->log($cats, LOG_DEBUG);//*/
		
		// デフォルト値は races_cat_code とする
		$ret = $racesCatCode;
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
		
		$racersCatCodes = array();
		if (!empty($cats)) {
			foreach ($cats as $c) {
				$racersCatCodes[] = $c['CategoryRacer']['category_code'];
			}
		}
		if (!empty($newCats)) {
			$racersCatCodes = array_merge($racersCatCodes, $newCats);
		}
		
		//$this->log('$racersCatCodes:', LOG_DEBUG);
		//$this->log(print_r($racersCatCodes, true), LOG_DEBUG);
		
		if (!$isSingleCat && !empty($racersCatCodes)) {
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
			foreach ($racersCatCodes as $code) {
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
		$this->EntryCategory = new EntryCategory();
		$this->EntryCategory->Behaviors->load('Utils.SoftDelete');
		$this->EntryRacer= new EntryRacer();
		$this->EntryRacer->Behaviors->load('Utils.SoftDelete');
		$this->CategoryRacer = new CategoryRacer();
		$this->CategoryRacer ->Behaviors->load('Utils.SoftDelete');
		$this->RacesCategory = new RacesCategory();
		$this->RacesCategory->Behaviors->load('Utils.SoftDelete');
		$this->MeetPointSeries = new MeetPointSeries();
		$this->MeetPointSeries->Behaviors->load('Utils.SoftDelete');
		$this->RacerResult = new RacerResult();
		$this->RacerResult->Behaviors->load('Utils.SoftDelete');
		$this->Meet= new Meet();
		$this->Meet->Behaviors->load('Utils.SoftDelete');
		
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
			
			if (isset($r['lap'])) {
				$lap = $r['lap'];
				if (!isset($this->__topLapCount) || $lap > $this->__topLapCount) {
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
		if ($this->_isSeasonAfter1920()) {
			$this->__rankUpMap = array(
				// 20-21 から C2, C3, CM2 への昇格が3名に。
				'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $this->__rule011122),
				'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $this->__rule012333),
				'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $this->__rule012333),
				'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $this->__rule012333),
				'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $this->__rule011122),
				'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $this->__rule012333),
				'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $this->__rule012333),
			);
		} else if ($this->_isSeasonAfter1819()) {
			$this->__rankUpMap = array(
				// 1920 から C1, CM1 への昇格が2名に。
				'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $this->__rule011122),
				'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $this->__rule012345),
				'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $this->__rule012345),
				'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $this->__rule012345),
				'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $this->__rule011122),
				'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $this->__rule012345),
				'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $this->__rule011122),
			);
		} else if ($this->_isSeasonAfter1617()) {
			//$this->log('is after', LOG_DEBUG);
			$this->__rankUpMap = array(
				// 1718 から C1, CM1 への昇格が2名に、基準人数50->40に変更。
				'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $this->__rule0112),
				'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $this->__rule0123),
				'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $this->__rule0123),
				'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $this->__rule0123),
				'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $this->__rule0112),
				'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $this->__rule0123),
				'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $this->__rule0112),
			);
		} else {
			$this->__rankUpMap = array(
				'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $this->__rule0111),
				'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $this->__rule0123_til167),
				'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $this->__rule0123_til167),
				'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $this->__rule0123_til167),
				'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $this->__rule0111),
				'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $this->__rule0123_til167),
				'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $this->__rule0111),
			);

			if ($this->_isSeasonBefore1617()) {
				// 2015-16 シーズンは C2, CM2 ともに昇格人数が1人に制限される前だった
				$this->__rankUpMap['C2']['rule'] = $this->__rule0123_til167;
				$this->__rankUpMap['CM2']['rule'] = $this->__rule0112_til167;
				$this->__rankUpMap['CM2+3']['rule'] = $this->__rule0112_til167;
			}
		}
	}
	
	/**
	 * 2016-17 シーズンより前のシーズンであるかをかえす
	 * @return boolean 
	 */
	private function _isSeasonBefore1617()
	{
		if (empty($this->__atDate)) {
			return false; // unlikely... 本メソッドを作成したのが1617なので巻き戻りはなしので false かえす。
		}
		
		return ($this->__atDate < '2016-04-01');
	}
	
	/**
	 * 2016-17 シーズンより後のシーズンであるかをかえす
	 * @return boolean 
	 */
	private function _isSeasonAfter1617()
	{
		if (empty($this->__atDate)) {
			return true; // unlikely... 本メソッドを作成したのが1718で巻き戻りはなしので true かえす。
		}
		
		return ($this->__atDate > '2017-03-31');
	}
	
	/**
	 * 2018-19 シーズンより後のシーズン（19-20以降）であるかをかえす
	 * @return boolean 
	 */
	private function _isSeasonAfter1819()
	{
		if (empty($this->__atDate)) {
			return true; // unlikely... 本メソッドを作成したのが1920で巻き戻りはなしので true かえす。
		}
		
		return ($this->__atDate > '2019-03-31');
	}
	
	/**
	 * 2019-20 シーズンより後のシーズン（20-21以降）であるかをかえす
	 * @return boolean 
	 */
	private function _isSeasonAfter1920()
	{
		if (empty($this->__atDate)) {
			return true; // unlikely... 本メソッドを作成したのが1920で巻き戻りはなしので true かえす。
		}
		
		return ($this->__atDate > '2020-03-31');
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
