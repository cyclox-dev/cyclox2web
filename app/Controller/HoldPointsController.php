<?php
App::uses('AppController', 'Controller');
/**
 * HoldPoints Controller
 *
 * @property HoldPoint $HoldPoint
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class HoldPointsController extends AppController {

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
		$this->HoldPoint->recursive = 0;
		$this->set('holdPoints', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->HoldPoint->exists($id)) {
			throw new NotFoundException(__('Invalid hold point'));
		}
		$options = array('conditions' => array('HoldPoint.' . $this->HoldPoint->primaryKey => $id));
		$this->set('holdPoint', $this->HoldPoint->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->HoldPoint->create();
			if ($this->HoldPoint->save($this->request->data)) {
				$this->Session->setFlash(__('The hold point has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hold point could not be saved. Please, try again.'));
			}
		}
		$racerResults = $this->HoldPoint->RacerResult->find('list');
		$this->set(compact('racerResults'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->HoldPoint->exists($id)) {
			throw new NotFoundException(__('Invalid hold point'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->HoldPoint->save($this->request->data)) {
				$this->Session->setFlash(__('The hold point has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hold point could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('HoldPoint.' . $this->HoldPoint->primaryKey => $id));
			$this->request->data = $this->HoldPoint->find('first', $options);
		}
		$racerResults = $this->HoldPoint->RacerResult->find('list');
		$this->set(compact('racerResults'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->HoldPoint->id = $id;
		if (!$this->HoldPoint->exists()) {
			throw new NotFoundException(__('Invalid hold point'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->HoldPoint->delete()) {
			$this->Session->setFlash(__('The hold point has been deleted.'));
		} else {
			$this->Session->setFlash(__('The hold point could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
