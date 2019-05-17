<?php

App::uses('ApiBaseController', 'Controller');

App::uses('Validation', 'Utility');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('PointCalculator', 'Cyclox/Util');
App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
App::uses('PointSeriesPointTo', 'Cyclox/Const');
App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');
App::uses('Util', 'Cyclox/Util');
App::uses('AjoccUtil', 'Cyclox/Util');

App::uses('AppShell','Console/Command');
App::uses('ResultShell','Console/Command');

/**
 * PointSeries Controller
 *
 * @property PointSeries $PointSeries
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class PointSeriesController extends ApiBaseController
{
	public $uses = array('PointSeries', 'MeetPointSeries', 'PointSeriesRacer', 'Season', 'PointSeriesGroup'
		, 'TmpPointSeriesRacerSet', 'PointSeriesGroup');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'RequestHandler');
	
	const __PATH_RANKING = 'cyclox2/point_series/rankings';
	const __RANKING_FILE_PREFIX = 'ranking_';

	public $paginate = array(
		'limit' => 30,
        'order' => array(
			'PointSeries.season_id' => 'DESC',
			'PointSeries.id' => 'ASC',
        )
    );
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = $this->paginate;
		
		$this->PointSeries->recursive = 0;
		
		if (isset($this->request->query['group'])) {
			$group = $this->request->query['group'];
			if ($group === '__not_grouped__' || $group === 0) {
				$this->Paginator->settings['conditions'] = array('point_series_group_id' => null);
			} else {
				$this->Paginator->settings['conditions'] = array('point_series_group_id' => $this->request->query['group']);
			}
		}
		
		$this->set('pointSeries', $this->Paginator->paginate());
		
		$this->PointSeriesGroup->recursive = 0;
		$this->set('series_groups', $this->PointSeriesGroup->find('list'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid point series'));
		}
		
		$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $id));
		$pointSeries = $this->PointSeries->find('first', $options);
		
		$opt = array(
			'conditions' => array(
				'point_series_id' => $id,
			),
			'order' => array(
				'Meet.at_date' => 'DESC',
			)
		);
		$mpss = $this->MeetPointSeries->find('all', $opt);
		
		$options = array(
			'conditions' => array(
				'point_series_id' => $id,
				'type' => 0, // タイトル行を利用
			),
			'order' => array(
				'TmpPointSeriesRacerSet.modified' => 'DESC',
			)
		);
		$psrSets = $this->TmpPointSeriesRacerSet->find('all', $options);
		
		$this->set(compact('pointSeries', 'mpss', 'psrSets'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($groupID = null) {
		if ($this->request->is('post')) {
			$this->PointSeries->create();
			if ($this->PointSeries->save($this->request->data)) {
				$this->Flash->success(__('The point series has been saved.'));
				return $this->redirect(array('action' => 'view', $this->PointSeries->id));
			} else {
				$this->Flash->set(__('The point series could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->PointSeries->Season->find('list');
		$pointSeriesGroups = $this->PointSeriesGroup->find('list');
		$this->set(compact('seasons', 'pointSeriesGroups'));
		
		$this->set('pointCalculators', PointCalculator::calculators());
		$this->set('sumUpRules', PointSeriesSumUpRule::rules());
		$this->set('pointTos', PointSeriesPointTo::pointToList());
		$this->set('termRules', PointSeriesTermOfValidityRule::rules());
		
		if (!is_null($groupID)) {
			$this->set('groupID', $groupID);
			$this->request->data['PointSeries']['point_series_group_id'] = $groupID;
			if (!empty($pointSeriesGroups[$groupID])) {
				$this->set('groupName', $pointSeriesGroups[$groupID]);
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid point series'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PointSeries->save($this->request->data)) {
				$this->Flash->success(__('The point series has been saved.'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Flash->set(__('The point series could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $id));
			$this->request->data = $this->PointSeries->find('first', $options);
		}
		$seasons = $this->PointSeries->Season->find('list');
		$pointSeriesGroups = $this->PointSeriesGroup->find('list');
		$this->set(compact('seasons', 'pointSeriesGroups'));
		
		$this->set('pointCalculators', PointCalculator::calculators());
		$this->set('sumUpRules', PointSeriesSumUpRule::rules());
		$this->set('pointTos', PointSeriesPointTo::pointToList());
		$this->set('termRules', PointSeriesTermOfValidityRule::rules());
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PointSeries->id = $id;
		if (!$this->PointSeries->exists()) {
			throw new NotFoundException(__('Invalid point series'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PointSeries->delete()) {
			$this->Flash->set(__('The point series has been deleted.'));
		} else {
			$this->Flash->set(__('The point series could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	/**
	 * ランキングを計算し直し、指定のファイルに保存する
	 * @param date $date 計算機順日時
	 */
	public function calcup($date = null)
	{
		$this->request->allowMethod('post');
		
		if (empty($this->request->data['point_series_id'])) {
			throw new BadRequestException('Needs Point Series id.');
		}
		
		$id = $this->request->data['point_series_id'];
		$date = $this->request->data['date'];
		$dividesBonusCol = $this->request->data['divides_bonus'];
		
		$dt = null;
		if (is_array($date)) {
			if (!empty($date['year']) && !empty($date['month']) && !empty($date['day'])) {
				$dt = $date['year'] . '-' . $date['month'] . '-' . $date['day'];
			}
		} else if (is_string($date)) {
			if (Util::is_date($date)) {
				$dt = $date;
			}
		}
		
		$ret = $this->calcUpSeries($id, $dt);
		
		if (empty($ret) || isset($ret['error'])) {
			$this->Flash->set('ポイントシリーズのランキング計算に失敗しました。エラー内容:' . h($ret['error']));
			$this->redirect($this->referer());
			return;
		}
		
		$ranking = $ret['ranking'];
		$ps = $ret['ps'];
		$mpss = $ret['mpss'];
		$nameMap = $ret['nameMap'];
		$teamMap = $ret['teamMap'];
		$jcfNoMp = $ret['jcfNoMap'];
		$uciIdMap = $ret['uciIdMap'];
		$racerPoints = $ret['racerPoints'];
		
		if (empty($ranking)) {
			throw new InternalErrorException('could not sum up ranking...');
		}
		
		$this->_mkdir4Ranking();
		
		$tmpPath = TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $id . '.csv.tmp';
		$tmpFile = new File($tmpPath);
		if ($tmpFile->exists()) {
			$tmpFile->delete();
		}
		$tmpFile->create();
		
		// 以下、fputcsv を使いたいので fp で処理
		$fp = fopen($tmpPath, 'w');
		
		$row = array(
			$ps['PointSeries']['name'] . ' ランキング',
			'更新日:' . date('Y-m-d'),
			'計算基準日:' . $dt
		);
		$this->__putToFp($fp, $row);
		
		$row = array('順位', '選手 Code', 'JCF-No.', 'UCI-ID', '選手名', 'チーム名');
		foreach ($mpss as $mps) {
			$row[] = $mps['MeetPointSeries']['express_in_series'];
			
			if ($dividesBonusCol) {
				$row[] = $mps['MeetPointSeries']['express_in_series'] . 'Bonus';
			}
		}
		foreach ($ranking['rank_pt_title'] as $title) {
			$row[] = $title;
		}
		
		$this->__putToFp($fp, $row);
		
		foreach ($ranking['ranking'] as $rpUnit) {
			
			$jcfno = empty($jcfNoMp[$rpUnit->code]) ? '' : $jcfNoMp[$rpUnit->code];
			$uciid = empty($uciIdMap[$rpUnit->code]) ? '' : $uciIdMap[$rpUnit->code];
			
			$row = array(
				$rpUnit->rank,
				$rpUnit->code,
				$jcfno,
				$uciid,
				$nameMap[$rpUnit->code],
			);
			
			$row[] = empty($teamMap[$rpUnit->code]) ? '' : $teamMap[$rpUnit->code];
			
			for ($i = 0; $i < count($mpss); $i++)
			{
				if (!isset($racerPoints[$rpUnit->code][$i])) {
					$row[] = '';
					if ($dividesBonusCol) {
						$row[] = '';
					}
					continue;
				}
				
				$point = $racerPoints[$rpUnit->code][$i];
				if ($dividesBonusCol) {
					$row[] = empty($point['pt']) ? '' : $point['pt'];
					$row[] = empty($point['bonus']) ? '' : $point['bonus'];
				} else {
					$ptExp = '';
					if (!empty($point['pt'])) {
						$ptExp .= $point['pt'];
					}
					if (!empty($point['bonus'])) {
						$ptExp .= '+' . $point['bonus'];
					}
					$row[] = $ptExp;
				}
			}
			
			foreach ($rpUnit->rankPt as $pt) {
				$row[] = $pt;
			}
			
			$this->__putToFp($fp, $row);
		}
		
		fclose($fp);
		
		$filename = TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $id . '.csv';
		$tmpFile->copy($filename, true);
		
		$this->Flash->set(h($ps['PointSeries']['name'] . 'のランキングファイルを更新しました。'));
		
		$this->redirect($this->referer());
	}
	
	/**
	 * file pointer に対して shift-JIS で CSV 出力する。
	 * @param filepointer $fp ファイルポインタ
	 * @param array $row 行ごとの配列
	 */
	private function __putToFp($fp, $row)
	{
		//mb_convert_variables('UTF-8', 'auto', $row);
		fputcsv($fp, $row);
	}
	
	/**
	 * ランキング集計を行なう。point series の設定で、hint に cat_limit:C1/C2 などとすると、
	 * 計算日でのカテゴリー所属がチェックされる。上記例だと C1 or C2 に所属していることが条件となる。
	 * @param type $seriesId
	 * @param type $date 計算基準日
	 * @return array 'ranking', 'ps', 'mpss', 'nameMap', 'teamMap', 'racerPoints' をキーとする配列。
	 *			エラーの場合、 'error' => 'エラー内容' の配列。
	 */
	public function calcUpSeries($seriesId, $date = null)
	{
		$this->PointSeries->id = $seriesId;
		if (!$this->PointSeries->exists()) {
			return array('error' => 'ポイントシリーズの指定が不正です。');
		}
		
		$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $seriesId));
		$ps = $this->PointSeries->find('first', $options);
		if (empty($ps['PointSeries']['sum_up_rule'])) {
			return array('error' => 'ポイントシリーズ／集計ルールが見つかりません。');
		}
		$sumUpRule = PointSeriesSumUpRule::ruleAt($ps['PointSeries']['sum_up_rule']);
		if (empty($sumUpRule)) {
			return array('error' => '集計ルールの指定が不正です。');
		}
		
		$catLimit = array();
		$onlyJcfer = false;
		if (isset($ps['PointSeries']['hint'])) {
			$seriesHints = PointSeriesSumUpRule::getSeriesHints($ps['PointSeries']['hint']);
			foreach ($seriesHints as $key => $val) {
				if ($key === 'cat_limit') {
					$catLimit = explode("/", $val);
					// not break // 最後のものを有効とする。
				} else if ($val === 'only_jcfer') {
					$onlyJcfer = true;
				}
			}
		}
		//$this->log('cat limit:', LOG_DEBUG);
		//$this->log($catLimit, LOG_DEBUG);
		
		$dt = ($date == null) ? date('Y-m-d') : $date;
		
		$op = array(
			'conditions' => array(
				'point_series_id' => $seriesId,
				array('or' => array(
					array('point_term_end >=' => $dt),
					array('point_term_end' => null),
				)),
				array('or' => array(
					array('point_term_begin <=' => $dt),
					array('point_term_begin' => null),
				)),
			),
			'order' => array('Meet.at_date' => 'ASC'),
		);
		
		$mpss = $this->MeetPointSeries->find('all', $op);
		if (empty($mpss)) {
			return array('error' => 'ポイントシリーズのレース指定が見つかりません。');
		}
		
		$meetIndex = 0;
		$racerPoints = array(); // key が選手コード。$meetTitles と同じインデックスにポイントが入る
		// とりあえずここで集計。トータルの順位付けは RnakCalcer が行なう。
		
		$this->PointSeriesRacer->Behaviors->load('Containable');
		$nameMap = array(); // 名前取得用。key: racer_code, val: name（半角スペース区切り）
		$teamMap = array(); // 同上チーム名取得用
		$jcfNoMap = array(); // JCF Number 取得用
		$uciIdMap = array(); // UCI ID 取得用
		
		$hints = array(); // 必ず集計する大会インデックスを取得しておく
		for ($i = 0; $i < count($mpss); $i++) {
			$mps = $mpss[$i];
			//$this->log('mps id:' . $mps['MeetPointSeries']['id'], LOG_DEBUG);
			
			$hints[] = $mps['MeetPointSeries']['hint'];
			
			$contains = array(
				'Racer' => array('fields' => array('family_name', 'first_name', 'team', 'birth_date', 'jcf_number', 'uci_id')),
				'RacerResult' => array(
					'fields' => array('rank'),
					'EntryRacer' => array(
						'fields' => array('name_at_race', 'team_name')
					)
				)
			);
			
			if (!empty($catLimit)) {
				$contains['Racer'][] = 'CategoryRacer';
			}
			
			$op = array(
				'conditions' => array('meet_point_series_id' => $mps['MeetPointSeries']['id']),
				'contain' => $contains
			);
			$psrs = $this->PointSeriesRacer->find('all', $op);
			//$this->log('psrs is...' . count($psrs), LOG_DEBUG);
			
			foreach ($psrs as $psr) {
				
				if (!empty($catLimit)) {
					// カテゴリー所属制限をチェック
					$hasCat = false;
					foreach ($psr['Racer']['CategoryRacer'] as $cr) {
						if ($cr['deleted'] == 1 || $cr['apply_date'] > $dt
								|| (!empty($cr['cancel_date']) && $cr['cancel_date'] < $dt)) {
							continue;
						}
						
						if (in_array($cr['category_code'], $catLimit)) {
							$hasCat = true;
							break;
						}
					}
					
					//$this->log('hasCat:' . $hasCat . ' racer:' . $psr['PointSeriesRacer']['racer_code'], LOG_DEBUG);
					if (!$hasCat) continue;
				}
				
				if ($onlyJcfer) {
					// jcf number 持っている選手のみ
					if (empty($psr['Racer']['jcf_number'])) {
						continue;
					}
				}
				
				// result.deleted, entry_racer.deleted など拾おうと思ったが、外部レースの集計を考えると入れておきたい
				// ただし deleted の連鎖がきちんと動いていないと不正になる可能性がある。
				// TODO: 再考慮スべし
				
				$racerCode = $psr['PointSeriesRacer']['racer_code'];
				if (empty($racerPoints[$racerCode])) {
					$racerPoints[$racerCode] = array();
				}
				//$this->log($psr, LOG_DEBUG);
				// ゼロも格納する
				$racerPoints[$racerCode][$meetIndex] = array();
				$racerPoints[$racerCode][$meetIndex]['pt'] = $psr['PointSeriesRacer']['point']; // not null
				$racerPoints[$racerCode][$meetIndex]['bonus'] = $psr['PointSeriesRacer']['bonus']; // may null
				if (!empty($psr['RacerResult']['rank'])) {
					// リザルト順位で比較する時用
					$racerPoints[$racerCode][$meetIndex]['rank'] = $psr['RacerResult']['rank'];
				}
				
				if (empty($nameMap[$racerCode])) {
					$name = $psr['Racer']['family_name'] . ' ' . $psr['Racer']['first_name'];
					$nameMap[$racerCode] = $name;
				}
				// $psr['Racer']['team'] は現在のチーム名とは異なる可能性もあるので、格納しない（出走チーム名無しの場合）。
				
				// それぞれのシリーズ内の選手名、チーム名を表示するため、result->entryRacer から取得。
				if (!empty($psr['RacerResult']['EntryRacer']['name_at_race'])) {
					$nameMap[$racerCode] = $psr['RacerResult']['EntryRacer']['name_at_race'];
				}
				if (!empty($nameMap[$racerCode])) {
					if (AjoccUtil::isLessElite($psr['Racer']['birth_date'], $mps['PointSeries']['season_id'])) {
						$nameMap[$racerCode] .= '*';
					}
				}
				
				if (!empty($psr['RacerResult']['EntryRacer']['team_name'])) {
					if (!Validation::email($psr['RacerResult']['EntryRacer']['team_name'])) {
						$teamMap[$racerCode] = $psr['RacerResult']['EntryRacer']['team_name'];
					} else {
						$this->log($psr['RacerResult']['EntryRacer']['team_name'] . 'がmail 形式のため、設定せず。', LOG_WARNING);
					}
				}
				
				if (!empty($psr['Racer']['jcf_number'])) {
					$jcfNoMap[$racerCode] = $psr['Racer']['jcf_number'];
				}
				
				if (!empty($psr['Racer']['uci_id'])) {
					$uciIdMap[$racerCode] = $psr['Racer']['uci_id'];
				}
			}
			
			++$meetIndex;
		}
		
		//$this->log($racerPoints, LOG_DEBUG);
		$ranking = $sumUpRule->calc($racerPoints, $hints, $ps['PointSeries']['hint']);
		
		return array(
			'ranking' => $ranking,
			'ps' => $ps,
			'mpss' => $mpss,
			'nameMap' => $nameMap,
			'teamMap' => $teamMap,
			'jcfNoMap' => $jcfNoMap,
			'uciIdMap' => $uciIdMap,
			'racerPoints' => $racerPoints,
		);
	}
	
	/**
	 * ダブルクオートで囲み、内部のダブルクオートをエスケープした文字列をかえす
	 * @param string $s 文字列
	 */
	private function __dQuoteEscaped($s)
	{
		return '"' . str_replace('"', '""', $s) . '"';
	}
	
	public function download_point_ranking_csv()
	{
		if (!$this->request->is('post')) {
			throw new BadMethodCallException('Bad method.');
		}
		
		if (empty($this->request->data['point_series_id'])) {
			throw new BadRequestException('Needs Point Series id.');
		}
		$psid = $this->request->data['point_series_id'];
		
		$this->PointSeries->id = $psid;
		if (!$this->PointSeries->exists()) {
			throw new NotFoundException(__('Invalid point series'));
		}
		
		$this->_mkdir4Ranking();
		
		if (empty($this->request->data['point_series_id'])) {
			throw new BadRequestException('Needs Parameter.');
		}
		
		$filename = TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $psid . '.csv';
		$file = new File($filename);
		
		if (!$file->exists())
		{
			$this->Flash->set(__('ランキングのファイルがありません。ファイルの更新が必要です。'));
			return $this->redirect(array('controller' => 'OrgUtil', 'action' => 'point_series_csv_links'));
		}
		
		$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $psid));
		$ps = $this->PointSeries->find('first', $options);
		
		$dlFilename = self::__RANKING_FILE_PREFIX . $ps['PointSeries']['name'] . '_' . date('Ymd\THi', $file->lastChange()) . '.csv';
		
		$this->autoRender = false;
		$this->response->file($file->path, array('name' => $dlFilename, 'download' => true));
	}
	
	/**
	 * 選手一覧用のディレクトリを作成する
	 */
	private function _mkdir4Ranking()
	{
		$dir = new Folder();
		$dir->create(TMP . 'cyclox2');
		
		$dir = new Folder();
		$dir->create(TMP . 'cyclox2/point_series');
		
		$dir = new Folder();
		$dir->create(TMP . self::__PATH_RANKING);
	}
	
	/**
	 * シリーズ一覧の json をかえす
	 */
	public function series_json()
	{
		$seriesList = $this->PointSeries->find('all', array('recursive' => -1));
		$groups = $this->PointSeriesGroup->find('all', array('recursive' => -1));
		$seasons = $this->Season->find('all', array('recursive' => -1));
		
		return $this->success(array(
			'series' => $seriesList,
			'series_groups' => $groups,
			'seasons' => $seasons,
		));
	}
	
	/**
	 * ランキングデータを更新する。
	 * @param type $psid ポイントシリーズ ID
	 */
	public function updateRanking($psid)
	{
		if (!$this->request->is('post')) {
			throw new BadMethodCallException('Bad method.');
		}
		
		if (!$this->PointSeries->exists($psid)) {
			throw new NotFoundException(__('無効なポイントシリーズが指定されました。'));
		}
		
		$shell = new ResultShell();
		$shell->startup();
		
		$ret = $shell->execUpdateRanking($psid);
		if ($ret) {
			$this->Flash->set(__('ランキングデータを更新しました。'), array('element' => 'success'));
		} else {
			$this->Flash->set(__('ランキングデータの更新に失敗しました。'), array('element' => 'error'));
		}
		
		$this->redirect($this->referer());
	}
	
	/**
	 * 公開とするデータを指定する
	 * @param int $id point series id
	 * @param int $psrsGroupId 公開とするデータ set の group id
	 * @return void
	 * @throws NotFoundException
	 */
	public function assign_public_ranking($id, $psrsGroupId)
	{
		$this->request->allowMethod('post', 'delete');

		$this->PointSeries->id = $id;
		if (!$this->PointSeries->exists()) {
			throw new NotFoundException(__('Invalid point series'));
		}
		
		$ps = array('PointSeries' => array(
			'public_psrset_group_id' => $psrsGroupId,
			'published_at' => date("Y-m-d H:i:s"),
		));
		if ($this->PointSeries->save($ps)) {
			$this->Flash->success(__('ポイントシリーズ ID:' . $id . ' の公開データとして Data-ID:' . $psrsGroupId . ' を指定しました。'));
			return $this->redirect($this->request->referer());
		} else {
			$this->Flash->set(__('公開処理に失敗しました。'));
		}
	}
	
	/**
	 * 
	 * @param int $id ポイントシリーズ ID
	 * @param int $psrsGroupId set の group id
	 */
	public function view_ranking($id, $psrsGroupId)
	{
		$opt = array(
			'conditions' => array(
				'point_series_id' => $id,
				'set_group_id' => $psrsGroupId
			),
			'order' => array(
				'rank' => 'ASC'
			)
		);
		
		$psrsets = $this->TmpPointSeriesRacerSet->find('all', $opt);
		$this->set('psrsets', $psrsets);
	}
}
