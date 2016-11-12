<?php

App::uses('ApiBaseController', 'Controller');

/**
 * EntryRacers Controller
 *
 * @property EntryRacer $EntryRacer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EntryRacersController extends ApiBaseController {

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
		$this->EntryRacer->recursive = 0;
		
		// recursive = 0 にしたので、同じ entry_racer が複数行になるのを防止。
		$this->EntryRacer->RacerResult->Behaviors->load('Utils.SoftDelete');
		
		$this->set('entryRacers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->EntryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid entry racer'));
		}
		$options = array('conditions' => array('EntryRacer.' . $this->EntryRacer->primaryKey => $id));
		$this->set('entryRacer', $this->EntryRacer->find('first', $options));
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
			$this->EntryRacer->create();
			if ($this->EntryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The entry racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry racer could not be saved. Please, try again.'));
			}
		}
		$this->set(compact('entryCategories', 'racers'));
	}
	
	/**
	 * API 上での add 処理
	 * @return void
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			//$this->log($this->request->data, LOG_DEBUG);
			$this->EntryRacer->create();
			
			if ($this->EntryRacer->save($this->request->data)) {
				return $this->success(array('entry_racer_id' => $this->EntryRacer->id));
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
		if (!$this->EntryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid entry racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EntryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The entry racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EntryRacer.' . $this->EntryRacer->primaryKey => $id));
			$this->request->data = $this->EntryRacer->find('first', $options);
		}
		$this->set(compact('entryCategories', 'racers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->EntryRacer->id = $id;
		if (!$this->EntryRacer->exists()) {
			throw new NotFoundException(__('Invalid entry racer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EntryRacer->delete()) {
			$this->Session->setFlash(__('The entry racer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The entry racer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
