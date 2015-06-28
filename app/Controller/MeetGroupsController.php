<?php
App::uses('AppController', 'Controller');
/**
 * MeetGroups Controller
 *
 * @property MeetGroup $MeetGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MeetGroupsController extends AppController {

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
		$options = array('conditions' => array('MeetGroup.' . $this->MeetGroup->primaryKey => $id));
		$this->set('meetGroup', $this->MeetGroup->find('first', $options));
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
		if ($this->request->is('get')) throw new MethodNotAllowedException();
		if (!$code) throw new NotFoundException(__('Invalid meet'));
		
		$mg = $this->MeetGroup->findByCode($code);
		if (!$mg) throw new NotFoundException(__('Invalid meet'));
		
		$this->MeetGroup->set('code', $code);
		$ret = $this->MeetGroup->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('大会グループ [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('大会グループの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
