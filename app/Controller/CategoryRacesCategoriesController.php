<?php
App::uses('AppController', 'Controller');
/**
 * CategoryRacesCategories Controller
 *
 * @property CategoryRacesCategory $CategoryRacesCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoryRacesCategoriesController extends AppController {

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
		$this->CategoryRacesCategory->recursive = 0;
		$this->set('categoryRacesCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoryRacesCategory->exists($id)) {
			throw new NotFoundException(__('Invalid category races category'));
		}
		$options = array('conditions' => array('CategoryRacesCategory.' . $this->CategoryRacesCategory->primaryKey => $id));
		$this->set('categoryRacesCategory', $this->CategoryRacesCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoryRacesCategory->create();
			if ($this->CategoryRacesCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The category races category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category races category could not be saved. Please, try again.'));
			}
		}
		$racesCategories = $this->CategoryRacesCategory->RacesCategory->find('list');
		$categories = $this->CategoryRacesCategory->Category->find('list');
		$this->set(compact('racesCategories', 'categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CategoryRacesCategory->exists($id)) {
			throw new NotFoundException(__('Invalid category races category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoryRacesCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The category races category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category races category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoryRacesCategory.' . $this->CategoryRacesCategory->primaryKey => $id));
			$this->request->data = $this->CategoryRacesCategory->find('first', $options);
		}
		$racesCategories = $this->CategoryRacesCategory->RacesCategory->find('list');
		$categories = $this->CategoryRacesCategory->Category->find('list');
		$this->set(compact('racesCategories', 'categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CategoryRacesCategory->id = $id;
		if (!$this->CategoryRacesCategory->exists()) {
			throw new NotFoundException(__('Invalid category races category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CategoryRacesCategory->delete()) {
			$this->Session->setFlash(__('The category races category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The category races category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
