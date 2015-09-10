<?php

App::uses('ApiBaseController', 'Controller');

/**
 * CategoryRacers Controller
 *
 * @property CategoryRacer $CategoryRacer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoryRacersController extends ApiBaseController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public $uses = array('CategoryRacer', 'Meet');
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CategoryRacer->recursive = 0;
		$this->set('categoryRacers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		// deleted を閲覧可能とする。api での削除メソッド
		$this->CategoryRacer->Behaviors->unload('Utils.SoftDelete');
		
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		
		$isApiCall = $this->_isApiCall();
		
		$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
		if ($isApiCall) {
			$options['recursive'] = -1;
		}
		
		$cr = $this->CategoryRacer->find('first', $options);
		if ($isApiCall) {
			$this->success($cr);
		} else {
			$this->set('categoryRacer', $cr);
		}
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($racerCode = null)
	{
		if ($this->_isApiCall()) {
			return $this->__addOnApi();
		} else {
			return $this->__addOnPage($racerCode);
		}
	}
	
	/**
	 * 管理画面上での add 処理
	 * @return void
	 */
	private function __addOnPage($racerCode = null)
	{
		if ($this->request->is('post')) {
			//$this->log($this->request->data);
			$this->CategoryRacer->create();
			if ($this->CategoryRacer->save($this->request->data)) {
				//$this->log($this->CategoryRacer->getDataSource()->getLog(), LOG_DEBUG);
				
				$this->Session->setFlash(__('The category racer has been saved.'));
				return $this->redirect('/category_racers/view/' . $this->CategoryRacer->id);
			} else {
				$this->Session->setFlash(__('The category racer could not be saved. Please, try again.'));
			}
		}
		
		$categories = $this->CategoryRacer->Category->find('list', array('fields' => array('Category.code', 'Category.name')));
		$meets = $this->Meet->find('list', array('fields' => array('Meet.code', 'Meet.name')));
		
		$this->set(compact('categories', 'meets'));
		
		if ($racerCode != null)  {
			$this->set('racerCode', $racerCode);
			$this->request->data['CategoryRacer']['racer_code'] = $racerCode;
		}
	}
	
	/**
	 * API 上での add 処理
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			
			//$this->log($this->request->data);
			// 重複などについては最新情報のダウンロードで補完するものとする。
			
			$this->CategoryRacer->create();
			if ($this->CategoryRacer->save($this->request->data)) {
				// 設定された ID をかえす
				$newId = $this->CategoryRacer->id;
				return $this->success(array('id' => $newId));
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
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
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The category racer has been saved.'));
				return $this->redirect('/category_racers/view/' . $this->CategoryRacer->id);
			} else {
				$this->Session->setFlash(__('The category racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
			$this->request->data = $this->CategoryRacer->find('first', $options);
		}
		
		$categories = $this->CategoryRacer->Category->find('list', array('fields' => array('Category.code', 'Category.name')));
		$meets = $this->Meet->find('list', array('fields' => array('Meet.code', 'Meet.name')));
		
		$this->set(compact('categories', 'meets'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) 
	{
		$this->CategoryRacer->id = $id;
		if (!$this->CategoryRacer->exists()) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CategoryRacer->delete()) {
			$this->Session->setFlash(__('選手のカテゴリー所属情報 [ID:' . $id . '] を削除しました（削除日時の適用）。'));
		} else {
			$this->Session->setFlash(__('選手のカテゴリー所属情報削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
