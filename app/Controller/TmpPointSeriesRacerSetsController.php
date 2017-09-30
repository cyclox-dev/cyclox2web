<?php
App::uses('AppController', 'Controller');
/**
 * TmpPointSeriesRacerSet Controller
 *
 * @property TmpPointSeriesRacerSet $TmpPointSeriesRacerSet
 * @property PaginatorComponent $Paginator
 */
class TmpPointSeriesRacerSetsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TmpPointSeriesRacerSet->recursive = 0;
		$this->set('tmpPointSeriesRacerSets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TmpPointSeriesRacerSet->exists($id)) {
			throw new NotFoundException(__('Invalid tmp point series racer set'));
		}
		$options = array('conditions' => array('TmpPointSeriesRacerSet.' . $this->TmpPointSeriesRacerSet->primaryKey => $id));
		$this->set('tmpPointSeriesRacerSet', $this->TmpPointSeriesRacerSet->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TmpPointSeriesRacerSet->create();
			if ($this->TmpPointSeriesRacerSet->save($this->request->data)) {
				$this->Flash->set(__('The tmp point series racer set has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
		}
		$pointSeries = $this->TmpPointSeriesRacerSet->PointSeries->find('list');
		$racers = $this->TmpPointSeriesRacerSet->Racer->find('list');
		$this->set(compact('pointSeries', 'racers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TmpPointSeriesRacerSet->exists($id)) {
			throw new NotFoundException(__('Invalid tmp point series racer set'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TmpPointSeriesRacerSet->save($this->request->data)) {
				$this->Flash->set(__('The tmp point series racer set has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('TmpPointSeriesRacerSet.' . $this->TmpPointSeriesRacerSet->primaryKey => $id));
			$this->request->data = $this->TmpPointSeriesRacerSet->find('first', $options);
		}
		$pointSeries = $this->TmpPointSeriesRacerSet->PointSeries->find('list');
		$racers = $this->TmpPointSeriesRacerSet->Racer->find('list');
		$this->set(compact('pointSeries', 'racers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TmpPointSeriesRacerSet->id = $id;
		if (!$this->TmpPointSeriesRacerSet->exists()) {
			throw new NotFoundException(__('Invalid tmp point series racer set'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TmpPointSeriesRacerSet->delete()) {
			$this->Flash->set(__('The tmp point series racer set has been deleted.'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Flash->set(__('The tmp point series racer set could not be deleted. Please, try again.'));
			return $this->redirect(array('action' => 'index'));
		}
	}
}
