<?php
App::uses('AppController', 'Controller');
/**
 * RedLines Controller
 *
 * @property RedLine $RedLine
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class RedLinesController extends AppController {

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
		$this->RedLine->recursive = 0;
		$this->set('redLines', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RedLine->exists($id)) {
			throw new NotFoundException(__('Invalid red line'));
		}
		$options = array('conditions' => array('RedLine.' . $this->RedLine->primaryKey => $id));
		$this->set('redLine', $this->RedLine->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RedLine->create();
			if ($this->RedLine->save($this->request->data)) {
				$this->Flash->success(__('The red line has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The red line could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->RedLine->Season->find('list');
		$categories = $this->RedLine->Category->find('list');
		$this->set(compact('seasons', 'categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->RedLine->exists($id)) {
			throw new NotFoundException(__('Invalid red line'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RedLine->save($this->request->data)) {
				$this->Flash->success(__('The red line has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The red line could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RedLine.' . $this->RedLine->primaryKey => $id));
			$this->request->data = $this->RedLine->find('first', $options);
		}
		$seasons = $this->RedLine->Season->find('list');
		$categories = $this->RedLine->Category->find('list');
		$this->set(compact('seasons', 'categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->RedLine->id = $id;
		if (!$this->RedLine->exists()) {
			throw new NotFoundException(__('Invalid red line'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RedLine->delete()) {
			$this->Flash->success(__('The red line has been deleted.'));
		} else {
			$this->Flash->error(__('The red line could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
