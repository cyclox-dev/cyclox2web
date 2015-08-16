<?php
App::uses('AppController', 'Controller');
/**
 * PointSeries Controller
 *
 * @property PointSeries $PointSeries
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PointSeriesController extends AppController {

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
		$this->PointSeries->recursive = 0;
		$this->set('pointSeries', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid point series'));
		}
		$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $id));
		$this->set('pointSeries', $this->PointSeries->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PointSeries->create();
			if ($this->PointSeries->save($this->request->data)) {
				$this->Session->setFlash(__('The point series has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The point series could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->PointSeries->Season->find('list');
		$this->set(compact('seasons'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid point series'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PointSeries->save($this->request->data)) {
				$this->Session->setFlash(__('The point series has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The point series could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PointSeries.' . $this->PointSeries->primaryKey => $id));
			$this->request->data = $this->PointSeries->find('first', $options);
		}
		$seasons = $this->PointSeries->Season->find('list');
		$this->set(compact('seasons'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PointSeries->id = $id;
		if (!$this->PointSeries->exists()) {
			throw new NotFoundException(__('Invalid point series'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PointSeries->delete()) {
			$this->Session->setFlash(__('The point series has been deleted.'));
		} else {
			$this->Session->setFlash(__('The point series could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
