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
		if ($this->request->is(array('post', 'put'))) { // primary key が設定されている場合には put となる。
			// TODO: 存在チェック？
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
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MeetGroup->id = $id;
		if (!$this->MeetGroup->exists()) {
			throw new NotFoundException(__('Invalid meet group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->MeetGroup->delete()) {
			$this->Session->setFlash(__('The meet group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The meet group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
