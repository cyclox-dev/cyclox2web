<?php

App::uses('ApiBaseController', 'Controller');

/**
 * CategoryRacers Controller
 *
 * @property CategoryRacer $CategoryRacer
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class CategoryRacersController extends ApiBaseController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'RequestHandler');

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
				
				$this->Flash->set(__('The category racer has been saved.'));
				return $this->redirect('/racers/view/' . $this->request->data['CategoryRacer']['racer_code']);
			} else {
				$this->Flash->set(__('The category racer could not be saved. Please, try again.'));
			}
		}
		
		$categories = $this->CategoryRacer->Category->find('list', array('fields' => array('Category.code', 'Category.name')));
		$meets = $this->Meet->find('list', array('fields' => array('Meet.code', 'Meet.name')));
		
		$this->set(compact('categories', 'meets'));
		
		if ($racerCode != null)  {
			$this->set('racerCode', $racerCode);
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
		if ($this->_isApiCall()) {
			return $this->__editOnApi($id);
		} else {
			return $this->__editOnPage($id);
		}
	}
	
	private function __editOnPage($id = null)
	{
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoryRacer->save($this->request->data)) {
				$this->Flash->set(__('The category racer has been saved.'));
				return $this->redirect(array('controller' => 'Racers', 'action' => 'view', $this->request->data['CategoryRacer']['racer_code']));
			} else {
				$this->Flash->set(__('The category racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
			$this->request->data = $this->CategoryRacer->find('first', $options);
		}
		
		$categories = $this->CategoryRacer->Category->find('list', array('fields' => array('Category.code', 'Category.name')));
		$meets = $this->Meet->find('list', array('fields' => array('Meet.code', 'Meet.name')));
		
		$this->set(compact('categories', 'meets'));
	}
	
	private function __editOnApi($id = null)
	{
		if ($this->request->is('post')) {
			
			// Local edit -> web delete -> update to web での対策
			$this->CategoryRacer->Behaviors->unload('Utils.SoftDelete');
			
			if (!$this->CategoryRacer->exists($id)) {
				throw new NotFoundException(__('Invalid category racer'));
			}
			$this->CategoryRacer->id = $id;
			if ($this->CategoryRacer->save($this->request->data)) {
				$newId = $this->CategoryRacer->id;
				return $this->success(array('id' => $newId)); // add とそろえる
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
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
		if ($this->_isApiCall()) {
			return $this->__deleteOnApi($id);
		} else {
			return $this->__deleteOnPage($id);
		}
	}
	
	private function __deleteOnPage($id = null)
	{
		$this->CategoryRacer->id = $id;
		$this->CategoryRacer->Behaviors->unload('Utils.SoftDelete'); // 一旦 deleted が存在するかについても確認
		if (!$this->CategoryRacer->exists()) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		$this->request->allowMethod('post', 'delete');
		
		$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
		$cr = $this->CategoryRacer->find('first', $options);
		
		$this->CategoryRacer->Behaviors->load('Utils.SoftDelete');
		if ($this->CategoryRacer->delete()) {
			$this->Flash->set(__('選手のカテゴリー所属情報 [ID:' . $id . '] を削除しました（削除ステータスを設定）。'));
		} else {
			$this->Flash->set(__('選手のカテゴリー所属情報削除に失敗しました。'));
		}
		
		return $this->redirect(array('controller' => 'Racers', 'action' => 'view', $cr['CategoryRacer']['racer_code']));
	}
	
	private function __deleteOnApi($id = null)
	{
		$this->CategoryRacer->id = $id;
		
		// soft, hard いずれでも削除されていれば OK とする
		if (!$this->CategoryRacer->exists()) {
			return $this->success('already deleted');
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CategoryRacer->delete()) {
			return $this->success(array('ok'));
		} else {
			return $this->error('削除処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
		}
	}
}
