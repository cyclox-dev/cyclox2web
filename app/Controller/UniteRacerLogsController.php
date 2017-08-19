<?php
App::uses('AppController', 'Controller');
/**
 * UniteRacerLogs Controller
 *
 * @property UniteRacerLog $UniteRacerLog
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class UniteRacerLogsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->UniteRacerLog->recursive = 0;
		$this->set('uniteRacerLogs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->UniteRacerLog->exists($id)) {
			throw new NotFoundException(__('Invalid unite racer log'));
		}
		$options = array('conditions' => array('UniteRacerLog.' . $this->UniteRacerLog->primaryKey => $id));
		$this->set('uniteRacerLog', $this->UniteRacerLog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->UniteRacerLog->create();
			if ($this->UniteRacerLog->save($this->request->data)) {
				$this->Flash->set(__('The unite racer log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The unite racer log could not be saved. Please, try again.'));
			}
		}
		//$racers = $this->UniteRacerLog->Racer->find('list');
		//$this->set(compact('racers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->UniteRacerLog->exists($id)) {
			throw new NotFoundException(__('Invalid unite racer log'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->UniteRacerLog->save($this->request->data)) {
				$this->Flash->set(__('The unite racer log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The unite racer log could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('UniteRacerLog.' . $this->UniteRacerLog->primaryKey => $id));
			$this->request->data = $this->UniteRacerLog->find('first', $options);
		}
		//$racers = $this->UniteRacerLog->Racer->find('list');
		//$this->set(compact('racers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->UniteRacerLog->id = $id;
		if (!$this->UniteRacerLog->exists()) {
			throw new NotFoundException(__('Invalid unite racer log'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->UniteRacerLog->delete()) {
			$this->Flash->set(__('The unite racer log has been deleted.'));
		} else {
			$this->Flash->set(__('The unite racer log could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
