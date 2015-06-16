<?php
App::uses('AppController', 'Controller');
/**
 * RacesCategories Controller
 *
 * @property RacesCategory $RacesCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacesCategoriesController extends AppController {

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
		$this->RacesCategory->recursive = 0;
		$this->set('racesCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RacesCategory->exists($id)) {
			throw new NotFoundException(__('Invalid races category'));
		}
		$options = array('conditions' => array('RacesCategory.' . $this->RacesCategory->primaryKey => $id));
		$this->set('racesCategory', $this->RacesCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is(array('post', 'put'))) {
			$this->RacesCategory->create();
			if ($this->RacesCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The races category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The races category could not be saved. Please, try again.'));
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
		$this->RacesCategory->validator()->remove('code', 'isPKUnique');
		if (!$this->RacesCategory->exists($id)) {
			throw new NotFoundException(__('Invalid races category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RacesCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The races category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The races category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RacesCategory.' . $this->RacesCategory->primaryKey => $id));
			$this->request->data = $this->RacesCategory->find('first', $options);
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
		$this->RacesCategory->id = $id;
		if (!$this->RacesCategory->exists()) {
			throw new NotFoundException(__('Invalid races category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RacesCategory->delete()) {
			$this->Session->setFlash(__('The races category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The races category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
