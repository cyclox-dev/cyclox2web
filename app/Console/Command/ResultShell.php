<?php

/*
 *  created at 2017/09/30 by shun
 */

App::uses('PointSeriesController', 'Controller');
App::uses('OrgUtilController', 'Controller');
App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
App::uses('CakeTime', 'Utility');
App::uses('MailReporter', 'Cyclox/Util');

/**
 * リザルトに関する処理を行なう shell
 *
 * @author shun
 */
class ResultShell extends AppShell
{
	const __TYPE_TITLE = 0;
	const __TYPE_DATA = 1;
	
	public $uses = array('TransactionManager', 'TmpResultUpdateFlag', 'TmpPointSeriesRacerSet'
			, 'MeetPointSeries', 'EntryCategory', 'EntryRacer', 'AjoccptLocalSetting', 'TmpAjoccptRacerSet');
	
	private $__psController;
	private $__orgUtilController;
	
	public function main()
	{
        $this->out('please input function name as 1st arg.');
    }
	
	// @Override
	function startup()
	{
		$this->__psController = new PointSeriesController();
		$this->__orgUtilController = new OrgUtilController();
		
		parent::startup();
	}
	
	/**
	 * 更新をチェックし、必要なリザルトについて AJOCC ポイントランキング計算をする。
	 * > app ディレクトリ
	 * > Console/cake result updateAjoccPtRankings
	 */
	public function updateAjoccPtRankings()
	{
		$this->log('>>> Start updateAjoccPtRankings', LOG_INFO);
		
		$flagCats = $this->TmpResultUpdateFlag->query('select * from tmp_result_update_flags as Flag'
			. ' inner join entry_categories as ec on ec.id = Flag.entry_category_id'
			. ' inner join entry_groups as eg on eg.id = ec.entry_group_id'
			. ' inner join meets as Meet on eg.meet_code = Meet.code' // 大会日取得
			. ' where ec.deleted = 0 and eg.deleted = 0 and Meet.deleted = 0'
			. ' and ajoccpt_sumuped = 0 and ec.applies_ajocc_pt = 1');
		
		if (empty($flagCats)) {
			$this->log('処理対象となるフラグがありませんでした。', LOG_INFO);
			$this->log('>>> End updateAjoccPtRankings', LOG_INFO);
		}
		
		/*
		flag--ec でまとめて取得
		ec ごとに as_category 取得して処理
		完了で flag を sumuped
		done な season-cat は記録しておいて、既にやったのならば、処理なしで flag sumuped のみ。
		*/
		
		$this->log('更新対象のflagは以下の通り', LOG_INFO);
		$this->log($flagCats, LOG_INFO);
		
		$flagIdDone = array();
		$seasonCatDone = array();
		
		foreach ($flagCats as $fc) {
			$seasonId = $fc['Meet']['season_id'];
			
			$opt = array(
				'conditions' => array(
					'EntryRacer.deleted' => 0,
					'RacerResult.deleted' => 0,
					'entry_category_id'=> $fc['ec']['id']
				),
				'fields' => array(
					'DISTINCT RacerResult.as_category'
				)
			);
			
			$ers = $this->EntryRacer->find('all', $opt);
			
			foreach ($ers as $er) {
				$asCat = $er['RacerResult']['as_category'];
				
				$this->log('about season:' . $seasonId . ' cat:'. $asCat . ' of flagID:' . $fc['Flag']['id'], LOG_DEBUG);
				
				if (in_array($this->__seasonCatKey($seasonId, $asCat), $seasonCatDone)) {
					$this->log('処理済み', LOG_DEBUG);
					$updated = true;
				} else {
					$updated = $this->__updateAjoccRanking($asCat, $seasonId);
					
					if ($updated) {
						$localSettings = $this->AjoccptLocalSetting->find('all', array('conditions' => array('season_id' => $seasonId)));

						foreach ($localSettings as $locals) {
							$ret = $this->__updateAjoccRanking($asCat, $seasonId, $locals);
							
							if (!$ret) {
								$updated = false;
							}
						}
					} else {
						$this->log('local 設定なしの ajocc ランキングデータの作成に失敗しました。', LOG_INFO);
					}
				}

				if ($updated) {
					$flagIdDone[] = $fc['Flag']['id'];
					$seasonCatDone[] = $this->__seasonCatKey($seasonId, $asCat);
				} else {
					$msg = 'as_category:' . $asCat . ', season:' . $seasonId . ' の AjoccPoint ランキング作成に失敗しました。ログを確認してください。';
					$this->log($msg, LOG_ERR);
					MailReporter::report('ResultShell#updateAjoccPtRankings ' . $msg, 'Error');
					// continue;
				}
			}
		}
		
		$this->log('以下のフラグを修正済みとして設定する:' . implode(',', $flagIdDone), LOG_INFO);
		
		// flag 処理済みをマーキング
		$opt = array(
			'TmpResultUpdateFlag.id' => $flagIdDone,
		);
		
		$ups = array(
			'ajoccpt_sumuped' => 1,
			'modified' => "'" . date('Y-m-d H:i:s') . "'", // updateAll だと Date にシングルクォートつけてくれないみたい。
		);
		
		if (!$this->TmpResultUpdateFlag->updateAll($ups, $opt)) {
			$msg = 'TmpResultUpdateFlag [id:' . implode(',', $flagIdDone) . '] の ajocc ランキング集計済み日時の設定に失敗しました。\n'
					. '集計自体は済んでいますが、次回に再度（つまり無駄な）更新処理が走ってしまいます。';
			$this->log($msg, LOG_WARNING);
			MailReporter::report('ResultShell#updateAjoccPtRankings ' . $msg, 'Warn');
		}
		
		// 削除済み ecat なフラグを削除
		$cdt = array(
			'EntryCategory.deleted' => 1,
		);
		
		if (!$this->TmpResultUpdateFlag->deleteAll($cdt, false)) {
			$msg = '集計済みでないが、EntryCategory.deleted なデータの削除に失敗しました。';
			$this->log($msg, LOG_WARNING);
			MailReporter::report('ResultShell#updateAjoccPtRankings ' . $msg, 'Warn');
			// not return
		}
		$this->log('既に無効となっている TmpResultUpdateFlag の削除について完了。', LOG_INFO);
		
		
		$this->log('<<< End updateAjoccPtRankings', LOG_INFO);
	}
	
	private function __seasonCatKey($seasonId, $catCode)
	{
		return $seasonId . '_x_' . $catCode;
	}
	
	/**
	 * 更新をチェックし、必要なリザルトについて AJOCC ポイントランキング計算をする。
	 * > app ディレクトリ
	 * > Console/cake result updateAjoccRanking CL1 99
	 */
	public function updateAjoccRanking()
	{
		$this->log('>>> Start updateAjoccRanking', LOG_INFO);
		
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（カテゴリーコード, シーズン ID）が必要です。');
		} else {
			$catCode = $this->args[0];
			$seasonId = $this->args[1];

			$this->__execUpdateAjoccRanking($catCode, $seasonId);
		}
		
		$this->log('<<< End updateAjoccRanking', LOG_INFO);
	}
	
	/**
	 * updateAjoccRanking() の実際の実行処理
	 * @param string $catCode
	 * @param int $seasonId
	 * @return void
	 */
	private function __execUpdateAjoccRanking($catCode, $seasonId)
	{
		$ret = $this->__updateAjoccRanking($catCode, $seasonId);
		
		if (!$ret)
		{
			$this->log('AJOCC ランキングの更新に失敗しました（ローカル設定なし）。', LOG_ERR);
			return;
		}
		
		$opt = array('conditions' => array(
			'season_id' => $seasonId,
		));
		$localSettings = $this->AjoccptLocalSetting->find('all', $opt);

		foreach ($localSettings as $locals) {
			$ret = $this->__updateAjoccRanking($catCode, $seasonId, $locals);

			if (!$ret) {
				$this->log('AJOCC ランキングの更新に失敗しました。ローカル設定 id:' . $locals['AjoccptLocalSetting']['id'], LOG_ERR);
				return;
			}
		}
	}
	
	/**
	 * 単体指定での ajocc ranking データを更新する
	 * @param string $catCode カテゴリーコード
	 * @param int $seasonId シーズン ID
	 * *param type $localSetting ajocc point local 設定
	 * @return boolean 正常に処理を終了したか
	 */
	private function __updateAjoccRanking($catCode, $seasonId, $localSetting = null)
	{
		$ret = $this->__orgUtilController->calcAjoccPoints($catCode, $seasonId, $localSetting);
		
		$location = 'cat:' . $catCode . ' season:' . $seasonId;
		if (!empty($localSetting)) {
			$location .= ' local setting id:' . $localSetting['AjoccptLocalSetting']['id'];
		}
		
		if ($ret === false) {
			$this->log(__('内部的なエラーのため、ランキングを更新できませんでした。（カテゴリー指定が不正？）' . $location), LOG_INFO);
			return false;
		}
		if (empty($ret['racerPoints'])) {
			$this->log(__('対象となるリザルトが無いため(?)、ランキングを更新できませんでした。' . $location), LOG_INFO);
			return true; // 正常とする
		}
		
		$meetTitles = $ret['meetTitles'];
		$racerPoints = $ret['racerPoints'];
		
		$sets = $this->__createAjoccptSets($catCode, $seasonId, $meetTitles, $racerPoints, $localSetting);
		
		if (empty($sets)) {
			$this->log(__('対象となるレースデータが無いため、ランキングを更新できませんでした。' . $location), LOG_INFO);
			return true;
		}
		
		if ($this->__saveAjoccRanking($seasonId, $catCode, $sets, $localSetting)) {
			$this->log(__('ランキングを保存しました。' . $location), LOG_INFO);
		} else {
			$this->log(__('ランキングの保存に失敗しました（local 設定なし）。' . $location), LOG_INFO);
		}
		
		return true;
	}
	
	private function __saveAjoccRanking($seasonId, $catCode, $sets, $localSetting = null)
	{
		//>>> transaction ++++++++++++++++++++++++++++++++++++++++
		$transaction = $this->TransactionManager->begin();
		
		$localsId = $localSetting['AjoccptLocalSetting']['id'];
		
		// 前回計算分を削除
		$cdt = array(
			'season_id' => $seasonId,
			'category_code' => $catCode,
			'ajoccpt_local_setting_id' => $localsId,
		);
		
		if (!$this->TmpAjoccptRacerSet->deleteAll($cdt, false)) {
			$this->TransactionManager->rollback($transaction);
			$msg = 'ajocc ランキング[season:' . $seasonId . '-cat:' . $catCode . '] の集計（前回データの削除）に失敗し、処理を中断しました。';
			$this->log($msg, LOG_ERR);
			MailReporter::report('ResultShell#__updateAjoccPtRanking ' . $msg, 'ERROR');
			return false;
		}

		if (count($sets) > 1) {
			if (!$this->TmpAjoccptRacerSet->saveAll($sets)) {
				$this->TransactionManager->rollback($transaction);
				$msg = 'ajocc ランキング[season:' . $seasonId . '-cat:' . $catCode . '] の集計（データの作成）に失敗し、処理を中断しました。';
				$this->log($msg, LOG_ERR);
				MailReporter::report('ResultShell#__updateAjoccPtRanking ' . $msg, 'ERROR');
				return false;
			}
		}

		$this->TransactionManager->commit($transaction);
		//<<< transaction ++++++++++++++++++++++++++++++++++++++++
		
		return true;
	}
	
	/**
	 * ajocc point ランキングデータの保存用配列をかえす。
	 * @param string $catCode
	 * @param int $seasonId
	 * @param type $meetTitles
	 * @param type $racerPoints
	 * @param type $localSetting ローカル設定。FALSE で設定なし。
	 * @return array 
	 */
	private function __createAjoccptSets($catCode, $seasonId, $meetTitles, $racerPoints, $localSetting = null)
	{
		if (empty($meetTitles)) {
			$this->log('対象となるレースがありません。', LOG_INFO);
			return array();
		}
		
		// 誰もポイントを取得していない列を除去する。
		$titles = array();
		foreach ($racerPoints as &$rp) {
			$rp['rev_points'] = array();
		}
		unset($rp);
		
		$index = 0;
		for ($i = 0; $i < count($meetTitles); $i++)
		{
			$hasPoint = false;
			foreach ($racerPoints as &$rp) {
				if (!empty($rp['points'][$i])) {
					$rp['rev_points'][$index] = $rp['points'][$i];
					$hasPoint = true;
				}
			}
			unset($rp);
			
			if ($hasPoint)
			{
				$titles[$index] = $meetTitles[$i];
				++$index;
			}
		}
		
		$sets = array();
		
		$titleSet = array(
			'TmpAjoccptRacerSet' => array(
				'season_id' => $seasonId,
				'category_code' => $catCode,
				'type' => self::__TYPE_TITLE,
				'rank' => 0,
				'racer_code' => '選手Code',
				'name' => '選手',
				'team' => 'チーム',
				'point_json' => json_encode($titles, JSON_UNESCAPED_UNICODE),
				'sumup_json' => json_encode(array("合計", "自乗和"), JSON_UNESCAPED_UNICODE),
			)
		);
		
		if (!empty($localSetting)) {
			$titleSet['TmpAjoccptRacerSet']['ajoccpt_local_setting_id'] = $localSetting['AjoccptLocalSetting']['id'];
		}
		
		$sets[] = $titleSet;
		
		foreach ($racerPoints as $rcode => $rp) {
			$set = array(
				'TmpAjoccptRacerSet' => array(
					'season_id' => $seasonId,
					'category_code' => $catCode,
					'type' => self::__TYPE_DATA,
					'rank' => $rp['rank'],
					'racer_code' => $rcode,
					'name' => $rp['name'],
					'team' => isset($rp['team']) ? $rp['team'] : '',
					'point_json' => json_encode($rp['rev_points'], JSON_UNESCAPED_UNICODE),
					'sumup_json' => json_encode(array($rp['total'], $rp['totalSquared']), JSON_UNESCAPED_UNICODE),
				)
			);
			
			if (!empty($localSetting)) {
				$set['TmpAjoccptRacerSet']['ajoccpt_local_setting_id'] = $localSetting['AjoccptLocalSetting']['id'];
			}
			
			$sets[] = $set;
		}
		
		return $sets;
	}
	
	/**
	 * 更新をチェックし、必要なリザルトについて PointSeries のランキング計算をする。
	 * 第1引数として nextDayUpdate を使用すると昨日にリザルトがアップされたものを更新する
	 * > app ディレクトリ
	 * > Console/cake result updateSeriesRankings nextDayUpdate
	 */
	public function updateSeriesRankings()
	{
		$this->log('>>> Start updateSeriesRankings', LOG_INFO);
		
		$isNextDayUpdate = isset($this->args[0]) && $this->args[0] === 'nextDayUpdate';
		
		// フラグの立っているものを抽出
		$this->TmpResultUpdateFlag->Behaviors->load('Containable');
		
		$opt = array(
			'conditions' => array(
				//'points_sumuped' => 0,
				'EntryCategory.deleted' => 0,
			),
			'contain' => array(
				'EntryCategory' => array(
					'EntryGroup' => array()
				)
			)
		);
		
		if ($isNextDayUpdate) {
			$opt['conditions']['result_updated >='] = date('Y/m/d', strtotime('-1 day')) . ' 00:00:00';
			$opt['conditions']['result_updated <'] = date('Y-m-d') . ' 00:00:00';
			// points_sumuped は見ない
		} else {
			$opt['conditions']['points_sumuped'] = 0;
		}
		
		$flags = $this->TmpResultUpdateFlag->find('all', $opt);
		//$this->log($flags, LOG_DEBUG);

		// レースが登録されているシリーズを取得
		$psids = $this->__getPsIds($flags);
		if (!empty($psids)) {
			$this->log('更新対象のシリーズ id は以下の通り', LOG_INFO);
			$this->log($psids, LOG_INFO);
		}
		
		// シリーズを更新
		foreach ($psids as $p) {
			$ret = $this->__updateRanking($p['psid'], $p['ecatids']);
			
			if (!$ret) {
				$this->log('シリーズ id[' . $p['psid'] . '] の更新に失敗しました。（続行します。）', LOG_WARNING);
				// not return
			}
		}

		// 後処理として、deleted EntryCategory を指定している flag は削除してしまう。
		$this->TmpResultUpdateFlag->Behaviors->unload('Containable');
		$cdt = array(
			'EntryCategory.deleted' => 1,
		);
		
		if (!$this->TmpResultUpdateFlag->deleteAll($cdt, false)) {
			$msg = '集計済みでないが、EntryCategory.deleted なデータの削除に失敗しました。';
			$this->log($msg, LOG_WARNING);
			MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'Warn');
			// not return
		}
		$this->log('既に無効となっている TmpResultUpdateFlag の削除について完了。', LOG_INFO);
		
		$this->log('<<< End updateSeriesRankings', LOG_INFO);
	}
	
	/**
	 * 指定 ID のポイントシリーズのランキングデータを更新する。
	 * > app ディレクトリ
	 * > Console/cake result updateRanking 88
	 */
	public function updateRanking()
	{
		if (!isset($this->args[0])) {
			$this->out('1つの引数（整数／ポイントシリーズ ID）が必要です。');
			return;
		}
		
		$this->out('>>> Start updateRanking');
		
		$ret = $this->__updateRanking($this->args[0]);
		if (!$ret) {
			$this->log('処理に失敗しました。', LOG_ERR);
		}
		
		$this->out('<<< End updateRanking');
	}
	
	/**
	 * 指定 ID のポイントシリーズのランキングデータを更新する。（コントローラーなどからの呼び出し用）
	 * @param type $psid ポイントシリーズ ID
	 */
	public function execUpdateRanking($psid = false)
	{
		return $this->__updateRanking($psid);
	}
	
	/**
	 * 指定のポイントシリーズのランキングデータを更新する。
	 * @param int $psid ポイントシリーズ ID
	 * @param array $ecatids フラグ更新用。エントリーカテゴリー ID の配列。false で更新しない。
	 * @return boolean 更新に成功したか。
	 */
	private function __updateRanking($psid, $ecatids = false)
	{
		$sets = array();
			
		$ret = $this->__psController->calcUpSeries($psid);

		if (empty($ret) || isset($ret['error'])) {
			$this->log('ポイントシリーズのランキング計算に失敗しました。エラー内容:' . h($ret['error']), LOG_ERR);
			return false;
		}
		
		$ranking = $ret['ranking'];
		$ps = $ret['ps'];
		$mpss = $ret['mpss'];
		$nameMap = $ret['nameMap'];
		$teamMap = $ret['teamMap'];
		$racerPoints = $ret['racerPoints'];

		if (empty($racerPoints)) {
			return false;
		}

		$opt = array(
			'fields' => array('max(set_group_id) as max_set_group_id'),
			'conditions' => array('point_series_id' => $ps['PointSeries']['id'])
		);
		$maxSet = $this->TmpPointSeriesRacerSet->find('first', $opt);
		//$this->log('max id obj is', LOG_DEBUG);
		//$this->log($maxSet, LOG_DEBUG);
		$maxSetGroupId =  empty($maxSet[0]['max_set_group_id']) ? 1 : $maxSet[0]['max_set_group_id'] + 1;

		$titleRow = $this->__createPsrSetTitle($mpss, $ranking, $ps, $maxSetGroupId);
		$sets[] = $titleRow;

		foreach ($ranking['ranking'] as $rpUnit) {
			$row = $this->__createPsrSetData($mpss, $racerPoints, $rpUnit, $ps, $nameMap, $teamMap, $maxSetGroupId);
			if (!is_null($row)) {
				$sets[] = $row;
			}
		}
		//$this->log('set is', LOG_DEBUG);
		//$this->log($sets, LOG_DEBUG);
		
		if (count($sets) > 1) {
			if (!$this->TmpPointSeriesRacerSet->saveAll($sets)) {
				$msg = 'ポイントシリーズ[id:' . $psid . '] の集計（データの作成）に失敗し、処理を中断しました。';
				$this->log($msg, LOG_ERR);
				MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'ERROR');
				return false;
			}
		}

		//<<< transaction ++++++++++++++++++++++++++++++++++++++++

		if (!empty($ecatids)) {
			// すべての tmp_result_update_flags のステータスを変更する
			$opt = array('entry_category_id' => $ecatids);
			$ups = array(
				'points_sumuped' => 1,
				'modified' => "'" . date('Y-m-d H:i:s') . "'", // updateAll だと Date にシングルクォートつけてくれないみたい。
			);
			if (!$this->TmpResultUpdateFlag->updateAll($ups, $opt)) {
				$msg = '出走カテゴリー [id:' . implode(',', $ecatids) . '] の集計済み日時の設定に失敗しました。\n'
					. '集計自体は済んでいますが、次回に再度（つまり無駄な）更新処理が走ってしまいます。';
				$this->log($msg, LOG_WARNING);
				MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'Warn');
				// not return
			}
		}

		$this->log('pt series[id:' . $psid . '] について集計処理完了。', LOG_INFO);
		return true;
	}
	
	/**
	 * ポイントシリーズ ID の配列をかえす
	 * @param array $flags
	 * @return array ポイントシリーズ ID の配列
	 */
	private function __getPsIds($flags)
	{
		$psids = array();
		
		// レースが登録されているシリーズを取得
		foreach ($flags as $flag) {
			$opt = array(
				'conditions' => array(
					'meet_code' => $flag['EntryCategory']['EntryGroup']['meet_code'],
					// 'entry_category_name' => $flag['EntryCategory']['name'], match or not をプログラム側で走査する
					'MeetPointSeries.deleted' => 0,
				)
			);
			
			$mpss = $this->MeetPointSeries->find('all', $opt);
			//$this->log('mps:', LOG_DEBUG);
			//$this->log($mps, LOG_DEBUG);
			
			$tmpMpss = array();
			foreach ($mpss as $mps) {
				// mps.ecat_name にワイルドカードが含まれるのでプログラム側で走査
				$mpsName = $mps['MeetPointSeries']['entry_category_name'];
				$fecname = $flag['EntryCategory']['name'];
				if ($mpsName === $fecname) {
					$tmpMpss[] = $mps;
				} else if ($this->__endsWith($mpsName, '*')) {
					$nameBody = substr($mpsName, 0, -1);
					if ($this->__startsWith($fecname, $nameBody)) {
						$tmpMpss[] = $mps;
					}
				}
			}
			$mpss = $tmpMpss;
			
			$ecatid = $flag['EntryCategory']['id'];
			
			foreach ($mpss as $mps) {
				$psid = $mps['PointSeries']['id'];
				
				$finds = false;
				foreach ($psids as &$p) {
					if ($p['psid'] == $psid) {
						$p['ecatids'][] = $ecatid;
						$finds = true;
						break;
					}
				}
				unset($p);
				
				if (!$finds) {
					$psids[] = array(
						'psid' => $psid,
						'ecatids' => array($ecatid),
					);
				}
			}
		}
		
		return $psids;
	}
	
	private function __startsWith($haystack, $needle) {
		return substr($haystack, 0, strlen($needle)) === $needle;
	}
	
	private function __endsWith($haystack, $needle) {
		return substr($haystack, - strlen($needle)) === $needle;
	}
	
	/**
	 * ポイントシリーズデータのタイトル行を作成する
	 * @return array
	 */
	private function __createPsrSetTitle($mpss, $ranking, $ps, $setGroupId)
	{
		$meetTitles = array();
		foreach ($mpss as $mps) {
			$title = array(
				'name' => $mps['MeetPointSeries']['express_in_series'],
				'code' => $mps['MeetPointSeries']['meet_code'],
				'at_date' => $mps['Meet']['at_date'],
			);
			
			// ワイルドカードなければ ecat.name を設定する
			$mpsEcatName = $mps['MeetPointSeries']['entry_category_name'];
			if (!$this->__endsWith($mpsEcatName, '*')) {
				$title['entry_category_name'] = $mpsEcatName;
			}
			
			$meetTitles[] = $title;
		}

		$totalTitles = $ranking['rank_pt_title'];

		// タイトル行作成
		$this->TmpPointSeriesRacerSet->create();
		$titleRow = array(
			'TmpPointSeriesRacerSet' => array(
				'point_series_id' => $ps['PointSeries']['id'],
				'set_group_id' => $setGroupId,
				'type' => self::__TYPE_TITLE,
				'rank' => 0, // ゼロ行目として配置
				'racer_code' => '選手Code',
				'name' => '選手',
				'team' => 'チーム',
				'point_json' => json_encode($meetTitles, JSON_UNESCAPED_UNICODE),
				'sumup_json' => json_encode($totalTitles, JSON_UNESCAPED_UNICODE),
			)
		);
		
		return $titleRow;
	}
	
	/**
	 * ポイントシリーズデータ1選手分のデータを作成する
	 * @return array かえすデータが無い場合には null をかえす
	 */
	private function __createPsrSetData($mpss, $racerPoints, $rpUnit, $ps, $nameMap, $teamMap, $setGroupId)
	{
		if (empty($racerPoints[$rpUnit->code])) {
			return null;
		}

		$points = array();
		for ($i = 0; $i < count($mpss); $i++) {
			if (isset($racerPoints[$rpUnit->code][$i])) {
				$point = $racerPoints[$rpUnit->code][$i];
				$str = '';
				if (!empty($point['pt'])) {
					$str = $point['pt'];
				}
				if (!empty($point['bonus'])) {
					$str .= '+' . $point['bonus'];
				}
		
				$points[$i] = $str;
			}
		}
		
		$sumups = array();
		foreach ($rpUnit->rankPt as $pt) {
			$sumups[] = $pt;
		}

		$row = array(
			'TmpPointSeriesRacerSet' => array(
				'point_series_id' => $ps['PointSeries']['id'],
				'set_group_id' => $setGroupId,
				'type' => self::__TYPE_DATA,
				'rank' => $rpUnit->rank,
				'racer_code' => $rpUnit->code,
				'name' => $nameMap[$rpUnit->code],
				'team' => (empty($teamMap[$rpUnit->code]) ? '' : $teamMap[$rpUnit->code]),
				'point_json' => json_encode($points),
				'sumup_json' => json_encode($sumups),
			)
		);
		//$this->log($row, LOG_DEBUG);
		
		return $row;
	}
}
