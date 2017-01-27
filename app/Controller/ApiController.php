<?php

App::uses('ApiBaseController', 'Controller');

App::uses('Validation', 'Utility');
App::uses('Util', 'Cyclox/Util');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('Gender', 'Cyclox/Const');
App::uses('Constant', 'Cyclox/Const');
App::uses('CategoryReason', 'Cyclox/Const');
App::uses('PointCalculator', 'Cyclox/Util');
App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');

App::uses('PointSeriesController', 'Controller');

/*
 *  created at 2015/06/19 by shun
 */

/**
 * API 入出力のみを扱うコントローラクラス
 *
 * @author shun
 */
class ApiController extends ApiBaseController
{
	public $uses = array('TransactionManager',
		'Meet', 'CategoryRacer', 'Racer', 'MeetGroup', 'Season',
		'EntryGroup', 'EntryCategory', 'EntryRacer', 'RacerResult', 'TimeRecord', 'HoldPoint',
		'PointSeries', 'MeetPointSeries', 'PointSeriesRacer', 'RacesCategory',
		'Category', 'CategoryGroup');
	
	public $components = array('Session', 'RequestHandler', 'ResultParamCalc', 'UnifiedRacer', 'AgedCategory');
	
	/**
	 * 更新すべき大会情報についての code リストを取得する
	 * @param date $date 最後の更新ダウンロード日時
	 */
	public function updated_meet_codes($date = null)
	{
		// http://ajocc.net/api/update_list/2015-12-31.json
		
		if ($date) {
			$dt = $this->__getFindSqlDate($date);
			
			if ($dt) {
				$opt = array('conditions' => array('modified >' => $dt));
				$meets = $this->Meet->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$meets = $this->Meet->find('list');
		}
		
		return $this->success(array('meets' => $meets));
	}
	
	/**
	 * 更新すべき選手カテゴリー情報を取得する
	 * @param date $date 最後の更新ダウンロード日時
	 */
	public function updated_category_racer_ids($date = null)
	{
		if ($date) {
			$this->CategoryRacer->Behaviors->unload('Utils.SoftDelete');
			$dt = $this->__getFindSqlDate($date);
			
			if ($dt) {
				$opt = array('conditions' => array('modified >' => $dt));
				$meets = $this->CategoryRacer->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$meets = $this->CategoryRacer->find('list');
		}
		
		return $this->success(array('category_racers' => $meets));
	}
	
	/**
	 * 更新すべき選手情報（選手コードの配列）を取得する
	 * @param date $date 最後の更新ダウンロード日時、日時指定がない場合、全てのデータを取得する。
	 */
	public function updated_racer_codes($date = null)
	{
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // deleted もひろう
		
		if ($date) {
			$dt = $this->__getFindSqlDate($date);
			
			if ($dt) {
				$opt = array('conditions' => array('modified >' => $dt),'fields' => array('code', 'family_name'));
				$racers = $this->Racer->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$racers = $this->Racer->find('list');
		}
		
		return $this->success(array('racers' => $racers));
	}
	
	/**
	 * 更新すべき大会グループ（大会グループコードの配列）を取得する
	 * @param type $date 最後の更新ダウンロード日時
	 */
	public function updated_meet_group_codes($date = null)
	{
		if ($date) {
			$dt = $this->__getFindSqlDate($date);
			
			if ($dt) {
				$opt = array('conditions' => array('modified >' => $dt),'fields' => array('code', 'name'));
				$mg = $this->MeetGroup->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$mg = $this->MeetGroup->find('list');
		}
		
		return $this->success(array('meet_groups' => $mg));
	}
	
	public function updated_season_ids($date = null)
	{
		if ($date) {
			$dt = $this->__getFindSqlDate($date);
			
			if ($dt) {
				$opt = array('conditions' => array('modified >' => $dt),'fields' => array('id', 'name'));
				$season = $this->Season->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$season = $this->Season->find('list');
		}
		
		return $this->success(array('seasons' => $season));
	}
	
	/**
	 * 結果に関する現在の ID をまとめて取得する
	 * @param string $meetCode 大会コード
	 * @param string $ecatName 出走カテゴリー名
	 * @return void
	 */
	public function ecat_body_id($meetCode, $ecatName)
	{
		 if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}

		$egroups = $this->EntryGroup->find('all', array('conditions' => array('meet_code' => $meetCode)));
		if (empty($egroups)) {
			return $this->error('大会が見つかりません。', self::STATUS_CODE_BAD_REQUEST);
		}
		//$this->log($egroups, LOG_DEBUG);

		$ecat = null;
		$breaks = false;
		foreach ($egroups as $egroup) {
			foreach ($egroup['EntryCategory'] as $ec) {
				if ($ec['name'] === $ecatName) {
					$ecat = $ec; // 複数ヒットをエラーとする？ -> No. 登録で重複させないように
					$breaks = true;
					break;
				}
			}

			if ($breaks) break;
		}

		if (empty($ecat)) {
			return $this->error("出走カテゴリーが見つかりません。", self::STATUS_CODE_BAD_REQUEST);
		}

		$conditions = array(
			'conditions' => array('entry_category_id' => $ecat['id']),
			'recursive' => -1,
			'fields' => array('id', 'body_number')
		);
		$eracers = $this->EntryRacer->find('all', $conditions);
		//$this->log($eracers, LOG_DEBUG);

		if (empty($eracers)) {
			return $this->error("出走カテゴリーに選手が設定されていません。", self::STATUS_CODE_BAD_REQUEST);
		}

		$erMap = array();
		
		//$this->log($eracers, LOG_DEBUG);

		foreach ($eracers as $eracer) {
			$erMap[$eracer['EntryRacer']['body_number']] = $eracer['EntryRacer']['id'];
		}

		return $this->success(array(
			'body-eracer_svr_id' => $erMap,
		));
	}
	
	/**
	 * 出走設定を追加する
	 */
	public function add_entry()
	{
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		
		if (empty($this->request->data['entry_group'])) {
			return $this->error('出走グループキー "entry_group" がありません。', self::STATUS_CODE_BAD_REQUEST);
		}
		if (empty($this->request->data['entry_cats'])) {
			return $this->error('出走グループキー "entry_cats" がありません。', self::STATUS_CODE_BAD_REQUEST);
		}
		
		$duplicatedEcatNames = array();
		
		// 出走グループ名が同じものがあった場合、出走データ + リザルトを除去する。
		if (!empty($this->request->data['entry_group']['EntryGroup']['name']) &&
				!empty($this->request->data['entry_group']['EntryGroup']['meet_code'])) {
			$egroupName = $this->request->data['entry_group']['EntryGroup']['name'];
			$meetCode = $this->request->data['entry_group']['EntryGroup']['meet_code'];
			
			// 出走グループ名が異なり、同じ名前の出走カテゴリーがある場合には警告（出走グループ名同じなら下流で削除）
			$egroups = $this->EntryGroup->find('all', array('conditions' => array('meet_code' => $meetCode)));
			$cats = $this->request->data['entry_cats'];
			if (is_array($cats) && !emptY($cats)) {
				foreach ($cats as $cat) {
					//$this->log('vs ' . $egroupName . 'ofEcat:' . $cat['EntryCategory']['name'], LOG_DEBUG);
					foreach ($egroups as $egroup) {
						//$this->log('egroupName:' . $egroup['EntryGroup']['name'], LOG_DEBUG);
						if ($egroup['EntryGroup']['name'] === $egroupName) continue; // これから削除するものは除く
						foreach ($egroup['EntryCategory'] as $e) {
							//$this->log('e-name:' . $e['name'], LOG_DEBUG);
							if ($cat['EntryCategory']['name'] === $e['name']) {
								$duplicatedEcatNames[] = $e['name'];
								break;
							}
						}
					}
				}
			}
			
			// 同じ名前の出走グループを削除
			$opt = array('conditions' => array('name' => $egroupName, 'meet_code' => $meetCode));
			$oldGroups = $this->EntryGroup->find('list', $opt);
			
			// MORE: 除去する前に表示のための格納
			// および旧カテゴリーデータの復旧
			// リストに格納、あとで表示。
			if (!empty($oldGroups)) {
				foreach ($oldGroups as $key => $val) {
					
				}
			}
			
			// oldGroups に関連づいている昇格データについて除去 <-- EntryGroup->delete() から削除。
			
			if (!empty($oldGroups)) {
				foreach ($oldGroups as $key => $val)
				{
					$this->EntryGroup->delete($key);
					// 失敗しない？
				}
			}			
		}
		
		$transaction = $this->TransactionManager->begin();
		
		try {
			$this->EntryGroup->create();
			if (!$this->EntryGroup->save($this->request->data['entry_group'])) {
				$this->TransactionManager->rollback($transaction);
				return $this->error('出走グループの保存に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}
			
			$cats = $this->request->data['entry_cats'];
			
			if (is_array($cats) && !emptY($cats)) {
				foreach ($cats as $cat) {
					$this->EntryCategory->create();
					
					foreach ($cat['EntryRacer'] as &$er) {
						$trueCode = $this->UnifiedRacer->trueRacerCode($er['racer_code']);
						if (!empty($trueCode)) {
							$this->log('add_entry - EntryRacer[name:' . $er['name_at_race'] . ']の選手コードを' 
									. $er['racer_code'] . '→' . $trueCode . 'に変換しました。', LOG_DEBUG);
							$er['racer_code'] = $trueCode;
						}
					}
					unset($er);
					
					$cat['EntryCategory']['entry_group_id'] = $this->EntryGroup->id;
					//$this->log('cat:', LOG_DEBUG);
					//$this->log($cat, LOG_DEBUG);
					if (!$this->EntryCategory->saveAssociated($cat)) {
						$this->TransactionManager->rollback($transaction);
						return $this->error('出走カテゴリーの保存に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
					}
				}
			}
			
			$this->TransactionManager->commit($transaction);
			
			if (empty($duplicatedEcatNames)) {
				return $this->success(array('ok')); // 件数とか？
			} else {
				return $this->success(array('duplidated_entry_category' => $duplicatedEcatNames));
			}
		} catch (Exception $ex) {
			$this->log('exception:' . $ex.message, LOG_DEBUG);
			$this->TransactionManager->rollback($transaction);
			return $this->error('予期しないエラー:' . $ex, self::STATUS_CODE_BAD_REQUEST);
		}
		
	}
	
	/**
	 * 結果を upload する
	 * @param string $meetCode 大会コード
	 * @param string $ecatName 出走カテゴリー名
	 * @return void
	 */
	public function add_result($meetCode = null, $ecatName = null)
	{
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		
		if (emptY($meetCode) || empty($ecatName)) {
			return $this->error('大会 Code または出走カテゴリー名が指定されていません。', self::STATUS_CODE_BAD_REQUEST);
		}
		
		if (!isset($this->request->data['body-result'])) {
			return $this->error('"body-result" の値が設定されていません。', self::STATUS_CODE_BAD_REQUEST);
		}
		
		// 出走カテゴリーの特定
		
		$opt = array(
			'conditions' => array('meet_code' => $meetCode),
			'order' => array('EntryGroup.modified' => 'desc')
			// 新しい方の出走グループを使用する。出走グループ名前変更対策。
		);
		$egroups = $this->EntryGroup->find('all', $opt);
		if (empty($egroups)) {
			return $this->error('大会が見つかりません。', self::STATUS_CODE_BAD_REQUEST);
		}
		
		$ecats = array();
		foreach ($egroups as $egroup) {
			foreach ($egroup['EntryCategory'] as $ec) {
				if ($ec['deleted'] == 0 && $ec['name'] === $ecatName) { // ecat.deleted は出てこない
					$ecats[] = $ec;
				}
			}
		}
		unset($ec);

		if (empty($ecats)) {
			return $this->error("出走カテゴリーが見つかりません。", self::STATUS_CODE_BAD_REQUEST);
		}
		
		// modified が一番新しいものを
		$ecat = $ecats[0];
		for ($i = 1; $i < count($ecats); $i++) {
			$ec = $ecats[$i];
			if ($ec['modified'] > $ecat['modified']) {
				$ecat = $ec;
			}
		}
		
		//++++++++++++++++++++++++++++++++++++++++
		// meet point series の有効期間設定
		$ret = $this->__setupTermOfSeriesPoint($meetCode, $ecatName);
		// Transaction は使用せず
		
		if (!$ret) {
			$this->log("ポイントシリーズの有効期間設定が無効です。（処理は続行します。）", LOG_ERR);
			// not return
		}
		
		//++++++++++++++++++++++++++++++++++++++++
		// 各個人の成績
		
		// 出走選手取得
		$conditions = array(
			'conditions' => array('entry_category_id' => $ecat['id'])
		);
		$eracers = $this->EntryRacer->find('all', $conditions);
		
		if (empty($eracers)) {
			return $this->error("出走カテゴリーに選手が設定されていません。", self::STATUS_CODE_BAD_REQUEST);
		}
		
		$erMap = array(); // key:body value entry_racer
		foreach ($eracers as $eracer) {
			$erMap[$eracer['EntryRacer']['body_number']] = $eracer;
		}
		
		$opt = array('conditions' => array('code' => $meetCode), 'recursive' => -1);
		$meet = $this->Meet->find('first', $opt);
		
		// メイン処理
		
		$errs = array(); // 保存処理後の result param 計算&設定用
		
		$transaction = $this->TransactionManager->begin();
		try {
			// 現在ある全てのリザルトデータを削除
			foreach ($eracers as $er) {
				if (!empty($er['RacerResult']['id'])) {
					$result_id = $er['RacerResult']['id'];
					
					if (!$this->RacerResult->exists($result_id)) {
						continue;
					}
				
					if (!$this->RacerResult->delete($result_id)) {
						$this->TransactionManager->rollback($transaction);
						return $this->error('リザルトの削除に失敗しました（想定しないエラー）。', self::STATUS_CODE_BAD_REQUEST);
					}
				}
			}
			
			// entry racer の有無をチェック
			foreach ($this->request->data['body-result'] as $body => $result) {
				if (empty($erMap[$body])) {
					$this->TransactionManager->rollback($transaction);
					return $this->error("無効な BodyNo. の設定が存在します。\n"
						. "出走データとリザルトをチェックして下さい。\n"
						. "（出走設定を再度 upload すると解決する場合があります。）", self::STATUS_CODE_BAD_REQUEST);
				}
			}
			
			$ress = array();
			
			foreach ($this->request->data['body-result'] as $body => $result) {
				$er = $erMap[$body];
				
				// リザルトの保存
				$this->RacerResult->create();
				$result['RacerResult']['entry_racer_id'] = $er['EntryRacer']['id'];
				$result['RacerResult']['as_category']
						= $this->ResultParamCalc->asCategory($er['EntryRacer']['racer_code'], $ecat, $meet['Meet']['at_date']);
				
				/*if (!$this->RacerResult->saveAssociated($result)) {
					$this->TransactionManager->rollback($transaction);
					return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
				}//*/
				$ress[] = $result;
				
				//$this->log('new result id:' . $this->RacerResult->id, LOG_DEBUG);
				$result['RacerResult']['id'] = $this->RacerResult->id;
				
				$err = array();
				$err['EntryRacer'] = $erMap[$body]['EntryRacer'];
				$err['RacerResult'] = $result['RacerResult'];
				$errs[] = $err;
			}
			
			//$this->log('results is,,,', LOG_DEBUG);
			//$this->log($ress, LOG_DEBUG);
			
			if (!$this->RacerResult->saveAll($ress, array('deep' => true))) {
				$this->TransactionManager->rollback($transaction);
				return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
			}//*/
			
			//$this->log('end', LOG_DEBUG);
			$this->TransactionManager->commit($transaction);
		} catch (Exception $ex) {
			$this->log('exception:' . $ex.message, LOG_DEBUG);
			$this->TransactionManager->rollback($transaction);
			return $this->error('予期しないエラー:' . $ex, self::STATUS_CODE_BAD_REQUEST);
		}
		
		if (count($errs) == 0) {
			$this->log('リザルトが設定されていません。', LOG_DEBUG);
		} else {
			$this->ResultParamCalc->reCalcResults($ecat['id']);
		}
		
		return $this->success(array('ok')); // 件数とか？
	}
	
	private function __setupTermOfSeriesPoint($meetCode, $ecatName)
	{
		if (empty($meetCode) || empty($ecatName)) {
			return false;
		}
		
		$opt = array(
			'conditions' => array(
				'meet_code' => $meetCode,
				'entry_category_name' => $ecatName
			)
		);
		$mpss = $this->MeetPointSeries->find('all', $opt);
		
		if (empty($mpss)) {
			return true;
		}
		
		foreach ($mpss as $mps) {
			$termRuleVal = $mps['PointSeries']['point_term_rule'];
			$rule = PointSeriesTermOfValidityRule::ruleAt($termRuleVal);
			if (is_null($rule)) {
				$this->log('期間設定ルールを設定できません。', LOG_DEBUG);
				return false;
			}
			
			if (!empty($rule)) {
				$term = $rule->calc($mps['Meet']['at_date']);
				
				$newMps = array();
				$newMps['MeetPointSeries'] = array();
				
				if (!empty($term['begin'])) {
					$newMps['MeetPointSeries']['point_term_begin'] = $term['begin'];
				} else {
					$newMps['MeetPointSeries']['point_term_begin'] = null;
				}
				if (!empty($term['end'])) {
					$newMps['MeetPointSeries']['point_term_end'] = $term['end'];
				} else {
					$newMps['MeetPointSeries']['point_term_end'] = null;
				}
				
				//$this->log($mps, LOG_DEBUG);
				
				if (!empty($term['begin']) || !empty($term['end'])) {
					$this->MeetPointSeries->id = $mps['MeetPointSeries']['id'];
					$ret = $this->MeetPointSeries->save($newMps);
					
					if (!$ret) {
						$this->log('MeetPointSeries の保存に失敗しました。', LOG_ERR);
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	/**
	 * 次に払出す選手コードをかえす
	 * @param string $meetGroupCode 大会グループコード
	 * @param string $seasonNumber シーズンナンバー 156, 167 など。未指定ならば現在シーズンの値が使用される。
	 */
	public function next_racer_code_number($meetGroupCode = null, $seasonNumber = null)
	{
		if (empty($meetGroupCode)) {
			throw new BadRequestException('meet_group_code is needed.');
		}
		
		// intval で string 先頭のゼロは除去される。
		
		$snumberStr = $seasonNumber;
		if (empty($snumberStr)) {
			$snumberStr = AjoccUtil::seasonExp();
		} else if (strlen($snumberStr) != 3) {
			throw new BadRequestException('season_number should be length=3 and integer');
		}
		
		// MORE: 検証処理の一般化
		
		// 値の検証
		$sn = intval($snumberStr);
		if ($snumberStr !== '000') {
			// 小数は考えないことにする。
			if (!is_numeric($snumberStr) || $sn === false) {
				throw new BadRequestException('season_number should be length=3 and integer');
			}

			$pre = (int)($sn / 10);
			$next = $sn % 10;
			//$this->log('pre:' . $pre . ' next:' . $next, LOG_DEBUG);

			if ((int)(($pre % 10 + 1) % 10) != $next) {
				throw new BadRequestException('season_number is bad formatted');
			}
		}
		
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // contains delete
		$racers = $this->Racer->find('list', array(
			'fields' => array('code'),
			'recursive' => -1,
			'conditions' => array('code LIKE' => $meetGroupCode . '-' . $snumberStr . '-%'),
			'order' => array('code' => 'ASC'),
		));
		
		// 最大値を求める
		$max = -1;
		foreach ($racers as $code) {
			// イレギュラーな選手コードも想定しておこう
			if (substr_count($code, '-') != 2) {
				continue;
			}
			
			$strs = explode('-', $code);
			$numStr = $strs[2];
			
			if (!is_numeric($numStr)) {
				continue;
			}
			
			$num = intval($numStr);
			if ($num === 0) {
				continue;
			}
			
			//$this->log('max:' . $max . ' num:' . $num, LOG_DEBUG);
			if ($max > 0 && $num != $max + 1) {
				break;
			}
			
			$max = $num;
		}
		
		if ($max === -1) {
			return $this->success(array('racer_code_next_number' => 1));
		} else {
			return $this->success(array('racer_code_next_number' => $max + 1));
		}
	}
	
	/**
	 * 
	 * @param type $meetGroupCode
	 * @param type $seasonExp
	 * @param type $minNumber
	 * @return array 
	 */
	public function racer_code_4tails($meetGroupCode = null, $seasonExp = null)
	{
		if (empty($meetGroupCode) || empty($seasonExp)) {
			$this->error('大会グループもしくはシーズンの指定が無効です。', self::STATUS_CODE_BAD_REQUEST);
		}
		
		$snumberStr = $seasonExp;
		if (empty($snumberStr)) {
			$snumberStr = AjoccUtil::seasonExp();
		} else if (strlen($snumberStr) != 3) {
			$this->error('season_number should be length=3 and integer', self::STATUS_CODE_BAD_REQUEST);
		}
		
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // contains deleted
		$racers = $this->Racer->find('list', array(
			'fields' => array('code'),
			'recursive' => -1,
			'conditions' => array('code LIKE' => $meetGroupCode . '-' . $snumberStr . '-%'),
		));
		
		$codes = array();
		foreach ($racers as $code)
		{
			$codes[] = $code;
		}
		
		return $this->success(array('codes' => $codes));
	}
	
	/**
	 * 更新のあった選手データを取得する。
	 * 
	 * QUERY: int $offset 取得するデータ上のオフセット。デフォルト値はゼロ
	 * QUERY: int $limit 取得するデータの件数。デフォルト値は30。
	 * QUERY: date $date これより後に更新された選手データが取得される。指定なしの場合、全てのデータを対象とする。
	 * RETURN: 選手データの配列 'response' => array('racers' => array([] => array('Racer' => $DATA,,,
	 */
	public function updated_racers()
	{	
		//$this->log('offset params is:', LOG_DEBUG);
		//$this->log($this->params->query, LOG_DEBUG);
		
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // deleted もひろう
		
		$offset = 0;
		if (!empty($this->params->query['offset'])) {
			$offset = $this->params->query['offset'];
		}
		
		$limit = 30;
		if (!empty($this->params->query['limit'])) {
			$limit = $this->params->query['limit'];
		}
		
		$opt = array(
			'recursive' => -1,
		);
		
		if (!empty($this->params->query['date'])) {
			$dt = $this->__getFindSqlDate($this->params->query['date']);
			if (!$dt) {
				throw new BadRequestException('argument "date" should be Date formatted by YY-MM-dd-HH-mm-ss');
			}
			
			$opt['conditions'] = array(
				'modified >' => $dt
			);
		}
		
		$count = $this->Racer->find('count', $opt);
		
		$opt['offset'] = $offset;
		$opt['limit'] = $limit;
		$racers = $this->Racer->find('all', $opt);
		
		return $this->success(array('racers' => $racers, 'total' => $count));
	}
	
	/**
	 * 更新のあった選手カテゴリー所属データを取得する。
	 * 
	 * QUERY: int $offset 取得するデータ上のオフセット。デフォルト値はゼロ
	 * QUERY: int $limit 取得するデータの件数。デフォルト値は30。
	 * QUERY: date $date これより後に更新された選手データが取得される。指定なしの場合、全てのデータを対象とする。
	 * RETURN: 選手データの配列 'response' => array('category_racers' => array([] => array('CategoryRacer' => $DATA,,,
	 */
	public function updated_category_racers()
	{	
		//$this->log('offset params is:', LOG_DEBUG);
		//$this->log($this->params->query, LOG_DEBUG);
		
		$offset = 0;
		if (!empty($this->params->query['offset'])) {
			$offset = $this->params->query['offset'];
		}
		
		$limit = 30;
		if (!empty($this->params->query['limit'])) {
			$limit = $this->params->query['limit'];
		}
		
		$opt = array(
			'recursive' => -1,
		);
		
		if (!empty($this->params->query['date'])) {
			$dt = $this->__getFindSqlDate($this->params->query['date']);
			if (!$dt) {
				throw new BadRequestException('argument "date" should be Date formatted by YY-MM-dd-HH-mm-ss');
			}
			
			$opt['conditions'] = array(
				'modified >' => $dt
			);
		}
		
		$this->CategoryRacer->Behaviors->unload('Utils.SoftDelete'); // deleted もひろう
		$count = $this->CategoryRacer->find('count', $opt);
		
		$opt['offset'] = $offset;
		$opt['limit'] = $limit;
		$catRacers = $this->CategoryRacer->find('all', $opt);
		
		return $this->success(array('category_racers' => $catRacers, 'total' => $count));
	}
	
	/**
	 * SQL 条件に必要な日付オブジェクトをかえす
	 * @param type $dateStr 日付の文字列表現
	 * @return boolean 返還後文字列もしくは false をかえす
	 */
	private function __getFindSqlDate($dateStr)
	{
		if ($dateStr)
		{
			$dt = DateTime::createFromFormat('Y-m-d-H-i-s', $dateStr);
			if ($dt)
			{
				return date_format($dt, 'Y-m-d H:i:s');
			}
		}
		
		return false;
	}
	
	/**
	 * 選手データまとめて upload API
	 * @throws BadRequestException .json 拡張子無しでのアクセス時
	 */
	public function upload_racers()
	{
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		
		//$this->log($this->request->data, LOG_DEBUG);
		
		// MEMO: saveMany では deleted を勘案してくれない。
		// よってループで保存すべきものだけを抽出して saveMany する。
		// deleted な選手の更新の場合は変更適用し、deleted でなくする
		
		if (is_array($this->request->data)) {
			$this->Racer->Behaviors->unload('Utils.SoftDelete');
			
			foreach ($this->request->data as $racerMap)	{
				if (empty($racerMap['Racer'])) {
					return $this->error('key:Racer not found.', self::STATUS_CODE_BAD_REQUEST);
				}
				$r = $racerMap['Racer'];
				if (empty($r['code'])) {
					return $this->error('key:Racer.code not found.', self::STATUS_CODE_BAD_REQUEST);
				}
				
				// team の空入力での書換えは無しとする（Cyclox2 App ver1.10 のバグ対策）
				// --> @ver1.20 時間が経過したので上記対策をキャンセルとする。@20161224
				//		逆にチーム名を empty にできないため、不都合となった。
				if (isset($racerMap['Racer']['team'])) {
					if (Validation::email($racerMap['Racer']['team'])) {
						$this->log('チーム名:' . $racerMap['Racer']['team'] . 'を空に設定します', LOG_INFO);
						unset($racerMap['Racer']['team']);
					}
				}
				if (isset($racerMap['Racer']['team_en'])) {
					if (Validation::email($racerMap['Racer']['team_en'])) {
						$this->log('team(em):' . $racerMap['Racer']['team_en'] . 'を空に設定します', LOG_INFO);
						unset($racerMap['Racer']['team_en']);
					}
				}
				//$this->log('racer:', LOG_DEBUG);
				//$this->log($racerMap['Racer'], LOG_DEBUG);
				
				$this->log('code:' . $r['code'] . 'について処理', LOG_INFO);
				
				if (!$this->Racer->exists($r['code'])) {
					$this->log('not exists', LOG_INFO);
					if (empty($r['family_name'])) $racerMap['Racer']['family_name'] = '_姓が未入力です';
					if (empty($r['first_name'])) $racerMap['Racer']['first_name'] = '_名前が未入力です';

					if (empty($r['family_name_kana'])) $racerMap['Racer']['family_name_kana'] = '';
					if (empty($r['family_name_en'])) $racerMap['Racer']['family_name_en'] = '';
					if (empty($r['first_name_kana'])) $racerMap['Racer']['first_name_kana'] = '';
					if (empty($r['first_name_en'])) $racerMap['Racer']['first_name_en'] = '';
					
					if (!isset($r['gender'])) $racerMap['Racer']['gender'] = Gender::$UNASSIGNED->val();
				}
				
				// deleted => not deleted に設定し、変更も適用。
				//$this->log('code:' . $r['code'] . ' is exists(deleted)', LOG_DEBUG);
				$racerMap['Racer']['deleted'] = 0;
				$racerMap['Racer']['deleted_date'] = null;

				if (!$this->Racer->save($racerMap)) {
					return $this->error('Saving (deleted)racers failed.', self::STATUS_CODE_BAD_REQUEST);
				}

				// aged category の保存
				if (!$this->AgedCategory->checkAgedCategory($r['code'], date('Y-m-d'), true)) {
					$this->log('Aged Category の保存に失敗しました。', LOG_ERR);
					// not return false
				}
			}
			
			return $this->success('ok');
		}
		
		return $this->error('Saving racers failed.', self::STATUS_CODE_BAD_REQUEST);
	}
	
	/**
	 * 選手データまとめて upload API
	 * @throws BadRequestException .json 拡張子無しでのアクセス時
	 */
	public function upload_racers_2()
	{
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		if (!is_array($this->request->data)) {
			return $this->error('Saving racers failed.', self::STATUS_CODE_BAD_REQUEST);
		}
		
		//$this->log($this->request->data, LOG_DEBUG);
		
		$this->Racer->Behaviors->unload('Utils.SoftDelete');
		
		foreach ($this->request->data as $code => $diffs) {
			$isNewRacer = false;
			$originalRacer = null;
			$newDiff = array('Racer' => array());
			
			//$this->log('diff map is,,,', LOG_DEBUG);
			//$this->log($diffs, LOG_DEBUG);
			foreach ($diffs as $diffMap) {
				if (empty($diffMap['created']) || empty($diffMap['diff'])) {
					return $this->error('key:diff/created not found.', self::STATUS_CODE_BAD_REQUEST);
				}
				
				if (!empty($diffMap['is_new_racer'])) {
					$isNewRacer = true;
				}

				if ($isNewRacer) {
					// 全ての項目をそのまま書き込み
					foreach ($diffMap['diff']['Racer'] as $key => $val) {
						$newDiff['Racer'][$key] = $val;
					}
				} else {
					// データ更新日時が古いものは元データで空の箇所だけ書込
					if (empty($originalRacer)) {
						$opt = array(
							'conditions' => array('code' => $code),
							'recursive' => -1
						);
						$originalRacer = $this->Racer->find('first', $opt);
						if (empty($originalRacer)) {
							return $this->error('Racer:' . $code . ' is not new racer.', self::STATUS_CODE_BAD_REQUEST);
						}
						
						//$this->log('original:', LOG_DEBUG);
						//$this->log($originalRacer, LOG_DEBUG);
					}
					
					if ($diffMap['created'] < $originalRacer['Racer']['modified']) {
						// 古いデータのため、空値埋めだけにする。
						foreach ($diffMap['diff']['Racer'] as $key => $val) {
							if ($key == 'gender') { // gender の場合のみ 0=male があるので特別処理
								$g = $originalRacer['Racer']['gender'];
								if ($g == null || $g == Gender::$UNASSIGNED->val()) {
									$newDiff['Racer'][$key] = $val;
								}
							} else if (empty($originalRacer['Racer'][$key])
									&& $originalRacer['Racer'][$key] !== '0') { // '0' という値は許可
								$newDiff['Racer'][$key] = $val;
							}
						}
					} else {
						foreach ($diffMap['diff']['Racer'] as $key => $val) {
							//$this->log('key:' . $key . ' val:' . $val, LOG_DEBUG);
							$newDiff['Racer'][$key] = $val;
						}
					}
				}
				
				// team 名が mail 形式の場合に空にする
				if (isset($newDiff['Racer']['team'])) {
					if (Validation::email($newDiff['Racer']['team'])) {
						$this->log('チーム名:' . $newDiff['Racer']['team'] . 'を空に設定します', LOG_INFO);
						unset($newDiff['Racer']['team']);
					}
				}
				if (isset($newDiff['Racer']['team_en'])) {
					if (Validation::email($newDiff['Racer']['team_en'])) {
						$this->log('team(en):' . $newDiff['Racer']['team_en'] . 'を空に設定します', LOG_INFO);
						unset($newDiff['Racer']['team_en']);
					}
				}
				
				if (!$this->Racer->exists($code)) {
					$this->log('not exists', LOG_INFO);
					$r = $newDiff['Racer'];
					
					if (empty($r['family_name'])) $newDiff['Racer']['family_name'] = '_姓が未入力です';
					if (empty($r['first_name'])) $newDiff['Racer']['first_name'] = '_名前が未入力です';

					if (empty($r['family_name_kana'])) $newDiff['Racer']['family_name_kana'] = '';
					if (empty($r['family_name_en'])) $newDiff['Racer']['family_name_en'] = '';
					if (empty($r['first_name_kana'])) $newDiff['Racer']['first_name_kana'] = '';
					if (empty($r['first_name_en'])) $newDiff['Racer']['first_name_en'] = '';

					if (!isset($r['gender'])) $newDiff['Racer']['gender'] = Gender::$UNASSIGNED->val();
				}
			}
			
			if (empty($newDiff['Racer'])) continue;
			
			$newDiff['Racer']['code'] = $code;
			
			//$this->log('code:' . $code . 'について処理', LOG_INFO);
			//$this->log($newDiff, LOG_DEBUG);

			// deleted => not deleted に設定し、変更も適用。
			//$this->log('code:' . $r['code'] . ' is exists(deleted)', LOG_DEBUG);
			$newDiff['Racer']['deleted'] = 0;
			$newDiff['Racer']['deleted_date'] = null;

			if (!$this->Racer->save($newDiff)) {
				return $this->error('Saving (deleted)racers failed.', self::STATUS_CODE_BAD_REQUEST);
			}

			// aged category の保存
			if (!$this->AgedCategory->checkAgedCategory($code, date('Y-m-d'), true)) {
				$this->log('Aged Category の保存に失敗しました。', LOG_ERR);
				// not return false
			}
		}

		return $this->success('ok');
	}
	
	/**
	 * カテゴリー所属をまとめて upload API。
	 * post body により CategoryRacer を更新する。レスポンスはリクエストの配列位置に対応する
	 * ID (on svr) が格納される。
	 * @throws BadRequestException .json 拡張子無しでのアクセス時
	 */
	public function upload_category_racers()
	{
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		
		// MEMO: saveMany では deleted を勘案してくれない。
		// よってループで保存すべきものだけを抽出してから saveMany する。
		
		if (is_array($this->request->data)) {
			$saveCatRacers = array(); // 保存対象のみ格納する（deleted は除外）
			$deletedIndexList = array();
			$deletedIds = array();
			$index = 0;
			
			foreach ($this->request->data as $crMap)	{
				if (empty($crMap['CategoryRacer'])) {
					return $this->error('key:Racer not found.', self::STATUS_CODE_BAD_REQUEST);
				}
				$cr = $crMap['CategoryRacer'];
				
				$this->CategoryRacer->Behaviors->load('Utils.SoftDelete');
				
				if (!emptY($cr['id']) && $this->CategoryRacer->exists($cr['id'])) {
					$saveCatRacers[] = $crMap;
					//$this->log('id:' . $cr['id'] . ' is exists(not del', LOG_DEBUG);
				} else {
					$this->CategoryRacer->Behaviors->unload('Utils.SoftDelete');
					if (!emptY($cr['id']) && $this->CategoryRacer->exists($cr['id'])) {
						// deleted = 別個に save
						$deletedIndexList[] = $index;
						$deletedIds[] = $cr['id'];
						//$this->log('id:' . $cr['id'] . ' is exists but deleted', LOG_DEBUG);
						
						$crMap['CategoryRacer']['deleted'] = 0;
						$crMap['CategoryRacer']['deleted_date'] = null;
						//$this->log('crMap:', LOG_DEBUG);
						//$this->log($crMap, LOG_DEBUG);
						
						if (!$this->CategoryRacer->save($crMap)) {
							return $this->error('Saving (deleted)category-racers failed.', self::STATUS_CODE_BAD_REQUEST);
						}
					} else {
						// 新規選手登録
						$saveCatRacers[] = $crMap;
						//$this->log('index:' . $index . ' is new racer', LOG_DEBUG);
					}
				}
				++$index;
			}
			
			$this->CategoryRacer->resetUpdatedIdList();
			
			if (empty($saveCatRacers) || $this->CategoryRacer->saveMany($saveCatRacers)) {
				$idList = $this->CategoryRacer->getUpdatedIdList();
				
				// 削除された位置に 'deleted' を挿入
				for ($i = 0; $i < count($deletedIndexList); $i++) {
					array_splice($idList, $deletedIndexList[$i], 0, $deletedIds[$i]);
				}
				
				return $this->success(array('id_list' => $idList));
			}
		}
		
		return $this->error('Saving category-racers failed.', self::STATUS_CODE_BAD_REQUEST);
	}
	
	/**
	 * 基礎データの更新情報を取得する。基準日付に対して更新したデータがあれば全データをかえす。
	 */
	public function updated_base_data()
	{
		if (!$this->_isApiCall()) { // post は許可
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		
		// category
		// cateogry_group
		// meet_group
		// races_category
		// season
		
		// deleted は拾わない
		
		$opt = array('recursive' => -1);
		
		if (!empty($this->request->query['date'])) {
			$dt = $this->__getFindSqlDate($this->request->query['date']);
			if (!$dt) {
				return $this->error('日時表現が不正です。', self::STATUS_CODE_BAD_REQUEST);
			}
			
			$opt['conditions'] = array(
				'modified >' => $dt
			);
		}
		
		$apiRes = array();
		
		$catCount = $this->Category->find('count', $opt);
		if ($catCount > 0) {
			$cats = $this->Category->find('all', array('recursive' => -1));
			if (!empty($cats)) {
				$apiRes['category'] = $cats;
			}
		}
		
		$cgCount = $this->CategoryGroup->find('count', $opt);
		if ($cgCount > 0) {
			$cgs = $this->CategoryGroup->find('all', array('recursive' => -1));
			if (!empty($cgs)) {
				$apiRes['category_group'] = $cgs;
			}
		}
		
		$mgCount = $this->MeetGroup->find('count', $opt);
		if ($mgCount > 0) {
			$mgs = $this->MeetGroup->find('all', array('recursive' => -1));
			if (!empty($mgs)) {
				$apiRes['meet_group'] = $mgs;
			}
		}
		
		$seasonCount = $this->Season->find('count', $opt);
		if ($seasonCount > 0) {
			$seasons = $this->Season->find('all', array('recursive' => -1));
			if (!empty($seasons)) {
				$apiRes['season'] = $seasons;
			}
		}
		
		// qualifiedCatCodes を別立てで付加する
		$rcCount = $this->RacesCategory->find('count', $opt);
		if ($rcCount > 0) {
			$this->RacesCategory->unbindModel(array(
				'hasMany' => array('EntryCategory')
			));
			$rcs = $this->RacesCategory->find('all');
			$racesCats = array();
			
			foreach ($rcs as $rc) {
				if (!empty($rc['CategoryRacesCategory'])) {
					$rcs['RacesCategory']['qualifiedCatCodes'] = array();
					foreach ($rc['CategoryRacesCategory'] as $crc) {
						$rc['RacesCategory']['qualifiedCatCodes'][] = $crc['category_code'];
					}

					unset($rc['CategoryRacesCategory']);
				}
				$racesCats[] = $rc;
			}
			
			//$this->log('rcs', LOG_DEBUG);
			//$this->log($racesCats, LOG_DEBUG);
			
			if (!empty($racesCats)) {
				$apiRes['races_category'] = $racesCats;
			}
		}
		
		return $this->success($apiRes);
	}
	
	/**
	 * ポイントシリーズのランキングにより並び替えられた結果をかえす。
	 * post body からポイントシリーズを取得する。
	 * @throws BadRequestException .json 拡張子無しでのアクセス時
	 */
	public function sorted_by_series()
	{
		/** リクエスト
        {
            "date": "2015-9-8",
            "series": [
                { "type":"series", "id": 12 }, <-- シリーズ指定
                { "type":"ajocc_pt", "season": 4, "category": "CL1"} <-- AjoccPt 指定
            ],
            "racer": [
                "CCM-156-0023", "KNS-000-9822",
            ]
        }
		//*/
		
		/* レスポンス
         * インデックス値はリクエストでのシリーズ指定と一致する
        {
            "sorted"; {
                "KNS-000-2245": [
                    { "rank":1, "exp":"33pt" }, <-- series
					114, <-- Ajocc point
                    { "rank":34, "exp":"8,64pt" },
                ],
               "KNS-156-0002": [
                    { "rank":25, "point":"2pt" },
					35, <-- Ajocc point
                    { "rank":2, "point":"55,1167pt" },
                ],
            }
        }
        //*/
	
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
		}
		
		if (!is_array($this->request->data)) {
			return $this->error('sorted_by_series failed. is bad request...', self::STATUS_CODE_BAD_REQUEST);
		}
		
		if (empty($this->request->data['racer'])) {
			return $this->error('have not racer!', self::STATUS_CODE_BAD_REQUEST);
		}
		if (empty($this->request->data['series'])) {
			return $this->error('have not series!', self::STATUS_CODE_BAD_REQUEST);
		}
		
		$date = empty($this->request->data['date']) ? date('Y-m-d') : $this->request->data['date'];
		
		$racers = $this->request->data['racer'];
		$series = $this->request->data['series'];
		//*/
		/* テスト用
		$racers = array(
			'CCH-000-0777',
			'CCH-000-0507',
			'CCH-000-0222',
			'CCH-000-0101',
			'GPM-000-0845'
		);
		$series = array(
			array(
				'type' => 'series',
				'id' => 8
			),
			array(
				'type' => 'ajocc_pt',
				'category' => 'C2',
				'season' => 4
			)
		);
		$date = date('Y-m-d');//*/
		
		$rankInfos = array();
		foreach ($racers as $code) {
			$rankInfos[$code] = array(
				'code' => $code,
				'ranks' => array()
			);
		}
		
		foreach ($series as $ser) {
			// すでに上位のシリーズでの並びが決定されている場合には下位のポイントは意味ないが、
			// 情報として表示するので検索する。パフォーマンスが悪い場合には除外することを検討すること。
			// （ただし同点同順位の選手らの改めての並び替えは必要となる。）
			
			if ($ser['type'] === "series") {
				$rankInfos = $this->__addPointSeriesInfo($rankInfos, $ser['id'], $date);
			} else if ($ser['type'] === "ajocc_pt") {
				$rankInfos = $this->__addAjoccRankingInfo($rankInfos, $ser['season'], $ser['category']);
			}
		}
		
		//$this->log('ranking:', LOG_DEBUG);
		//$this->log($rankInfos, LOG_DEBUG);
		
		usort($rankInfos, array($this, '__compare_series_rankings'));
		
		//$this->log('ranking:', LOG_DEBUG);
		//$this->log($rankInfos, LOG_DEBUG);
		
		/* テスト用配列
		$ranks = array(
			'CCM-156-0025' => array(
				'code' => 'CCM-156-0025',
				'ranks' => array(
					array('rank' => 1, 'exp' => '224,3352pt'),
					12,
				)
			),
			'KNS-000-1156' => array(
				'code' => 'KNS-000-1156',
				'ranks' => array(
					array('rank' => 22, 'exp' => '12,144pt'),
					25,
				)
			),
		);
		usort($ranks, array($this, '__compare_series_rankings'));
		
		$this->log('test ranks:', LOG_DEBUG);
		$this->log($ranks, LOG_DEBUG);
		//*/
		
		return $this->success(array('sorted' => $rankInfos));
	}
	
	public static function __compare_series_rankings($a, $b)
	{
		for ($i = 0; $i < count($a['ranks']); $i++) {
			$itemA = $a['ranks'][$i];
			$itemB = $b['ranks'][$i];
			if (is_array($itemA)) {
				// compare with series
				if (is_null($itemA['rank'])) {
					if (is_null($itemB['rank'])) {
						continue;
					}
					return 1;
				}
				if (is_null($itemB['rank'])) {
					return -1;
				}
				
				if ($itemA['rank'] == $itemB['rank']) {
					// 同位
					continue;
				}
				
				return $itemA['rank'] - $itemB['rank'];
			} else {
				// compare with ajocc @pt
				if ($itemA != $itemB) {
					return $itemB - $itemA;
				}
			}
		}
		
		// 判断できず
		return 0;
	}
	
	/**
	 * $rankInfos にポイントシリーズによる情報を加える。要素は { "rank":23, "exp":"56,556pt" } である。
	 * @param type $rankInfos
	 * @param type $seriesId
	 * @param date $baseDate ポイント計測器準備
	 * @param type $racers not null, not empty
	 */
	private function __addPointSeriesInfo($rankInfos, $seriesId, $baseDate)
	{
		$psController = new PointSeriesController();
		$calced = $psController->calcUpSeries($seriesId, $baseDate);
		
		$ranking = $calced['ranking']['ranking'];
		
		foreach ($rankInfos as $code => &$ri) {
			$rpUnit = null;
			foreach ($ranking as $unit) {
				if ($unit->code  == $code) {
					$rpUnit = $unit;
					break;
				}
			}
			
			if (empty($rpUnit)) {
				// 空配列で順位なしを与える
				$ri['ranks'][] = array(
					'rank' => null,
					'exp' => '',
				);
			} else {
				$str = '';
				foreach ($rpUnit->rankPt as $pt) {
					if (strlen($str) > 0) {
						$str .= ',';
					}
					$str .= $pt;
				}
				$str .= 'pt';
				
				$ri['ranks'][] = array(
					'rank' => $rpUnit->rank,
					'exp' => $str,
				);
			}
		}
		
		return $rankInfos;
	}
	
	/**
	 * $rankInfos に Ajocc point による情報を加える。ポイントは not null で int である。
	 * @param type $rankInfos 
	 * @param type $season シーズン ID
	 * @param type $category カテゴリーコード
	 * @param type $racers not null, not empty
	 */
	private function __addAjoccRankingInfo($rankInfos, $season, $category)
	{
		$this->log('called', LOG_DEBUG);
		
		// season とカテゴリー指定でリザルト取得。選手コードも in list。
		// ajocc point を集計してポイントのみを並べる。
		
		$this->EntryRacer->Behaviors->load('Utils.SoftDelete');
		$this->EntryRacer->Behaviors->load('Containable');
		
		$codes = array();
		$sumUped = array();
		foreach ($rankInfos as $code => $val) {
			$codes[] = $code;
			$sumUped[$code] = 0;
		}
		
		$options = array(
			'conditions' => array(
				'EntryRacer.racer_code' => $codes,
				'RacerResult.deleted' => 0,
				'RacerResult.ajocc_pt >' => 0,
				'RacerResult.as_category' => $category,
				'EntryCategory.deleted' => 0
				// season.id は検索条件に入れられないので後の for 文内でチェックする
			),
			'contain' => array(
				'RacerResult',
				'EntryCategory' => array(
					'fields' => array(),
					'EntryGroup' => array(
						'fields' => array(),
						'Meet' => array(
							'fields' => array('season_id'),
						),
					)
				)
			)
		);
		
		// TODO: season_id を調べたいため、かなり重い処理になる。
		// EntryCategory に season をキャッシュ値で持たせたい。
		
		$offset = 0;
		$limit = 100;
		
		while (true) {
			$options['offset'] = $offset;
			$options['limit'] = $limit;
			$ers = $this->EntryRacer->find('all', $options);
			if (empty($ers)) break;

			//$this->log('ers:', LOG_DEBUG);
			//$this->log($ers, LOG_DEBUG);
			
			foreach ($ers as $er) {
				if (empty($er['EntryCategory']['EntryGroup']['Meet']['season_id'])
						|| $er['EntryCategory']['EntryGroup']['Meet']['season_id'] != $season) {
					continue;
				}
				
				$sumUped[$er['EntryRacer']['racer_code']] += $er['RacerResult']['ajocc_pt'];
			}
			
			$offset += $limit;
		}
		
		foreach ($rankInfos as $code => &$ri) {
			$ri['ranks'][] = $sumUped[$code];
		}
		
		$this->log('end', LOG_DEBUG);
		
		return $rankInfos;
	}
}
