<?php

App::uses('AppController', 'Controller');
App::uses('AjoccUtil', 'Cyclox/Util');

/**
 * Meets Controller
 *
 * @property Meet $Meet
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MeetsController extends AppController {

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
		$this->Meet->recursive = 0;
		$this->set('meets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Meet->exists($id)) {
			throw new NotFoundException(__('Invalid meet'));
		}
		$options = array('conditions' => array('Meet.' . $this->Meet->primaryKey => $id));
		$this->set('meet', $this->Meet->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if ($this->request->is('post')) {
			$this->Meet->create();
			
			$meetGroupCode = $this->request->data['Meet']['meet_group_code'];
			$this->request->data['Meet']['code'] = AjoccUtil::nextMeetCode($meetGroupCode);
			
			if ($this->Meet->save($this->request->data)) {
				$this->log($this->Meet->getDataSource()->getLog(), LOG_DEBUG);
			
				$this->Session->setFlash(__('The meet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->Meet->Season->find('list');
		$meetGroups = $this->Meet->MeetGroup->find('list');
		$this->set(compact('seasons', 'meetGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Meet->exists($id)) {
			throw new NotFoundException(__('Invalid meet'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Meet->save($this->request->data)) {
				$this->Session->setFlash(__('The meet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Meet.' . $this->Meet->primaryKey => $id));
			$this->request->data = $this->Meet->find('first', $options);
		}
		$seasons = $this->Meet->Season->find('list');
		$meetGroups = $this->Meet->MeetGroup->find('list');
		$this->set(compact('seasons', 'meetGroups'));
	}

	public function delete($code = null)
	{
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if (!$code) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		if (!$this->Meet->exists($code)) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		$this->Meet->set('code', $code);
		$ret = $this->Meet->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('大会 ' . $code . ' を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('大会の削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
	
	
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete__($id = null) {
		$this->Meet->id = $id;
		if (!$this->Meet->exists()) {
			throw new NotFoundException(__('Invalid meet'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Meet->delete()) {
			$this->Session->setFlash(__('The meet has been deleted.'));
		} else {
			$this->Session->setFlash(__('The meet could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
