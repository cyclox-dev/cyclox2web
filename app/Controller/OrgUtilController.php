<?php

App::uses('ApiBaseController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Gender', 'Cyclox/Const');
App::uses('UniteRacerStatus', 'Cyclox/Const');

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
	 public $uses = array('TransactionManager',
		 'Meet', 'Category', 'EntryGroup', 'EntryRacer', 'CategoryRacer', 'Racer'
			, 'PointSeries', 'PointSeriesRacer', 'UniteRacerLog');
	 
	 public $components = array('Flash', 'RequestHandler');
	 
	 const __PATH_RACERS = 'cyclox2/org_util/racers';
	 const __RACERS_FILE_PREFIX = 'racers_';

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
						
						if (!empty($eracer['RacerResult']['as_category'])) {
							// as_category 値があるならそれで判定
							if ($eracer['RacerResult']['as_category'] != $this->request->data['category_code']) {
								continue;
							}
						} else {
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
						}
						
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
						
						if (!empty($eracer['EntryRacer']['team_name'])) {
							// 最後のチーム名を格納しておく
							$rp['team'] = $eracer['EntryRacer']['team_name'];
						}
						
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
		
		//$this->log('title:', LOG_DEBUG);
		//$this->log($meetTitles, LOG_DEBUG);
		//$this->log('points:', LOG_DEBUG);
		//$this->log($racerPoints, LOG_DEBUG);
		
		$year = $this->request->data['base_year'];
		$seasonExp = $year . '-' . ($year % 100 + 1);
		$body = "AJOCC Point Ranking\n" .
			'Season,' . $seasonExp . "\n" .
			'Category,' . $this->request->data['category_code'] . "\n" .
			'集計日,' . date('Y/m/d H:i:s') . "\n\n";
		
		// A1, A2 は空
		$body .= '順位,選手 Code,選手名,チーム,';
		
		foreach ($meetTitles as $title) {
			$body .= $title . ',';
		}
		$body .= "合計,自乗和\n";
		
		$rank = 0;
		$skip = 0;
		$preTotal = -1;
		$preSqured = -1;
		
		foreach ($racerPoints as $rcode => $rp) {
			//$this->log('name is:' . $rp['name'], LOG_DEBUG);
			
			if ($rp['total'] == $preTotal && $rp['totalSquared'] == $preSqured) {
				 ++$skip;
			} else {
				$rank += 1 + $skip;
				$skip = 0;
				$preTotal = $rp['total'];
				$preSqured = $rp['totalSquared'];
			}
			
			$line = $rank . ',' . $rcode . ',' . $rp['name'] . ',';
			if (!empty($rp['team'])) {
				$line .= $rp['team'];
			}
			$line .= ',';
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
	
	public function racer_list_csv_links()
	{
		$cats = $this->Category->find('all', array('fields' => array('code', 'name'), 'recursive' => -1));
		
		$this->log($cats, LOG_DEBUG);
		
		// TODO: Category ごとは後で実装する。
		//$this->set('cats', $cats);
	}
	
	public function download_racers_csv()
	{
		if (!$this->request->is('post')) {
			throw new BadMethodCallException('Bad method.');
		}
		
		$this->_mkdir4RacerList();
		
		$catCode = $this->request->data['category_code'];
		
		$filename = self::__RACERS_FILE_PREFIX;
		if (empty($catCode)) {
			$catCode = 'all';
		}
		$filename .= $catCode;
		
		$this->log('tmp:' . TMP, LOG_DEBUG);
		$file = new File(TMP . self::__PATH_RACERS . '/' . $filename . '.csv');
		$this->log($file, LOG_DEBUG);
		
		if (!$file->exists())
		{
			$this->Flash->set($catCode . __('用の選手リストのファイルがありません。ファイルの更新が必要です。'));
			return $this->redirect(array('action' => 'racer_list_csv_links'));
		}
		
		//$this->log('update:' . date('Ymd\THi', $file->lastChange()), LOG_DEBUG);
		$dlFilename = $filename . '_' . date('Ymd\THi', $file->lastChange()) . '.csv';
		
		$this->log($file->path, LOG_DEBUG);
		
		$this->autoRender = false;
		$this->response->file($file->path, array('name' => $dlFilename, 'download' => true));
	}
	
	/**
	 * 選手リストを作成（更新）する
	 */
	public function create_racer_lists()
	{
		$this->_mkdir4RacerList();
		
		$this->Racer->Behaviors->load('Utils.SoftDelete');
		$this->CategoryRacer->Behaviors->load('Utils.SoftDelete');
		
		//++++++++++++++++++++++++++++++++++++++++
		// All
		$this->log('start all racer csv', LOG_DEBUG);
		
		$tmpFile = new File(TMP . self::__PATH_RACERS . '/' . self::__RACERS_FILE_PREFIX . 'all.csv.tmp');
		if ($tmpFile->exists()) {
			$tmpFile->delete();
		}
		$tmpFile->create();
		
		$tmpFile->append(mb_convert_encoding('AJOCC 選手リスト,更新日:' . date('Y/m/d') ."\n", 'SJIS', 'auto'));
		$tmpFile->append(mb_convert_encoding('選手コード,姓,名,姓（かな）,名（かな）,姓 (en),名 (en),チーム名'
			. ',性別,生年月日,国籍,Jcf No.,UCI ID,UCI No.,UCI Code,都道府県,所属カテゴリー' . "\n", 'SJIS', 'auto'));
		
		$offset = 0;
		$limit = 100;
		while (true)
		{
			$racers = $this->Racer->find('all', 
				array('offset' => $offset, 'limit' => $limit, 'order' => array('code' => 'ASC')));
			
			if (empty($racers)) {
				break;
			}
			
			// 念のため時間も指定しておく
			$dateNowFrom = (new DateTime('now'))->setTime(0, 0, 0);
			$dateNowTo = (new DateTime('now'))->setTime(23, 59, 59);
			
			foreach ($racers as $racer) {
				$r = $racer['Racer'];
				
				$genExp = '';
				if ($r['gender'] == Gender::$MALE->val()) {
					$genExp = 'M';
				} else if ($r['gender'] == Gender::$FEMALE->val()) {
					$genExp = 'F';
				}
				
				$birthExp = '';
				if (!empty($r['birth_date'])) {
					$dt = new DateTime($r['birth_date']);
					$year = $dt->format('Y');
					//$this->log('$year:' . $year, LOG_DEBUG);
					if ($year > 1905) {
						$birthExp = $r['birth_date'];
					}
				}
				
				$catExp = '';
				$cats = array();
				foreach ($racer['CategoryRacer'] as $catRacer) {
					// すでに表示しているものは排除
					if (in_array($catRacer['category_code'], $cats)) {
						continue;
					}
					
					// 過去のカテゴリーは排除
					if (!empty($catRacer['cancel_date'])) {
						$cancelDate = new DateTime($catRacer['cancel_date']);
						if ($cancelDate < $dateNowTo) {
							continue;
						}
					}
					
					if (empty($catRacer['apply_date'])) {
						continue;
					}
					
					// 将来のカテゴリーも排除
					$applyDate = new DateTime($catRacer['apply_date']);
					if ($applyDate > $dateNowFrom) {
						continue;
					}
					
					if (!empty($catExp)) {
						$catExp .= ',';
					}
					$catExp .= $catRacer['category_code'];
					$cats[] = $catRacer['category_code'];
				}
				
				$tmpFile->append(
					mb_convert_encoding(
						$this->__strOrEmpty($r['code']) . ',' .
						$this->__strOrEmpty($r['family_name']) . ',' .
						$this->__strOrEmpty($r['first_name']) . ',' .
						$this->__strOrEmpty($r['family_name_kana']) . ',' .
						$this->__strOrEmpty($r['first_name_kana']) . ',' .
						$this->__strOrEmpty($r['family_name_en']) . ',' .
						$this->__strOrEmpty($r['first_name_en']) . ',' .
						$this->__strOrEmpty($r['team']) . ',' .
						$genExp . ',' .
						$this->__strOrEmpty($birthExp) . ',' .
						$this->__strOrEmpty($r['nationality_code']) . ',' .
						$this->__strOrEmpty($r['jcf_number']) . ',' .
						$this->__strOrEmpty($r['uci_id']) . ',' .
						$this->__strOrEmpty($r['uci_number']) . ',' .
						$this->__strOrEmpty($r['uci_code']) . ',' .
						$this->__strOrEmpty($r['prefecture']) . ',' .
						'"' . $catExp . '"' . // カンマ対策でダブルクォート囲み
						"\n"
					, 'SJIS', 'auto')
					);
			}
			
			$offset += $limit;
		}
		
		$tmpFile->close();
		
		$filename = TMP . self::__PATH_RACERS . '/' . self::__RACERS_FILE_PREFIX . 'all.csv';
		$tmpFile->copy($filename, true);
		
		$this->log('end all racer csv', LOG_DEBUG);
		
		//++++++++++++++++++++++++++++++++++++++++
		// category ごと
		
		// TODO: Category ごとリスト実装
		
		$this->Flash->set(h('選手リストを更新しました。'));
		$this->redirect(array('action' => 'racer_list_csv_links'));
	}
	
	
	public function point_series_csv_links()
	{
		$opt = array('order' => array(
			'season_id' => 'DESC',
			'PointSeries.id' => 'ASC'
		));
		
		$pss = $this->PointSeries->find('all', $opt);
		$this->log($pss, LOG_DEBUG);
		$this->set('pss', $pss);
	}
	
	/**
	 * empty の場合には空文字をかえす
	 * @param string $str
	 * @return string null でない文字列
	 */
	private function __strOrEmpty($str)
	{
		return emptY($str) ? '' : $str;
	}
	
	/**
	 * 選手一覧用のディレクトリを作成する
	 */
	private function _mkdir4RacerList()
	{
		$dir = new Folder();
		$dir->create(TMP . 'cyclox2');
		
		$dir = new Folder();
		$dir->create(TMP . 'cyclox2/org_util');
		
		$dir = new Folder();
		$dir->create(TMP . self::__PATH_RACERS);
	}
	
	private function __confirm_unite_racer()
	{
		if (empty($this->request->data['racer_code_united']) || empty($this->request->data['racer_code_unite_to'])) {
			$this->Flash->set(__('選手コードが未入力です。'));
			return false;
		}

		if ($this->request->data['racer_code_united'] === $this->request->data['racer_code_unite_to']) {
			$this->Flash->set(__('異なる選手コードを入力して下さい。'));
			return false;
		}

		$united = $this->request->data['racer_code_united'];
		$uniteTo = $this->request->data['racer_code_unite_to'];

		if (!$this->Racer->existsOnDB($united)) {
			$this->Flash->set(__('統合される選手コードを持つ選手が存在しません。'));
			return false;
		} else if (!$this->Racer->exists($united)) {
			$this->Flash->set(__('統合元の選手データは削除済みです。'));
			return false;
		}

		if (!$this->Racer->existsOnDB($uniteTo)) {
			$this->Flash->set(__('統合先の選手コードを持つ選手が存在しません。'));
			return false;
		} else if (!$this->Racer->exists($uniteTo)) {
			$this->Flash->set(__('統合先の選手データは削除済みです。'));
			return false;
		}
		
		return true;
	}
	
	/**
	 * 選手データ統合アクション
	 * @return void
	 */
	public function unite_racer()
	{
		if ($this->request->is('post')) {

			if (!$this->__confirm_unite_racer()) {
				return;
			}

			$united = $this->request->data['racer_code_united'];
			$uniteTo = $this->request->data['racer_code_unite_to'];
			$note = $this->request->data['note'];

			$this->Racer->CategoryRacer->Behaviors->load('Utils.SoftDelete');
			$racerUniteTo = $this->Racer->find('first', array('conditions' => array('code' => $uniteTo)));

			if (empty($racerUniteTo)) {
				$this->Flash->set(__('想定しないエラーです。'));
				$this->redirect(array('action' => 'unite_racer'));
				return;
			} else if (!empty($racerUniteTo['Racer']['united_to'])) {
				$this->Flash->set(__('統合先の選手データは' . $racerUniteTo['Racer']['united_to'] .  'の選手に統合済みです。'));
				$this->redirect(array('action' => 'unite_racer'));
				return;
			}

			$racerUnited = $this->Racer->find('first', array('conditions' => array('code' => $united)));
			if (empty($racerUnited)) {
				$this->Flash->set(__('想定しないエラーです。'));
				$this->redirect(array('action' => 'unite_racer'));
				return;
			}

			$this->set('uniteTo', $racerUniteTo);
			$this->set('united', $racerUnited);
			$this->set('note', $note);
			$this->render('unite_racer_confirm');
		}
	}
	
	/**
	 * 選手コードを統合する
	 */
	public function do_unite_racer()
	{
		$this->log($this->request->data, LOG_DEBUG);
		
		$this->request->allowMethod('post');
		
		if (!$this->__confirm_unite_racer()) {
			$this->Flash->set('選手データ不正のため、統合に失敗しました。');
			$this->redirect('unite_racer');
			return false;
		}

		$united = $this->request->data['racer_code_united'];
		$uniteTo = $this->request->data['racer_code_unite_to'];
		$note = $this->request->data['note'];
		
		$transaction = $this->TransactionManager->begin();

		if ($this->uniteRacer($united, $uniteTo, $note)) {

			/*
			$this->log('デバッグで rollback します。', LOG_DEBUG);
			$this->TransactionManager->rollback($transaction);/*/
			$this->TransactionManager->commit($transaction);//*/
			
			$this->Flash->set(__('選手統合完了。カテゴリー所属をチェックし、不要なものは削除して下さい。'));
			
			$this->redirect(array('controller' => 'racers' ,'action' => 'view', $uniteTo));
		} else {
			$this->Flash->set(__('選手データの統合に失敗しました'));
			$this->TransactionManager->rollback($transaction);
			
			$this->redirect('unite_racer');
		}
	}
	
	/**
	 * 選手データの統合処理を行なう
	 * @param string $united 統合される選手コード
	 * @param string $uniteTo 統合先選手コード
	 * @param string $userNote 統合処理に関するユーザ入力メモ
	 * @return boolean 統合に成功したか
	 */
	public function uniteRacer($united, $uniteTo, $userNote = '')
	{
		// racer への適用
		$param = array(
			'code' => $united,
			'united_to' => $uniteTo
		);
		
		if (!$this->Racer->save($param)) {
			$this->log('Racer への適用に失敗しました。', LOG_ERR);
			return false;
		}
		
		// 統合元を削除
		if (!$this->Racer->delete($united)) {
			$this->log('統合する Racer の削除に失敗しました。', LOG_ERR);
			return false;
		}
		
		$uniteLog = '';
		
		$racer = $this->Racer->find('first', array('conditions' => array('code' => $uniteTo)));
		
		// category racer 書換え
		$param = array(
			'conditions' => array('racer_code' => $united),
			'recursive' => -1
		);
		$catRacers = $this->CategoryRacer->find('all', $param);
		
		if (!empty($catRacers)) {
			$param = array();
			$ids = '';
			foreach ($catRacers as $cr) {
				$param[] = array(
					'id' => $cr['CategoryRacer']['id'],
					'racer_code' => $uniteTo
				);

				$ids .= $cr['CategoryRacer']['id'] . ',';
			}

			if (!$this->CategoryRacer->saveAll($param)) {
				$this->log('CategoryRacer の書換えに失敗しました。', LOG_ERR);
				return false;
			}

			$this->log('catRacer[id:' . $ids . '] の選手コードを書換え。', LOG_DEBUG);
			$uniteLog .= 'カテゴリー所属 (CategoryRacer) = [id:' . $ids . '] ';
		}
		
		// entry racer 書換え
		$param = array(
			'conditions' => array('racer_code' => $united),
			'recursive' => -1
		);
		
		$eracers = $this->EntryRacer->find('all', $param);
		
		if (!empty($eracers)) {
			$param = array();
			$ids = '';
			foreach ($eracers as $er) {
				$param[] = array(
					'id' => $er['EntryRacer']['id'],
					'racer_code' => $uniteTo,
					'name_at_race' => $racer['Racer']['family_name'] . ' ' . $racer['Racer']['first_name'],
					'name_kana_at_race' => $racer['Racer']['family_name_kana'] . ' ' . $racer['Racer']['first_name_kana'],
					'name_en_at_race' => $racer['Racer']['family_name_en'] . ' ' . $racer['Racer']['first_name_en'],
					'team_name' => $racer['Racer']['team'],
				);

				$ids .= $er['EntryRacer']['id'] . ',';
			}

			if (!$this->EntryRacer->saveAll($param)) {
				$this->log('EntryRacer の書換えに失敗しました。', LOG_ERR);
				return false;
			}

			$this->log('EntryRacer[id:' . $ids . '] の選手コードを書換え。', LOG_DEBUG);
			$uniteLog .= '出走選手データ (EntryRacer) = [id:' . $ids . "] ";
		}
		
		// point series racers
		$param = array(
			'conditions' => array('racer_code' => $united),
			'recursive' => -1
		);
		
		$psrs = $this->PointSeriesRacer->find('all', $param);
		
		if (!empty($psrs)) {
			$param = array();
			$ids = '';
			foreach ($psrs as $psr) {
				$param[] = array(
					'id' => $psr['PointSeriesRacer']['id'],
					'racer_code' => $uniteTo
				);

				$ids .= $psr['PointSeriesRacer']['id'] . ',';
			}

			if (!$this->PointSeriesRacer->saveAll($param)) {
				$this->log('PointSeriesRacer の書換えに失敗しました。', LOG_ERR);
				return false;
			}
			
			$this->log('PointSeriesRacer[id:' . $ids . '] の選手コードを書換え。', LOG_DEBUG);
			$uniteLog .= 'シリーズポイント取得データ (PointSeriesRacer) = [id:' . $ids . "]";
		}
		
		$urLog = array();
		$urLog['UniteRacerLog'] = array();
		$urLog['UniteRacerLog']['united'] = $united;
		$urLog['UniteRacerLog']['unite_to'] = $uniteTo;
		$urLog['UniteRacerLog']['at_date'] = date("Y-m-d H:i:s");
		$userName = (isset($this->Auth)) ? $this->Auth->user('username') : 'Machine(shell)';
		$urLog['UniteRacerLog']['by_user'] = $userName;
		if (empty($uniteLog)) {
			$urLog['UniteRacerLog']['log'] = $userNote . "／"
					.'選手データを除き、この統合処理により変更されたデータはありません。';
		} else {
			$urLog['UniteRacerLog']['log'] = $userNote . "／"
					."選手データ統合により変更されたデータ:\n" . $uniteLog;
		}
		$urLog['UniteRacerLog']['status'] = UniteRacerStatus::$DONE->ID();
		
		if (!$this->UniteRacerLog->save($urLog)) {
			$this->log('選手データ統合処理のログ保存に失敗しました。' . $united . '→' . $uniteTo, LOG_ERR);
		}
		
		return true;
	}
}
