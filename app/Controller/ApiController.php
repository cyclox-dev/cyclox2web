<?php

App::uses('ApiBaseController', 'Controller');

App::uses('Util', 'Cyclox/Util');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('Constant', 'Cyclox/Const');
App::uses('CategoryReason', 'Cyclox/Const');

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
		'EntryGroup', 'EntryCategory', 'EntryRacer', 'RacerResult', 'TimeRecord');
	
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
	 * @param date $date 最後の更新ダウンロード日時
	 */
	public function updated_racer_codes($date = null)
	{
		if ($date) {
			$dt = $this->__getFindSqlDate($date);
			
			if ($dt) {
				$opt = array('conditions' => array('modified >' => $dt),'fields' => array('code', 'family_name'));
				$meets = $this->Racer->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$meets = $this->Racer->find('list');
		}
		
		return $this->success(array('racers' => $meets));
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
					$ecat = $ec; // TODO: 複数ヒットをエラーとする？
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
			return $this->error('予期しないエラー:' + $ex, self::STATUS_CODE_BAD_REQUEST);
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
					$ecat = $ec; // TODO: 複数ヒットをエラーとする？
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
				
				// リザルトの保存
				$this->RacerResult->create();
				$result['RacerResult']['entry_racer_id'] = $er['EntryRacer']['id'];
				if (!$this->RacerResult->saveAssociated($result)) {
					$this->TransactionManager->rollback($transaction);
					return $this->error('保存処理に失敗しました。', self::STATUS_CODE_BAD_REQUEST);
				}
				
				//$this->log($er, LOG_DEBUG);
				
				// Open 参加は除く
				if ($er['EntryRacer']['entry_status'] != RacerEntryStatus::$OPEN->val()) {

					$rank = empty($result['RacerResult']['rank']) ? null : $result['RacerResult']['rank'];

					// result_id, rcat, 出走人数より昇格判定（ポイントもできそう）
					$ret = $this->__savePointEtc($er['EntryRacer']['racer_code'], $this->RacerResult->id,
							$rank, $startedCount, $ecat, $meet['Meet']);
					if ($ret == Constant::RET_FAILED || $ret == Constant::RET_ERROR) {
						$this->log($er['EntryRacer']['racer_code'] + ' の昇格処理に失敗しました。', LOG_ERR);
					}
				}
			}
			
			$this->TransactionManager->commit($transaction);
			return $this->success(array('ok')); // 件数とか？
		} catch (Exception $ex) {
			$this->log('exception:' . $ex.message, LOG_DEBUG);
			$this->TransactionManager->rollback($transaction);
			return $this->error('予期しないエラー:' + $ex, self::STATUS_CODE_BAD_REQUEST);
		}
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
	 * 昇格・残留ポイント・AJOCC ポイントなどを計算し、適用する。
	 * @param string $racerCode 選手コード
	 * @param int $racerResultId リザルト
	 * @param int $rank レースでの順位 null ok
	 * @param int $raceStartedCount レースの出走人数（Open 参加を除く）
	 * @param string $ecat 出走カテゴリー
	 * @param date $meet 大会データ
	 * @return int Constant.RET_ のいずれか
	 */
	private function __savePointEtc($racerCode, $racerResultId, $rank, $raceStartedCount, $ecat, $meet)
	{
		if (empty($racerCode) || empty($racerResultId) || empty($raceStartedCount) ||
			empty($ecat) || empty($meet['at_date'])) {
			return Constant::RET_ERROR;
		}
		
		if (empty($rank)) {
			return Constant::RET_NO_ACTION;
		}
		
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
		$catBinds = $this->CategoryRacer->find('all', array($conditions, 'recursive' => -1));
		//$this->log('cats:', LOG_DEBUG);
		//$this->log($catBinds, LOG_DEBUG);
		
		// TODO: 警告を出す？
		if (empty($catBinds)) {
			return Constant::RET_NO_ACTION;
		}
		
		$rcatCode = $ecat['races_category_code'];
		
		if ($ecat['applies_rank_up'] === 1) {
			// 出走人数と昇格のルール
			$rule0123 = array(10, 20, 30);
			$rule0112 = array(
				array(10 => 0), array(20 => 1), array(30 => 1), array(99999 => 2)
			);

			// 文字列で判断する
			// TODO: 処理改善。レースカテゴリーが含有するリザルト
			// racesCatCode => array('needs' => 必要な所属, 'to' =>昇格先)
			$map = array(
				'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $rule0123),
				'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $rule0123),
				'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $rule0123),
				'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $rule0123),
				'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $rule0112),
				'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $rule0123),
				'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $rule0112),
				// TODO: 勝利したら CM1 表彰台で CM2 だっけ？
				//'CM1+2+3' => array('needs' => array('CM1', 'CM2', 'CM3'), 'to' => 'CM1'),
			);

			if (empty($map[$rcatCode])) {
				return Constant::RET_NO_ACTION;
			}

			// 人数と順位についてチェック
			$i = 0;
			for (; $i < count($map[$rcatCode]['rule']); $i++) {
				$maxRacerCount = $map[$rcatCode]['rule'][$i];
				if ($raceStartedCount <= $maxRacerCount) {
					break;
				}
			}
			//$this->log($i . '人まで昇格 vs rank:' . $rank, LOG_DEBUG);

			if ($i == 0 || $i < $rank) {
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
				// TODO: 警告を検討すること
				return Constant::RET_NO_ACTION;
			}

			$applyDate = date('Y/m/d', strtotime($meet['at_date'] . ' +1 day'));

			// 同じ大会で同じ昇格をしているデータがあるなら、リザルトは除去されていると推測されるので、削除する。
			$conditions = array(
				'meet_code' => $meet['code'],
				'category_code' => $map[$rcatCode]['to'],
				'apply_date' => $applyDate,
			);
			$this->CategoryRacer->deleteAll($conditions);

			// 昇格前カテゴリーは cancel_date を設定
			foreach ($catBinds as $catBind) {
				foreach ($map[$rcatCode]['needs'] as $catName) {
					//$this->log($catBind['CategoryRacer']['category_code'] . ' vs ' . $catName, LOG_DEBUG);
					if ($catBind['CategoryRacer']['category_code'] === $catName) {
						//$this->log('delete!!', LOG_DEBUG);
						$catBind['CategoryRacer']['cancel_date'] = $meet['at_date'];
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
			//$cr['CategoryRacer']

			$this->log('cr is,,,', LOG_DEBUG);
			$this->log($cr, LOG_DEBUG);

			$this->CategoryRacer->create();
			if (!$this->CategoryRacer->save($cr)) {
				return Constant::RET_FAILED;
			}
		}
		
		
		
		return Constant::RET_SUCCEED;
	}
}
