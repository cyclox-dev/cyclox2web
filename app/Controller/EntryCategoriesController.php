<?php
App::uses('AppController', 'Controller');
/**
 * EntryCategories Controller
 *
 * @property EntryCategory $EntryCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EntryCategoriesController extends AppController {

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
		$this->EntryCategory->recursive = 0;
		$this->set('entryCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->EntryCategory->exists($id)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$options = array('conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $id));
		$this->set('entryCategory', $this->EntryCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EntryCategory->create();
			if ($this->EntryCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The entry category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry category could not be saved. Please, try again.'));
			}
		}
		$entryGroups = $this->EntryCategory->EntryGroup->find('list');
		$racesCategories = $this->EntryCategory->RacesCategory->find('list');
		$this->set(compact('entryGroups', 'racesCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->EntryCategory->exists($id)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EntryCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The entry category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $id));
			$this->request->data = $this->EntryCategory->find('first', $options);
		}
		$entryGroups = $this->EntryCategory->EntryGroup->find('list');
		$racesCategories = $this->EntryCategory->RacesCategory->find('list');
		$this->set(compact('entryGroups', 'racesCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->EntryCategory->id = $id;
		if (!$this->EntryCategory->exists()) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EntryCategory->delete()) {
			$this->Session->setFlash(__('The entry category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The entry category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
