<?php
App::uses('AppController', 'Controller');
/**
 * CategoryGroups Controller
 *
 * @property CategoryGroup $CategoryGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoryGroupsController extends AppController {

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
		$this->CategoryGroup->recursive = 0;
		$this->set('categoryGroups', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoryGroup->exists($id)) {
			throw new NotFoundException(__('Invalid category group'));
		}
		$options = array('conditions' => array('CategoryGroup.' . $this->CategoryGroup->primaryKey => $id));
		$this->set('categoryGroup', $this->CategoryGroup->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoryGroup->create();
			if ($this->CategoryGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The category group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category group could not be saved. Please, try again.'));
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
		if (!$this->CategoryGroup->exists($id)) {
			throw new NotFoundException(__('Invalid category group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoryGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The category group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoryGroup.' . $this->CategoryGroup->primaryKey => $id));
			$this->request->data = $this->CategoryGroup->find('first', $options);
		}
	}

	/**
	 * delete method
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $id カテゴリーグループコード
	 * @return void
	 */
	public function delete($id = null) 
	{
		if ($this->request->is('get')) throw new MethodNotAllowedException();
		
		$this->CategoryGroup->id = $id;
		if (!$this->CategoryGroup->exists()) throw new NotFoundException(__('Invalid category group'));
		
		$ret = $this->CategoryGroup->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('カテゴリーグループ [ID:' . $id . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('カテゴリーグループの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
