<?php
App::uses('AppController', 'Controller');
/**
 * RacesCategories Controller
 *
 * @property RacesCategory $RacesCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacesCategoriesController extends AppController {

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
		$this->RacesCategory->recursive = 0;
		$this->set('racesCategories', $this->Paginator->paginate());
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
		if (!$this->RacesCategory->exists($code)) {
			throw new NotFoundException(__('Invalid races category'));
		}
		$options = array('conditions' => array('RacesCategory.' . $this->RacesCategory->primaryKey => $code));
		$this->set('racesCategory', $this->RacesCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add()
	{
		if ($this->request->is(array('post', 'put'))) {
			if (isset($this->request->data['RacesCategory']['code'])
					&& $this->RacesCategory->exists($this->request->data['RacesCategory']['code'])) {
				$this->RacesCategory->validator()->invalidate("code", "そのカテゴリーコードはすでに使用されています。");
			} else {
				$this->RacesCategory->create();

				$ageStr = '';
				foreach ($this->request->data['RacesCategory']['uci_age_limit'] as $a) {
					$ageStr .= $a;
				}
				debug($ageStr);
				$this->request->data['RacesCategory']['uci_age_limit'] = $ageStr;

				if ($this->RacesCategory->save($this->request->data)) {
					$this->log($this->RacesCategory->getDataSource()->getLog(), LOG_DEBUG);

					$this->Session->setFlash(__('The races category has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The races category could not be saved. Please, try again.'));
				}
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
		if (!$this->RacesCategory->exists($code)) {
			throw new NotFoundException(__('Invalid races category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RacesCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The races category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The races category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RacesCategory.' . $this->RacesCategory->primaryKey => $code));
			$this->request->data = $this->RacesCategory->find('first', $options);
		}
	}

	/**
	 * delete method
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $code レースカテゴリーコード
	 * @return void
	 */
	public function delete($code = null) {
		if ($this->request->is('get')) throw new MethodNotAllowedException();
		if (!$code) throw new NotFoundException(__('Invalid races-category'));
		
		$mt = $this->RacesCategory->findByCode($code);
		if (!$mt) throw new NotFoundException(__('Invalid races-category'));
		
		$this->RacesCategory->set('code', $code);
		$ret = $this->RacesCategory->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('レースカテゴリー [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
			$this->Session->setFlash(__('レースカテゴリーの削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
