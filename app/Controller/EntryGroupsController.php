<?php
App::uses('AppController', 'Controller');
/**
 * EntryGroups Controller
 *
 * @property EntryGroup $EntryGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EntryGroupsController extends AppController {

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
	public function add() {
		if ($this->request->is('post')) {
			$this->EntryGroup->create();
			if ($this->EntryGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The entry group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry group could not be saved. Please, try again.'));
			}
		}
		$meets = $this->EntryGroup->Meet->find('list');
		$this->set(compact('meets'));
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
				$this->Session->setFlash(__('The entry group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry group could not be saved. Please, try again.'));
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
			$this->Session->setFlash(__('The entry group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The entry group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
