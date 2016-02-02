<?php

/* 
 *  created at 2015/12/21 by shun
 */

/**
 * 1回だけの処理に使用する。コンソールから起動する。
 * 例）
 * > cd Cake/app
 * > Console/cake one_time TheMethodName arg,,,
 */
class OneTimeShell extends AppShell
{
	public $uses = array('EntryGroup', 'EntryRacer', 'Racer', 'CategoryRacer');
	
    public function main() {
        $this->out('please input function name as 1st arg.');
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
}