<?php

App::uses('ApiBaseController', 'Controller');

/**
 * EntryCategories Controller
 *
 * @property EntryCategory $EntryCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EntryCategoriesController extends ApiBaseController
{
	public $uses = array('EntryCategory', 'EntryRacer', 'PointSeries');
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->EntryCategory->recursive = 0;
		$this->set('entryCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null)
	{
		if (!$this->EntryCategory->exists($id)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$options = array(
			'conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $id),
			'recursive' => 0,
		);
		$ecat = $this->EntryCategory->find('first', $options);
		
		$this->EntryRacer->Behaviors->load('Containable');
		
		$opt = array();
		$opt['contain'] = array('RacerResult' => array('HoldPoint', 'PointSeriesRacer'));
		$opt['conditions'] = array(
			'entry_category_id' => $ecat['EntryCategory']['id']
		);
		$opt['order'] = array('body_number * 1' => 'asc'); // "* 1" -> 整数でオーダー
		$eracers = $this->EntryRacer->find('all', $opt);
		//$this->log('racers:', LOG_DEBUG);
		//$this->log($eracers, LOG_DEBUG);
		
		$ecat['EntryRacer'] = $eracers;
		$this->set('entryCategory', $ecat);
		
		// リザルトの entry_category_id の有効な数を数える（NULL だったらリザルト無しだから）
		$results = array();
		$psTitles = array(); // [n] => array('id' => id, 'name' => name)
		$holdPointCount = 0;
		foreach ($eracers as $er) {
			// リザルトのあるものだけを格納
			if (isset($er['RacerResult']['id'])) {
				
				// $er に対してシリーズポイント設定
				if (!empty($er['RacerResult']['PointSeriesRacer'])) {
					foreach ($er['RacerResult']['PointSeriesRacer'] as $psr) {
						// point_series_is がタイトルにあるか検索
						$finds = false;
						$index = 0;
						foreach ($psTitles as $title) {
							if ($psr['point_series_id'] == $title['id']) {
								$finds = true;
								break;
							}
							++$index;
						}
						
						if (!$finds) {
							$opt = array('conditions' => array('id' => $psr['point_series_id']), 'recursive' => -1);
							$series = $this->PointSeries->find('first', $opt);
							$psTitles[$index] = array('id' => $psr['point_series_id'], 'name' => $series['PointSeries']['short_name']);
						}
						
						if (empty($er['RacerResult']['points'])) {
							$er['RacerResult']['points'] = array();
						}
						$er['RacerResult']['points'][$index] = array(
							'pt' => $psr['point'],
							'bonus' => $psr['bonus'],
						);
						// TODO: 検証 - ポイントシリーズが複数になった時にきちんと表示されるか。
					}
				}
				
				$results[] = $er;
				if (!empty($er['RacerResult']['HoldPoint'])) {
					++$holdPointCount;
				}
			}
		}
		//$this->log('results:', LOG_DEBUG);
		//$this->log($results, LOG_DEBUG);
		//$this->log($psTitles, LOG_DEBUG);
		
		if (!empty($results)) {
			$results = Set::sort($results, '{n}.RacerResult.order_index', 'asc');
			$this->set('results', $results);
			$this->set('holdPointCount', $holdPointCount);
			$this->set('psTitles', $psTitles);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add()
	{
		if ($this->_isApiCall()) {
			return $this->__addOnApi();
		} else {
			return $this->__addOnPage();
		}
	}
	
	/**
	 * 管理画面上での add 処理
	 * @return void
	 */
	private function __addOnPage()
	{
		if ($this->request->is('post')) {
			$this->EntryCategory->create();
			if ($this->EntryCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The entry category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry category could not be saved. Please, try again.'));
			}
		}
		$racesCategories = $this->EntryCategory->RacesCategory->find('list');
		$this->set(compact('entryGroups', 'racesCategories'));
	}
	
	/**
	 * API 上での add 処理
	 * @return void
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			$this->log($this->request->data, LOG_DEBUG);
			$this->EntryCategory->create();
			
			if ($this->EntryCategory->save($this->request->data)) {
				return $this->success(array('entry_category_id' => $this->EntryCategory->id));
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
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
		if (!$this->EntryCategory->exists($id)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EntryCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The entry category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $id));
			$this->request->data = $this->EntryCategory->find('first', $options);
		}
		$racesCategories = $this->EntryCategory->RacesCategory->find('list');
		$this->set(compact('entryGroups', 'racesCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->EntryCategory->id = $id;
		if (!$this->EntryCategory->exists()) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EntryCategory->delete()) {
			$this->Session->setFlash(__('The entry category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The entry category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
