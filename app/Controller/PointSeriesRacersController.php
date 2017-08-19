<?php
App::uses('AppController', 'Controller');
/**
 * PointSeriesRacers Controller
 *
 * @property PointSeriesRacer $PointSeriesRacer
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class PointSeriesRacersController extends AppController {

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
		$this->PointSeriesRacer->recursive = 0;
		$this->set('pointSeriesRacers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PointSeriesRacer->exists($id)) {
			throw new NotFoundException(__('Invalid point series racer'));
		}
		$options = array('conditions' => array('PointSeriesRacer.' . $this->PointSeriesRacer->primaryKey => $id));
		$this->set('pointSeriesRacer', $this->PointSeriesRacer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PointSeriesRacer->create();
			if ($this->PointSeriesRacer->save($this->request->data)) {
				$this->Flash->set(__('The point series racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The point series racer could not be saved. Please, try again.'));
			}
		}
		$pointSeries = $this->PointSeriesRacer->PointSeries->find('list');
		$meetPointSeries = $this->PointSeriesRacer->MeetPointSeries->find('list');
		$this->set(compact('pointSeries', 'meetPointSeries'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PointSeriesRacer->exists($id)) {
			throw new NotFoundException(__('Invalid point series racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PointSeriesRacer->save($this->request->data)) {
				$this->Flash->set(__('The point series racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The point series racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PointSeriesRacer.' . $this->PointSeriesRacer->primaryKey => $id));
			$this->request->data = $this->PointSeriesRacer->find('first', $options);
		}
		$pointSeries = $this->PointSeriesRacer->PointSeries->find('list');
		$meetPointSeries = $this->PointSeriesRacer->MeetPointSeries->find('list');
		$this->set(compact('pointSeries', 'meetPointSeries'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PointSeriesRacer->id = $id;
		if (!$this->PointSeriesRacer->exists()) {
			throw new NotFoundException(__('Invalid point series racer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PointSeriesRacer->delete()) {
			$this->Flash->set(__('The point series racer has been deleted.'));
		} else {
			$this->Flash->set(__('The point series racer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
