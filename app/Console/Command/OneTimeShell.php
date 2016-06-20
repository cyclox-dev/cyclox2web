<?php

/* 
 *  created at 2015/12/21 by shun
 */

App::uses('ApiController', 'Controller');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('ResultParamCalcComponent', 'Controller/Component'); 
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
			$hasError = false;
			
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
									. ':' . $pt . 'pt,';
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
}