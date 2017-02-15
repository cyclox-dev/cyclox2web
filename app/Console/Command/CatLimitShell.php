<?php

/*
 *  created at 2016/10/31 by shun
 */

App::uses('Constant', 'Cyclox/Const');
App::uses('EntryCatLimit', 'Cyclox/Const');
App::uses('Util', 'Cyclox/Util');

/**
 * Description of CatLimitShell
 *
 * @author shun
 */
class CatLimitShell extends AppShell
{
	public $uses = array('TransactionManager', 'ParmVar', 'EntryRacer', 'Category', 'CategoryRacesCategory'
			, 'Racer');
	
	public function startup()
	{
		parent::startup();
	}
	
	public function main()
	{
        $this->out('please input function name as 1st arg.');
    }
	
	/**
	 * 内容の重複する CategoryRacer に deleted ステータスを設定する
	 * > app ディレクトリ
	 * > Console/cake cat_limit setupCatLimit
	 */
	public function setupCatLimit()
	{
		$putsDebugLogs = false;
		
		// isset($this->args[0])
		// 引数による選手指定、日時指定などはとりあえず無しで。
		// cron 前提で作成している @20161031
		
		$this->log('>>> Start setupCatLimit', LOG_DEBUG);
		
		// 最後に parm vars に設定する日時を取得
		$nextUpdateDate = date("Y-m-d H:i:s");
		
		// parm vars から最終更新日時を取得
		$pv = $this->ParmVar->find('first', array('conditions' => array('pkey' => Constant::PKEY_CATLIMIT_LAST_UPDATE_DATE)));
		
		$lastUpdateDate = null;
		if (!empty($pv)) {
			$lastUpdateDate = $pv['ParmVar']['value'];
		}
		
		// 大会データが更新されていたら関連する entry_racers.modified を現在日時で更新する
		$ret = $this->__updateERacerAtUpdateMeet($lastUpdateDate);
		if (!$ret) {
			$this->log('大会データ更新に関わる EntryRacer.modified の更新に失敗しました。（※続行します。）', LOG_WARNING);
		}
		
		$this->EntryRacer->Behaviors->unload('Utils.SoftDelete'); // deleted の modified も検知させる
		$this->EntryRacer->Behaviors->load('Containable');
		
		$opt = array('conditions' => array());
		if (!empty($lastUpdateDate)) {
			$opt['conditions']['EntryRacer.modified >'] = $lastUpdateDate;
		}
		$opt['contain'] = array(
			'EntryCategory' => array(
				'fields' => array('races_category_code'),
				'EntryGroup' => array(
					'fields' => array(),
					'Meet' => array(
						'fields' => array('at_date'),
					)
				)
			)
		);
		
		$eliteRCCodes = $this->__racesCatCodes(EntryCatLimit::$ELITE->catGroupId());
		$mastersRCCodes = $this->__racesCatCodes(EntryCatLimit::$MASTERS->catGroupId());
		if ($putsDebugLogs) $this->log('Elite:', LOG_DEBUG);
		if ($putsDebugLogs) $this->log($eliteRCCodes, LOG_DEBUG);
		if ($putsDebugLogs) $this->log('Masters:', LOG_DEBUG);
		if ($putsDebugLogs) $this->log($mastersRCCodes, LOG_DEBUG);
		
		$offset = 0;
		$limit = 50;
		$theIndex = 0;
		
		// >>> Transaction
		$transaction = $this->TransactionManager->begin();
		
		while (true) {
			$opt['offset'] = $offset;
			$opt['limit'] = $limit;
			
			$ers = $this->EntryRacer->find('all', $opt);
			
			if (empty($ers)) {
				if ($offset == 0) {
					$this->log('処理する EntryRacer がありませんでした。', LOG_INFO);
				} else {
					$this->log('処理する EntryRacer がゼロになりました。終了します。', LOG_DEBUG);
				}
				break;
			}
			
			foreach ($ers as $er) {
				++$theIndex;
				
				if ($putsDebugLogs) $this->log('--- ' . $theIndex . '/EntryRacer:' . $er['EntryRacer']['id'] . ' '
						. $er['EntryRacer']['racer_code'] . ' ofRace:' . $er['EntryCategory']['races_category_code'], LOG_DEBUG);
				
				// modified が EorM でなければ処理しない
				if (!(
						in_array($er['EntryCategory']['races_category_code'], $eliteRCCodes) ||
						in_array($er['EntryCategory']['races_category_code'], $mastersRCCodes)
					)) {
					if ($putsDebugLogs) $this->log('EntryRaces:' . $er['EntryRacer']['id'] . 'について EorM でないので処理せず。', LOG_DEBUG);
					continue;
				}
				
				// 削除もありえる（制限 none への切り換え）
				// なので、更新を検知として、その選手のそのシーズンのチェックを行なう
				// そのシーズンの最初のエントリーから順に見ていって
				// Masters or Elite のエントリーがあれば設定し、ないなら n とする。
				
				$dt = $er['EntryCategory']['EntryGroup']['Meet']['at_date'];
				
				if ($putsDebugLogs) $this->log('date:' . $dt
						. ' ' . $this->__seasonStartDate($dt) . '-' . $this->__seasonEndDate($dt), LOG_DEBUG);
				
				$query = 'select * from entry_racers'
						. ' inner join entry_categories on entry_racers.entry_category_id = entry_categories.id'
						. ' inner join entry_groups on entry_categories.entry_group_id = entry_groups.id'
						. ' inner join meets on entry_groups.meet_code = meets.code';
				$query .= " where meets.at_date >= '" . $this->__seasonStartDate($dt) . "' and meets.at_date <= '" . $this->__seasonEndDate($dt) . "'";
				$query .= " and entry_racers.racer_code = '" . $er['EntryRacer']['racer_code'] . "'";
				$query .= ' and ('
							. ' entry_categories.races_category_code in (' . $this->__strArray2commaedSqlStr($eliteRCCodes) . ')'
							. ' or'
							. ' entry_categories.races_category_code in (' . $this->__strArray2commaedSqlStr($mastersRCCodes) . ')'
						. ')';
				$query .= ' and entry_racers.deleted = 0 and meets.deleted = 0;'; // ここでは deleted は含めない
				
				//$this->log('query: ' . $query, LOG_DEBUG);
				$entries = null;
				try {
					$entries = $this->EntryRacer->query($query);
				} catch (PDOException $ex) {
					$this->log('EntryRacer->query() に失敗しました。PDOException:', LOG_ERR);
					$this->log($ex->getMessage(), LOG_ERR);
					$this->TransactionManager->rollback($transaction);
					return;
				}
				
				//$this->log($entries, LOG_DEBUG);
				
				/* ここでの戻り値は query を使用しているため、以下のようになる。
				array(
					array(
						'entry_racers' => array(',,,'),
						'entry_categories' => array(',,,'),
						'entry_groups' => array(',,,'),
						'meets' => array(',,,'),
					),
				);
				//*/
				
				if (empty($entries)) {
					// このシーズンに deleted EntryRacer しか無かった場合
					// 制限 none を設定する
					if ($putsDebugLogs) $this->log('set no-entry_limit to ' . $er['EntryRacer']['racer_code'] . ' at ' . $dt, LOG_DEBUG);
					if (!$this->__setEntryCatLimit($er['EntryRacer']['racer_code'], $dt, EntryCatLimit::$NONE)) {
						$this->log('EntryCatLimit::NONE の保存に失敗しました。', LOG_ERR);
						$this->TransactionManager->rollback($transaction);
						return;
					}
					continue;
				}
				
				// EorM で season 最初の EntryRacer を取得
				
				$firstEr = null;
				foreach ($entries as $entry) {
					if ($putsDebugLogs) $this->log('entry:' . $entry['entry_racers']['id']
							. ' RCCode:' . $entry['entry_categories']['races_category_code'], LOG_DEBUG);
					
					if (empty($firstEr) || $entry['meets']['at_date'] < $firstEr['meets']['at_date']) {
						if ($putsDebugLogs) $this->log('storing,,,', LOG_DEBUG);
						$firstEr = $entry;
					}
				}
				
				if (empty($firstEr)) continue;
				
				if ($putsDebugLogs) $this->log('find EorM of Racer:' . $firstEr['entry_racers']['racer_code']
						. ' from racesCat:' . $firstEr['entry_categories']['races_category_code']
						. ' at ' . $firstEr['meets']['at_date'] . '/' . $firstEr['meets']['code'], LOG_DEBUG);
				
				$catLimit = (in_array($firstEr['entry_categories']['races_category_code'], $eliteRCCodes))
						? EntryCatLimit::$ELITE : EntryCatLimit::$MASTERS;
				
				if (!$this->__setEntryCatLimit($firstEr['entry_racers']['racer_code'], $firstEr['meets']['at_date'], $catLimit)) {
					$this->log('EntryCatLimit の保存に失敗しました。', LOG_ERR);
					$this->TransactionManager->rollback($transaction);
					return;
				}
			}
			
			if (count($ers) % $limit != 0) {
				$this->log('処理する EntryRacer の件数から判断し、終了します。', LOG_INFO);
				break;
			}
			
			$offset += $limit;
		}
		
		$this->TransactionManager->commit($transaction);
		// <<< Transaction
		
		// 最終更新日時の記録
		$obj = array(
			'pkey' => Constant::PKEY_CATLIMIT_LAST_UPDATE_DATE,
			'value' => $nextUpdateDate,
		);
		if (!empty($pv)) {
			$obj['id'] = $pv['ParmVar']['id'];
		}
		
		if (!$this->ParmVar->save($obj)) {
			$this->log('ParmVar:' . Constant::PKEY_CATLIMIT_LAST_UPDATE_DATE . ' の保存に失敗しました。', LOG_ERR);
			return;
		}
		
		$this->log('>>> End setupCatLimit', LOG_DEBUG);
	}
	
	/**
	 * EntryCatLimit を設定する
	 * @param type $racerCode
	 * @param type $date
	 * @param type $catLimit 
	 * @return boolean 処理が成功したか
	 */
	private function __setEntryCatLimit($racerCode, $date, $catLimit)
	{
		// 2015-16 シーズンからの e,m,n の文字列の羅列で表現する。例）eenmmm
		
		if (empty($date)) {
			$this->log('日付指定が無効です。date:' . $date, LOG_WARNING);
			return false;
		}
		
		$sindex = Util::cxSeasonIndex($date);
		
		if ($sindex === false) {
			$this->log('2015-16 より前のシーズンは想定していません。', LOG_ERR);
			return false;
		}
		
		$racer = $this->Racer->find('first', array('conditions' => array('code' => $racerCode)));
		
		if (empty($racer)) {
			$this->log('選手が見つかりませんでした（保存処理をスキップします）。選手コード:' . $racerCode, LOG_WARNING);
			return true;
		}
		
		$currCatLimit = $racer['Racer']['cat_limit'];
		
		if (empty($currCatLimit)) $currCatLimit = '';
		//$this->log('curr[' . $currCatLimit . ']=' . strlen($currCatLimit) . ' sindex:' . $sindex, LOG_DEBUG);
		
		$newCatLimit = '';
		if ($sindex < strlen($currCatLimit)) {
			$newCatLimit = substr_replace($currCatLimit, $catLimit->charVal(), $sindex, 1);
		} else {
			$newCatLimit = $currCatLimit;
			while (strlen($newCatLimit) < $sindex) {
				$newCatLimit .= EntryCatLimit::$NONE->charVal();
			}
			$newCatLimit .= $catLimit->charVal();
		}
		
		$ret = $this->Racer->save(array(
			'code' => $racerCode,
			'cat_limit' => $newCatLimit,
		));
		
		if ($ret) {
			$this->log('Racer:' . $racerCode . ' limit:' . $catLimit->name() . ' @' . $date . ' to limit:' . $newCatLimit, LOG_INFO);
		}
		
		return $ret;
	}
	
	/**
	 * シーズン開始日をかえす
	 * @param type $date
	 * @return date
	 */
	private function __seasonStartDate($date)
	{
		if (empty($date)) {
			$date = new DateTime(date('Y-m-d'));
		} else {
			$date = new DateTime($date);
		}
		
		$y = $date->format('Y');
		$m = $date->format('m');
		if ($m < 4) {
			--$y;
		}
		
		return date($y . '-04-01');
	}
	
	/**
	 * シーズン最終日をかえす
	 * @param type $date
	 * @return cate\date
	 */
	private function __seasonEndDate($date)
	{
		if (empty($date)) {
			$date = new DateTime(date('Y-m-d'));
		} else {
			$date = new DateTime($date);
		}
		
		$y = $date->format('Y');
		$m = $date->format('m');
		if ($m >= 4) {
			++$y;
		}
		
		return date($y . '-03-31');
	}
	
	/**
	 * 指定カテゴリーグループを含むカテゴリーのコードの配列をかえす
	 * @param type $categoryGroupId
	 */
	private function __racesCatCodes($categoryGroupId)
	{
		if (empty($categoryGroupId)) return array();
		
		$this->Category->Behaviors->load('Utils.SoftDelete');
		$this->CategoryRacesCategory->Behaviors->load('Utils.SoftDelete');
		
		$cats = $this->Category->find('all', array('conditions' => array('category_group_id' => $categoryGroupId)));
		
		$codes = array();
		foreach ($cats as $cat) {
			$rcrs = $this->CategoryRacesCategory->find('all', array('conditions' => array('category_code' => $cat['Category']['code'])));
			foreach ($rcrs as $rcr) {
				if (!in_array($rcr['CategoryRacesCategory']['races_category_code'], $codes)) {
					$codes[] = $rcr['CategoryRacesCategory']['races_category_code'];
				}
			}
		}
		
		return $codes;
	}
	
	/**
	 * コンソールからのテスト用
	 * > app ディレクトリ
	 * > Console/cake cat_limit updateERacerAtUpdateMeet 2016-10-11 12:00:00
	 */
	public function updateERacerAtUpdateMeet()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$date = $this->args[0] . ' ' . $this->args[1];
		
		$this->__updateERacerAtUpdateMeet($date);
	}
	
	/**
	 * 更新のあった大会に係る EntryRacer.modified を現在日時に設定する。$lastUpdateDate が null の場合は処理は行われない。
	 * @param $lastUpdateDate この date 以降の大会について更新される。
	 * @return 正常に処理を行なったか。
	 */
	private function __updateERacerAtUpdateMeet($lastUpdateDate = null)
	{
		if (empty($lastUpdateDate)) return true;
		
		$this->log('>>> Start __updateERacerAtUpdateMeet with $lastUpdateDate:' . $lastUpdateDate, LOG_DEBUG);

		$eliteRCCodes = $this->__racesCatCodes(EntryCatLimit::$ELITE->catGroupId());
		$mastersRCCodes = $this->__racesCatCodes(EntryCatLimit::$MASTERS->catGroupId());
		
		$query = 'update entry_racers'
				. ' inner join entry_categories on entry_racers.entry_category_id = entry_categories.id'
				. ' inner join entry_groups on entry_categories.entry_group_id = entry_groups.id'
				. ' inner join meets on entry_groups.meet_code = meets.code';
		$query .= " set entry_racers.modified = now()";
		$query .= " where meets.modified >= '" . $lastUpdateDate . "'";
		$query .= ' and ('
					. ' entry_categories.races_category_code in (' . $this->__strArray2commaedSqlStr($eliteRCCodes) . ')'
					. ' or'
					. ' entry_categories.races_category_code in (' . $this->__strArray2commaedSqlStr($mastersRCCodes) . ')'
				. ')';
		$query .= ' and entry_racers.deleted = 0 and meets.deleted = 0;';

		//$this->log('query: ' . $query, LOG_DEBUG);
		try {
			$this->EntryRacer->query($query); // 戻り値は特にない。
		} catch (PDOException $ex) {
			$this->log('大会更新に関わる EntryRacer.modified の更新に失敗しました。PDOException:', LOG_ERR);
			$this->log($ex->getMessage(), LOG_ERR);
			return false;
		}
		
		$sqlLog = $this->Racer->getDataSource()->getLog();
		if (!empty($sqlLog['log'])) {
			$this->log('affected.EntryRacer:' . $sqlLog['log'][count($sqlLog['log']) - 1]['affected'], LOG_DEBUG);
		}
		
		$this->log('<<< End __updateERacerAtUpdateMeet', LOG_DEBUG);

		return true;
	}
	
	/**
	 * 文字列配列をカンマ区切り、かつシングルクォートでエスケープされた文字列に変換する
	 * @param array $strs 
	 * @return string 引数 $strs が array でない場合、空文字をかえす。
	 */
	private function __strArray2commaedSqlStr($strs)
	{
		if (is_array($strs)) {
			$ret = '';
			foreach ($strs as $s) {
				if (!empty($ret)) {
					$ret .= ',';
				}
				$ret .= "'" . $s . "'";
			}
			return $ret;
		} else {
			$this->log('想定しない引数指定です。空文字を返します。', LOG_DEBUG);
			return '';
		}
	}
}
