<?php

/*
 *  created at 2015/06/13 by shun
 */

/**
 * Meet コントローラー
 *
 * @author shun
 */
class MeetsController extends AppController
{
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	public function index() {
		$this->set('meets', $this->Meet->find('all', array('conditions' => array('Meet.deleted' => null))));
	}
	
	public function view($code = null)
	{
		if (!$code) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		$meet = $this->Meet->findByCode($code);
		if (!$meet) {
			throw new NotFoundException(__('Invalid meet'));
		}
		$this->set('meet', $meet);
	}
	
	public function add()
	{
		if ($this->request->is('post')) {
			$this->Meet->create();
			$this->request->data['Meet']['code'] = 'YAM-123-002';
			$this->request->data['Meet']['meet_group_code'] = 'YAM';
			$this->request->data['Meet']['season_id'] = 4;
			debug($this->request->data);
			if ($this->Meet->save($this->request->data)) {
				$this->Session->setFlash(__('新規大会' . $this->request->data['Meet']['code'] . 'を登録しました。'));
                return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFash(__('failed'));
		}
	}
	
	public function edit($code = null)
	{
		if (!$code) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		$meet = $this->Meet->findByCode($code);
		if (!$meet) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		if ($this->request->is(array('post', 'put'))) {
			//$this->Meet->code = $code;
			$this->Meet->set('code', $code);
			
			// primary key でなく、not null であるパラメタを埋める。
			$this->request->data['Meet']['meet_group_code'] = $meet['Meet']['meet_group_code'];
			$this->request->data['Meet']['season_id'] = $meet['Meet']['season_id'];
			debug($this->request->data);
			
			$ret = $this->Meet->save($this->request->data); // ->data が不正確な場合は true がかえる...
			if (is_array($ret)) {
				$this->Session->setFlash(__('大会 ' . $code . ' の変更を保存しました。'));
				return;//return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('大会情報の変更保存に失敗しました。'));
		}

		if (!$this->request->data) {
			$this->request->data = $meet;
		}
	}
	
	public function delete($code = null)
	{
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if (!$code) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		$meet = $this->Meet->findByCode($code);
		if (!$meet) {
			throw new NotFoundException(__('Invalid meet'));
		}
		
		$this->Meet->set('code', $code);
		
		$ret = $this->Meet->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('大会 ' . $code . ' を削除しました。'));
		} else {
			$this->Session->setFlash(__('大会の削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
