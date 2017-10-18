<?php

/*
 *  created at 2017/09/30 by shun
 */

App::uses('PointSeriesController', 'Controller');
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
			, 'MeetPointSeries');
	
	private $__psController;
	
	public function main()
	{
        $this->out('please input function name as 1st arg.');
    }
	
	// @Override
	function startup()
	{
		$this->__psController = new PointSeriesController();
		
		parent::startup();
	}
	
	/**
	 * 更新をチェックし、必要なリザルトについて PointSeries のランキング計算をする。
	 * > app ディレクトリ
	 * > Console/cake result updateSeriesRankings
	 */
	public function updateSeriesRankings()
	{
		$this->log('>>> Start updateSeriesRankings', LOG_INFO);
		
		// フラグの立っているものを抽出
		$this->TmpResultUpdateFlag->Behaviors->load('Containable');
		
		$opt = array(
			'conditions' => array(
				'points_sumuped' => 0,
				'EntryCategory.deleted' => 0,
			),
			'contain' => array(
				'EntryCategory' => array(
					'EntryGroup' => array()
				)
			)
		);
		$flags = $this->TmpResultUpdateFlag->find('all', $opt);
		//$this->log($flags, LOG_DEBUG);

		// レースが登録されているシリーズを取得
		$psids = $this->__getPsIds($flags);
		$this->log('更新対象のシリーズ id は以下の通り', LOG_INFO);
		$this->log($psids, LOG_INFO);
		
		// シリーズを更新
		foreach ($psids as $p) {
			$ret = $this->updateRanking($p);
			
			if (!$ret) {
				$this->log('シリーズ id[' . $p['psid'] . '] の更新に失敗しました。（続行します。）', LOG_WARNING);
				// not return
			}
		}

		// 後処理として、deleted EntryCategory を指定している flag は削除してしまう。
		$this->TmpResultUpdateFlag->Behaviors->unload('Containable');
		$opt = array(
			'points_sumuped' => 0,
			'EntryCategory.deleted' => 1,
		);
		
		if (!$this->TmpResultUpdateFlag->deleteAll($opt, false)) {
			$msg = '集計済みでないが、EntryCategory.deleted なデータの削除に失敗しました。';
			$this->log($msg, LOG_WARNING);
			MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'Warn');
			// not return
		}
		$this->log('既に無効となっている TmpResultUpdateFlag の削除について完了。', LOG_INFO);
		
		$this->log('<<< End updateSeriesRankings', LOG_INFO);
	}
	
	/**
	 * 指定のポイントシリーズのランキングデータを更新する。
	 * @param array $p {'psid'=>88, 'ecatids'=> {12, 34}} の形式のデータ。ecatids はフラグ更新用。
	 * @return boolean 更新にせいこうしたか。
	 */
	public function updateRanking($p)
	{
		$psid = $p['psid'];
		$sets = array();
			
		$ret = $this->__psController->calcUpSeries($psid);

		$ranking = $ret['ranking'];
		$ps = $ret['ps'];
		$mpss = $ret['mpss'];
		$nameMap = $ret['nameMap'];
		$teamMap = $ret['teamMap'];
		$racerPoints = $ret['racerPoints'];

		if (empty($racerPoints)) {
			return false;
		}

		$titleRow = $this->__createPsrSetTitle($mpss, $ranking, $ps);
		$sets[] = $titleRow;

		foreach ($ranking['ranking'] as $rpUnit) {
			$row = $this->__createPsrSetData($mpss, $racerPoints, $rpUnit, $ps, $nameMap, $teamMap);
			if (!is_null($row)) {
				$sets[] = $row;
			}
		}
		//$this->log('set is', LOG_DEBUG);
		//$this->log($sets, LOG_DEBUG);

		//>>> transaction ++++++++++++++++++++++++++++++++++++++++
		$transaction = $this->TransactionManager->begin();
		// 前回計算分を削除
		$cdt = array('point_series_id' => $ps['PointSeries']['id']);
		if (!$this->TmpPointSeriesRacerSet->deleteAll($cdt, false)) {
			$this->TransactionManager->rollback($transaction);
			$msg = 'ポイントシリーズ[id:' . $psid . '] の集計（前回データの削除）に失敗し、処理を中断しました。';
			$this->log($msg, LOG_ERR);
			MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'ERROR');
			return false;
		}

		if (count($sets) > 1) {
			if (!$this->TmpPointSeriesRacerSet->saveAll($sets)) {
				$this->TransactionManager->rollback($transaction);
				$msg = 'ポイントシリーズ[id:' . $psid . '] の集計（データの作成）に失敗し、処理を中断しました。';
				$this->log($msg, LOG_ERR);
				MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'ERROR');
				return false;
			}
		}

		$this->TransactionManager->commit($transaction);
		//<<< transaction ++++++++++++++++++++++++++++++++++++++++

		// すべての tmp_result_update_flags のステータスを変更する
		$opt = array('entry_category_id' => $p['ecatids']);
		$ups = array(
			'points_sumuped' => 1,
			'modified' => "'" . date('Y-m-d H:i:s') . "'", // updateAll だと Date にシングルクォートつけてくれないみたい。
		);
		if (!$this->TmpResultUpdateFlag->updateAll($ups, $opt)) {
			$msg = '出走カテゴリー [id:' . implode(',', $p['ecatids']) . '] の集計済み日時の設定に失敗しました。\n'
				. '集計自体は済んでいますが、次回に再度（つまり無駄な）更新処理が走ってしまいます。';
			$this->log($msg, LOG_WARNING);
			MailReporter::report('ResultShell#updateSeriesRankings ' . $msg, 'Warn');
			// not return
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
	private function __createPsrSetTitle($mpss, $ranking, $ps)
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
	private function __createPsrSetData($mpss, $racerPoints, $rpUnit, $ps, $nameMap, $teamMap)
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
