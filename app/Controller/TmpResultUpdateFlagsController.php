<?php
App::uses('AppController', 'Controller');
/**
 * TmpResultUpdateFlags Controller
 *
 * @property TmpResultUpdateFlag $TmpResultUpdateFlag
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class TmpResultUpdateFlagsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TmpResultUpdateFlag->recursive = 0;
		$this->set('tmpResultUpdateFlags', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TmpResultUpdateFlag->exists($id)) {
			throw new NotFoundException(__('Invalid tmp result update flag'));
		}
		$options = array('conditions' => array('TmpResultUpdateFlag.' . $this->TmpResultUpdateFlag->primaryKey => $id));
		$this->set('tmpResultUpdateFlag', $this->TmpResultUpdateFlag->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TmpResultUpdateFlag->create();
			if ($this->TmpResultUpdateFlag->save($this->request->data)) {
				$this->Flash->success(__('The tmp result update flag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tmp result update flag could not be saved. Please, try again.'));
			}
		}
		$entryCategories = $this->TmpResultUpdateFlag->EntryCategory->find('list');
		$this->set(compact('entryCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TmpResultUpdateFlag->exists($id)) {
			throw new NotFoundException(__('Invalid tmp result update flag'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TmpResultUpdateFlag->save($this->request->data)) {
				$this->Flash->success(__('The tmp result update flag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tmp result update flag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TmpResultUpdateFlag.' . $this->TmpResultUpdateFlag->primaryKey => $id));
			$this->request->data = $this->TmpResultUpdateFlag->find('first', $options);
		}
		$entryCategories = $this->TmpResultUpdateFlag->EntryCategory->find('list');
		$this->set(compact('entryCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TmpResultUpdateFlag->id = $id;
		if (!$this->TmpResultUpdateFlag->exists()) {
			throw new NotFoundException(__('Invalid tmp result update flag'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TmpResultUpdateFlag->delete()) {
			$this->Flash->success(__('The tmp result update flag has been deleted.'));
		} else {
			$this->Flash->error(__('The tmp result update flag could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
