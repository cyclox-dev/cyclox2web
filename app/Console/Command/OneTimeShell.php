<?php

/* 
 *  created at 2015/12/21 by shun
 */

App::uses('ApiController', 'Controller');
App::uses('Gender', 'Cyclox/Const');
App::uses('OrgUtilController', 'Controller');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('ResultParamCalcComponent', 'Controller/Component'); 
App::uses('AgedCategoryComponent', 'Controller/Component'); 
App::uses('CategoryReason', 'Cyclox/Const');

/**
 * 1回だけの処理に使用する。コンソールから起動する。
 * 例）
 * > cd Cake/app
 * > Console/cake one_time TheMethodName arg,,,
 */
class OneTimeShell extends AppShell
{
	public $uses = array('TransactionManager', 'EntryGroup', 'EntryRacer', 'Racer', 'CategoryRacer'
			, 'RacerResult', 'HoldPoint');
	
	private $__apiController;
	private $__resParamCalc;
	private $__agedCatComp;
	
	public function main()
	{
        $this->out('please input function name as 1st arg.');
    }
	
	// @Override
	function startup()
	{
		$this->__apiController = new ApiController();
		
		$collection = new ComponentCollection();
		$this->__resParamCalc = new ResultParamCalcComponent($collection);
		$this->__agedCatComp = new AgedCategoryComponent($collection);
		
		parent::startup();
	}
	
	/**
	 * EntryRacer.team_name から Racer.team を設定する。コンソールでの処理。起動方法は
	 * > app ディレクトリ
	 * > Console/cake one_time setupTeamName
	 */
	public function setupTeamName()
	{
		$offset = 0;
		
		while (true)
		{
			$opt = array(
				'condifions' => array(
					'and' => array(
						array('not' => array('Meet.at_date' => 'null')),
						array('deleted' => 0)
					)
				),
				'order' => array('Meet.at_date' => 'asc'),
				'limit' => 10,
				'offset' => $offset,
			);
			
			$egroups = $this->EntryGroup->find('all', $opt);
			//$this->out(print_r($egroups));
			
			if (empty($egroups)) break;
			
			foreach ($egroups as $egroup) {
				if (empty($egroup['Meet']['at_date'])) continue;
				if ($egroup['Meet']['deleted'] == 1) continue;
				
				foreach ($egroup['EntryCategory'] as $ecat) {
					if ($ecat['deleted'] == 1) continue;
					
					$opt = array(
						'conditions' => array(
							'and' => array(
								'entry_category_id' => $ecat['id']),
								'EntryRacer.deleted' => 0
							)
					);
					
					$eracers = $this->EntryRacer->find('all', $opt);
					
					foreach ($eracers as $eracer) {
						if (empty($eracer['EntryRacer']['racer_code'])) continue;
						if (empty($eracer['EntryRacer']['team_name'])) continue;
						if ($eracer['Racer']['deleted'] == 1) continue;
						
						$rcode = $eracer['EntryRacer']['racer_code'];
						$team = $eracer['EntryRacer']['team_name'];
						
						$pack = array();
						$pack['Racer'] = array();
						$pack['Racer']['team'] = $team;
						$pack['Racer']['modified'] = date('Y-m-d H:i:s');
						
						$this->Racer->id = $rcode;
						if (!$this->Racer->save($pack)) {
							$this->out('!!! save failed !!!');
							exit();
						}
						
						$this->out('racer:' . $rcode . ' team:' . $team);
					}
				}
			}
			
			$offset += 10;
		}
		
		$this->out('--- END ---');
	}
	
	/**
	 * 内容の重複する CategoryRacer に deleted ステータスを設定する
	 * > app ディレクトリ
	 * > Console/cake one_time setupDuplicatedCatRacerDeleted 0 100
	 */
	public function setupDuplicatedCatRacerDeleted()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$this->out('>>> Start setupDuplicatedCatRacerDeleted');
		
		//$this->out('offset:' . $this->args[0] . ' limit:' . $this->args[1]);
		$offset = $this->args[0];
		$limit = $this->args[1];
		
		$opt = array(
			'recursive' => -1,
			'conditions' => array('deleted' => 0)
		);
		
		//$crs = $this->CategoryRacer->find('all', $opt);
		// find all, delete all では deleted されたものが重複する場合があるので1つ1つ for で回して処理する
		
		$i = $offset;
		for (; $i < $offset + $limit; $i++)
		{
			$opt['offset'] = $i;
			$catRacer = $this->CategoryRacer->find('first', $opt);
			if (empty($catRacer)) break;
			
			$conditions = array(
				'deleted' => 0,
				'NOT' => array('id' => $catRacer['CategoryRacer']['id']),
				'racer_code' => $catRacer['CategoryRacer']['racer_code'],
				'category_code' => $catRacer['CategoryRacer']['category_code'],
				// reason 系, result_id は同一性をチェックしない
				'apply_date' => $catRacer['CategoryRacer']['apply_date'],
			);
			
			if (empty($catRacer['CategoryRacer']['cancel_date'])) {
				$conditions['cancel_date'] = null;
			} else {
				$conditions['OR'] = array(
					array('cancel_date' => null),
					array('cancel_date' => $catRacer['CategoryRacer']['cancel_date'])
				);
			}
			
			$opt2 = array(
				'recursive' => -1,
				'conditions' => $conditions
			);
			
			$crs = $this->CategoryRacer->find('all', $opt2);
			//$this->out('' . $i . ' crs size:' . count($crs));
			
			/*if (!empty($crs)) {
				$this->log('conditions:', LOG_DEBUG);
				$this->log($conditions, LOG_DEBUG);
			}//*/
			
			foreach ($crs as $cr) {
				$this->CategoryRacer->id = $cr['CategoryRacer']['id'];
				
				//$this->log($cr, LOG_DEBUG);
				
				if (!$this->CategoryRacer->delete()) {
					$this->out('category racer [id:' . $cr['CategoryRacer']['id'] . '] の削除に失敗');
					return;
				} else {
					$this->out('deleted id:' . $cr['CategoryRacer']['id'] . ' by ' . $catRacer['CategoryRacer']['id']);
				}//*/
			}
			
			if (!empty($crs)) {
				$this->out('選手コード[' . $catRacer['CategoryRacer']['racer_code'] . ']の ' . count($crs) . '件のカテゴリー所属を削除しました。');
			}
		}
		
		if ($i - $offset < $limit) {
			$this->out('指定した件数がありませんでした（処理終了の可能性）');
		}
		
		$this->out('<<< End setupDuplicatedCatRacerDeleted');
	}
	
	/**
	 * RacerResult に as_category param を設定する
	 * > cd app ディレクトリ
	 * > Console/cake one_time setupAsCategory 0 100
	 */
	public function setupAsCategory()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$this->out('>>> Start setupsetupAsCategoryDuplicatedCatRacerDeleted');
		$this->out('offset:' . $this->args[0] . ' limit:' . $this->args[1]);
		
		$opt = array(
			'offset' => $this->args[0],
			'limit' => $this->args[1],
			'recursive' => -1,
			'conditions' => array('deleted' => 0)
		);
		
		$this->RacerResult->Behaviors->load('Utils.SoftDelete');
		$rrs = $this->RacerResult->find('all', $opt);
		
		$this->EntryRacer->Behaviors->load('Utils.SoftDelete');
		$this->EntryRacer->Behaviors->load('Containable');
		
		$erOpt = array(
			'contain' => array(
				'EntryCategory' => array(
					'EntryGroup' => array(
						'fields' => array(),
						'Meet' => array(
							'fields' => array('at_date')
						)
					)
				)
			)
		);
		
		$countSuccess = 0;
		$countFailed = 0;
		$countNoNeed = 0;
		
		foreach ($rrs as $result) {
			if (!empty($result['RacerResult']['as_category'])) {
				++$countNoNeed;
				continue;
			}
			
			$erOpt['conditions'] = array('EntryRacer.id' => $result['RacerResult']['entry_racer_id']);
			
			$er = $this->EntryRacer->find('first', $erOpt);
			
			if (empty($er) || empty($er['EntryRacer']['racer_code'])) {
				$this->out('result[id:' . $result['RacerResult']['id'] . '] について、EntryRacer もしくは'
					. 'それに関する選手コードが empty です。');
				continue;
			}
			
			if (empty($er['EntryCategory'])) {
				$this->out('result[id:' . $result['RacerResult']['id'] . '] について、出走カテゴリーが empty です。');
				continue;
			}
			
			if (empty($er['EntryCategory']['EntryGroup']['Meet']['at_date'])) {
				$this->out('result[id:' . $result['RacerResult']['id'] . '] について、Meet.at_date が empty です。');
				continue;
			}
			
			$asCat = $this->__resParamCalc->asCategory($er['EntryRacer']['racer_code'], $er['EntryCategory']
					, $er['EntryCategory']['EntryGroup']['Meet']['at_date']);
			
			if (empty($asCat)) {
				$this->out('result[id:' . $result['RacerResult']['id'] . '] について有効な as category を取得できませんでした。');
				continue;
			}
			
			$r = array();
			$r['RacerResult'] = $result['RacerResult'];
			$r['RacerResult']['as_category'] = $asCat;
			
			if ($this->RacerResult->save($r)) {
				$this->out('result[id:' . $result['RacerResult']['id'] . '] につい as_category を設定。');
				++$countSuccess;
			} else {
				$this->out('result[id:' . $result['RacerResult']['id'] . '] につい保存に失敗しました。');
				++$countFailed;
			}
		}
		
		if (count($rrs) < $this->args[1]) {
			$this->out('指定した件数がありませんでした（処理終了の可能性）');
		}
		
		$this->out('処理数 succcess:' . $countSuccess . ' failed:' . $countFailed . ' notNeed:' . $countNoNeed);
		$this->out('<<< End setupAsCategory');
	}
	
	/**
	 * 順位ありで ajocc point がついていない箇所について ajocc point を設定する。
	 * > cd app ディレクトリ
	 * > Console/cake one_time setupAjoccPtToEmpty 0 100
	 */
	public function setupAjoccPtToEmpty()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$this->out('>>> Start setupAjoccPtToEmpty');
		$this->out('offset:' . $this->args[0] . ' limit:' . $this->args[1]);
		
		$this->RacerResult->Behaviors->load('Utils.SoftDelete');
		$this->RacerResult->Behaviors->load('Containable');
		
		$opt = array(
			'offset' => $this->args[0],
			'limit' => $this->args[1],
			'conditions' => array(
				'ajocc_pt' => 0,
				'NOT' => array('rank' => null),
				'rank <=' => '60'
			),
			'contain' => array(
				'EntryRacer' => array(
					'EntryCategory'
				)
			)
		);
		
		$rrs = $this->RacerResult->find('all', $opt);
		
		$list4Save = array();
		$ids = '';
		
		foreach ($rrs as $rr) {
			if (empty($rr['EntryRacer']['entry_category_id'])) {
				$this->out('出走カテゴリー ID が設定されていません。');
				continue;
			}
			
			if (!empty($rr['EntryRacer']['EntryCategory']['applies_ajocc_pt'])
					&& !$rr['EntryRacer']['EntryCategory']['applies_ajocc_pt']) {
				continue;
			}
			
			//$this->log('rr is', LOG_DEBUG);
			//$this->log($rr, LOG_DEBUG);
			
			// 出走人数をカウント
			$ecatId = $rr['EntryRacer']['entry_category_id'];
			$started = $this->__calcStartedCount($ecatId);
			
			$pt = 0;
			$isOpenRacer = ($rr['EntryRacer']['entry_status'] == RacerEntryStatus::$OPEN->val());
			
			if (!$isOpenRacer && isset($rr['RacerResult']['rank'])) {
				$pt = $this->__resParamCalc->calcAjoccPt($rr['RacerResult']['rank'], $started);
				$this->out('result:' . $rr['RacerResult']['id'] . '-ecat[id:' . $ecatId . '] 出走人数:' . $started . ' point:' . $pt);
			}
			
			if ($pt !== -1) {
				$result = array(
					'id' => $rr['RacerResult']['id'],
					'ajocc_pt' => $pt,
				);
				$list4Save[] = $result;
				$ids .= $rr['RacerResult']['id'] . '/' . $pt . ',';
			} else {
				$this->out('EntryRacer[id:' . $rr['EntryRacer']['id'] . '] について、Ajocc Point の計算に失敗しました。');
			}
		}
		
		//$this->out('list is');
		//$this->out(var_export($list4Save));
		
		if (!empty($list4Save)) {
			if ($this->RacerResult->saveMany($list4Save)) {
				$this->out('Result[' . $ids . '] を保存しました。');
			} else {
				$this->out('Result[' . $ids . '] について、保存に失敗しました。');
			}
		}
		
		$this->out('<<< End setupAjoccPtToEmpty');
	}
	
	/**
	 * 出走人数をかえす
	 * @param int $ecatId 出走カテゴリー ID
	 * @return int 出走人数
	 */
	private function __calcStartedCount($ecatId)
	{
		if (empty($ecatId)) return null;
		
		$this->EntryRacer->Behaviors->load('Utils.SoftDelete');
		$this->EntryRacer->Behaviors->load('Containable');
		
		$opt = array(
			'conditions' => array(
				'entry_category_id' => $ecatId
			),
			'contain' => array(
				'RacerResult' => array(
					'fields' => array(
						'status'
					)
				)
			)
		);
		
		$started = 0;
		
		$eracers = $this->EntryRacer->find('all', $opt);
		
		foreach ($eracers as $er) {
			if (isset($er['RacerResult']['status'])) {
				if ($er['RacerResult']['status'] != RacerResultStatus::$DNS->val()) {
					++$started;
				}
			}
		}
		
		return $started;
	}
	
	/**
	 * 2015-16 シーズンのリザルトから降格処理を行なう
	 * > cd app ディレクトリ
	 * > Console/cake one_time execCategoryDown1516 0 100
	 */
	public function execCategoryDown1516()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$offset = $this->args[0];
		$limit = $this->args[1];
		
		$this->out('>>> Start execCategoryDown');
		
		$this->CategoryRacer->Behaviors->load('Containable');
		$this->EntryRacer->Behaviors->load('Containable');
		
		// 現在有効な catRacer を取得（降格処理を行なうカテゴリーのみ）
		$opt = array(
			'recursive' => -1,
			'conditions' => array(
				'CategoryRacer.deleted' => 0,
				'OR' => array(
					array('category_code' => 'C1'),
					array('category_code' => 'C2'),
					array('category_code' => 'C3'),
					array('category_code' => 'CM1'),
					array('category_code' => 'CM2'),
				)
			),
			'offset' => $offset,
			'limit' => $limit,
			'contain' => array(
				'Racer',
			),
		);
		
		$crs = $this->CategoryRacer->find('all', $opt);
		
		//$this->out('crs is,,,');
		//$this->out(print_r($crs));
		
		$this->log('Log of execCategoryDown1516 start ---', LOG_DEBUG);
		$transaction = $this->TransactionManager->begin();
		
		$skipCanceled = 0;
		$skipNewApplied = 0;
		$skipDeleted = 0;
		$index = 0;
		$downCatCount = array(
			'C1' => 0,
			'C2' => 0,
			'C3' => 0,
			'CM1' => 0,
			'CM2' => 0,
		);
		
		$hasError = false;

		foreach ($crs as $cr) {
			++$index;
			if (empty($cr['Racer']) || $cr['Racer']['deleted'] == 1) {
				++$skipDeleted;
				continue;
			}
			
			if (!empty($cr['CategoryRacer']['cancel_date'])) {
				++$skipCanceled;
				continue; // offset 値をキープしたいので、find の条件文には入れていない
			}
			
			if (!empty($cr['CategoryRacer']['apply_date']) && $cr['CategoryRacer']['apply_date'] > '2016-03-31') {
				++$skipNewApplied;
				continue; // offset 値をキープしたいので、find の条件文には入れていない
			}
			
			// 関連するリザルトと紐づく残留ポイントを取得
			
			$this->out('cr racer_code:' . $cr['CategoryRacer']['racer_code'] . ' cat:' . $cr['CategoryRacer']['category_code']);
			$erOpt = array(
				'recursive' => -1,
				'conditions' => array(
					'EntryRacer.deleted' => 0,
					'RacerResult.deleted' => 0,
					'racer_code' => $cr['CategoryRacer']['racer_code'],
					//'HoldPoint.category_code' => $cr['CategoryRacer']['category_code'] <- これはできず
				),
				'contain' => array(
					'RacerResult' => array(
						'HoldPoint',
					),
					'EntryCategory' => array(
						'fields' => array('name', 'deleted'),
						'EntryGroup' => array(
							'fields' => array('deleted'),
							'Meet'
						)
					)
				)
			);
			
			$ers = $this->EntryRacer->find('all', $erOpt);
			
			/*if (!empty($ers)) {
				$this->out('er is,,,');
				$this->out(print_r($ers));
			}//*/
			
			// 残留ポイントの集計
			$pt = 0;
			$ptLog = '';
			
			foreach ($ers as $er) {
				if (!empty($er['RacerResult']['HoldPoint'])) {
					
					if (empty($er['EntryCategory']['EntryGroup']['Meet'])
						|| $er['EntryCategory']['EntryGroup']['Meet']['deleted'] == 1
						|| $er['EntryCategory']['EntryGroup']['deleted'] == 1
						|| $er['EntryCategory']['deleted'] == 1) {
						continue;
					}
					foreach ($er['RacerResult']['HoldPoint'] as $hp) {
						if ($hp['category_code'] == $cr['CategoryRacer']['category_code']) {
							$pt += $hp['point'];
							$ptLog .= $er['EntryCategory']['EntryGroup']['Meet']['code'] . '/' . $er['EntryCategory']['name']
									. ':' . $hp['point'] . 'pt,';
						}
					}
				}
			}
			
			$ptLog = 'crid:' . $cr['CategoryRacer']['id'] . ',' . $cr['Racer']['code'] . ','
					. $cr['Racer']['family_name']. ',' . $cr['Racer']['first_name']
					. ',' . $cr['CategoryRacer']['category_code'] . ',残留pt:' . $pt . ',log:' . $ptLog;
			
			// 降格処理
			if ($pt < 3) {
				// 降格処理
				$catToList = array(
					'C1' => 'C2',
					'C2' => 'C3',
					'C3' => 'C4',
					'CM1' => 'CM2',
					'CM2' => 'CM3',
				);
				
				$catTo = $catToList[$cr['CategoryRacer']['category_code']];
				if (empty($catTo)) {
					$this->log('降格先カテゴリーが見つかりません。' . $ptLog, LOG_ERR);
					$hasError = true;
					break;
				}
				
				 // 現在のカテゴリー所属に cancel_date を設定
				$categoryRacer = array(
					'id' => $cr['CategoryRacer']['id'],
					'cancel_date' => '2016-03-31',
					// reason_note は無し
				);
				$ptLog = $ptLog;
				if (!$this->CategoryRacer->save($categoryRacer)) {
					$this->log('カテゴリー所属の cancel_date 設定に失敗。' . $ptLog, LOG_ERR);
					$hasError = true;
					break;
				}
				
				$categoryRacer = array(
					'racer_code' => $cr['Racer']['code'],
					'category_code' => $catTo,
					'apply_date' => '2016-04-01',
					'reason_id'=> CategoryReason::$SEASON_DOWN->ID(),
					'reason_note' => '2015-16シーズン成績の降格処理による'
				);
				$this->CategoryRacer->create(); // id をリセットしておく
				if (!$this->CategoryRacer->save($categoryRacer)) {
					$this->log('カテゴリー所属の新規作成に失敗。' . $ptLog, LOG_DEBUG);
					$this->TransactionManager->rollback($transaction);
					break;
				}
				
				$downCatCount[$cr['CategoryRacer']['category_code']] = $downCatCount[$cr['CategoryRacer']['category_code']] + 1;
				$ptLog = '降格,' . $cr['CategoryRacer']['category_code'] . '→' . $catTo . ',' . $ptLog;
			} else {
				$ptLog = 'KEEP,---,' . $ptLog;
			}

			$this->log($index . ',' . $ptLog, LOG_DEBUG);
		} // end foreach $crs
		
		if ($hasError) {
			$this->TransactionManager->rollback($transaction);
		} else {
			$this->TransactionManager->commit($transaction);
		
			$skipLog = 'skip(canceled):' . $skipCanceled . ', skip(new):' . $skipNewApplied
					. ', deleted:' . $skipDeleted . ',降格:';
			foreach ($downCatCount as $k => $v) {
				$skipLog .= ',' . $k . ':' . $v;
			}
			$this->log($skipLog, LOG_DEBUG);
		}
		$this->log('Log of execCategoryDown1516 end ---', LOG_DEBUG);
	}
	
	/**
	 * 2016-17 シーズンのリザルトから降格処理を行なう
	 * > cd app ディレクトリ
	 * > Console/cake one_time execCategoryDown1617 0 100
	 * > Console/cake one_time execCategoryDown1617 0 100 logonly
	 * logonly オプションでは Transaction をコミットせず、ログのみ出力する。
	 */
	public function execCategoryDown1617()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$offset = $this->args[0];
		$limit = $this->args[1];
		
		$commits = true;
		if (isset($this->args[2]) && $this->args[2] == 'logonly') {
			$commits = false;
		}
		
		$this->out('>>> Start execCategoryDown');
		
		$this->CategoryRacer->Behaviors->load('Containable');
		$this->EntryRacer->Behaviors->load('Containable');
		
		// 現在有効な catRacer を取得（降格処理を行なうカテゴリーのみ）
		$opt = array(
			'recursive' => -1,
			'conditions' => array(
				'CategoryRacer.deleted' => 0,
				'OR' => array(
					array('category_code' => 'C1'),
					array('category_code' => 'C2'),
					array('category_code' => 'C3'),
					array('category_code' => 'CM1'),
					array('category_code' => 'CM2'),
				)
			),
			'offset' => $offset,
			'limit' => $limit,
			'contain' => array(
				'Racer',
			),
		);
		
		$crs = $this->CategoryRacer->find('all', $opt);
		
		//$this->out('crs is,,,');
		//$this->out(print_r($crs));
		
		$this->log('Log of execCategoryDown1617 start ---', LOG_DEBUG);
		$transaction = $this->TransactionManager->begin();
		
		$skipCanceled = 0;
		$skipNewApplied = 0;
		$skipDeleted = 0;
		$index = 0;
		$downCatCount = array(
			'C1' => 0,
			'C2' => 0,
			'C3' => 0,
			'CM1' => 0,
			'CM2' => 0,
		);
		
		$hasError = false;

		foreach ($crs as $cr) {
			++$index;
			if (empty($cr['Racer']) || $cr['Racer']['deleted'] == 1) {
				++$skipDeleted;
				continue;
			}
			
			if (!empty($cr['CategoryRacer']['cancel_date'])) {
				++$skipCanceled;
				continue; // offset 値をキープしたいので、find の条件文には入れていない
			}
			
			if (!empty($cr['CategoryRacer']['apply_date']) && $cr['CategoryRacer']['apply_date'] > '2017-03-31') {
				++$skipNewApplied;
				continue; // offset 値をキープしたいので、find の条件文には入れていない
			}
			
			// 関連するリザルトと紐づく残留ポイントを取得
			
			//$this->out('cr racer_code:' . $cr['CategoryRacer']['racer_code'] . ' cat:' . $cr['CategoryRacer']['category_code']);
			
			$query = 'select * from entry_racers'
					. ' inner join entry_categories on entry_racers.entry_category_id = entry_categories.id'
					. ' inner join entry_groups on entry_categories.entry_group_id = entry_groups.id'
					. ' inner join meets on entry_groups.meet_code = meets.code'
					. ' inner join racer_results on entry_racers.id = racer_results.entry_racer_id'
					. ' inner join hold_points on hold_points.racer_result_id = racer_results.id';
			$query .= ' where entry_racers.deleted = 0'
					. ' and racer_results.deleted = 0'
					. ' and entry_categories.deleted = 0'
					. " and entry_groups.deleted = 0"
					. " and meets.deleted = 0"
					. " and meets.at_date > '2016-08-01' and meets.at_date < '2017-04-01'"
					. " and racer_code = '" . $cr['CategoryRacer']['racer_code'] . "'"
					. " and hold_points.category_code = '" . $cr['CategoryRacer']['category_code'] . "'";
			
			$ers = $this->EntryRacer->query($query);
			/*
			$this->log('ers[0]:', LOG_DEBUG);
			$this->log($ers[0], LOG_DEBUG);
			
			$this->log('ers[1]:', LOG_DEBUG);
			$this->log($ers[1], LOG_DEBUG);
			/*
			$ers = $this->EntryRacer->find('all', $erOpt);
			
			$this->log('ers[0]:', LOG_DEBUG);
			$this->log($ers[0], LOG_DEBUG);
			//*/
			
			/*if (!empty($ers)) {
				$this->out('er is,,,');
				$this->out(print_r($ers));
			}//*/
			
			// 残留ポイントの集計
			$pt = 0;
			$ptLog = '';
			
			foreach ($ers as $er) {
				if (!empty($er['hold_points'])) {
					$hp = $er['hold_points'];
					$pt += $hp['point'];
					$ptLog .= $er['meets']['code'] . '/' . $er['entry_categories']['name']
							. ':' . $hp['point'] . 'pt,';
				}
			}
			
			$ptLog = 'crid:' . $cr['CategoryRacer']['id'] . ',' . $cr['Racer']['code'] . ','
					. $cr['Racer']['family_name']. ',' . $cr['Racer']['first_name']
					. ',' . $cr['CategoryRacer']['category_code'] . ',残留pt:' . $pt . ',log:' . $ptLog;
			
			// 降格処理
			if ($pt < 3) {
				// 降格処理
				$catToList = array(
					'C1' => 'C2',
					'C2' => 'C3',
					'C3' => 'C4',
					'CM1' => 'CM2',
					'CM2' => 'CM3',
				);
				
				$catTo = $catToList[$cr['CategoryRacer']['category_code']];
				if (empty($catTo)) {
					$this->log('降格先カテゴリーが見つかりません。' . $ptLog, LOG_ERR);
					$hasError = true;
					break;
				}
				
				 // 現在のカテゴリー所属に cancel_date を設定
				$categoryRacer = array(
					'id' => $cr['CategoryRacer']['id'],
					'cancel_date' => '2017-03-31',
					// reason_note は無し
				);
				
				if (!$this->CategoryRacer->save($categoryRacer)) {
					$this->log('カテゴリー所属の cancel_date 設定に失敗。' . $ptLog, LOG_ERR);
					$hasError = true;
					break;
				}
				
				$categoryRacer = array(
					'racer_code' => $cr['Racer']['code'],
					'category_code' => $catTo,
					'apply_date' => '2017-04-01',
					'reason_id'=> CategoryReason::$SEASON_DOWN->ID(),
					'reason_note' => '2016-17シーズン成績の降格処理による'
				);
				$this->CategoryRacer->create(); // id をリセットしておく
				if (!$this->CategoryRacer->save($categoryRacer)) {
					$this->log('カテゴリー所属の新規作成に失敗。' . $ptLog, LOG_DEBUG);
					$this->TransactionManager->rollback($transaction);
					break;
				}
				
				$downCatCount[$cr['CategoryRacer']['category_code']] = $downCatCount[$cr['CategoryRacer']['category_code']] + 1;
				$ptLog = '降格,' . $cr['CategoryRacer']['category_code'] . '→' . $catTo . ',' . $ptLog;
			} else {
				$ptLog = 'KEEP,---,' . $ptLog;
			}

			$this->log($index . ',' . $ptLog, LOG_DEBUG);
		} // end foreach $crs
		
		if ($hasError) {
			$this->TransactionManager->rollback($transaction);
		} else {
			if ($commits) {
				$this->TransactionManager->commit($transaction);
			} else {
				$this->TransactionManager->rollback($transaction);
				$this->log(' ROLLBACK for test', LOG_DEBUG);
			}
			
			$skipLog = 'skip(canceled):' . $skipCanceled . ', skip(new):' . $skipNewApplied
					. ', deleted:' . $skipDeleted . ',降格:';
			foreach ($downCatCount as $k => $v) {
				$skipLog .= ',' . $k . ':' . $v;
			}
			$this->log($skipLog, LOG_DEBUG);
		}
		$this->log('Log of execCategoryDown1617 end ---', LOG_DEBUG);
	}

	/**
	 * 名前（姓+名）が重複する選手を抽出し、ログに出力するする。
	 * > cd app ディレクトリ
	 * > Console/cake one_time extractNameDuplicatedRacers
	 */
	public function extractNameDuplicatedRacers()
	{
		$offset = 0;
		$limit = 500;
		
		$this->out('>>> Start extractNameDuplicatedRacers');
		
		while (true) {
			$opt = array(
				'recursive' => -1,
				'conditions' => array(
					'Racer.deleted' => 0,
				),
				'offset' => $offset,
				'limit' => $limit,
				// category は人間によるチェックとする
			);

			$racers = $this->Racer->find('all', $opt);

			if (empty($racers)) {
				$this->log('could not find racers... break.', LOG_DEBUG);
				break;
			} else {
				$index = -1;
				foreach ($racers as $racer) {
					++$index;
					$nameContition = $this->__createSameNameConditions($racer);
					//$this->log('conditions:', LOG_DEBUG);
					//$this->log($nameContition, LOG_DEBUG);

					if (empty($nameContition)) {
						continue;
					}

					$ropt = array(
						'recursive' => -1,
						'conditions' => array(
							'deleted' => 0,
							'OR' => $nameContition,
							'NOT' => array('code' => $racer['Racer']['code'])
						)
					);
					$theIndex = $offset + $index;
					//$this->log('index:' . $theIndex, LOG_DEBUG);
					//$this->log($ropt, LOG_DEBUG);

					$rs = $this->Racer->find('all', $ropt);
					if (empty($rs)) {
						//$this-log('rs is empty,,,', LOG_DEBUG);
						continue;
					}

					// $racer['Racer']['code'} が最も古いコードでなければ skip する。
					$rcodeNum = $this->__racerCodeNumberValue($racer['Racer']['code']);
					if ($rcodeNum === false) {
						$this->log('選手コードナンバーが取得できません:' . $racer['Racer']['code'], LOG_ERR);
					}
					$continues = false;
					foreach ($rs as $r) {
						$num = $this->__racerCodeNumberValue($r['Racer']['code']);
						if ($num === false) {
							$this->log('選手コードナンバーが取得できません' . $r['Racer']['code'], LOG_ERR);
						}
						if ($num < $rcodeNum) {
							$continues = true;
							break;
						}
					}
					if ($continues) {
						continue;
					}
					unset($r);
					
					$birth = $this->__createBirthExpress($racer['Racer']['birth_date']);

					$this->log('<< ORIGINAL >>,' . $theIndex . ',' . $racer['Racer']['code']
							. ',' . $racer['Racer']['family_name'] . ',' . $racer['Racer']['first_name']
							. ',' . $racer['Racer']['family_name_kana'] . ',' . $racer['Racer']['first_name_kana']
							. ',' . $racer['Racer']['family_name_en'] . ',' . $racer['Racer']['first_name_en']
							. ',Team:' . $racer['Racer']['team'] . ',' . $racer['Racer']['prefecture'] . ',Birth:' . $birth, LOG_DEBUG);

					$smallIndex = 1;

					foreach ($rs as $r) {
						$bt = $this->__createBirthExpress($r['Racer']['birth_date']);

						$msg = '';
						if ($racer['Racer']['family_name'] === $r['Racer']['family_name']
								&& $racer['Racer']['first_name'] === $r['Racer']['first_name']) {
							$msg .= ',ok';
						} else {
							$msg .= ',氏名異なる！';
						}
						if ($racer['Racer']['birth_date'] == '---'
								|| $r['Racer']['birth_date'] == '---') {
							$msg .= ',---';
						} else if ($racer['Racer']['birth_date'] === $r['Racer']['birth_date']) {
							$msg .= ',ok';
						} else {
							$msg .= ',誕生日異なる！';
						}
						if (empty($racer['Racer']['prefecture']) || empty($r['Racer']['prefecture'])) {
							$msg .= ',---';
						} else if ($racer['Racer']['prefecture'] == $r['Racer']['prefecture']) {
							$msg .= ',ok';
						} else {
							$msg .= ', 県異なる！';
						}

						$this->log(',' . $theIndex . '-' . $smallIndex . ',' .  $r['Racer']['code']
							. ',' . $r['Racer']['family_name'] . ',' . $r['Racer']['first_name']
							. ',' . $r['Racer']['family_name_kana'] . ',' . $r['Racer']['first_name_kana']
							. ',' . $r['Racer']['family_name_en'] . ',' . $r['Racer']['first_name_en']
							. ',Team:' . $r['Racer']['team'] . ',' . $r['Racer']['prefecture'] . ',Birth:' . $bt . $msg, LOG_DEBUG);

						++$smallIndex;
					}
					$this->log('', LOG_DEBUG);
				}
			}
			
			$offset += $limit;
		}
		
		$this->out('<<< End extractNameDuplicatedRacers');
	}
	
	/**
	 * @private
	 * extractNameDuplicatedRacers 用メソッド。名前同一チェック用の条件 array を作成する。
	 * @param type $racer 選手情報 key:Racer, value:array を持つ。
	 */
	private function __createSameNameConditions($racer)
	{
		$conditions = array();
		
		if (!empty($racer['Racer']['family_name']) && !empty($racer['Racer']['first_name'])) {
			$conditions[] = array(
				'AND' => array(
					'family_name ' => $racer['Racer']['family_name'],
					'first_name' => $racer['Racer']['first_name'],
				)
			);
		}
		/*
		 * カナ, en 名前は対象外とした。
		if (!empty($racer['Racer']['family_name_kana']) && !empty($racer['Racer']['first_name_kana'])) {
			$conditions[] = array(
				'AND' => array(
					'family_name_kana' => $racer['Racer']['family_name_kana'],
					'first_name_kana' => $racer['Racer']['first_name_kana'],
				)
			);
		}
		if (!empty($racer['Racer']['family_name_en']) && !empty($racer['Racer']['first_name_en'])) {
			$conditions[] = array(
				'AND' => array(
					'family_name_en' => $racer['Racer']['family_name_en'],
					'first_name_en' => $racer['Racer']['first_name_en'],
				)
			);
		}//*/
		
		if (empty($conditions)) {
			return array();
		}
		
		return $conditions;
	}
	
	/**
	 * extractNameDuplicatedRacers 用メソッド。選手コードのナンバー部分を数値に変換する。例）-156-0023 -> 1,560,023
	 * @param type $racerCode
	 */
	private function __racerCodeNumberValue($racerCode)
	{
		if (empty($racerCode)) {
			return false;
		}
		
		$str1 = substr($racerCode, 4, 3);
		$str2 = substr($racerCode, 8, 4);
		
		if ($str1 === false || $str2 === false) {
			$this->log('選手コードからのナンバー抽出に失敗しました。' . $racerCode, LOG_DEBUG);
			return false;
		}
		
		return intval($str1) * 10000 + intval($str2);
	}
	
	/**
	 * 誕生日表現をかえす。1900年などの場合は '---' をかえす
	 * @param string $birthStr date(Y-m-d) 形式の文字列
	 * @return string 誕生日表現
	 */
	private function __createBirthExpress($birthStr)
	{
		$birth = '---';
		if (!empty($birthStr)) {
			$date = DateTime::createFromFormat("Y-m-d", $birthStr);
			$year = $date->format("Y");
			if ($year > 1901) {
				$birth = $birthStr;
			}
		}
		
		return $birth;
	}
	
	/**
	 * 姓、名、カナ姓、カナ名のいずれかが空の選手を抽出し、ログに出力するする。
	 * > cd app ディレクトリ
	 * > Console/cake one_time extractEmptyNameRacers 0 100
	 */
	public function extractEmptyNameRacers()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$offset = $this->args[0];
		$limit = $this->args[1];
		
		$this->log('>>> Start extractNameDuplicatedRacers', LOG_DEBUG);
		
		$opt = array(
			'recursive' => -1,
			'conditions' => array(
				'deleted' => 0,
				'OR' => array(
					'first_name' => '',
					'family_name' => '',
					'first_name_kana' => '',
					'family_name_kana' => '',
				)
			),
			'offset' => $offset,
			'limit' => $limit,
			// category は人間によるチェックとする
		);
		
		$racers = $this->Racer->find('all', $opt);
		
		$theIndex = 1;
		foreach ($racers as $racer) {
			$this->log('<< ORIGINAL >>,' . $theIndex . ',' . $racer['Racer']['code']
					. ',' . $racer['Racer']['family_name'] . ',' . $racer['Racer']['first_name']
					. ',' . $racer['Racer']['family_name_kana'] . ',' . $racer['Racer']['first_name_kana']
					. ',Team:' . $racer['Racer']['team'] . ',' . $racer['Racer']['prefecture'], LOG_DEBUG);
			++$theIndex;
		}
		
		$this->log('>>> End extractNameDuplicatedRacers', LOG_DEBUG);
	}
	
	/**
	 * 選手統合処理を行なう
	 * > cd app ディレクトリ
	 * > Console/cake one_time uniteRacer united uniteTo
	 */
	public function uniteRacer()
	{
		if (!isset($this->args[0]) || !isset($this->args[1])) {
			$this->out('2つの引数（整数／offset 位置, 処理件数）が必要です。');
			return;
		}
		
		$united= $this->args[0];
		$uniteTo = $this->args[1];
		
		$this->log('>>> Start uniteRacer', LOG_DEBUG);
		
		$orgUtilController = new OrgUtilController();
		
		if ($orgUtilController->uniteRacer($united, $uniteTo, 'shell による処理です。')) {
			$this->log('uniteRacer:' . $united . ' to ' . $uniteTo . ' succeeded.', LOG_INFO);
		} else {
			$this->log('uniteRacer:' . $united . ' to ' . $uniteTo . ' failed...', LOG_ERR);
		}
		
		$this->log('>>> End uniteRacer', LOG_DEBUG);
	}
	
	/**
	 * 全ての選手に対して aged category のチェック・設定を行なう。
	 * > cd app ディレクトリ
	 * > Console/cake one_time setupAgedCategory
	 */
	public function setupAgedCategory()
	{
		$date = date('Y/m/d');
		
		if (isset($this->args[0])) {
			$date = $this->args[0];
			if (DateTime::createFromFormat('Y-m-d', $date) === FALSE) {
				$this->log('1st arg is incorrect date format.');
				return;
			}
		}
		
		$this->log('date is:' . $date, LOG_DEBUG);
		
		$offset = 0;
		$limit = 50;
		$index = 0;
		
		$this->log('>>> Start setupAgedCategory', LOG_INFO);
		
		while (true) {
			// >>> Transaction
			$transaction = $this->TransactionManager->begin();

			$opt = array(
				'recursive' => -1,
				'conditions' => array(
					'Racer.deleted' => 0,
					array('NOT' => array('birth_date' => null)),
					//array('NOT' => array('gender' => Gender::$UNASSIGNED->val())),
				),
				'offset' => $offset,
				'limit' => $limit,
			);
			
			$racers = $this->Racer->find('all', $opt);
			
			if (empty($racers)) {
				$this->log('could not find racers... break.', LOG_DEBUG);
				break;
			}
			
			foreach ($racers as $r) {
				++$index;
				$this->log('--- index:' . $index . ' [' . $r['Racer']['code'] . '] '
						. $r['Racer']['family_name'] . ' ' . $r['Racer']['first_name']
						. ' ' . $r['Racer']['birth_date'] . ' gen:' . $r['Racer']['gender'], LOG_DEBUG);
				
				if (!$this->__agedCatComp->checkAgedCategory($r['Racer']['code'], $date, false)) {
					$this->log('code:' . $r['Racer']['code'] . ' の処理に失敗しました。', LOG_ERR);
					$this->TransactionManager->rollback($transaction);
					return;
				}
			}
			
			$this->TransactionManager->commit($transaction);
			// <<< Transaction

			$offset += $limit;
		}
		
		$this->log('<<< End setupAgedCategory', LOG_INFO);
	}
	
	/**
	 * 選手コード指定でカテゴリー所属
	 * > cd app ディレクトリ
	 * > Console/cake one_time checkAgedCategory KNS-156-0023 2016-04-01
	 */
	public function checkAgedCategory()
	{
		if (!isset($this->args[1])) {
			$this->log('2 arg needs.', LOG_ERR);
			return;
		}
		$date = $this->args[1];
		$this->log('date is', LOG_DEBUG);
		$this->log($date, LOG_DEBUG);
		
		if (DateTime::createFromFormat('Y-m-d', $date) !== FALSE) {
			$this->log('2nd arg is incorrect date format.', LOG_ERR);
			return;
		}
		
		$code = $this->args[0];
		
		if (!$this->__agedCatComp->checkAgedCategory($code, $date, false)) {
			$this->log('code:' . $code . ' の処理に失敗しました。', LOG_ERR);
		}
		$this->log('end,,,', LOG_DEBUG);
	}
	
	/**
	 * カテゴリー所属から性別を設定する
	 * > cd app ディレクトリ
	 * > Console/cake one_time setupGenderFromCats
	 */
	public function setupGenderFromCats()
	{
		// Women 系統持っているなら Lady
		// そうでく、Elite, Masters, CJ, U15, U17 持っているなら Men
		
		$ladyCats = array('CL1', 'CL2', 'CL3');
		$menCats = array('C1', 'C2', 'C3', 'C4', 'CM1', 'CM2', 'CM3', 'CM4', 'CJ', 'U15', 'U17');
		
		$opt = array(
			'recursive' => -1,
			'conditions' => array(
				'Racer.deleted' => 0,
				array('gender' => Gender::$UNASSIGNED->val()),
			)
		);
		
		$count = $this->Racer->find('count', $opt);
		if ($count <= 0) {
			$this->log('処理なし', LOG_INFO);
			return;
		}
		
		$offset = $count - 50; // 逆順でやっていく
		if ($offset < 0) $offset = 0;
		$limit = 50;
		
		$opt['recursive'] = 1;
		
		$this->log('>>> Start setupGenderFromCats', LOG_INFO);
		
		// >>> Transaction
		$transaction = $this->TransactionManager->begin();
		
		$index = 0;
		while (true) {
			$opt['offset'] = $offset;
			$opt['limit'] = $limit;
			
			$racers = $this->Racer->find('all', $opt);
			
			if (empty($racers)) {
				$this->log('could not find racers... break.', LOG_DEBUG);
				break;
			}
			
			foreach ($racers as $r) {
				++$index;
				if (empty($r['CategoryRacer'])) continue;
				
				$ladiesCat = null;
				foreach ($r['CategoryRacer'] as $cr) {
					if (in_array($cr['category_code'], $ladyCats)) {
						$ladiesCat = $cr['category_code'];
						break;
					}
				}
				
				if (!empty($ladiesCat)) {
					$this->log('[' . $index . '] Racer:' . $r['Racer']['code'] . ' gender:Lady from cat:' . $ladiesCat, LOG_DEBUG);
					$param = array(
						'code' => $r['Racer']['code'],
						'gender' => Gender::$FEMALE->val()
					);
					$this->Racer->create();
					if (!$this->Racer->save($param)) {
						$this->log('code:' . $r['Racer']['code'] . ' の処理に失敗しました。', LOG_ERR);
						$this->TransactionManager->rollback($transaction);
					}
					continue;
				}
				
				$isMenCat = null;
				foreach ($r['CategoryRacer'] as $cr) {
					if (in_array($cr['category_code'], $menCats)) {
						$isMenCat = $cr['category_code'];
						break;
					}
				}
				
				if (empty($isMenCat)) continue;
				
				$this->log('[' . $index . '] Racer:' . $r['Racer']['code'] . ' gender:Men from cat:' . $isMenCat, LOG_DEBUG);
				$param = array(
					'code' => $r['Racer']['code'],
					'gender' => Gender::$MALE->val()
				);
				$this->Racer->create();
				if (!$this->Racer->save($param)) {
					$this->log('code:' . $r['Racer']['code'] . ' の処理に失敗しました。', LOG_ERR);
					$this->TransactionManager->rollback($transaction);
				}
			}
			
			if ($offset == 0) break;
			
			$offset -= $limit;
			if ($offset < 0) {
				$offset = 0;
			}
		}
		
		$this->TransactionManager->commit($transaction);
		// <<< Transaction
		
		$this->log('<<< End setupGenderFromCats', LOG_INFO);
	}
}