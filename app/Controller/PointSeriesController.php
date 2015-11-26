<?php

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('PointSeriesSumUpRule', 'Cyclox/Const');

/**
 * PointSeries Controller
 *
 * @property PointSeries $PointSeries
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PointSeriesController extends AppController
{
	public $uses = array('PointSeries', 'MeetPointSeries', 'PointSeriesRacer');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	
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
	 */
	public function calcup()
	{
		$this->request->allowMethod('post');
		
		if (empty($this->request->data['point_series_id'])) {
			throw new BadRequestException('Needs Point Series id.');
		}
		
		$id = $this->request->data['point_series_id'];
		
		$this->PointSeries->id = $id;
		if (!$this->PointSeries->exists()) {
			throw new NotFoundException(__('Invalid point series'));
		}
		
		$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $id));
		$ps = $this->PointSeries->find('first', $options);
		if (empty($ps['PointSeries']['sum_up_rule'])) {
			throw new NotFoundException(__('Invalid sum-up-rule setting of point series'));
		}
		$sumUpRule = PointSeriesSumUpRule::ruleAt($ps['PointSeries']['sum_up_rule']);
		if (empty($sumUpRule)) {
			throw new NotFoundException(__('Invalid(empty) sum-up-rule setting of point series'));
		}
		
		$op = array(
			'conditions' => array(
				'point_series_id' => $id,
				'or' => array(
					array('point_term_end >=' => date('yyyy-mm-dd')),
					array('point_term_end ' => null),
				)
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
		// TODO チーム名も
		
		$hints = array(); // 必ず集計する大会インデックスを取得しておく
		for ($i = 0; $i < count($mpss); $i++) {
			$mps = $mpss[$i];
			//$this->log('mps id:' . $mps['MeetPointSeries']['id'], LOG_DEBUG);
			
			$hints[] = $mps['MeetPointSeries']['hint'];
			
			$op = array(
				'conditions' => array('meet_point_series_id' => $mps['MeetPointSeries']['id']),
				'contain' => array('Racer.family_name', 'Racer.first_name', 'RacerResult.rank')
			);
			$psrs = $this->PointSeriesRacer->find('all', $op);
			//$this->log('psrs is...' . count($psrs), LOG_DEBUG);
			
			foreach ($psrs as $psr) {
				$racerCode = $psr['PointSeriesRacer']['racer_code'];
				if (empty($racerPoints[$racerCode])) {
					$racerPoints[$racerCode] = array();
				}
				$this->log($psr, LOG_DEBUG);
				// ゼロも格納する
				$racerPoints[$racerCode][$meetIndex] = array();
				$racerPoints[$racerCode][$meetIndex]['pt'] = $psr['PointSeriesRacer']['point']; // not null
				$racerPoints[$racerCode][$meetIndex]['bonus'] = $psr['PointSeriesRacer']['bonus']; // may null
				if (!empty($psr['RacerResult']['rank'])) {
					// リザルト順位で比較する時用
					$racerPoints[$racerCode][$meetIndex]['rank'] = $psr['RacerResult']['rank'];
				}
				
				if (empty($nameMap[$racerCode])) {
					$nameMap[$racerCode] = $psr['Racer']['family_name'] . ' ' . $psr['Racer']['first_name'];
				}
			}
			
			++$meetIndex;
		}
		
		//$this->log($racerPoints, LOG_DEBUG);
		$ranking = $sumUpRule->calc($racerPoints, $hints);
		
		if (empty($ranking)) {
			throw new InternalErrorException('could not sum up ranking...');
		}
		
		$this->_mkdir4Ranking();
		
		$tmpFile = new File(TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $id . '.csv.tmp');
		if ($tmpFile->exists()) {
			$tmpFile->delete();
		}
		$tmpFile->create();
		$tmpFile->append(mb_convert_encoding($ps['PointSeries']['name'] . ' ランキング,更新日:' . date('Y/m/d') ."\n", 'SJIS', 'auto'));
		$rowString = '順位,選手 Code,選手名';
		foreach ($mpss as $mps) {
			$rowString .= ',' . $mps['MeetPointSeries']['express_in_series'];
		}
		foreach ($ranking['rank_pt_title'] as $title) {
			$rowString .= ',' . $title;
		}
		$tmpFile->append(mb_convert_encoding($rowString . "\n", 'SJIS', 'auto'));
		
		foreach ($ranking['ranking'] as $rpUnit) {
			$rowString = $rpUnit->rank . ',' . $rpUnit->code . ',"' . $nameMap[$rpUnit->code] . '"';
			
			for ($i = 0; $i < count($mpss); $i++)
			{
				$rowString .= ',';
				if (!isset($racerPoints[$rpUnit->code][$i])) continue;
				
				$point = $racerPoints[$rpUnit->code][$i];
				if (!empty($point['pt'])) {
					$rowString .= $point['pt'];
				}
				if (!empty($point['bonus'])) {
					$rowString .= '+' . $point['bonus'];
				}
			}
			
			foreach ($rpUnit->rankPt as $pt) {
				$rowString .= ',' . $pt;
			}
			
			$tmpFile->append(mb_convert_encoding($rowString . "\n", 'SJIS', 'auto'));
		}
		
		$tmpFile->close();
		
		$filename = TMP . self::__PATH_RANKING . '/' . self::__RANKING_FILE_PREFIX . $id . '.csv';
		$tmpFile->copy($filename, true);
		
		$this->Session->setFlash(h($ps['PointSeries']['name'] . 'のランキングファイルを更新しました。'));
		
		$this->redirect(array('controller' => 'OrgUtil', 'action' => 'point_series_csv_links'));
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
			return $this->redirect(array('controller' => 'OrgUtil', 'action' => 'racer_list_csv_links'));
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
}
