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
 * @param string $code
 * @return void
 */
	public function view($code = null) {
		if (!$this->CategoryGroup->exists($code)) {
			throw new NotFoundException(__('Invalid category group'));
		}
		$options = array('conditions' => array('CategoryGroup.' . $this->CategoryGroup->primaryKey => $code));
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
 * @param string $code
 * @return void
 */
	public function edit($code = null) {
		if (!$this->CategoryGroup->exists($code)) {
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
			$options = array('conditions' => array('CategoryGroup.' . $this->CategoryGroup->primaryKey => $code));
			$this->request->data = $this->CategoryGroup->find('first', $options);
		}
	}

	/**
	 * delete method
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $code カテゴリーグループコード
	 * @return void
	 */
	public function delete($code = null) 
	{
		$this->CategoryGroup->id = $code;
		if (!$this->CategoryGroup->exists()) {
			throw new NotFoundException(__('Invalid category group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CategoryGroup->logicalDelete()) {
			$this->Session->setFlash(__('カテゴリーグループ [ID:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('カテゴリーグループの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
