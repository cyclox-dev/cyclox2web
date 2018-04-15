<?php

App::uses('ApiBaseController', 'Controller');

/**
 * MeetGroups Controller
 *
 * @property MeetGroup $MeetGroup
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class MeetGroupsController extends ApiBaseController
{
	public $uses = array('MeetGroup', 'Meet');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Flash', 'RequestHandler');
	// 大会グループ自体が少ないので paginator は一旦無しに。@20180304

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->MeetGroup->recursive = 0;
		$this->set('meetGroups', $this->MeetGroup->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetGroup->exists($id)) {
			throw new NotFoundException(__('Invalid meet group'));
		}
		
		$isApiCall = $this->_isApiCall();
		
		$options = array('conditions' => array('MeetGroup.' . $this->MeetGroup->primaryKey => $id));
		$options['recursive'] = -1;
		$meetGroup = $this->MeetGroup->find('first', $options);
		if ($isApiCall) {
			$this->success($meetGroup);
		} else {
			$this->Meet->Behaviors->load('Utils.SoftDelete');
			$options = array(
				'conditions' => array('meet_group_code' => $id),
				'recursive' => -1,
				'order' => array('at_date' => 'DESC'),
			);
			$meets = $this->Meet->find('all', $options);
			
			$meetGroup['meets'] = $meets;
			//$this->log('Meet:', LOG_DEBUG);
			//$this->log($meets, LOG_DEBUG);
			$this->set('meetGroup', $meetGroup);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is(array('post', 'put'))) {
			if (isset($this->request->data['MeetGroup']['code'])
					&& $this->MeetGroup->exists($this->request->data['MeetGroup']['code'])) {
				$this->MeetGroup->validator()->invalidate("code", "その大会グループコードはすでに使用されています。");
			} else {
				$this->MeetGroup->create();
				$ret = $this->MeetGroup->save($this->request->data);
				if (is_array($ret)) {
					$this->Flash->set(__('The meet group has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->set(__('The meet group could not be saved. Please, try again.'));
				}
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
		if (!$this->MeetGroup->exists($id)) {
			throw new NotFoundException(__('Invalid meet group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->MeetGroup->id = $id; // id 指定で update にする
			if ($this->MeetGroup->save($this->request->data)) {
				$this->Flash->set(__('The meet group has been saved.'));
				return $this->redirect('/meet_groups/view/' . $id);
			} else {
				$this->Flash->set(__('The meet group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MeetGroup.' . $this->MeetGroup->primaryKey => $id));
			$this->request->data = $this->MeetGroup->find('first', $options);
		}
	}

	/**
	 * delete method.
	 * 削除日時の適用
	 * @param string $code 大会グループコード
	 * @return void
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 */
	public function delete($code = null) {
		$this->MeetGroup->id = $code;
		if (!$this->MeetGroup->exists()) {
			throw new NotFoundException(__('Invalid meet group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->MeetGroup->delete()) {
			$this->Flash->set(__('大会グループ [code:' . $code . '] を削除しました（削除ステータスを設定）。'));
		} else {
			$this->Flash->set(__('大会グループの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
