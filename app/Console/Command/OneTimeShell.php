<?php

/* 
 *  created at 2015/12/21 by shun
 */

/**
 * 1回だけの処理に使用する。コンソールから起動する。
 * 例）
 * > cd Cake/app
 * > Consle/cake one_time_shell TheMethodName arg,,,
 */
class OneTimeShell extends AppShell
{
	public $uses = array('EntryGroup', 'EntryRacer', 'Racer');
	
    public function main() {
        $this->out('please input function name as 1st arg.');
    }
	
	/**
	 * EntryRacer.team_name から Racer.team を設定する。コンソールでの処理。起動方法は
	 * > app ディレクトリ
	 * > Console/cake one_time_shell setupTeamName
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
}