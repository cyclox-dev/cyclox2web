<?php
App::uses('AppController', 'Controller');
/**
 * TimeRecordInfos Controller
 *
 * @property TimeRecordInfo $TimeRecordInfo
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TimeRecordInfosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TimeRecordInfo->recursive = 0;
		$this->set('timeRecordInfos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TimeRecordInfo->exists($id)) {
			throw new NotFoundException(__('Invalid time record info'));
		}
		$options = array('conditions' => array('TimeRecordInfo.' . $this->TimeRecordInfo->primaryKey => $id));
		$this->set('timeRecordInfo', $this->TimeRecordInfo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TimeRecordInfo->create();
			if ($this->TimeRecordInfo->save($this->request->data)) {
				$this->Session->setFlash(__('The time record info has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The time record info could not be saved. Please, try again.'));
			}
		}
		$entryGroups = $this->TimeRecordInfo->EntryGroup->find('list');
		$this->set(compact('entryGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TimeRecordInfo->exists($id)) {
			throw new NotFoundException(__('Invalid time record info'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TimeRecordInfo->save($this->request->data)) {
				$this->Session->setFlash(__('The time record info has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The time record info could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TimeRecordInfo.' . $this->TimeRecordInfo->primaryKey => $id));
			$this->request->data = $this->TimeRecordInfo->find('first', $options);
		}
		$entryGroups = $this->TimeRecordInfo->EntryGroup->find('list');
		$this->set(compact('entryGroups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TimeRecordInfo->id = $id;
		if (!$this->TimeRecordInfo->exists()) {
			throw new NotFoundException(__('Invalid time record info'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TimeRecordInfo->delete()) {
			$this->Session->setFlash(__('The time record info has been deleted.'));
		} else {
			$this->Session->setFlash(__('The time record info could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
