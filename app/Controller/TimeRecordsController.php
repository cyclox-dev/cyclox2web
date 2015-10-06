<?php
App::uses('AppController', 'Controller');
/**
 * TimeRecords Controller
 *
 * @property TimeRecord $TimeRecord
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TimeRecordsController extends AppController {

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
		$this->TimeRecord->recursive = 0;
		$this->set('timeRecords', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TimeRecord->exists($id)) {
			throw new NotFoundException(__('Invalid time record'));
		}
		$options = array('conditions' => array('TimeRecord.' . $this->TimeRecord->primaryKey => $id));
		$this->set('timeRecord', $this->TimeRecord->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TimeRecord->create();
			if ($this->TimeRecord->save($this->request->data)) {
				$this->Session->setFlash(__('The time record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The time record could not be saved. Please, try again.'));
			}
		}
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
		if (!$this->TimeRecord->exists($id)) {
			throw new NotFoundException(__('Invalid time record'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TimeRecord->save($this->request->data)) {
				$this->Session->setFlash(__('The time record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The time record could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TimeRecord.' . $this->TimeRecord->primaryKey => $id));
			$this->request->data = $this->TimeRecord->find('first', $options);
		}
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
		$this->TimeRecord->id = $id;
		if (!$this->TimeRecord->exists()) {
			throw new NotFoundException(__('Invalid time record'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TimeRecord->delete()) {
			$this->Session->setFlash(__('The time record has been deleted.'));
		} else {
			$this->Session->setFlash(__('The time record could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
