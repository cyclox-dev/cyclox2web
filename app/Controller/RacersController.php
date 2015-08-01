<?php

App::uses('ApiBaseController', 'Controller');
App::uses('AjoccUtil', 'Cyclox/Util');

/**
 * Racers Controller
 *
 * @property Racer $Racer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RacersController extends ApiBaseController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler', 'Search.Prg');
	
	// Search プラグイン設定
    public $presetVars = array(
		'keyword' => array('type' => 'value'),
		'andor' => array('type' => 'value'),
	);
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Racer->recursive = 1;
		
		$this->Prg->commonProcess();
		$req = $this->passedArgs;
        if (!empty($this->request->data['Racer']['keyword'])) {
            $andor = !empty($this->request->data['Racer']['andor']) ? $this->request->data['Racer']['andor'] : null;
            $word = $this->Racer->multipleKeywords($this->request->data['Racer']['keyword'], $andor);
            $req = array_merge($req, array("word" => $word));
        }
		
		
		$this->paginate = array('conditions' => $this->Racer->parseCriteria($req));
		
		$this->set('racers', $this->paginate());
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
		//if (!$this->Racer->exists($code)) {
		if (!$this->Racer->existsOnDB($code)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		
		// deleted も表示する
		$this->Racer->softDelete(false);
		
		$isApiCall = $this->_isApiCall();
		
		$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $code));
		if ($isApiCall) {
			$options['recursive'] = -1;
		}
		
		$racer = $this->Racer->find('first', $options);
		if ($isApiCall) {
			$this->success($racer);
		} else {
			$this->set('racer', $racer);
		}
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() 
	{
		if ($this->request->is(array('post', 'put'))) {
			if (!$this->_validateFamilyName()) {
				$this->Racer->validator()->invalidate('family_name', '姓のいずれかに入力が必要です。');
				$this->Racer->validator()->invalidate('family_name_kana', '姓のいずれかに入力が必要です。');
				$this->Racer->validator()->invalidate('family_name_en', '姓のいずれかに入力が必要です。');
				return;
			}
			if (!$this->_validateFirstName()) {
				$this->Racer->validator()->invalidate('first_name', '姓のいずれかに入力が必要です。');
				$this->Racer->validator()->invalidate('first_name_kana', '姓のいずれかに入力が必要です。');
				$this->Racer->validator()->invalidate('first_name_en', '姓のいずれかに入力が必要です。');
				return;
			}
		}
		
		if ($this->_isApiCall()) {
			return $this->__addOnApi();
		} else {
			return $this->__addOnPage();
		}
	}
	
	/**
	 * 姓のいずれかが入力されているかをかえす
	 * @return boolean
	 */
	private function _validateFamilyName()
	{
		$this->log($this->data, LOG_DEBUG);
		if (empty($this->data['Racer']['family_name'])
				&& empty($this->data['Racer']['family_name_kana'])
				&& empty($this->data['Racer']['family_name_en'])) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * 名のいずれかが入力されているかをかえす
	 * @return boolean
	 */
	private function _validateFirstName()
	{
		if (empty($this->data['Racer']['first_name'])
				&& empty($this->data['Racer']['first_name_kana'])
				&& empty($this->data['Racer']['first_name_en'])) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * 管理画面上での add 処理
	 * @return void
	 */
	private function __addOnPage()
	{
		if ($this->request->is(array('post', 'put'))) {
			$this->Racer->create();
			$code = AjoccUtil::nextRacerCode();
			$this->request->data['Racer']['code'] = $code;
			
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('新規選手データ [code:' . $code . '] を保存しました。'));
				return $this->redirect('/racers/view/' . $code);
			} else {
				$this->Session->setFlash(__('The racer could not be saved. Please, try again.'));
			}
		}
	}
	
	/**
	 * API 上での add 処理
	 * @return void
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			//$this->log($this->request->data, LOG_DEBUG);
			$this->Racer->create();
			
			if (!isset($this->request->data['Racer']['code']))
			{
				return $this->error('選手コードがありません (Racer.code)', self::STATUS_CODE_BAD_REQUEST);
			}
			
			$code = $this->request->data['Racer']['code'];
			if ($this->Racer->exists($code)) {
				return $this->error('すでにその選手コードは使われています。', self::STATUS_CODE_BAD_REQUEST);
			}
			
			if ($this->Racer->save($this->request->data)) {
				return $this->success(array());
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
	 * @param string $code
	 * @return void
	 */
	public function edit($code = null)
	{
		if ($this->_isApiCall()) {
			return $this->__editOnApi($code);
		} else {
			return $this->__editOnPage($code);
		}
	}
	
	/**
	 * 管理画面上での edit 処理
	 * @return void
	 */
	private function __editOnPage($code = null)
	{
		if (!$this->Racer->exists($code)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('The racer has been saved.'));
				return $this->redirect('/racers/view/' . $code);
			} else {
				$this->Session->setFlash(__('The racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $code));
			$this->request->data = $this->Racer->find('first', $options);
			$this->set('rcode', $this->request->data['Racer']['code']);
		}
	}
	
	/**
	 * API 上での edit 処理
	 * @return void
	 */
	private function __editOnApi($code = null)
	{
		if (!$this->Racer->exists($code)) {
			return $this->error('不正なリクエストです。（指定の選手コードが存在しません）。');
		}
		
		$this->log($this->request->data);
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Racer->save($this->request->data)) {
				return $this->success(array());
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
	}

	/**
	 * delete method
	 * 削除日時の適用
	 * @throws NotFoundException
	 * @param string $code 選手コード
	 * @return void
	 */
	public function delete($code = null)
	{
		$this->Racer->id = $code;
		if (!$this->Racer->exists()) {
			throw new NotFoundException(__('Invalid racer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Racer->delete()) {
			$this->Session->setFlash(__('選手 [code:' . $code . '] を削除しました（削除日時を適用）。'));
		} else {
            $this->Session->setFlash(__('選手の削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
