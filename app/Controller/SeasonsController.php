<?php
App::uses('AppController', 'Controller');
/**
 * Seasons Controller
 *
 * @property Season $Season
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SeasonsController extends AppController {

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
		$this->Season->recursive = 0;
		$this->set('seasons', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Season->exists($id)) {
			throw new NotFoundException(__('Invalid season'));
		}
		$options = array('conditions' => array('Season.' . $this->Season->primaryKey => $id));
		$this->set('season', $this->Season->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Season->create();
			if ($this->Season->save($this->request->data)) {
				$this->Session->setFlash(__('The season has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The season could not be saved. Please, try again.'));
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
		if (!$this->Season->exists($id)) {
			throw new NotFoundException(__('Invalid season'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Season->save($this->request->data)) {
				$this->Session->setFlash(__('The season has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The season could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Season.' . $this->Season->primaryKey => $id));
			$this->request->data = $this->Season->find('first', $options);
		}
	}

	/**
	 * delete method.
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $id シーズン ID
	 * @return void
	 */
	public function delete($id = null) 
	{
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		$this->Season->id = $id;
		if (!$this->Season->exists()) {
			throw new NotFoundException(__('Invalid season'));
		}
		
		$ret = $this->Season->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('シーズン [ID:' . $id . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('シーズンの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
