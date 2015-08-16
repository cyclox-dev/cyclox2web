<?php
App::uses('AppController', 'Controller');
/**
 * PointSeriesRacers Controller
 *
 * @property PointSeriesRacer $PointSeriesRacer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PointSeriesRacersController extends AppController {

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
				$this->Session->setFlash(__('The point series racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The point series racer could not be saved. Please, try again.'));
			}
		}
		$pointSeries = $this->PointSeriesRacer->PointSeries->find('list');
		$racerResults = $this->PointSeriesRacer->RacerResult->find('list');
		$racers = $this->PointSeriesRacer->Racer->find('list');
		$this->set(compact('pointSeries', 'racerResults', 'racers'));
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
				$this->Session->setFlash(__('The point series racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The point series racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PointSeriesRacer.' . $this->PointSeriesRacer->primaryKey => $id));
			$this->request->data = $this->PointSeriesRacer->find('first', $options);
		}
		$pointSeries = $this->PointSeriesRacer->PointSeries->find('list');
		$racerResults = $this->PointSeriesRacer->RacerResult->find('list');
		$racers = $this->PointSeriesRacer->Racer->find('list');
		$this->set(compact('pointSeries', 'racerResults', 'racers'));
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
			$this->Session->setFlash(__('The point series racer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The point series racer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
