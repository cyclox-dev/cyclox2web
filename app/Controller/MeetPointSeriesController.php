<?php
App::uses('AppController', 'Controller');
/**
 * MeetPointSeries Controller
 *
 * @property MeetPointSeries $MeetPointSeries
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MeetPointSeriesController extends AppController {

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
		$this->MeetPointSeries->recursive = 0;
		$this->set('meetPointSeries', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetPointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid meet point series'));
		}
		$options = array('conditions' => array('MeetPointSeries.' . $this->MeetPointSeries->primaryKey => $id));
		$this->set('meetPointSeries', $this->MeetPointSeries->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MeetPointSeries->create();
			if ($this->MeetPointSeries->save($this->request->data)) {
				$this->Session->setFlash(__('The meet point series has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet point series could not be saved. Please, try again.'));
			}
		}
		$pointSeries = $this->MeetPointSeries->PointSeries->find('list');
		$meets = $this->MeetPointSeries->Meet->find('list');
		$this->set(compact('pointSeries', 'meets'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MeetPointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid meet point series'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetPointSeries->save($this->request->data)) {
				$this->Session->setFlash(__('The meet point series has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet point series could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MeetPointSeries.' . $this->MeetPointSeries->primaryKey => $id));
			$this->request->data = $this->MeetPointSeries->find('first', $options);
		}
		$pointSeries = $this->MeetPointSeries->PointSeries->find('list');
		$meets = $this->MeetPointSeries->Meet->find('list');
		$this->set(compact('pointSeries', 'meets'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MeetPointSeries->id = $id;
		if (!$this->MeetPointSeries->exists()) {
			throw new NotFoundException(__('Invalid meet point series'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->MeetPointSeries->delete()) {
			$this->Session->setFlash(__('The meet point series has been deleted.'));
		} else {
			$this->Session->setFlash(__('The meet point series could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
