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
	public $components = array('Paginator', 'Flash', 'RequestHandler',
			'Security' => array(
				'unlockedActions' => array('delete'), // 他のコントローラーからアクセスあり。
			)
	);

	public $uses = array('CategoryRacer', 'Meet', 'Racer');

	function beforeFilter()
	{
		parent::beforeFilter();
		
		$this->Security->blackHoleCallback = 'blackhole';
	}
	
	public function blackhole($type)
	{
		$msg = 'セキュリティエラー';
		if ($type === 'csrf') {
			$msg = 'CSRF に関するエラー';
		} else if ($type === 'auth') {
			$msg = '認証エラー　';
		}
		
		$this->Flash->set('トークンエラー！もしくはトークンの期限切れ。');
		$this->Flash->set('(' . $msg . ')');
		$this->Flash->set('ページのリロードやブラウザバックは禁止です。処理を最初からやり直してください。 ');
		$this->redirect('/');
	}
	
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
	
	public function change_em($rcode = null)
	{
		if (!$this->Racer->exists($rcode)) {
			$this->Flash->set(__('選手が見つかりません。'));
			return $this->redirect($this->referer());
		}
		
		// TODO: 年齢によってはマスターズへの移行は認められない。
		
		$this->Racer->CategoryRacer->Behaviors->load('Utils.SoftDelete');
		
		$options = array(
			'conditions' => array('Racer.' . $this->Racer->primaryKey => $rcode),
		);
		$racer = $this->Racer->find('first', $options);
		$cat_tos = $this->__check_category_to($racer['CategoryRacer']);
		
		$this->set('racer', $racer);
		$this->set('cat_tos', $cat_tos);
	}
	
	/**
	 * カテゴリー乗換先を取得する
	 * @param array $cats 現在持っているカテゴリー情報
	 * @return array カテゴリー乗換情報。要素は array で key は from, to。
	 */
	private function __check_category_to($cats)
	{
		$cat_tos = array();
		
		$map = array(
			'CM1' => 'C2',
			'CM2' => 'C3',
			'CM3' => 'C4',
			'C1' => 'CM1',
			'C2' => 'CM2',
			'C3' => 'CM3',
			'C4' => 'CM3',
		);
		
		foreach ($cats as $cat)  {
			if (!empty($map[$cat['category_code']]) && empty($cat['cancel_date'])) {
				$cat_tos[] = array(
					'from' => $cat['category_code'],
					'to' => $map[$cat['category_code']],
				);
			}
		}
		
		return $cat_tos;
	}
	
	public function check_change_em($rcode = null)
	{
		if (!$this->request->is('post')) {
			$this->Flash->set(__('カテゴリー乗換処理はキャンセルされました。', self::STATUS_CODE_BAD_REQUEST));
			return $this->redirect(array('/racers/index'));
		}
		
		//$this->log($this->request->data, LOG_DEBUG);
		
		if (empty($rcode) || empty($this->request->data['CategoryRacer']['cat_to'])) {
			$this->Flash->set(__('選手コードおよびカテゴリー乗換先の指定がありません。', self::STATUS_CODE_BAD_REQUEST));
			return empty($rcode) ? $this->redirect('/racers/index') : $this->redirect('/racers/view/' . $rcode);
		}
		
		$this->Racer->CategoryRacer->Behaviors->load('Utils.SoftDelete');
		
		$options = array(
			'conditions' => array('Racer.' . $this->Racer->primaryKey => $rcode),
		);
		$racer = $this->Racer->find('first', $options);
		
		// 終了となる所属を取得
		$end_cats = array();
		$keep_cats = array();
		$reason_note = '';
		$cat_to = $this->request->data['CategoryRacer']['cat_to'];
		$elites = array('C1', 'C2', 'C3', 'C4');
		$masters = array('CM1', 'CM2', 'CM3');
		
		if (in_array($cat_to, $elites)) {
			$end_codes = $masters;
			$reason_note = 'エリートへのカテゴリー乗換';
		} else if (in_array($cat_to, $masters)) {
			$end_codes = $elites;
			$reason_note = 'マスターズへのカテゴリー乗換';
		} else {
			$end_codes = array();
		}
		
		foreach ($racer['CategoryRacer'] as $cr) {
			if (in_array($cr['category_code'], $end_codes) && empty($cr['cancel_date'])) {
				$end_cats[] = $cr;
 			} else {
				$keep_cats[] = $cr;
			}
		}
		
		// 所属終了日、開始日の設定（現在日時から取得）
		$y = date('Y');
		$m = date('n');
		if ($m < 4) {
			--$y;
		}
		
		$end_date = $y . '-08-31';
		$start_date = $y . '-09-01';
		
		$this->set('racer', $racer);
		$this->set('end_cats', $end_cats);
		$this->set('keep_cats', $keep_cats);
		$this->set('reason_note', $reason_note);
		$this->set('cat_to', $cat_to);
		$this->set('end_date', $end_date);
		$this->set('start_date', $start_date);
	}
	
	public function exec_change_em($rcode = null)
	{
		if (!$this->request->is('post')) {
			$this->Flash->set(__('カテゴリー乗換処理はキャンセルされました。', self::STATUS_CODE_BAD_REQUEST));
			return $this->redirect(array('/racers/index'));
		}
		
		//$this->log($this->request->data, LOG_DEBUG);
		
		if (empty($rcode) || empty($this->request->data['CategoryRacer'])) {
			$this->Flash->set(__('選手コードもしくはカテゴリー乗換先の指定がありません。', self::STATUS_CODE_BAD_REQUEST));
			return empty($rcode) ? $this->redirect('/racers/index') : $this->redirect('/racers/view/' . $rcode);
		}
		
		
		//$this->log($this->request->data, LOG_DEBUG);
		
		$this->loadModel('TransactionManager');
		
		$transaction = $this->TransactionManager->begin();
		
		try {
			$err = false;
			
			// 終了するカテゴリーデータの保存
			if (!empty($this->request->data['sub']['end_ids_json'])) {
				$ids = json_decode($this->request->data['sub']['end_ids_json']);
				
				if (empty($this->request->data['sub']['end_date'])) {
					// 所属終了日設定（現在日時から取得）
					$y = date('Y');
					$m = date('n');
					if ($m < 4) {
						--$y;
					}

					$end_date = $y . '-08-31';
				} else {
					$end_date = $this->request->data['sub']['end_date'];
				}
				
				$cancel_crs = array();
				foreach ($ids as $cid) {
					$cancel_crs[] = array('id' => $cid, 'cancel_date' => $end_date);
				}
				$ret = $this->CategoryRacer->saveMany($cancel_crs, array('atomic' => false));
				$this->log($ret, LOG_DEBUG);
				
				if ($ret === false) {
					$err = 'カテゴリー所属の終了日設定に失敗しました。';
				}
			}
			
			// カテゴリー所属の保存
			$this->CategoryRacer->create();
			$ret = $this->CategoryRacer->save($this->request->data['CategoryRacer']);
			if ($ret === false) {
				$err = '新規カテゴリー所属の設定に失敗しました。';
			}
			
			if (empty($err)) {
				
				$this->TransactionManager->commit($transaction);
				
				$msg = $rcode . 'の選手についてカテゴリー乗換処理を正常に終了しました。';
				$this->log($msg, LOG_INFO);
				$this->Flash->success($msg);
				return $this->redirect('/racers/view/'. $rcode);
			} else {
				$this->TransactionManager->rollback($transaction);
				
				$this->log('カテゴリー乗換データの書込に失敗しました。', LOG_INFO);
				$this->Flash->set('カテゴリー乗換データの書込に失敗しました。');
				$this->Flash->set('失敗理由:' . $err);
				
				return $this->redirect('/racers/view/' . $rcode);
			}
		} catch (Exception $ex) {
			$this->TransactionManager->rollback($transaction);
			
			$this->log('予測しないエラーにより終了しました。ex:' . $ex->getMessage(), LOG_ERR);
			$this->Flash->set(__('予測されないエラー' . $ex->getMessage() . 'により、カテゴリー乗換処理はキャンセルされました。'));
			return $this->redirect(array('action' => 'change_em', $rcode));
		}
		
		
	}
}
