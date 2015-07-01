<?php

App::uses('ApiBaseController', 'Controller');
App::uses('AjoccUtil', 'Cyclox/Util');

/**
 * Meets Controller
 *
 * @property Meet $Meet
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MeetsController extends ApiBaseController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Meet->recursive = 0;
		$this->set('meets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $code
 * @return void
 */
	public function view($code = null) 
	{
		if (!$this->Meet->exists($code)) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		$isApiCall = $this->_isApiCall();

		$options = array('conditions' => array('Meet.' . $this->Meet->primaryKey => $code));
		if ($isApiCall) {
			$options['recursive'] = -1;
		}
		
		$meet = $this->Meet->find('first', $options);
		if ($isApiCall) {
			$this->success($meet);
		} else {
			$this->set('meet', $meet);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add()
	{
		if ($this->request->is('post')) {
			$this->Meet->create();

			$meetGroupCode = $this->request->data['Meet']['meet_group_code'];
			$code = AjoccUtil::nextMeetCode($meetGroupCode);
			$this->request->data['Meet']['code'] = $code;

			if ($this->Meet->save($this->request->data)) {
				$this->Session->setFlash(__('新規大会 [code:' . $code . '] を保存しました。'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->Meet->Season->find('list');
		$meetGroups = $this->Meet->MeetGroup->find('list');
		$this->set(compact('seasons', 'meetGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $code
 * @return void
 */
	public function edit($code = null) {
		if (!$this->Meet->exists($code)) {
			throw new NotFoundException(__('Invalid meet'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Meet->save($this->request->data)) {
				$this->Session->setFlash(__('The meet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Meet.' . $this->Meet->primaryKey => $code));
			$this->request->data = $this->Meet->find('first', $options);
		}
		$seasons = $this->Meet->Season->find('list');
		$meetGroups = $this->Meet->MeetGroup->find('list');
		$this->set(compact('seasons', 'meetGroups'));
	}

	/**
	 * delete method.
	 * 削除日時の適用
	 * @param string $code 大会コード
	 * @return void
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 */
	public function delete($code = null)
	{
		$this->Meet->id = $code;
		if (!$this->Meet->exists()) {
			throw new NotFoundException(__('Invalid meet'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Meet->logicalDelete()) {
			$this->Session->setFlash(__('大会 [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('大会の削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
