<?php

App::uses('ApiBaseController', 'Controller');

App::uses('Util', 'Cyclox/Util');


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
	 * 結果を upload する
	 */
	public function add_result($meetCode, $ecatName)
	{
		if (!$this->_isApiCall()) {
			throw new BadRequestException('無効なアクセスです。');
		}
		
		if (!$this->request->is('post')) {
			return $this->error('不正なリクエストです。', self::STATUS_CODE_METHOD_NOT_ALLOWED);
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
			'conditions' => array('entry_category_id' => $ecat['id']),
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
		
		// メイン処理
		
		if (!isset($this->request->data['body-result'])) {
			return $this->error('"body-result" の値が設定されていません。');
		}
		
		$transaction = $this->TransactionManager->begin();
		
		try
		{
			// 現在ある全てのリザルトデータを削除
			foreach ($eracers as $er) {
				if (!empty($er['RacerResult']['id'])) {
					$result_id = $er['RacerResult']['id'];

					if (!$this->RacerResult->delete($result_id)) {
						$this->TransactionManager->rollback($transaction);
						return $this->error('リザルトの削除に失敗しました（想定しないエラー）。');
					}
					// ラップタイムは model dependent=true で削除する
					// TODO: 確認
				}
			}

			foreach ($this->request->data['body-result'] as $body => $result) {
				$er = $erMap[$body];
				if (empty($er)) {
					$this->TransactionManager->rollback($transaction);
					return $this->error('無効な BodyNo. の設定が存在します。出走データをチェックして下さい。');
				}
				//$this->log($result);
				
				// リザルトの保存
				$this->RacerResult->create();
				$result['RacerResult']['entry_racer_id'] = $er['EntryRacer']['id'];
				if (!$this->RacerResult->saveAssociated($result)) {
					$this->TransactionManager->rollback($transaction);
					return $this->error('保存処理に失敗しました。');
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
}
