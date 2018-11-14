<?php

App::uses('ApiBaseController', 'Controller');
App::uses('CategoryReason', 'Cyclox/Const');
App::uses('AjoccUtil', 'Cyclox/Util');

/**
 * EntryCategories Controller
 *
 * @property EntryCategory $EntryCategory
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class EntryCategoriesController extends ApiBaseController
{
	public $uses = array('TransactionManager', 'EntryCategory', 'EntryRacer', 'PointSeries', 'TmpResultUpdateFlag'
		, 'MeetPointSeries', 'Category', 'EntryGroup', 'Racer', 'CategoryRacer', 'Meet');
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'RequestHandler', 'ResultParamCalc', 'ResultRead');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->EntryCategory->recursive = 0;
		$this->set('entryCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null)
	{
		if (!$this->EntryCategory->exists($id)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$options = array(
			'conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $id),
			'recursive' => 0,
		);
		$ecat = $this->EntryCategory->find('first', $options);
		
		$this->EntryRacer->Behaviors->load('Utils.SoftDelete');
		$this->EntryRacer->Behaviors->load('Containable');
		
		$opt = array();
		$opt['contain'] = array('RacerResult' => array('HoldPoint', 'PointSeriesRacer'));
		$opt['conditions'] = array(
			'entry_category_id' => $ecat['EntryCategory']['id']
		);
		$opt['order'] = array('body_number * 1' => 'asc'); // "* 1" -> 整数でオーダー
		$eracers = $this->EntryRacer->find('all', $opt);
		//$this->log('racers:', LOG_DEBUG);
		//$this->log($eracers, LOG_DEBUG);
		
		$ecat['EntryRacer'] = $eracers;
		$this->set('entryCategory', $ecat);
		
		// リザルトの entry_category_id の有効な数を数える（NULL だったらリザルト無しだから）
		$results = array();
		$psTitles = array(); // [n] => array('id' => id, 'name' => name)
		$holdPointCount = 0;
		foreach ($eracers as $er) {
			// リザルトのあるものだけを格納
			if (isset($er['RacerResult']['id'])) {
				
				// $er に対してシリーズポイント設定
				if (!empty($er['RacerResult']['PointSeriesRacer'])) {
					foreach ($er['RacerResult']['PointSeriesRacer'] as $psr) {
						// point_series_is がタイトルにあるか検索
						$finds = false;
						$index = 0;
						foreach ($psTitles as $title) {
							if ($psr['point_series_id'] == $title['id']) {
								$finds = true;
								break;
							}
							++$index;
						}
						
						if (!$finds) {
							$opt = array('conditions' => array('id' => $psr['point_series_id']), 'recursive' => -1);
							$series = $this->PointSeries->find('first', $opt);
							$psTitles[$index] = array('id' => $psr['point_series_id'], 'name' => $series['PointSeries']['short_name']);
						}
						
						if (empty($er['RacerResult']['points'])) {
							$er['RacerResult']['points'] = array();
						}
						$er['RacerResult']['points'][$index] = array(
							'pt' => $psr['point'],
							'bonus' => $psr['bonus'],
						);
						// TODO: 検証 - ポイントシリーズが複数になった時にきちんと表示されるか。
					}
				}
				
				$results[] = $er;
				if (!empty($er['RacerResult']['HoldPoint'])) {
					++$holdPointCount;
				}
			}
		}
		//$this->log('results:', LOG_DEBUG);
		//$this->log($results, LOG_DEBUG);
		//$this->log($psTitles, LOG_DEBUG);
		
		if (!empty($results)) {
			$results = Hash::sort($results, '{n}.RacerResult.order_index', 'asc');
			$this->set('results', $results);
			$this->set('holdPointCount', $holdPointCount);
			$this->set('psTitles', $psTitles);
		}
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
	 * 管理画面上での add 処理
	 * @return void
	 */
	private function __addOnPage()
	{
		if ($this->request->is('post')) {
			$this->EntryCategory->create();
			if ($this->EntryCategory->save($this->request->data)) {
				$this->Flash->set(__('The entry category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The entry category could not be saved. Please, try again.'));
			}
		}
		$racesCategories = $this->EntryCategory->RacesCategory->find('list');
		$this->set(compact('entryGroups', 'racesCategories'));
	}
	
	/**
	 * API 上での add 処理
	 * @return void
	 */
	private function __addOnApi()
	{
		if ($this->request->is('post')) {
			$this->log($this->request->data, LOG_DEBUG);
			$this->EntryCategory->create();
			
			if ($this->EntryCategory->save($this->request->data)) {
				return $this->success(array('entry_category_id' => $this->EntryCategory->id));
			} else {
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
	}
	
	public function addEmpty($meetCode = null)
	{
		if (empty($meetCode)) {
			$this->Flash->error(__('大会コードを指定して下さい。'));
		} else {
			if ($this->request->is('post')) {
				$dat = $this->request->data;
				
				$ecname = $dat['EntryCategory'][0]['name'];
				
				if ($this->__checkEcatNameDuplicated($meetCode, $ecname)) {
					$this->Flash->set(__('出走カテゴリー名 ' . $ecname . ' が既に存在します。'
						. '既存のものを削除するか、違う名前で作成して下さい。', self::STATUS_CODE_BAD_REQUEST));
				} else {
					$dat['EntryGroup']['skip_lap_count'] = 0;
					$dat['EntryGroup']['name'] = $ecname;
					$dat['EntryCategory'][0]['start_delay_sec'] = 0;
					//$this->log($dat, LOG_DEBUG);
					if ($this->EntryGroup->saveAssociated($dat)) {
						$this->Flash->success(__('空の出走カテゴリー ' . $dat['EntryCategory'][0]['name'] . ' を作成しました。', self::STATUS_CODE_BAD_REQUEST));
						return $this->redirect(array('controller' => 'meets', 'action' => 'view', $meetCode));
					} else {
						$this->Flash->set(__('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST));
					}
				}
			}
		}
		
		$this->set('cats', $this->Category->find('list'));
		$this->set('meetCode', $meetCode);
	}
	
	public function write_results($ecatID)
	{
		// ApiManager->execAddEntry() 参考のこと。
		
		if (!$this->EntryCategory->exists($ecatID)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		
		//$this->log('posted ========================================', LOG_DEBUG);
		//$this->log($this->request->data, LOG_DEBUG);
		
		$transaction = $this->TransactionManager->begin();
		
		try {
			$ret = $this->__write_results($ecatID, $this->request->data);
			
			if ($ret === true) {
				$this->TransactionManager->commit($transaction);
				
				$msg = '出走・リザルトの書込およびポイントなどの計算を正常に終了しました。';
				$this->log($msg, LOG_INFO);
				$this->Flash->success($msg);
				return $this->redirect(array('action' => 'view', $ecatID));
			} else {
				$this->TransactionManager->rollback($transaction);
				
				$this->log('出走・リザルトの書込に失敗しました。', LOG_INFO);
				$this->Flash->set('出走・リザルトの書込に失敗しました。');
				if (!empty($ret['err'])) {
					foreach ($ret['err'] as $er) {
						$this->Flash->set($er);
					}
				}
				return $this->redirect(array('action' => 'select_result_file', $ecatID));
			}
		} catch (Exception $ex) {
			$this->TransactionManager->rollback($transaction);
			
			$this->log('予測しないエラーにより終了しました。ex:' . $ex->getMessage(), LOG_ERR);
			$this->Flash->set(__('予測されないエラー' . $ex->getMessage() . 'により、リザルト読込処理はキャンセルされました。'));
			return $this->redirect(array('action' => 'select_result_file', $ecatID));
		}
	}
	
	/**
	 * 
	 * @param type $ecatID
	 * @return true or ['err' => ['mwg', 'mwg',,,]] 正常終了の場合は true を、エラーがあった場合は err をキーとする配列をかえす
	 */
	private function __write_results($ecatID, $entryResultData)
	{
		// 既存 entry racer の削除 - racer_results.soft_delete のため、deleteAll() は使えないのでループを回す。
		$cdt = array('entry_category_id' => $ecatID);
		$ers = $this->EntryRacer->find('list', array('conditions' => $cdt));
		foreach ($ers as $erid => $er) {
			if (!$this->EntryRacer->delete($erid, true)) {
				return array('err' => array('既存出走設定の削除に失敗しました。'));
			}
		}
		
		$meet = $this->__getMeetInfo($ecatID);
		if ($meet === false) {
			return array('err' => array('出走設定から大会情報の取得に失敗しました。'));
		}
		
		// 選手コードが無いデータ（=新規選手）について新規コードを設定する
		$racerCodes = AjoccUtil::nextRacerCodesAt($meet['MeetGroup'], $meet['Meet']['at_date'], 300);
		$codeMap = array(); // key: $entryResultData 内インデックス, val: 新規付与した選手コード
		$rcodei = 0;
		
		foreach ($entryResultData['EntryRacer'] as $index => &$erres) {
			if (empty($erres['racer_code'])) {
				if ($rcodei >= count($racerCodes)) {
					return array('err' => array('選手コードの払い出しができません（可能コードなし or 制限値オーバー）。管理者に連絡をしてください。'));
				}
				$rcode = $racerCodes[$rcodei];
				$erres['racer_code'] = $rcode;
				$rcodei++;
				
				$codeMap[$index] = $rcode;
			}
		}
		unset($erres);

		// entry racer, result の保存
		if (!$this->EntryRacer->saveMany($entryResultData['EntryRacer'], array('atomic' => false, 'deep' => true))) {
			return array('err' => array('出走設定の保存に失敗しました。'));
		}
		
		// +++ 失敗すると面倒な新規選手の登録および書き換え
		$newRacers = array(); // 新規選手
		$newCr = array(); // $newRacers にくっつけられないので cat racer は別工程で保存する
		
		foreach ($entryResultData['Racer'] as $index => $r) {
			if (isset($r['code'])) {
				// 既存値がある場合には生年月日、UCI-ID は書き換えない
				$registed = $this->Racer->find('first', array('conditions' => array('code' => $r['code'])));
				if (empty($registed)) {
					return array('err' => array( 'code:' . $r['code'] . ' の選手（'
							. $r['family_name'] . ' ' . $r['first_name'] . ' が見つからないか削除されています。'));
				}
				
				if (!empty($registed['Racer']['birth_date'])) unset($r['birth_date']);
				if (!empty($registed['Racer']['uci_id'])) unset($r['uci_id']);
			} else {
				// 新規選手コードの払い出し --> 設定
				if (empty($codeMap[$index])) {
					return array('err' => array('選手コードの払い出しができません（可能コードなし or 制限値オーバー）。管理者に連絡をてください。'));
				}
				$rcode = $codeMap[$index];
				$r['code'] = $rcode;
				
				$ky = 'family_name_kana';	if (empty($r[$ky])) $r[$ky] = '';
				$ky = 'first_name_kana';	if (empty($r[$ky])) $r[$ky] = '';
				$ky = 'family_name_en';		if (empty($r[$ky])) $r[$ky] = '';
				$ky = 'first_name_en';		if (empty($r[$ky])) $r[$ky] = '';

				if (isset($r['category_code'])) {
					// category 所属を与える
					// TODO: category_code の存在チェック
					$newCr[] = array(
						'CategoryRacer' => array(
							'racer_code' => $rcode,
							'category_code' => $r['category_code'],
							'apply_date' => $meet['Meet']['at_date'],
							'reason_id' => CategoryReason::$FIRST_REGIST->ID(),
							'reason_note' => 'web リザルト読込による新規選手へのカテゴリー付与',
							'meet_code' => $meet['Meet']['code'],
					));
				}//*/
			}
			
			unset($r['category_code']);
			$newRacers[] = $r;
		}
		
		//$this->log('new racers:', LOG_DEBUG);
		//$this->log($newRacers, LOG_DEBUG);
		
		if (!$this->Racer->saveMany($newRacers, array('atomic' => false))) {
			return array('err' => array('選手データの保存に失敗しました。'));
		}
		if (!$this->CategoryRacer->saveMany($newCr, array('atomic' => false))) {
			return array('err' => array('カテゴリー所属データの保存に失敗しました。'));
		}
		//return array('err' => array('テスト用 return false'));
		
		// リザルト再計算
		$ret = $this->__recalc_result($ecatID);
		
		if ($ret !== true) {
			$errmsg = 'エラー！';
			if (isset($ret['error'])) {
				$errmsg = $ret['error'];
			}
			return array('err' => array($errmsg));
		}		

		return true;
	}
	
	private function __getMeetInfo($ecatID) {
		$opt = array(
			'conditions' => array('EntryCategory.id' => $ecatID),
		);
		$ecat = $this->EntryCategory->find('first', $opt);
		//$this->log('$ecat:', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($ecat['EntryGroup']['meet_code'])) {
			return false;
		}
		
		$mcode = $ecat['EntryGroup']['meet_code'];
		$meet = $this->Meet->find('first', array('conditions' => array('Meet.code' => $mcode)));
		
		if (empty($meet)) {
			return false;
		}
		
		return $meet;
	}
	
	public function select_result_file($ecatID)
	{
		if (!$this->EntryCategory->exists($ecatID)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$options = array(
			'conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $ecatID),
			'recursive' => 0,
		);
		$ecat = $this->EntryCategory->find('first', $options);
		
		$this->set('entryCategory', $ecat);
	}
	
	public function check_result_file($ecatID)
	{
		if (!$this->request->is('post')) {
			$this->Flash->set(__('リザルト読込処理はキャンセルされました。', self::STATUS_CODE_BAD_REQUEST));
			return $this->redirect(array('action' => 'select_result_file', $ecatID));
		}
		
		$filepath = $this->request->data['File']['csv']['tmp_name'];
		
		if (empty($filepath) || !file_exists($filepath)) {
			$this->Flash->set(__('ファイルを指定して下さい。', self::STATUS_CODE_BAD_REQUEST));
			return $this->redirect($this->referer());
		}
		/*
		$txt = file_get_contents($filename);
		$this->log('txt id:', LOG_DEBUG);
		$this->log($txt, LOG_DEBUG); //*/
		
		if (($fp = fopen($filepath, "r")) === false) {
			$this->Flash->set(__('ファイル読込に失敗しました。', self::STATUS_CODE_BAD_REQUEST));
			return $this->redirect($this->referer());
		}
		
		try {
			$results = $this->ResultRead->readResults($fp, $ecatID);
			
			//$this->log('$results is,,,', LOG_DEBUG);
			//$this->log($results, LOG_DEBUG);
			
			$this->set('ecat_id', $ecatID);
			$this->set('results', $results);
			fclose($fp);
		} catch (Exception $ex) {
			$this->Flash->set(__('リザルト読込に失敗しました。' . $ex->getMessage(), self::STATUS_CODE_BAD_REQUEST));
			fclose($fp);
			return $this->redirect($this->referer());
		}
	}
	
	/**
	 * 重複する名前を持つ出走カテゴリーがあるかチェックする
	 * @param type $meetCode
	 * @param type $ecatName
	 * @return boolean 重複するものがある場合 true をかえす。
	 * @throws InternalErrorException
	 */
	private function __checkEcatNameDuplicated($meetCode, $ecatName)
	{
		if (empty($meetCode) || empty($ecatName)) {
			throw new InternalErrorException('引数が不正です。');
		}
		
		$count = $this->EntryCategory->find('count', array('conditions' => array('EntryGroup.meet_code' => $meetCode, 'EntryCategory.name' => $ecatName)));
		
		return $count > 0;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->EntryCategory->exists($id)) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EntryCategory->save($this->request->data)) {
				$this->Flash->set(__('The entry category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The entry category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $id));
			$this->request->data = $this->EntryCategory->find('first', $options);
		}
		$racesCategories = $this->EntryCategory->RacesCategory->find('list');
		$this->set(compact('entryGroups', 'racesCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->EntryCategory->id = $id;
		if (!$this->EntryCategory->exists()) {
			throw new NotFoundException(__('Invalid entry category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EntryCategory->delete()) {
			$this->Flash->set(__('The entry category has been deleted.'));
		} else {
			$this->Flash->set(__('The entry category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	/**
	 * リザルトの再計算を行なう
	 * @param int $ecatId 首相カテゴリー ID
	 * @return boolean
	 */
	public function recalc_result($ecatId = null)
	{
		$this->request->allowMethod('post');
		
		$ret = $this->__recalc_result($ecatId);
		
		if ($ret !== true) {
			$errmsg = 'エラー！';
			if (isset($ret['error'])) {
				$errmsg = $ret['error'];
			}
			return $this->Flash->set($errmsg);
		}
		
		return $this->redirect(array('action' => 'view', $ecatId));
	}
	
	/**
	 * リザルトの再計算を行なう
	 * @param int $ecatId 首相カテゴリー ID
	 * @return boolean
	 */
	private function __recalc_result($ecatId = null)
	{
		if (empty($ecatId)) {
			return array('error' => __('出走カテゴリーが指定されていません。'));
		}
		
		//++++++++++++++++++++++++++++++++++++++++
		// meet point series の有効期間設定
		$opt = array('conditions' => array('EntryCategory.' . $this->EntryCategory->primaryKey => $ecatId));
		$ecat = $this->EntryCategory->find('first', $opt);
		if (empty($ecat)) {
			return array('error' => __('指定された出走カテゴリーが無効です。'));
		}
		
		$ret = $this->MeetPointSeries->setupTermOfSeriesPoint($ecat['EntryGroup']['meet_code'], $ecat['EntryCategory']['name']);
		// Transaction は使用せず
		
		if (!$ret) {
			$this->log("ポイントシリーズの有効期間設定が無効です。（処理は続行します。）", LOG_ERR);
			// not return
		}
		
		$ret = $this->ResultParamCalc->reCalcResults($ecatId);
		
		if (empty($ret)|| $ret == Constant::RET_FAILED) {
			return array('error' => ('処理に失敗しました。'));
		} else if ($ret == Constant::RET_NO_ACTION) {
			return array('error' => __('出走する選手もしくはリザルトが設定されていません。'));
		}
		
		$flag = array(
			'TmpResultUpdateFlag' => array(
				'entry_category_id' => $ecatId,
				'result_updated' => date('Y-m-d H:i:s'),
			)
		);
		
		if (!$this->TmpResultUpdateFlag->save($flag)) {
			$this->log('リザルト更新フラグの保存に失敗しました。', LOG_WARNING);
		}
		
		return true;
	}
}
