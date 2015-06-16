<?php
App::uses('AppController', 'Controller');
/**
 * Racers Controller
 *
 * @property Racer $Racer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacersController extends AppController {

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
		$this->Racer->recursive = 0;
		$this->set('racers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Racer->exists($id)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $id));
		$this->set('racer', $this->Racer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is(array('post', 'put'))) {
			$this->Racer->create();
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('The racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The racer could not be saved. Please, try again.'));
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
		$this->Racer->validator()->remove('code', 'isPKUnique');
		if (!$this->Racer->exists($id)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('The racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $id));
			$this->request->data = $this->Racer->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Racer->id = $id;
		if (!$this->Racer->exists()) {
			throw new NotFoundException(__('Invalid racer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Racer->delete()) {
			$this->Session->setFlash(__('The racer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The racer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
