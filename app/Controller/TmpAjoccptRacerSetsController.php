<?php
App::uses('AppController', 'Controller');
/**
 * TmpAjoccptRacerSets Controller
 *
 * @property TmpAjoccptRacerSet $TmpAjoccptRacerSet
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class TmpAjoccptRacerSetsController extends AppController {

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
		$this->TmpAjoccptRacerSet->recursive = 0;
		$this->set('tmpAjoccptRacerSets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TmpAjoccptRacerSet->exists($id)) {
			throw new NotFoundException(__('Invalid tmp ajoccpt racer set'));
		}
		$options = array('conditions' => array('TmpAjoccptRacerSet.' . $this->TmpAjoccptRacerSet->primaryKey => $id));
		$this->set('tmpAjoccptRacerSet', $this->TmpAjoccptRacerSet->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TmpAjoccptRacerSet->create();
			if ($this->TmpAjoccptRacerSet->save($this->request->data)) {
				$this->Flash->set(__('The tmp ajoccpt racer set has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The tmp ajoccpt racer set could not be saved. Please, try again.'));
			}
		}
		$ajoccptLocalSettings = $this->TmpAjoccptRacerSet->AjoccptLocalSetting->find('list');
		$seasons = $this->TmpAjoccptRacerSet->Season->find('list');
		$categories = $this->TmpAjoccptRacerSet->Category->find('list');
		$this->set(compact('ajoccptLocalSettings', 'seasons', 'categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TmpAjoccptRacerSet->exists($id)) {
			throw new NotFoundException(__('Invalid tmp ajoccpt racer set'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TmpAjoccptRacerSet->save($this->request->data)) {
				$this->Flash->set(__('The tmp ajoccpt racer set has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The tmp ajoccpt racer set could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TmpAjoccptRacerSet.' . $this->TmpAjoccptRacerSet->primaryKey => $id));
			$this->request->data = $this->TmpAjoccptRacerSet->find('first', $options);
		}
		$ajoccptLocalSettings = $this->TmpAjoccptRacerSet->AjoccptLocalSetting->find('list');
		$seasons = $this->TmpAjoccptRacerSet->Season->find('list');
		$categories = $this->TmpAjoccptRacerSet->Category->find('list');
		$this->set(compact('ajoccptLocalSettings', 'seasons', 'categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TmpAjoccptRacerSet->id = $id;
		if (!$this->TmpAjoccptRacerSet->exists()) {
			throw new NotFoundException(__('Invalid tmp ajoccpt racer set'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TmpAjoccptRacerSet->delete()) {
			$this->Flash->set(__('The tmp ajoccpt racer set has been deleted.'));
		} else {
			$this->Flash->set(__('The tmp ajoccpt racer set could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
