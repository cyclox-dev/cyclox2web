<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoriesController extends AppController {

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
		$this->Category->recursive = 0;
		$this->set('categories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $code
 * @return void
 */
	public function view($code = null) {
		if (!$this->Category->exists($code)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $code));
		$this->set('category', $this->Category->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//$this->Category->validator()->add('code', 'codeUnique', array('rule' => 'isUnique', 'message' => 'bad code'));
		if ($this->request->is(array('post', 'put'))) {
			if (isset($this->request->data['Category']['code'])
					&& $this->Category->exists($this->request->data['Category']['code'])) {
				$this->Category->validator()->invalidate("code", "そのカテゴリーコードはすでに使用されています。");
			} else {
				$this->Category->create();
				if ($this->Category->save($this->request->data)) {
					$this->Session->setFlash(__('The category has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}
			}
		}
		$categoryGroups = $this->Category->CategoryGroup->find('list');
		$this->set(compact('categoryGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $code
 * @return void
 */
	public function edit($code = null) {
		if (!$this->Category->exists($code)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $code));
			$this->request->data = $this->Category->find('first', $options);
		}
		$categoryGroups = $this->Category->CategoryGroup->find('list');
		$this->set(compact('categoryGroups'));
	}

	/**
	 * delete method.
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $code カテゴリーコード
	 * @return void
	 */
	public function delete($code = null) {
		if ($this->request->is('get')) throw new MethodNotAllowedException();
		if (!$code) throw new NotFoundException(__('Invalid category'));
		
		$cat = $this->Category->findByCode($code);
		if (!$cat) throw new NotFoundException(__('Invalid category'));
		
		$this->Category->set('code', $code);
		$ret = $this->Category->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('カテゴリー [code:' . $code . ']を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('カテゴリーの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
