<?php

App::uses('ApiBaseController', 'Controller');

App::uses('Util', 'Cyclox/Util');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('Constant', 'Cyclox/Const');
App::uses('CategoryReason', 'Cyclox/Const');
App::uses('PointCalculator', 'Cyclox/Util');

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
		'PointSeries', 'MeetPointSeries', 'PointSeriesRacer');
	
	public $components = array('Session', 'RequestHandler');
	
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
		$this->log($eracers, LOG_DEBUG);

		if (empty($eracers)) {
			return $this->error("出走カテゴリーに選手が設定されていません。", self::STATUS_CODE_BAD_REQUEST);
		}

		$erMap = array();
		
		$this->log($eracers, LOG_DAEMON);

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
		
		// 出走グループ名が同じものがあった場合、出走データ + リザルトを除去する。
		if (!empty($this->request->data['entry_group']['EntryGroup']['name']) &&
				!empty($this->request->data['entry_group']['EntryGroup']['meet_code'])) {
			$egroupName = $this->request->data['entry_group']['EntryGroup']['name'];
			$meetCode = $this->request->data['entry_group']['EntryGroup']['meet_code'];
			
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
			return $this->success(array('ok')); // 件数とか？
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
		
		$egroups = $this->EntryGroup->find('all', array('conditions' => array('meet_code' => $meetCode)));
		if (empty($egroups)) {
			return $this->error('大会が見つかりません。', self::STATUS_CODE_BAD_REQUEST);
		}
		
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
		//$this->log($erMap);
		
		// 昇格用パラメタの取得
		$opt = array('conditions' => array('code' => $meetCode), 'recursive' => -1);
		$meet = $this->Meet->find('first', $opt);
		
		// メイン処理
		
		$transaction = $this->TransactionManager->begin();
		
		try
		{
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
			
			//$this->log($this->request->data['body-result'], LOG_DEBUG);
			//$this->log($meet, LOG_DEBUG);
			
			// 昇格処理のために出走人数のカウント
			$startedCount = 0;
			foreach ($this->request->data['body-result'] as $body => $result) {
				$er = $erMap[$body];
				if (!empty($er) && $er['EntryRacer']['entry_status'] != RacerEntryStatus::$OPEN->val()) {
					$rstatus = $result['RacerResult']['status'];
					if ($rstatus != RacerResultStatus::$DNS->val()) {
						++$startedCount;
					}
				}
			}
			
			foreach ($this->request->data['body-result'] as $body => $result) {
				$er = $erMap[$body];
				if (empty($er)) {
					$this->TransactionManager->rollback($transaction);
					return $this->error('無効な BodyNo. の設定が存在します。出走データをチェックして下さい。', self::STATUS_CODE_BAD_REQUEST);
				}
				//$this->log($result);
				
				$isOpenRacer = ($er['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
				
				$ajoccPt = 0;
				if (!$isOpenRacer && $ecat['applies_ajocc_pt']) {
					$ret = $this->__calcAjoccPt($result['RacerResult'], $startedCount);
					if ($ret == -1) {
						$this->log($er['EntryRacer']['racer_code'] . ' の Ajocc point 計算処理に失敗しました。', LOG_ERR);
					} else {
						$ajoccPt = $ret;
					}
				}
				
				// リザルトの保存
				$this->RacerResult->create();
				$result['RacerResult']['entry_racer_id'] = $er['EntryRacer']['id'];
				$result['RacerResult']['ajocc_pt'] = $ajoccPt;
				if (!$this->RacerResult->saveAssociated($result)) {
					$this->TransactionManager->rollback($transaction);
					return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
				}
				
				// Open 参加は除く
				if (!$isOpenRacer) {
					// result_id, rcat, 出走人数より昇格判定（ポイントもできそう）
					$ret = $this->__setupRankUp($er['EntryRacer']['racer_code'], $this->RacerResult->id,
							$result['RacerResult'], $startedCount, $ecat, $meet['Meet']);
					if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
						$this->log($er['EntryRacer']['racer_code'] . ' の昇格処理に失敗しました。', LOG_ERR);
					}
					// __setupRankUp() 内で昇格時の残留ポイント付与も行われている。
					
					$ret = $this->__setupHoldPoint($er['EntryRacer']['racer_code'], $this->RacerResult->id,
							$result['RacerResult'], $ecat, $meet['Meet']);
					// 昇格していても旧カテゴリーで残留ポイントは付与しておく。
					
					if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
						$this->log($er['EntryRacer']['racer_code'] . ' の残留ポイントの設定処理に失敗しました。', LOG_ERR);
					}
					
					$ret = $this->__setupPoints($er['EntryRacer']['racer_code'], $this->RacerResult->id,
							$result['RacerResult'], $startedCount, $ecat, $meet['Meet']);
					if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
						$this->log($er['EntryRacer']['racer_code'] . ' のポイント計算に失敗しました。', LOG_ERR);
					}
				}
			}
			
			$this->TransactionManager->commit($transaction);
			return $this->success(array('ok')); // 件数とか？
		} catch (Exception $ex) {
			$this->log('exception:' . $ex.message, LOG_DEBUG);
			$this->TransactionManager->rollback($transaction);
			return $this->error('予期しないエラー:' . $ex, self::STATUS_CODE_BAD_REQUEST);
		}
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
			'conditions' => array('code LIKE' => $meetGroupCode . '-' . $sn . '%'),
		));
		
		// 最大値を求める
		$max = -1;
		foreach ($racers as $code) {
			//$this->log('code is ' . $code . ' ' . substr_count($code, '-'), LOG_DEBUG);
			if (substr_count($code, '-') != 2) {
				continue;
			}
			
			$hifnPos = strrpos($code, '-');
			if ($hifnPos === false || $hifnPos >= strlen($code) - 1) {
				continue;
			}
			
			$numStr = substr($code, $hifnPos + 1);
			//$this->log('num str:' . $numStr, LOG_DEBUG);
			if (!is_numeric($numStr)) {
				continue;
			}
			// 小数、10進数以外の表記は intval(string) なら問題なし。
			
			$num = intval($numStr);
			if ($num === false) {
				continue;
			}
			
			if ($num > $max) {
				$max = $num;
			}
		}
		
		if ($max === -1) {
			return $this->success(array('racer_code_next_number' => 1));
		} else {
			return $this->success(array('racer_code_next_number' => $max + 1));
		}
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
	 * AJOCC Point を計算する
	 * @param type $result リザルト
	 * @param type $startedCount 出走人数
	 * @return int ポイント。エラーの場合 -1 をかえす。
	 */
	private function __calcAjoccPt($result, $startedCount)
	{
		if (empty($result) || $startedCount <= 0) {
			return -1;
		}
		
		if (empty($result['rank'])) {
			return 0;
		}
		
		$map = array(
			array(
				'started_over' => 40, 'points' => array(
					56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
					16, 14, 13, 12, 11, 10,  9,  9,  8,  8,
					 7,  7,  7,  6,  6,  6,  5,  5,  5,  5,
					 4,  4,  4,  4,  3,  3,  3,  3,  3,  3,
					 2,  2,  2,  2,  2,  2,  2,  1,  1,  1,
					 1,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				'started_over' => 20, 'points' => array(
					42, 34, 28, 24, 21, 18, 15, 13, 11, 10,
					9,  8,  7,  6,  6,  5,  5,  4,  4,  4,
					3,  3,  3,  3,  2,  2,  2,  2,  2,  2,
					2,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				'started_over' => 0, 'points' => array(
					28, 20, 15, 12, 10, 8,  6,  5,  4,  3,
					3,  2,  2,  2,  1,  1,  1,  1,  1,  1,
				)
			)
		);
		
		// ポイントの決定
		$point = 0;
		foreach ($map as $item) {
			if ($startedCount > $item['started_over']) {
				$rankIndex = $result['rank'] - 1;
				
				if (isset($item['points'][$rankIndex])) {
					$point = $item['points'][$rankIndex];
					break;
				}
			}
		}
		
		$this->log('ajocc pt is: ' . $point, LOG_DEBUG);
		return $point;
	}
	
	/**
	 * 昇格を計算し、適用する。
	 * @param string $racerCode 選手コード
	 * @param int $racerResultId リザルト ID
	 * @param int $result リザルト
	 * @param int $raceStartedCount レースの出走人数（Open 参加を除く）
	 * @param string $ecat 出走カテゴリー
	 * @param date $meet 大会データ
	 * @return int Constant.RET_ のいずれか
	 */
	private function __setupRankUp($racerCode, $racerResultId, $result, $raceStartedCount, $ecat, $meet)
	{
		if (empty($racerCode) || empty($racerResultId) || empty($result) || empty($raceStartedCount) ||
			empty($ecat) || empty($meet)) {
			return Constant::RET_ERROR;
		}
		
		$rank = empty($result['rank']) ? null : $result['rank'];

		if ($ecat['applies_rank_up'] != 1 || empty($rank)) {
			return Constant::RET_NO_ACTION;
		}
		
		// 選手の現在のカテゴリー所属を取得
		$conditions = array(
			'racer_code' => $racerCode,
			'OR' => array(
				array('cancel_date' => null),
				array('cancel_date >=' => $meet['at_date']) // 所属チェックにも使っているので注意
			),
			'apply_date <=' => $meet['at_date'],
		);
		$this->CategoryRacer->actsAs = array('Utils.SoftDelete'); // deleted を拾わないように
		$catBinds = $this->CategoryRacer->find('all', array('conditions' => $conditions, 'recursive' => -1));
		//$this->log('cats:', LOG_DEBUG);
		//$this->log($catBinds, LOG_DEBUG);
		
		if (empty($catBinds)) {
			// MORE: 有効なカテゴリーを1つも持たない場合に警告を出す？
			return Constant::RET_NO_ACTION;
		}
		
		$rcatCode = $ecat['races_category_code'];
		
		// 特別処理
		// M1+2+3 は勝利したら CM1 表彰台で CM2（降格なし）
		if ($rcatCode === 'CM1+2+3')
		{
			$this->log('CM1+2+3 rank up', LOG_DEBUG);
			
			// CM1 持ってるなら処理なし
			foreach ($catBinds as $catBind) {
				$this->log('curr:' . $catBind['CategoryRacer']['category_code'], LOG_DEBUG);
				if ($catBind['CategoryRacer']['category_code'] === 'CM1') {
					$this->log('find cm1', LOG_DEBUG);
					return Constant::RET_NO_ACTION;
				}
			}
			
			$newCategory = null;
			$oldCat = null;
			
			$this->log('rank is,,,:' . $rank, LOG_DEBUG);
			
			if ($rank === 1) {
				// カテゴリー所持の確認
				foreach ($catBinds as $catBind) {
					if ($catBind['CategoryRacer']['category_code'] === 'CM2') {
						$newCategory = 'CM1';
						$oldCat = 'CM2';
						break;
					}
				}
				if (empty($newCategory)) {
					foreach ($catBinds as $catBind) {
						if ($catBind['CategoryRacer']['category_code'] === 'CM3') {
							$newCategory = 'CM1';
							$oldCat = 'CM3';
							break;
						}
					}
				}
			} else if ($rank === 2 || $rank === 3) {
				// CM2 なら処理なし
				foreach ($catBinds as $catBind) {
					if ($catBind['CategoryRacer']['category_code'] === 'CM2') {
						return Constant::RET_NO_ACTION;
					}
				}
				// カテゴリー所持の確認
				foreach ($catBinds as $catBind) {
					if ($catBind['CategoryRacer']['category_code'] === 'CM3') {
						$newCategory = 'CM2';
						$oldCat = 'CM3';
						break;
					}
				}
			}
			
			if (empty($newCategory)) {
				// MORE: 持っているべきカテゴリー所持していないことについて警告を検討
				return Constant::RET_NO_ACTION;
			}
			
			$applyDate = date('Y/m/d', strtotime($meet['at_date'] . ' +1 day'));
			
			// 同じ大会で同じ昇格をしているデータがあるなら、リザルトは除去されていると推測されるので、削除する。
			$conditions = array(
				'racer_code' => $racerCode,
				'meet_code' => $meet['code'],
				'category_code' => $newCategory,
				'apply_date' => $applyDate,
				'reason_id' => CategoryReason::$RESULT_UP->ID(),
			);
			$this->CategoryRacer->deleteAll($conditions);
			
			foreach ($catBinds as $catBind) {
				if ($catBind['CategoryRacer']['category_code'] === $oldCat) {
					$catBind['CategoryRacer']['cancel_date'] = $meet['at_date'];
					$this->CategoryRacer->create();
					if (!$this->CategoryRacer->save($catBind)) {
						$this->log('CategoryRacer の cancel_date 設定->保存に失敗', LOG_ERR);
					}
					// not break: 全部キャンセルする
				}
			}
			
			$this->log('will create', LOG_DEBUG);
			
			$cr = array();
			$cr['CategoryRacer'] = array();
			$cr['CategoryRacer']['racer_code'] = $racerCode;
			$cr['CategoryRacer']['category_code'] = $newCategory;
			$cr['CategoryRacer']['apply_date'] = $applyDate;
			$cr['CategoryRacer']['reason_id'] = CategoryReason::$RESULT_UP->ID();
			$cr['CategoryRacer']['reason_note'] = "";
			$cr['CategoryRacer']['racer_result_id'] = $racerResultId;
			$cr['CategoryRacer']['meet_code'] = $meet['code'];
			$cr['CategoryRacer']['cancel_date'] = null;

			$this->CategoryRacer->create();
			if (!$this->CategoryRacer->save($cr)) {
				$this->log('昇格の選手カテゴリー Bind の保存に失敗しました。', LOG_ERR);
				return Constant::RET_FAILED;
			}

			$this->log('(with rank-up) will give give hold point to:' . $newCategory, LOG_DEBUG);
			$hp = array();
			$hp['HoldPoint'] = array();
			$hp['HoldPoint']['racer_result_id'] = $racerResultId;
			$hp['HoldPoint']['point'] = 3;
			$hp['HoldPoint']['category_code'] = $newCategory;

			$this->HoldPoint->create();
			if (!$this->HoldPoint->save($hp)) {
				$this->log('新カテゴリーに対する残留ポイントの保存に失敗しました。', LOG_ERR);
				return Constant::RET_FAILED;
			}

			return Constant::RET_SUCCEED;
		}
		
		// 出走人数と昇格のルール
		$rule0123 = array(
			array('racer_count' => 50, 'up' => 3),
			array('racer_count' => 20, 'up' => 2),
			array('racer_count' => 10, 'up' => 1),
		);
		$rule0112 = array(
			array('racer_count' => 50, 'up' => 2),
			array('racer_count' => 10, 'up' => 1),
		);

		// 文字列で判断する
		// パラメタから処理したいが、複雑なのでやめておく。
		// racesCatCode => array('needs' => 必要な所属, 'to' =>昇格先)
		$map = array(
			'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $rule0123),
			'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $rule0123),
			'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $rule0123),
			'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $rule0123),
			'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $rule0112),
			'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $rule0123),
			'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $rule0112),
		);

		if (empty($map[$rcatCode])) {
			return Constant::RET_NO_ACTION;
		}
	
		// 人数と順位についてチェック
		$rankUpCount = 0;
		for ($i = 0; $i < count($map[$rcatCode]['rule']); $i++) {
			$racerCount = $map[$rcatCode]['rule'][$i]['racer_count'];
			if ($raceStartedCount >= $racerCount) {
				$rankUpCount = $map[$rcatCode]['rule'][$i]['up'];
				break;
			}
		}
		//$this->log($i . '人まで昇格 vs rank:' . $rank, LOG_DEBUG);

		if ($rankUpCount == 0 || $rank > $rankUpCount) {
			return Constant::RET_NO_ACTION;
		}

		// カテゴリーの所属を確認
		$hasCat = false;
		foreach ($catBinds as $catBind) {
			foreach ($map[$rcatCode]['needs'] as $catName) {
				if ($catBind['CategoryRacer']['category_code'] === $catName) {
					$hasCat = true;
					break;
				}
			}

			if ($hasCat) break;
		}

		if (!$hasCat) {
			// MORE: 必要なカテゴリーに所属していない -> 警告を検討すること。
			return Constant::RET_NO_ACTION;
		}

		$applyDate = date('Y/m/d', strtotime($meet['at_date'] . ' +1 day'));

		// 同じ大会で同じ昇格をしているデータがあるなら、リザルトは除去されていると推測されるので、削除する。
		$conditions = array(
			'racer_code' => $racerCode,
			'meet_code' => $meet['code'],
			'category_code' => $map[$rcatCode]['to'],
			'apply_date' => $applyDate,
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
		);
		$this->CategoryRacer->deleteAll($conditions); // MEMO: これは hard delete

		// 昇格前カテゴリーは cancel_date を設定
		foreach ($catBinds as $catBind) {
			foreach ($map[$rcatCode]['needs'] as $catName) {
				//$this->log($catBind['CategoryRacer']['category_code'] . ' vs ' . $catName, LOG_DEBUG);
				if ($catBind['CategoryRacer']['category_code'] === $catName) {
					//$this->log('delete!!', LOG_DEBUG);
					$catBind['CategoryRacer']['cancel_date'] = $meet['at_date'];
					$this->CategoryRacer->create();
					if (!$this->CategoryRacer->save($catBind)) {
						$this->log('CategoryRacer の cancel_date 設定->保存に失敗', LOG_ERR);
					}
					break; // $catBinds ループは break しないで全部削除する。
				}
			}
		}

		$cr = array();
		$cr['CategoryRacer'] = array();
		$cr['CategoryRacer']['racer_code'] = $racerCode;
		$cr['CategoryRacer']['category_code'] = $map[$rcatCode]['to'];
		$cr['CategoryRacer']['apply_date'] = $applyDate;
		$cr['CategoryRacer']['reason_id'] = CategoryReason::$RESULT_UP->ID();
		$cr['CategoryRacer']['reason_note'] = "";
		$cr['CategoryRacer']['racer_result_id'] = $racerResultId;
		$cr['CategoryRacer']['meet_code'] = $meet['code'];
		$cr['CategoryRacer']['cancel_date'] = null;

		$this->CategoryRacer->create();
		if (!$this->CategoryRacer->save($cr)) {
			$this->log('昇格の選手カテゴリー Bind の保存に失敗しました。', LOG_ERR);
			return Constant::RET_FAILED;
		}

		$this->log('(with rank-up) will give give hold point to:' . $map[$rcatCode]['to'], LOG_DEBUG);
		$hp = array();
		$hp['HoldPoint'] = array();
		$hp['HoldPoint']['racer_result_id'] = $racerResultId;
		$hp['HoldPoint']['point'] = 3;
		$hp['HoldPoint']['category_code'] = $map[$rcatCode]['to'];
		
		$this->HoldPoint->create();
		if (!$this->HoldPoint->save($hp)) {
			$this->log('新カテゴリーに対する残留ポイントの保存に失敗しました。', LOG_ERR);
			return Constant::RET_FAILED;
		}
		
		return Constant::RET_SUCCEED;
	}
	
	/**
	 * 残留ポイントを計算し、設定する。
	 * @param string $racerCode 選手コード
	 * @param int $racerResultId リザルト ID
	 * @param int $result リザルト
	 * @param string $ecat 出走カテゴリー
	 * @param string $meet 大会データ
	 */
	private function __setupHoldPoint($racerCode, $racerResultId, $result, $ecat, $meet)
	{
		if (empty($racerCode) || empty($racerResultId) || empty($result) ||
			empty($ecat) || empty($meet)) {
			return Constant::RET_ERROR;
		}
		
		if ($ecat['applies_hold_pt'] != 1) {
			return Constant::RET_NO_ACTION;
		}
		
		if (empty($result['rank_per']) || $result['rank_per'] > 66) {
			return Constant::RET_NO_ACTION;
		}
		$point = ($result['rank_per'] <= 25) ? 3 : 1;
		$this->log('point will be, ' . $point, LOG_DEBUG);
		
		// 選手の現在のカテゴリー所属を取得
		$conditions = array(
			'racer_code' => $racerCode,
			'OR' => array(
				array('cancel_date' => null),
				array('cancel_date >=' => $meet['at_date'])
			),
			'apply_date <=' => $meet['at_date'],
			//'reason_id' => CategoryReason::$RESULT_UP->ID(),
		);
		$catBinds = $this->CategoryRacer->find('all', array('conditions' => $conditions, 'recursive' => -1));
		
		// レースカテゴリーからカテゴリーに所属していることを確認。Rank の高いカテゴリーに対してポイントを与える。
		
		// racesCatCode => array(ポイント付与するカテゴリー) <-- 付与カテゴリーは高い順に並んでいること
		$map = array(
			'C1' => array('C1'),
			'C2' => array('C2'),
			'C3' => array('C3'),
			'C3+4' => array('C3'),
			//'C4' => array('C4'), // 不要
			'CM1' => array('CM1'),
			'CM2' => array('CM2'),
			//'CM3' => array('CM3'), // 不要
			//'CM4' => array('CM4'), // 不要
			'CM1+2+3' => array('CM1', 'CM2'),
			'CM2+3' => array('CM2'),
		);
		
		$rcatCode = $ecat['races_category_code'];
		
		if (empty($map[$rcatCode])) {
			return Constant::RET_NO_ACTION;
		}
		
		// カテゴリーの所属を確認
		$catCodeGiveTo = null;
		foreach ($map[$rcatCode] as $catCode) {
			foreach ($catBinds as $catBind) {
				$this->log($catBind['CategoryRacer']['category_code'] . ' vs ' . $catCode, LOG_DEBUG);
				if ($catBind['CategoryRacer']['category_code'] === $catCode) {
					$catCodeGiveTo = $catCode;
					$this->log('find!', LOG_DEBUG);
					break;
				}
			}

			if (!empty($catCodeGiveTo)) break;
		}

		if (empty($catCodeGiveTo)) {
			// MORE: 出走に必要なカテゴリーを持っていないことについて警告を検討すること
			return Constant::RET_NO_ACTION;
		}
		
		$this->log('will give give hold point to:' . $catCodeGiveTo . ' pt:' . $point, LOG_DEBUG);
		$hp = array();
		$hp['HoldPoint'] = array();
		$hp['HoldPoint']['racer_result_id'] = $racerResultId;
		$hp['HoldPoint']['point'] = $point;
		$hp['HoldPoint']['category_code'] = $catCodeGiveTo;
		
		$this->HoldPoint->create();
		if (!$this->HoldPoint->save($hp)) {
			return Constant::RET_FAILED;
		}
		
		return Constant::RET_SUCCEED;
	}
	
	/**
	 * 大会に設定されたポイントを計算し、適用する。
	 * @param string $racerCode 選手コード
	 * @param int $racerResultId リザルト ID
	 * @param int $result リザルト
	 * @param int $raceStartedCount レースの出走人数（Open 参加を除く）
	 * @param string $ecat 出走カテゴリー
	 * @param date $meet 大会データ
	 * @return int Constant.RET_ のいずれか
	 */
	private function __setupPoints($racerCode, $racerResultId, $result, $raceStartedCount, $ecat, $meet)
	{
		if (empty($racerCode) || empty($racerResultId) || empty($result) || empty($raceStartedCount) ||
			empty($ecat) || empty($meet)) {
			return Constant::RET_ERROR;
		}
		
		$conditions = array('meet_code' => $meet['code'], 'entry_category_name' => $ecat['name']);
		$pts = $this->MeetPointSeries->find('all', array('conditions' => $conditions));
		
		foreach ($pts as $ptSetting) {
			//$this->log('pt setting:', LOG_DEBUG);
			//$this->log($ptSetting, LOG_DEBUG);
			
			$calc = PointCalculator::getCalculator($ptSetting['PointSeries']['calc_rule']);
			if (empty($calc)) return;
			
			$pt = $calc->calc($result, $ecat, $ptSetting['MeetPointSeries']['grade']);
			if (!empty($pt)) {
				$psr = array();
				$psr['PointSeriesRacer'] = array(
					'racer_code' => $racerCode,
					'point_series_id' => $ptSetting['PointSeries']['id'],
					'gained_date' => $meet['at_date'],
					'racer_result_id' => $racerResultId,
					'meet_point_series_id' => $ptSetting['MeetPointSeries']['id'],
				);
				if (!empty($pt['point'])) $psr['PointSeriesRacer']['point'] = $pt['point'];
				if (!empty($pt['bonus'])) $psr['PointSeriesRacer']['bonus'] = $pt['bonus'];
				
				$this->PointSeriesRacer->create();
				if (!$this->PointSeriesRacer->save($psr)) {
					$this->log('ポイントシリーズ' . $ptSetting['PointSeries']['name'] . 'のポイント計算に失敗しました。', LOG_ERR);
				}
			}
		}
		
		return Constant::RET_SUCCEED;
	}
	
}
