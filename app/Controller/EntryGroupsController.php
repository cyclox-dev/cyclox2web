<?php

App::uses('ApiBaseController', 'Controller');

/**
 * EntryGroups Controller
 *
 * @property EntryGroup $EntryGroup
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class EntryGroupsController extends ApiBaseController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->EntryGroup->recursive = 0;
		$this->set('entryGroups', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->EntryGroup->exists($id)) {
			throw new NotFoundException(__('Invalid entry group'));
		}
		$options = array('conditions' => array('EntryGroup.' . $this->EntryGroup->primaryKey => $id));
		$this->set('entryGroup', $this->EntryGroup->find('first', $options));
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
			$this->EntryGroup->create();
			if ($this->EntryGroup->save($this->request->data)) {
				$this->Flash->set(__('The entry group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The entry group could not be saved. Please, try again.'));
			}
		}
		$meets = $this->EntryGroup->Meet->find('list');
		$this->set(compact('meets'));
	}
	
	/**
	 * API 上での add 処理
	 * @return void
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			//$this->log($this->request->data, LOG_DEBUG);
			$this->EntryGroup->create();
			
			if ($this->EntryGroup->save($this->request->data)) {
				return $this->success(array('entry_group_id' => $this->EntryGroup->id));
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
		if (!$this->EntryGroup->exists($id)) {
			throw new NotFoundException(__('Invalid entry group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EntryGroup->save($this->request->data)) {
				$this->Flash->set(__('The entry group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The entry group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EntryGroup.' . $this->EntryGroup->primaryKey => $id));
			$this->request->data = $this->EntryGroup->find('first', $options);
		}
		$meets = $this->EntryGroup->Meet->find('list');
		$this->set(compact('meets'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->EntryGroup->id = $id;
		if (!$this->EntryGroup->exists()) {
			throw new NotFoundException(__('Invalid entry group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EntryGroup->delete()) {
			$this->Flash->set(__('The entry group has been deleted.'));
		} else {
			$this->Flash->set(__('The entry group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
