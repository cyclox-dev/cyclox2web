<?php

/*
 *  created at 2017/09/30 by shun
 */

App::uses('PointSeriesController', 'Controller');
App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
App::uses('CakeTime', 'Utility');

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
		
		// TODO: mail report
		
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
		
		$ecatIds = array();
		foreach ($flags as $f) {
			$ecatIds[] = $f['TmpResultUpdateFlag']['entry_category_id'];
		}
		
		// シリーズを更新
		$psidStr = ''; // ログ用
		
		foreach ($psids as $psid) {
			$sets = array();
			
			$ret = $this->__psController->calcUpSeries($psid);
			
			$ranking = $ret['ranking'];
			$ps = $ret['ps'];
			$mpss = $ret['mpss'];
			$nameMap = $ret['nameMap'];
			$teamMap = $ret['teamMap'];
			$racerPoints = $ret['racerPoints'];
			
			if (empty($racerPoints)) continue;
			
			$psidStr .= $ps['PointSeries']['id'] . ',';
			
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
			
			// 前回計算分を削除
			
			
			

			if (count($sets) > 1) {
				if (!$this->TmpPointSeriesRacerSet->saveAll($sets)) {
					$this->log('ポイントシリーズ[id:' . $psidStr . '] の集計（一時データの作成）に失敗しました。\n'
						. '処理を中断します。', LOG_ERR);
					return;
				}
			}
		}

		// すべての tmp_result_update_flags のステータスを変更する
		$opt = array('entry_category_id' => $ecatIds);
		$ups = array(
			'points_sumuped' => 1,
			'modified' => "'" . date('Y-m-d H:i:s') . "'", // updateAll だと Date にシングルクォートつけてくれないみたい。
		);
		if (!$this->TmpResultUpdateFlag->updateAll($ups, $opt)) {
			$this->log('出走カテゴリー [id:' . implode(',', $ecatIds) . '] の集計済み日時の設定に失敗しました。\n'
				. '集計自体は済んでいますが、次回に再度（つまり無駄な）更新処理が走ってしまいます。', LOG_ERR);
			// not return
		}
		$this->log('TmpResultUpdateFlag のステータス切替について完了。', LOG_INFO);
		
		// 後処理として、deleted EntryCategory を指定している flag は削除してしまう。
		$this->TmpResultUpdateFlag->Behaviors->unload('Containable');
		$opt = array(
			'points_sumuped' => 0,
			'EntryCategory.deleted' => 1,
		);
		
		if (!$this->TmpResultUpdateFlag->deleteAll($opt, false)) {
			$this->log('集計済みでないが、EntryCategory.deleted なデータの削除に失敗しました。', LOG_ERR);
			// not return
		}
		$this->log('既に無効となっている TmpResultUpdateFlag の削除について完了。', LOG_INFO);
		
		$this->log('<<< End updateSeriesRankings', LOG_INFO);
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
					'entry_category_name' => $flag['EntryCategory']['name'],
					'MeetPointSeries.deleted' => 0,
				)
			);
			
			$mpss = $this->MeetPointSeries->find('all', $opt);
			//$this->log('mps:', LOG_DEBUG);
			//$this->log($mps, LOG_DEBUG);
			
			foreach ($mpss as $mps) {
				$psid = $mps['PointSeries']['id'];
				if (!in_array($psid, $psids)) {
					$psids[] = $psid;
				}
			}
		}
		
		return $psids;
	}
	
	/**
	 * ポイントシリーズデータのタイトル行を作成する
	 * @return array
	 */
	private function __createPsrSetTitle($mpss, $ranking, $ps)
	{
		$meetTitles = array();
		foreach ($mpss as $mps) {
			$meetTitles[] = array(
				'name' => $mps['MeetPointSeries']['express_in_series'],
				'code' => $mps['MeetPointSeries']['meet_code'],
				'entry_category_name' => $mps['MeetPointSeries']['entry_category_name'],
			);
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

		for ($i = 0; $i < count($mpss); $i++) {
			$points = array();
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
