<?php
App::uses('AppController', 'Controller');
/**
 * RacerResults Controller
 *
 * @property RacerResult $RacerResult
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacerResultsController extends AppController {

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
		$this->RacerResult->recursive = 0;
		$this->set('racerResults', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RacerResult->exists($id)) {
			throw new NotFoundException(__('Invalid racer result'));
		}
		$options = array('conditions' => array('RacerResult.' . $this->RacerResult->primaryKey => $id));
		$this->set('racerResult', $this->RacerResult->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RacerResult->create();
			if ($this->RacerResult->save($this->request->data)) {
				$this->Session->setFlash(__('The racer result has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The racer result could not be saved. Please, try again.'));
			}
		}
		$this->set(compact('entryRacers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->RacerResult->exists($id)) {
			throw new NotFoundException(__('Invalid racer result'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RacerResult->save($this->request->data)) {
				$this->Session->setFlash(__('The racer result has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The racer result could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RacerResult.' . $this->RacerResult->primaryKey => $id));
			$this->request->data = $this->RacerResult->find('first', $options);
		}
		$this->set(compact('entryRacers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->RacerResult->id = $id;
		if (!$this->RacerResult->exists()) {
			throw new NotFoundException(__('Invalid racer result'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RacerResult->delete()) {
			$this->Session->setFlash(__('The racer result has been deleted.'));
		} else {
			$this->Session->setFlash(__('The racer result could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
