<?php

App::uses('AppController', 'Controller');

/**
 * ParmVars Controller
 *
 * @property ParmVar $ParmVar
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ParmVarsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session',
		'Auth' => array(
			'authorize' => array('Controller'),
		),
	);
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ParmVar->recursive = 0;
		$this->set('parmVars', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ParmVar->exists($id)) {
			throw new NotFoundException(__('Invalid parm var'));
		}
		$options = array('conditions' => array('ParmVar.' . $this->ParmVar->primaryKey => $id));
		$this->set('parmVar', $this->ParmVar->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ParmVar->create();
			if ($this->ParmVar->save($this->request->data)) {
				$this->Session->setFlash(__('The parm var has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The parm var could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ParmVar->exists($id)) {
			throw new NotFoundException(__('Invalid parm var'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ParmVar->save($this->request->data)) {
				$this->Session->setFlash(__('The parm var has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The parm var could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ParmVar.' . $this->ParmVar->primaryKey => $id));
			$this->request->data = $this->ParmVar->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ParmVar->id = $id;
		if (!$this->ParmVar->exists()) {
			throw new NotFoundException(__('Invalid parm var'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ParmVar->delete()) {
			$this->Session->setFlash(__('The parm var has been deleted.'));
		} else {
			$this->Session->setFlash(__('The parm var could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
