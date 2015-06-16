<?php
App::uses('AppController', 'Controller');
/**
 * CategoryRacers Controller
 *
 * @property CategoryRacer $CategoryRacer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoryRacersController extends AppController {

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
		$this->CategoryRacer->recursive = 0;
		$this->set('categoryRacers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
		$this->set('categoryRacer', $this->CategoryRacer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoryRacer->create();
			if ($this->CategoryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The category racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category racer could not be saved. Please, try again.'));
			}
		}
		$categories = $this->CategoryRacer->Category->find('list');
		$racers = $this->CategoryRacer->Racer->find('list');
		$this->set(compact('categories', 'racers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The category racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
			$this->request->data = $this->CategoryRacer->find('first', $options);
		}
		$categories = $this->CategoryRacer->Category->find('list');
		$racers = $this->CategoryRacer->Racer->find('list');
		$this->set(compact('categories', 'racers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CategoryRacer->id = $id;
		if (!$this->CategoryRacer->exists()) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CategoryRacer->delete()) {
			$this->Session->setFlash(__('The category racer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The category racer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
