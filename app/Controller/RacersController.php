<?php

App::uses('AppController', 'Controller');
App::uses('AjoccUtil', 'Cyclox/Util');

/**
 * Racers Controller
 *
 * @property Racer $Racer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacersController extends AppController {

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
	public function add() {
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
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Racer->validator()->remove('code', 'isPKUnique');
		if (!$this->Racer->exists($id)) {
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
			$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $id));
			$this->request->data = $this->Racer->find('first', $options);
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
