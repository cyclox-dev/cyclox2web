<?php

App::uses('ApiBaseController', 'Controller');
App::uses('AjoccUtil', 'Cyclox/Util');
App::uses('CategoryReason', 'Cyclox/Const');

/**
 * Meets Controller
 *
 * @property Meet $Meet
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class MeetsController extends ApiBaseController
{
	public $uses = array('Meet', 'CategoryRacer', 'EntryCategory');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Flash', 'RequestHandler');

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
		//$this->log($meet, LOG_DEBUG);
		
		if (!$isApiCall) {
			foreach ($meet['EntryGroup'] as &$eg) { // 参照渡しで書き換え
				// 距離設定がない場合は大会設定を利用
				$this->log('sf:' . $eg['start_frac_distance'] . ' lap:' . $eg['lap_distance'], LOG_DEBUG);
				if (is_null($eg['start_frac_distance'])) {
					$eg['start_frac_distance'] = $meet['Meet']['start_frac_distance'];
				}
				if (is_null($eg['lap_distance'])) {
					$eg['lap_distance'] = $meet['Meet']['lap_distance'];
				}
			}
			unset($eg);
		}
		if ($isApiCall) {
			$this->success($meet);
		} else {
			$entryCategoryList = array();
			// 出走カテゴリーも取得
			foreach ($meet['EntryGroup'] as $eg) {
				$egID = $eg['id'];
				$conditions = array('entry_group_id' => $egID);
				$ecats = $this->EntryCategory->find('all', array('conditions' => $conditions, 'recursive' => -1));
				foreach ($ecats as $ecat) {
					$entryCategoryList[] = $ecat['EntryCategory'];
				}
			}
			//$this->log('$entryCategoryList is', LOG_DEBUG);
			//$this->log($entryCategoryList, LOG_DEBUG);
			
			$meet['EntryCategory'] = $entryCategoryList;
			$this->set('meet', $meet);
			
			// 昇格者データを取得
			$rankUps = $this->__rankUps($code);
			$this->set('results', $rankUps);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add($mgCode = null)
	{
		if ($this->request->is('post')) {
			$this->Meet->create();

			$meetGroupCode = $this->request->data['Meet']['meet_group_code'];
			$code = AjoccUtil::nextMeetCode($meetGroupCode);
			$this->request->data['Meet']['code'] = $code;

			if ($this->Meet->save($this->request->data)) {
				$this->Flash->set(__('新規大会 [code:' . $code . '] を保存しました。'));
				return $this->redirect('/meets/view/' . $this->Meet->id);
			} else {
				$this->Flash->set(__('The meet could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->Meet->Season->find('list');
		$meetGroups = $this->Meet->MeetGroup->find('list');
		$this->set(compact('seasons', 'meetGroups'));
		
		if (!is_null($mgCode)) {
			$this->set('meetGroupCode', $mgCode);
			$this->request->data['Meet']['meet_group_code'] = $mgCode;
		}
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
				$this->Flash->set(__('The meet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The meet could not be saved. Please, try again.'));
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
		if ($this->Meet->delete()) {
			$this->Flash->set(__('大会 [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Flash->set(__('大会の削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
	
	/**
	 * 昇格者データをかえす
	 * @param string $meetCode 大会コード
	 * @return 昇格者データ
	 */
	private function __rankUps($meetCode)
	{
		if (empty($meetCode)) {
			return null;
		}
		
		/*
		$opt = array(
			'conditions' => array('EntryGroup.meet_code' => $meetCode),
			'fields' => 'EntryCategory.id',
			'joins' => array(
				array(
					'type' => 'INNER',
					'table' => 'entry_groups',
					'alias' => 'EntryGroup',
					'conditions' => array('EntryCategory.entry_group_id = EntryGroup.id'),
				)
			),
			'recursive' => -1
		);
		$cats = $this->EntryCategory->find('all', $opt);
		 //*/
		
		$conditions = array('meet_code' => $meetCode, 'reason_id' => CategoryReason::$RESULT_UP->ID());
		$rankUps = $this->CategoryRacer->find('all', array('conditions' => $conditions));
		//$this->log($rankUps, LOG_DEBUG);
		return $rankUps;
	}
}
