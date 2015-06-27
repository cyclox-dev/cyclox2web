<?php

App::uses('ApiBaseController', 'Controller');
App::uses('AjoccUtil', 'Cyclox/Util');

/**
 * Racers Controller
 *
 * @property Racer $Racer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacersController extends ApiBaseController
{

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
		$this->Racer->recursive = 0;
		$this->set('racers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Racer->exists($id)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $id));
		$this->set('racer', $this->Racer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() 
	{
		if ($this->_isApiCall()) {
			return $this->__addOnApi();
		} else {
			return $this->__addOnPage();
		}
	}
	
	/**
	 * 管理画面上での add 処理
	 * @return void
	 */
	private function __addOnPage()
	{
		if ($this->request->is(array('post', 'put'))) {
			$this->Racer->create();
			$code = AjoccUtil::nextRacerCode();
			$this->request->data['Racer']['code'] = $code;
			
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('新規選手 [code:' . $code . '] を保存しました。'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The racer could not be saved. Please, try again.'));
			}
		}
	}
	
	/**
	 * API 上での add 処理
	 * @return void
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			$this->log($this->request->data, LOG_DEBUG);
			$this->Racer->create();
			
			if (!isset($this->request->data['Racer']['code']))
			{
				return $this->error('選手コードがありません (Racer.code)', self::STATUS_CODE_BAD_REQUEST);
			}
			
			$code = $this->request->data['Racer']['code'];
			if ($this->Racer->exists($code)) {
				return $this->error('すでにその選手コードは使われています。', self::STATUS_CODE_BAD_REQUEST);
			}
			
			if ($this->Racer->save($this->request->data)) {
				return $this->success(array());
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $code
	 * @return void
	 */
	public function edit($code = null)
	{
		if ($this->_isApiCall()) {
			return $this->__editOnApi($code);
		} else {
			return $this->__editOnPage($code);
		}
	}
	
	/**
	 * 管理画面上での edit 処理
	 * @return void
	 */
	private function __editOnPage($code = null)
	{
		if (!$this->Racer->exists($code)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('The racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $code));
			$this->request->data = $this->Racer->find('first', $options);
		}
	}
	
	/**
	 * API 上での edit 処理
	 * @return void
	 */
	private function __editOnApi($code = null)
	{
		if (!$this->Racer->exists($code)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		
		$this->log($this->request->data);
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Racer->save($this->request->data)) {
				return $this->success(array());
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
	}

	/**
	 * delete method
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $code 選手コード
	 * @return void
	 */
	public function delete($code = null)
	{
		if ($this->request->is('get')) throw new MethodNotAllowedException();
		if (!$code) throw new NotFoundException(__('Invalid meet'));
		
		$rc = $this->Racer->findByCode($code);
		if (!$rc) throw new NotFoundException(__('Invalid meet'));
		
		$this->Meet->set('code', $code);
		$ret = $this->Racer->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('選手 [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('選手の削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
