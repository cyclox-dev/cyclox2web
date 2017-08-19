<?php

App::uses('ApiBaseController', 'Controller');

/**
 * Seasons Controller
 *
 * @property Season $Season
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class SeasonsController extends ApiBaseController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'RequestHandler');

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
		
		$isApiCall = $this->_isApiCall();
		
		$options = array('conditions' => array('Season.' . $this->Season->primaryKey => $id));
		if ($isApiCall) {
			$options['recursive'] = -1;
		}
		
		$season = $this->Season->find('first', $options);
		if ($isApiCall) {
			$this->success($season);
		} else {
			$this->set('season', $season);
		}
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
				$this->Flash->set(__('The season has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The season could not be saved. Please, try again.'));
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
				$this->Flash->set(__('The season has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The season could not be saved. Please, try again.'));
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
		$this->MeetGroup->id = $id;
		if (!$this->MeetGroup->exists()) {
			throw new NotFoundException(__('Invalid meet group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->MeetGroup->delete()) {
			$this->Flash->set(__('シーズン [ID:' . $id . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Flash->set(__('シーズンの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
