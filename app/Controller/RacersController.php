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
	public $uses = array('Racer', 'EntryRacer');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler', 'Search.Prg', 'AgedCategory');
	
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
	public function index()
	{
		$this->Racer->recursive = 1;
		$this->Racer->CategoryRacer->Behaviors->load('Utils.SoftDelete');
		
		$this->Prg->commonProcess();
		$req = $this->passedArgs;
        if (!empty($this->request->data['Racer']['keyword'])) {
            $andor = !empty($this->request->data['Racer']['andor']) ? $this->request->data['Racer']['andor'] : null;
            $word = $this->Racer->multipleKeywords($this->request->data['Racer']['keyword'], $andor);
            $req = array_merge($req, array("word" => $word));
        }
		
		// 上記 multipleKeywords は使用しない。自前で and, or の条件文を作る。
		$cdt = $this->__makeRacerSearchCondition($req);
		//$this->log('cdt is,,,', LOG_DEBUG);
		//$this->log($cdt, LOG_DEBUG);
		
		if ($this->_isApiCall()) {
			$opt = array(
				//'conditions' => $this->Racer->parseCriteria($req),
				'conditions' => $cdt,
				'fields' => array('code', 'first_name', 'family_name', 'first_name_kana', 'family_name_kana'
					, 'first_name_en', 'family_name_en', 'gender', 'team', 'jcf_number', 'prefecture')
			);
			
			// CatRacer の fileds 指定
			$this->Racer->hasMany['CategoryRacer']['fields'] = array(
				'category_code', 'apply_date', 'cancel_date'
			);
			
			$racers = $this->Racer->find('all', $opt);
			$this->success($racers);
		} else {
			if (empty($this->request->data['Racer']['keyword'])) {
				$this->paginate = array('conditions' => $this->Racer->parseCriteria($req));
			} else {
				$this->paginate = array('conditions' => $cdt);
			}
			$this->set('racers', $this->paginate());
		}
	}
	
	/**
	 * リクエストから選手検索条件を作成する
	 * @param array $req 'keyword' をキーとする value を持つ。半角スペースにて
	 */
	private function __makeRacerSearchCondition($req)
	{
		if (empty($this->request->data['Racer']['keyword'])) {
			return $req;
		}
		
		$andor = 'or';
		if(!empty($this->request->data['Racer']['andor']) && in_array($this->request->data['Racer']['andor'], array('and', 'or'))) {
			$andor = $this->request->data['Racer']['andor'];
		}
		
		$cdt = array(); 
		// 全角スペース半角スペースに変換
		$str = trim(mb_convert_kana($this->request->data['Racer']['keyword'], 's', 'UTF-8'));
		// 半角スペースでの分割
		$kws = explode(' ', $str);
		//$this->log('kws is,,,', LOG_DEBUG);
		//$this->log($kws, LOG_DEBUG);
		
		foreach ($kws as $kw) {
			$hanKw = mb_convert_kana($kw, 'rn');
			$zenKw = mb_convert_kana($kw, 'RN');
			
			$orcdt = array();
			foreach ($this->Racer->filterArgs['word']['field'] as $f) {
				$orcdt[] = array(('' . $f . ' ' . $this->Racer->filterArgs['word']['type']) => ('%' . $kw . '%'));
				
				// 全角英数、半角英数を変換して条件を追加する
				if ($kw != $hanKw) {
					$orcdt[] = array(('' . $f . ' ' . $this->Racer->filterArgs['word']['type']) => ('%' . $hanKw . '%'));
				}

				// 全角英数、半角英数を変換して条件を追加する
				if ($kw != $zenKw) {
					$orcdt[] = array(('' . $f . ' ' . $this->Racer->filterArgs['word']['type']) => ('%' . $zenKw . '%'));
				}

				// 大文字小文字は考えない
			}
			
			$cdt[] = array('OR' => $orcdt);
		}
		
		//$this->log('cdt is', LOG_DEBUG);
		//$this->log($cdt, LOG_DEBUG);
		
		$ret = array($andor => $cdt);
		return $ret;
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
		
		$isApiCall = $this->_isApiCall();
		
		$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $code));
		if ($isApiCall) {
			$options['recursive'] = -1;
		}
		
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // 削除済みも表示する
		$this->Racer->CategoryRacer->Behaviors->load('Utils.SoftDelete');
		
		$racer = $this->Racer->find('first', $options);
		
		if ($isApiCall) {
			$this->success($racer);
		} else {
			$opt = array('conditions' => array('racer_code' => $code));

			$entryCount = $this->EntryRacer->find('count', $opt);
			
			// order by Meet.at_date では find できないので、
			// 最新更新の20件を find して地道に at_date ソートで最新10件程度を表示する。
			$opt['order'] = array('EntryRacer.modified' => 'desc');
			$opt['limit'] = 20; // 最新更新の20件取得しておいて10件の最新を配置
			// TODO: 改善できるなら改善
			
			$this->EntryRacer->Behaviors->load('Containable');
			$opt['contain'] = array(
				'RacerResult' => array(
					'HoldPoint'
				),
				'EntryCategory' => array(
					'EntryGroup' => array(
						'fields' => array(),
						'Meet' => array(
							'fields' => array('code', 'short_name', 'at_date'),
						)
					)
				)
			);
			$entries = $this->EntryRacer->find('all', $opt);
			/*
			$this->log('count:' . $entryCount, LOG_DEBUG);
			$this->log('entries', LOG_DEBUG);
			$this->log($entries, LOG_DEBUG);
			//*/

			$this->set('racer', $racer);
			$this->set('entryCount', $entryCount);
			$this->set('entries', $entries);
		}
	}
	
	/**
	 * 選手のリザルトを表示する
	 * @param type $code 選手コード
	 * @throws NotFoundException
	 */
	public function results($code = null)
	{
		if (!$this->Racer->existsOnDB($code)) {
			throw new NotFoundException(__('Invalid racer'));
		}
		
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // 削除済みも表示する
		$options = array('conditions' => array('Racer.' . $this->Racer->primaryKey => $code));
		$racer = $this->Racer->find('first', $options);
		
		$opt = array(
			'conditions' => array('racer_code' => $code),
			'order' => array('EntryRacer.modified' => 'asc'),
		);
		// order by Meet.at_date では find できないので、
		// 最新更新の20件を find して地道 at_date ソートする。
		
		$this->EntryRacer->Behaviors->load('Containable');
		$opt['contain'] = array(
			'RacerResult' => array(
				'HoldPoint'
			),
			'EntryCategory' => array(
				'EntryGroup' => array(
					'fields' => array(),
					'Meet' => array(
						'fields' => array('code', 'short_name', 'at_date'),
					)
				)
			)
		);
		$entries = $this->EntryRacer->find('all', $opt);
		/*
		$this->log('count:' . $entryCount, LOG_DEBUG);
		$this->log('entries', LOG_DEBUG);
		$this->log($entries, LOG_DEBUG);
		//*/

		$this->set('racer', $racer);
		$this->set('entries', $entries);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() 
	{
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
		
			$this->Racer->create();
			$code = AjoccUtil::nextRacerCode();
			$this->request->data['Racer']['code'] = $code;
			
			if ($this->Racer->save($this->request->data)) {
				$this->Session->setFlash(__('新規選手データ [code:' . $code . '] を保存しました。'));
				
				if (!$this->AgedCategory->checkAgedCategory($code, date('Y-m-d'), true)) {
					$this->log('Aged Category の保存に失敗しました。', LOG_ERR);
					// not return false
				}
				
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
			
			if (empty($this->request->data['Racer']['family_name'])) {
				$this->request->data['Racer']['family_name'] = '_姓が未入力です';
			}
			if (empty($this->request->data['Racer']['first_name'])) {
				$this->request->data['Racer']['first_name'] = '_名前が未入力です';
			}
			
			if (empty($this->request->data['Racer']['family_name_kana'])) {
				$this->request->data['Racer']['family_name_kana'] = '';
			}
			if (empty($this->request->data['Racer']['family_name_en'])) {
				$this->request->data['Racer']['family_name_en'] = '';
			}
			if (empty($this->request->data['Racer']['first_name_kana'])) {
				$this->request->data['Racer']['first_name_kana'] = '';
			}
			if (empty($this->request->data['Racer']['first_name_en'])) {
				$this->request->data['Racer']['first_name_en'] = '';
			}//*/
			
			if (!isset($this->request->data['Racer']['code'])) {
				return $this->error('選手コードがありません (Racer.code)', self::STATUS_CODE_BAD_REQUEST);
			}
			
			$code = $this->request->data['Racer']['code'];
			if ($this->Racer->exists($code)) {
				return $this->error('すでにその選手コードは使われています。', self::STATUS_CODE_BAD_REQUEST);
			}
			
			if ($this->Racer->save($this->request->data)) {
				if (!$this->AgedCategory->checkAgedCategory($code, date('Y-m-d'), true)) {
					$this->log('Aged Category の保存に失敗しました。', LOG_ERR);
					// not return false
				}
				
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
				
				if (!$this->AgedCategory->checkAgedCategory($code, date('Y-m-d'), true)) {
					$this->log('Aged Category の保存に失敗しました。', LOG_ERR);
					// not return false
				}
				
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
		$this->log($this->request->data);
		
		if ($this->request->is(array('post', 'put'))) {
			
			// Local edit -> web delete -> update to web での対策
			$this->Racer->Behaviors->unload('Utils.SoftDelete');
			if (!$this->Racer->exists($code)) {
				return $this->error('不正なリクエストです。（指定の選手コードが存在しません）。');
			}
			
			// team の空入力での書換えは無しとする（Cyclox2 App ver1.10 のバグ対策）
			if (isset($this->request->data['Racer']['team'])) {
				//if ($this->request->data['Racer']['team'] === '') {
				// --> @ver1.20 時間が経過したので上記対策をキャンセルとする。@20161224
				//		逆にチーム名を empty にできないため、不都合となった。
				if (Validation::email($this->request->data['Racer']['team'])) {
					$this->log('チーム名:' . $this->request->data['Racer']['team'] . 'を空に設定します', LOG_INFO);
					unset($this->request->data['Racer']['team']);
				}
			}
			
			//$this->log('racer:', LOG_DEBUG);
			//$this->log($this->request->data['Racer'], LOG_DEBUG);
			
			if ($this->Racer->save($this->request->data)) {
				
				if (!$this->AgedCategory->checkAgedCategory($code, date('Y-m-d'), true)) {
					$this->log('Aged Category の保存に失敗しました。', LOG_ERR);
					// not return false
				}
				
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
