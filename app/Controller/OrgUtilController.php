<?php

App::uses('ApiBaseController', 'Controller');

/*
 *  created at 2015/10/04 by shun
 */

/**
 * Description of OrgUtilController
 *
 * @author shun
 */
class OrgUtilController extends ApiBaseController
{
	 public $uses = array('Meet', 'Category', 'EntryGroup', 'EntryRacer', 'CategoryRacer');
	 
	 public $components = array('Session', 'RequestHandler');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->set("none", array());
	}
	
	/**
	 * AJOCC Point CSV ダウンロード一覧を表示する
	 */
	public function ajocc_pt_csv_links()
	{
		// AJOCC シーズンごとカテゴリーごと
		// 2015-16 を初シーズンとする。
		
		// 日付比較で今までのシーズンを抽出
		$y = (int)date('Y');
		$m = (int)date('n');
		
		// 2015-16 の 15 の方を基準とする
		if ($m < 4) {
			--$y;
		}
		
		$cats = $this->Category->find('all', array('fields' => array('code', 'name')));
		
		$links = array();
		for (; $y >= 2015; --$y) {
			$next = $y % 100 + 1;
			if ($next < 10) {
				$next = '0' . $next;
			}
			$title = $y . '-' . $next;
			
			$seasonPack = array();
			$seasonPack['title'] = $title;
			$seasonPack['base_year'] = $y;
			$seasonPack['dat'] = array();
			
			foreach ($cats as $cat) {
				$obj = array();
				$obj['title'] = $cat['Category']['name'];
				$obj['category_code'] = $cat['Category']['code'];
				
				$seasonPack['dat'][] = $obj;
			}
			$links[$y] = $seasonPack;
		}
		$this->log($links, LOG_DEBUG);
		
		$this->set('links', $links);
	}
	
	/**
	 * 
	 * @return type
	 * @throws BadRequestException
	 */
	public function download_ajocc_pt_csv()
	{
		if (!$this->request->is('post')) {
			throw new BadMethodCallException('bad method.');
		}
		
		if (empty($this->request->data['base_year']) || empty($this->request->data['category_code'])) {
			throw new BadRequestException('Needs Parameter.');
		}
		
		//$this->log('year:' . $this->request->data['base_year'] . ' cat:' . $this->request->data['category_code'], LOG_DEBUG);
		
		// 指定カテゴリーを含むレースカテゴリーを取得しておく
		$this->Category->Behaviors->load('Containable');
		$this->Category->actsAs = array('Utils.SoftDelete'); // deleted を拾わないように
		$opt = array();
		$opt['contain'] = array('CategoryRacesCategory');
		$opt['conditions'] = array(
			'code' => $this->request->data['category_code']
		);
		$cats = $this->Category->find('all', $opt);
		//$this->log($cats, LOG_DEBUG);
		$rcats = array();
		foreach ($cats as $cat) {
			foreach($cat['CategoryRacesCategory'] as $crc) {
				if (!empty($crc['deleted']) && $crc['deleted'] == 1) continue;
				
				if ($crc['category_code'] === $this->request->data['category_code']) {
					$rcats[] = $crc['races_category_code'];
				}
			}
		}
		//$this->log('rcats:', LOG_DEBUG);
		//$this->log($rcats, LOG_DEBUG);
		
		// 大会を日付順にチェック
		$minDate = $this->request->data['base_year'] . '-04-01';
		$maxDate = '' . ($this->request->data['base_year'] + 1) . '-03-31';
		$cnd = array('at_date between ? and ?' => array($minDate, $maxDate));
		$this->Meet->actsAs = array('Utils.SoftDelete'); // deleted を拾わないように
		$meets = $this->Meet->find('all', array('conditions' => $cnd, 'order' => array('at_date' => 'asc'), 'recursive' => -1));
		//$this->log($meets, LOG_DEBUG);
		
		$this->EntryGroup->actsAs = array('Utils.SoftDelete'); // deleted を拾わないように
		$this->EntryGroup->Behaviors->load('Containable');
		
		// 該当出走カテゴリーを引き出しておく
		$meetTitles = array();
		$racerPoints = array(); // key が選手コード。$meetTitles と同じインデックスにポイントが入る
		
		foreach ($meets as $meet) {
			$opt = array();
			$opt['contain'] = array('EntryCategory');
			$opt['conditions'] = array(
				'meet_code' => $meet['Meet']['code']
			);
			$egroups = $this->EntryGroup->find('all', $opt);
			//$this->log($egroups, LOG_DEBUG);
			
			$meetAdds = false;
			
			foreach ($egroups as $egroup) {
				foreach ($egroup['EntryCategory'] as $ecat) {
					if (!empty($ecat['deleted']) && $ecat['deleted'] == 1) {
						continue;
					}
					
					if (!$ecat['applies_ajocc_pt']) {
						continue;
					}
					
					$finds = false;
					foreach ($rcats as $rcat) {
						if ($ecat['races_category_code'] === $rcat) {
							$finds = true;
							break; // 1大会で1件のみとする
						}
					}
					
					if (!$finds) continue;
					
					if (!$meetAdds) {
						$meetTitles[] = $meet['Meet']['short_name'];
						$meetAdds = true;
					}
					
					$this->EntryRacer->actsAs = array('Utils.SoftDelete'); // deleted を拾わないように
					
					$opt = array('recursive' => 1);
					$opt['conditions'] = array(
						'entry_category_id' => $ecat['id'],
					);
					$ers = $this->EntryRacer->find('all', $opt);
					//$this->log('ers---', LOG_DEBUG);
					//$this->log($ers, LOG_DEBUG);
					
					foreach ($ers as $eracer) {
						if (!empty($eracer['Racer']['deleted']) && $eracer['Racer']['deleted'] == 1) continue;
						if (!empty($eracer['RacerResult']['deleted']) && $eracer['RacerResult']['deleted'] == 1) continue;
						//$this->log('ers:', LOG_DEBUG);
						//$this->log($eracer, LOG_DEBUG);
						if (empty($eracer['RacerResult']['ajocc_pt'])) continue;
						
						// 大会日におけるカテゴリーの所持を確認
						$this->CategoryRacer->actsAs = array('Utils.SoftDelete'); // deleted を拾わないように
						
						$opt = array('recursive' => -1);
						$opt['conditions'] = array(
							'racer_code' => $eracer['Racer']['code'],
							'category_code' => $this->request->data['category_code'],
							array('AND' => array(
								'NOT' => array('apply_date' => null), 
								'apply_date <=' => $meet['Meet']['at_date'])
							),
							array('OR' => array(
								array('cancel_date' => null),
								array('cancel_date >=' => $meet['Meet']['at_date']),
							)),
						);
						$crCount = $this->CategoryRacer->find('count', $opt);
						//$this->log('cr count:' . $crCount, LOG_DEBUG);
						
						if ($crCount == 0) continue;
						
						// シーズン最終日でのカテゴリー所持を確認（シーズン途中でのカテゴリー中断は想定しない）
						// 現在日がシーズン最終日をすぎていなくても、最終日計算で OK
						$lastDate =  new DateTime('' . ($this->request->data['base_year'] + 1) . '/3/31');
						//$this->log('last date:' . $lastDate->format('Y-m-d'), LOG_DEBUG);
						
						$opt = array('recursive' => -1);
						$opt['conditions'] = array(
							'racer_code' => $eracer['Racer']['code'],
							'category_code' => $this->request->data['category_code'],
							array('AND' => array(
								'NOT' => array('apply_date' => null), 
								'apply_date <=' => $lastDate->format('Y-m-d'))
							),
							array('OR' => array(
								array('cancel_date' => null),
								array('cancel_date >=' => $lastDate->format('Y-m-d'))
							)),
						);

						$crCount = $this->CategoryRacer->find('count', $opt);
						
						if ($crCount == 0) continue;
						
						$rcode = $eracer['Racer']['code'];
						$rp = array();
						if (!empty($racerPoints[$rcode])) {
							$rp = $racerPoints[$rcode];
						} else {
							$rp['name'] = $eracer['Racer']['family_name'] . '　' . $eracer['Racer']['first_name'];
							$rp['points'] = array();
						}
						
						$index = count($meetTitles) - 1;
						$rp['points'][$index] = $eracer['RacerResult']['ajocc_pt'];
						
						$racerPoints[$rcode] = $rp;
					}
				}
			}
		}
		
		// トータルと自乗和を計算
		foreach ($racerPoints as &$rp) {
			$total = 0;
			$totalSquared = 0;
			foreach ($rp['points'] as $pt) {
				$total += $pt;
				$totalSquared += $pt * $pt;
			}
			
			$rp['total'] = $total;
			$rp['totalSquared'] = $totalSquared;
		}
		unset($rp); // 下流で使うので
		
		// sort
		uasort($racerPoints, array($this, "_compareAjoccPoint"));
		
		$this->log('title:', LOG_DEBUG);
		$this->log($meetTitles, LOG_DEBUG);
		$this->log('points:', LOG_DEBUG);
		$this->log($racerPoints, LOG_DEBUG);
		
		$year = $this->request->data['base_year'];
		$seasonExp = $year . '-' . ($year % 100 + 1);
		$body = "AJOCC Point Ranking\n" .
			'Season,' . $seasonExp . "\n" .
			'Category,' . $this->request->data['category_code'] . "\n" .
			'集計日,' . date('Y/m/d H:i:s') . "\n\n";
		
		// A1, A2 は空
		$body .= '選手 Code,選手名,';
		
		foreach ($meetTitles as $title) {
			$body .= $title . ',';
		}
		$body .= "合計,自乗和\n";
		
		foreach ($racerPoints as $rcode => $rp) {
			$this->log('name is:' . $rp['name'], LOG_DEBUG);
			$line = $rcode . ',' . $rp['name'] . ',';
			for ($i = 0; $i < count($meetTitles); $i++) {
				if (!empty($rp['points'][$i])) {
					$line .= $rp['points'][$i];
				}
				$line .= ',';
			}
			
			$body .= $line . $rp['total'] . ',' . $rp['totalSquared'] . "\n";
		}
		
		$this->autoRender = false;
		//$this->response->charset('Shift_JIS'); // この行コメントアウトしても問題なしだった
		$this->response->type('csv');
		$this->response->download('ajocc_pt_' . $this->request->data['base_year'] . '_' . $this->request->data['category_code'] .'.csv');
		$this->response->body(mb_convert_encoding($body, 'Shift_JIS', 'UTF-8'));
	}
	
	/**
	 * AjoccPoint 比較用メソッド
	 * @param type $a
	 * @param type $b
	 * @return 順序
	 */
	static public function _compareAjoccPoint($a, $b)
	{
		if ($a['total'] == $b['total']) {
			return $b['totalSquared'] - $a['totalSquared'];
		}
		
		return $b['total'] - $a['total'];
	}
}
