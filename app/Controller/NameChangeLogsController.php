<?php
App::uses('AppController', 'Controller');
/**
 * NameChangeLogs Controller
 *
 * @property NameChangeLog $NameChangeLog
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NameChangeLogsController extends AppController {

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
		$this->NameChangeLog->recursive = 0;
		$this->set('nameChangeLogs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->NameChangeLog->exists($id)) {
			throw new NotFoundException(__('Invalid name change log'));
		}
		$options = array('conditions' => array('NameChangeLog.' . $this->NameChangeLog->primaryKey => $id));
		$this->set('nameChangeLog', $this->NameChangeLog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->NameChangeLog->create();
			if ($this->NameChangeLog->save($this->request->data)) {
				$this->Session->setFlash(__('The name change log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The name change log could not be saved. Please, try again.'));
			}
		}
		$racers = $this->NameChangeLog->Racer->find('list');
		$this->set(compact('racers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->NameChangeLog->exists($id)) {
			throw new NotFoundException(__('Invalid name change log'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->NameChangeLog->save($this->request->data)) {
				$this->Session->setFlash(__('The name change log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The name change log could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('NameChangeLog.' . $this->NameChangeLog->primaryKey => $id));
			$this->request->data = $this->NameChangeLog->find('first', $options);
		}
		$racers = $this->NameChangeLog->Racer->find('list');
		$this->set(compact('racers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->NameChangeLog->id = $id;
		if (!$this->NameChangeLog->exists()) {
			throw new NotFoundException(__('Invalid name change log'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->NameChangeLog->delete()) {
			$this->Session->setFlash(__('The name change log has been deleted.'));
		} else {
			$this->Session->setFlash(__('The name change log could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
