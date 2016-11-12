<?php

App::uses('ApiBaseController', 'Controller');

/**
 * MeetGroups Controller
 *
 * @property MeetGroup $MeetGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MeetGroupsController extends ApiBaseController
{
	public $uses = array('MeetGroup', 'Meet');

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
		$this->MeetGroup->recursive = 0;
		$this->set('meetGroups', $this->Paginator->paginate());
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
			$options = array('conditions' => array('meet_group_code' => $id));
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
					$this->Session->setFlash(__('The meet group has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The meet group could not be saved. Please, try again.'));
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
				$this->Session->setFlash(__('The meet group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meet group could not be saved. Please, try again.'));
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
			$this->Session->setFlash(__('大会グループ [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('大会グループの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
