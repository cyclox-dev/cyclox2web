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

/**
 * PointSeries Controller
 *
 * @property PointSeries $PointSeries
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PointSeriesController extends ApiBaseController
{
	public $uses = array('PointSeries', 'MeetPointSeries', 'PointSeriesRacer', 'Season');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');
	
	const __PATH_RANKING = 'cyclox2/point_series/rankings';
	const __RANKING_FILE_PREFIX = 'ranking_';


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PointSeries->recursive = 0;
		$this->set('pointSeries', $this->Paginator->paginate());
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
		$this->set('pointSeries', $this->PointSeries->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PointSeries->create();
			if ($this->PointSeries->save($this->request->data)) {
				$this->Session->setFlash(__('The point series has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The point series could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->PointSeries->Season->find('list');
		$this->set(compact('seasons'));
		
		$this->set('pointCalculators', PointCalculator::calculators());
		$this->set('sumUpRules', PointSeriesSumUpRule::rules());
		$this->set('pointTos', PointSeriesPointTo::pointToList());
		$this->set('termRules', PointSeriesTermOfValidityRule::rules());
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
				$this->Session->setFlash(__('The point series has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The point series could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $id));
			$this->request->data = $this->PointSeries->find('first', $options);
		}
		$seasons = $this->PointSeries->Season->find('list');
		$this->set(compact('seasons'));
		
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
			$this->Session->setFlash(__('The point series has been deleted.'));
		} else {
			$this->Session->setFlash(__('The point series could not be deleted. Please, try again.'));
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
		
		$ranking = $ret['ranking'];
		$ps = $ret['ps'];
		$mpss = $ret['mpss'];
		$nameMap = $ret['nameMap'];
		$teamMap = $ret['teamMap'];
		$racerPoints = $ret['racerPoints'];
		
		if (empty($ranking)) {
			throw new InternalErrorException('could not sum up ranking...');
		}
		
		$this->_mkdir4Ranking();
		
		$tmpFile = new File(TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $id . '.csv.tmp');
		if ($tmpFile->exists()) {
			$tmpFile->delete();
		}
		$tmpFile->create();
		$tmpFile->append(mb_convert_encoding($ps['PointSeries']['name'] . ' ランキング,更新日:' . date('Y-m-d')
				. ',計算基準日:' . $dt . "\n", 'UTF-8', 'auto'));
		$rowString = '順位,選手 Code,選手名,チーム名';
		foreach ($mpss as $mps) {
			$rowString .= ',' . $mps['MeetPointSeries']['express_in_series'];
			$rowString .= ',' . $mps['MeetPointSeries']['express_in_series'] . 'Bonus';
		}
		foreach ($ranking['rank_pt_title'] as $title) {
			$rowString .= ',' . $title;
		}
		$tmpFile->append(mb_convert_encoding($rowString . "\n", 'UTF-8', 'auto'));
		
		foreach ($ranking['ranking'] as $rpUnit) {
			$rowString = $rpUnit->rank . ',' . $rpUnit->code . ','
				. $this->__dQuoteEscaped($nameMap[$rpUnit->code]) . ',';
			if (!empty($teamMap[$rpUnit->code])) {
				$rowString .= $this->__dQuoteEscaped($teamMap[$rpUnit->code]);
			}
			
			for ($i = 0; $i < count($mpss); $i++)
			{
				$rowString .= ',';
				if (!isset($racerPoints[$rpUnit->code][$i])) {
					$rowString .= ',';
					continue;
				}
				
				$point = $racerPoints[$rpUnit->code][$i];
				if (!empty($point['pt'])) {
					$rowString .= $point['pt'];
				}
				$rowString .= ',';
				if (!empty($point['bonus'])) {
					$rowString .= $point['bonus'];
				}
			}
			
			foreach ($rpUnit->rankPt as $pt) {
				$rowString .= ',' . $pt;
			}
			
			$tmpFile->append(mb_convert_encoding($rowString . "\n", 'UTF-8', 'auto'));
		}
		
		$tmpFile->close();
		
		$filename = TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $id . '.csv';
		$tmpFile->copy($filename, true);
		
		$this->Session->setFlash(h($ps['PointSeries']['name'] . 'のランキングファイルを更新しました。'));
		
		$this->redirect(array('controller' => 'OrgUtil', 'action' => 'point_series_csv_links'));
	}
	
	/**
	 * ランキング集計を行なう。
	 * @param type $seriesId
	 * @param type $date
	 * @return array 'ranking', 'ps', 'mpss', 'nameMap', 'teamMap', 'racerPoints' をキーとする配列
	 * @throws NotFoundException
	 */
	public function calcUpSeries($seriesId, $date = null)
	{
		$this->PointSeries->id = $seriesId;
		if (!$this->PointSeries->exists()) {
			throw new NotFoundException(__('Invalid point series'));
		}
		
		$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $seriesId));
		$ps = $this->PointSeries->find('first', $options);
		if (empty($ps['PointSeries']['sum_up_rule'])) {
			throw new NotFoundException(__('Invalid sum-up-rule setting of point series'));
		}
		$sumUpRule = PointSeriesSumUpRule::ruleAt($ps['PointSeries']['sum_up_rule']);
		if (empty($sumUpRule)) {
			throw new NotFoundException(__('Invalid(empty) sum-up-rule setting of point series'));
		}
		
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
			throw new NotFoundException(__('Invalid point series'));
		}
		
		$meetIndex = 0;
		$racerPoints = array(); // key が選手コード。$meetTitles と同じインデックスにポイントが入る
		// とりあえずここで集計。トータルの順位付けは RnakCalcer が行なう。
		
		$this->PointSeriesRacer->Behaviors->load('Containable');
		$nameMap = array(); // 名前取得用。key: racer_code, val: name（半角スペース区切り）
		$teamMap = array(); // 同上チーム名取得用。
		
		$hints = array(); // 必ず集計する大会インデックスを取得しておく
		for ($i = 0; $i < count($mpss); $i++) {
			$mps = $mpss[$i];
			//$this->log('mps id:' . $mps['MeetPointSeries']['id'], LOG_DEBUG);
			
			$hints[] = $mps['MeetPointSeries']['hint'];
			
			$contains = array(
				'Racer' => array('fields' => array('family_name', 'first_name', 'team', 'birth_date')),
				'RacerResult' => array(
					'fields' => array('rank'),
					'EntryRacer' => array(
						'fields' => array('name_at_race', 'team_name')
					)
				)
			);
			
			$op = array(
				'conditions' => array('meet_point_series_id' => $mps['MeetPointSeries']['id']),
				'contain' => $contains
			);
			$psrs = $this->PointSeriesRacer->find('all', $op);
			//$this->log('psrs is...' . count($psrs), LOG_DEBUG);
			
			foreach ($psrs as $psr) {
				
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
					if ($this->__isLessElite($psr['Racer']['birth_date'], $mps['PointSeries']['season_id'])) {
						$name .= '*';
					}
					
					$nameMap[$racerCode] = $name;
				}
				// $psr['Racer']['team'] は現在のチーム名とは異なる可能性もあるので、格納しない（出走チーム名無しの場合）。
				
				// それぞれのシリーズ内の選手名、チーム名を表示するため、result->entryRacer から取得。
				if (!empty($psr['RacerResult']['EntryRacer']['name_at_race'])) {
					$nameMap[$racerCode] = $psr['RacerResult']['EntryRacer']['name_at_race'];
				}
				if (!empty($psr['RacerResult']['EntryRacer']['team_name'])) {
					if (!Validation::email($psr['RacerResult']['EntryRacer']['team_name'])) {
						$teamMap[$racerCode] = $psr['RacerResult']['EntryRacer']['team_name'];
					} else {
						$this->log($psr['RacerResult']['EntryRacer']['team_name'] . 'がmail 形式のため、設定せず。', LOG_WARNING);
					}
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
	
	/**
	 * UCI Elite 未満の年齢であるかをかえす
	 * @param date $birth 生年月日
	 * @param int $seasonID 年齢判定シーズン ID。null 指定、もしくは無効なシーズン ID 指定ならば現在日時で判定する。
	 * @return boolean Elite 未満の年齢であるか
	 */
	private function __isLessElite($birth, $seasonID)
	{
		if (empty($birth)) return false;
		
		$atDate = new DateTime('now');
		if (!empty($seasonID)) {
			$season = $this->Season->find('first', array('conditions' => array('id' => $seasonID), 'recurive' => 0));
			//$this->log('season:', LOG_DEBUG);
			//$this->log($season, LOG_DEBUG);
			
			if (!empty($season['Season']['end_date'])) {
				$atDate = new DateTime($season['Season']['end_date']);
			}
		}
		
		$uciAge = Util::uciCXAgeAt(new DateTime($birth), $atDate);
		//$this->log('uci age:' . $uciAge, LOG_DEBUG);
		
		return $uciAge < 23;
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
			$this->Session->setFlash(__('ランキングのファイルがありません。ファイルの更新が必要です。'));
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
		
		return $this->success(array('series' => $seriesList));
	}
}
