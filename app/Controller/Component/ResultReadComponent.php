<?php

/*
 *  created at 2016/05/18 by shun
 */

App::uses('Component', 'Controller');
App::uses('Util', 'Cyclox/Util');
App::uses('RacerEntryStatus', 'Cyclox/Const');
App::uses('RacerResultStatus', 'Cyclox/Const');
App::uses('ResultParamCalcComponent', 'Controller/Component'); 
App::uses('EntryCategory', 'Model');
App::uses('Meet', 'Model');
App::uses('Racer', 'Model');

/**
 * ResultReadComponent クラスで利用する
 */
class ResReadUnit {
	public $key = "unknown";
	public $title = 'no_title';
	public $needs = false;
	public $checks = false; // 登録値と比較するか
	public $isImportant = false;
	
	function __construct($k, $t, $inb, $c = false, $i = false)
	{
		$this->key = $k;
		$this->title = $t;
		$this->needs = $inb;
		$this->checks = $c;
		$this->isImportant = $i;
	}
}

/**
 * リザルトを計算するコンポーネント
 *
 * @author shun
 */
class ResultReadComponent extends Component
{
	private $EntryCategory;
	
	private $_readUnits;
	
	private $__TITLE_NOT_READ = '__title_not_read';
	private $__TITLE_ERRORS = '__title_errors';
	
	private function __createReadUnit()
	{
		$this->_readUnits = array(
			new ResReadUnit('body_number',		'BibNo',		true),
			new ResReadUnit("racer_code",		'選手コード',	false,	true,	true),
			new ResReadUnit("name",				'名前',			false), // not blank は name_en との兼ね合いのため、個別に行なう
														// また、isImportant は family, first 単位で判定するので false とする。
			new ResReadUnit("family_name",		'姓',			false,	true,	true),
			new ResReadUnit("first_name",		'名',			false,	true,	true),
			//new ResReadUnit("name_en",			'Name',			false),
			//new ResReadUnit("family_name_en",	'FamilyName',	false,	true,	true),
			//new ResReadUnit("first_name_en",	'FirstName',	false,	true,	true),
			new ResReadUnit("team",				'チーム',		false,	true,	false),
			new ResReadUnit("team_en",			'Team',			false,	true,	false),
			new ResReadUnit("uci_id",			'UCI_ID',		false,	true,	true),
			new ResReadUnit("birth_date",		'生年月日',		false,	true,	true),
			new ResReadUnit("entry_status",		'EntryStatus',	false), // 'opn' だったら対応する。ほかは無視。
			new ResReadUnit("rank",				'順位',			false), // result status によっては not blank
			new ResReadUnit("result_status",	'ResultStatus',	true),
			new ResReadUnit("lap",				'周回数',		false),
			new ResReadUnit("goal_time",		'タイム',		false),
			new ResReadUnit("category_code",	'カテゴリー',	false),
		);
	}
	
	public function readResults($fp, $ecatID)
	{
		$this->__createReadUnit();
		
		// CSVの中身がダブルクオーテーションで囲われていない場合に一文字目が化けるのを回避
		setlocale(LC_ALL, 'ja_JP');
		
		$this->EntryCategory = new EntryCategory();
		$ecat = $this->EntryCategory->find('first', array('conditions' => array('EntryCategory.id' => $ecatID)));
		if (empty($ecat)) {
			return array('error' => array('msg' => '出走カテゴリー指定が不正です。id=' . $ecatID));
		}
		
		$this->Meet = new Meet();
		$meet = $this->Meet->find('first', array(
			'conditions' => array('Meet.code' => $ecat['EntryGroup']['meet_code']),
			'recursive' => 0,
		));
		if (empty($meet)) {
			return array('error' => array('msg' => '出走カテゴリー指定から大会情報が取得できません。id=' . $ecatID));
		}
		$date = $meet['Meet']['at_date'];

		$titleMap = array();
		$eresults = array();
		$i = 0;
		while (($line = fgetcsv($fp)) !== FALSE) {
			mb_convert_variables('UTF-8', 'sjis-win', $line);
			if ($i == 0) {
				$titleMap = $this->__readResultCsvHeader($line);
				
				// TODO: タイトル内容チェック、選手コードなど
				
			} else {
				// TODO: 名前は必ずあること、は個別でチェック。__readResult() 内の方がよいかも。
				$res = $this->__readResult($line, $titleMap, $i);
				
				// TODO: 日付フォーマット変換
				if (!empty($res["racer_code"])){
					$res['original'] = $this->__getOriginalRacer($res, $date);
				}
				
				$cddts = $this->__getSameNamedRacer($res);
				$res['cddts'] = $cddts;

				// TODO: カテゴリー所持チェック？
				
				
				$eresults[] = $res;
			}
			
			$i++;
		}
		
		return array(
			'not_read_titles' => $titleMap[$this->__TITLE_NOT_READ],
			'title_errors' => $titleMap[$this->__TITLE_ERRORS],
			'racers' => $eresults,
			'runits' => $this->_readUnits,
		);
	}
	
	/**
	 * 同じ名前をもつ選手をかえす
	 * @param array $dat
	 */
	private function __getSameNamedRacer($dat)
	{
		$this->Racer = new Racer();
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // 削除済み選手チェックのため
		
		$opt = array(
			'conditions' => array('or' => array()),
			'recursive' => 0,
			'limit' => 5,
			'order' => array('Racer.deleted' => 'ASC'), // 削除済み選手をあとにまわす
		);
		
		if (!empty($dat['family_name']) && !empty($dat['first_name'])) {
			$opt['conditions']['or'][] = array(
				'family_name' => $dat['family_name'],
				'first_name' => $dat['first_name'],
			);
		}
		if (!empty($dat['family_name_en']) && !empty($dat['first_name_en'])) {
			$opt['conditions']['or'][] = array(
				'family_name_en' => $dat['family_name_en'],
				'first_name_en' => $dat['first_name_en'],
			);
		}
		
		$cddts = $this->Racer->find('all', $opt);
		
		return $cddts;
	}
	
	/**
	 * $dat['racer_code'] をを持つ選手情報をかえす
	 * @param array $dat エントリー読値
	 * @param date $date カテゴリー所持判断日付
	 * @return array 選手コードをもつ登録済みデータ
	 */
	private function __getOriginalRacer($dat, $date)
	{
		// assert !empty($dat['racer_code'])
		
		$this->Racer = new Racer();
		$this->Racer->Behaviors->unload('Utils.SoftDelete'); // 削除済み選手チェックのため
		
		$opt = array('conditions' => array('code' => $dat['racer_code']), 'recursive' => 0);
		$original = $this->Racer->find('first', $opt);
		
		if (empty($original)) {
			return array('error' =>
				array('racer_code' => '対象の選手コードを持つ選手が見つかりません。')
			);
		}
		
		if ($original['Racer']['deleted']) {
			return array('error' =>
				array('racer_code' => '対象の選手コードを持つ選手は削除されています。')
			);
		}
		
		return $original['Racer'];
	}
	
	/**
	 * 
	 * @param array(string) $line string を複数持った配列
	 * @param array $titleMap key=column-number, value=title であるマップ
	 * @param int $lineNum 行インデックス
	 * @return array 読込結果。エラーの場合には array(msg=>hoge, pos=>foo, key=>baa) な配列を返す
	 */
	private function __readResult($line, $titleMap, $lineNum)
	{
		$map = array();
		
		for ($i = 0; $i < count($line); $i++) {
			$err = null; $valexp = null; // 初期化
			
			if (empty($titleMap[$i])) continue;
			
			$val = $line[$i];
			$tunit = $titleMap[$i];
			$key = $tunit->key;
			//$pos = '第' . ($lineNum+1) . '行-' . chr(65 + $i) . '列'; // XYZ 以降オーバーには未対応
			$pos = 'セル' . ($lineNum+1) .  chr(65 + $i); // XYZ 以降オーバーには未対応
			$cnved = $val;
			
			if (empty($val)) {
				if ($tunit->key == 'body_number' || $tunit->key == 'result_status') {
					$err = '値が必要です。';
				} else if ($key !== 'entry_status') {
					continue;
				}
			}
			
			// 値の変換
			
			if (!empty($val)) {
				if ($key == 'racer_code') {
					if (!preg_match('/^[A-Z]{3}-[0-9]{3}-[0-9]{4}$/', $val)) {
						$err = '選手コードは XXX-178-0123 の形式です。';
						// MORE: 選手コードの変換（ハイフンや全角など）
					}
				} else if ($key == 'uci_id') {
					if (!preg_match('/^[0-9]{11}$/', $val)) {
						$err = 'UCI ID は11桁の数字です。';
						// MORE: 選手コードの変換（ハイフンや全角など）
					}
				} else if ($key == 'birth_date') {
					if (!Util::is_date($val)) {
						$err = '日付の形式が不正です。';
					}
				} else if ($key == 'result_status') {
					$r = RacerResultStatus::ofExpress($val, false);
					if ($r == false) {
						$err = '不正な値。マニュアルを確認のこと。';
					} else {
						$cnved = $r->val();
						$valexp = $r->code();
					}
				} else if ($key == 'goal_time') {
					$cnved = Util::time2milli($val);
					if ($cnved == false) {
						$err = '時間フォーマットが不正です。';
						$cnved = $val;
					}
				}
			}

			if ($key == 'entry_status') {
				if (!empty($val) && strtolower($val) !== 'opn') {
					$err = 'OPN 以外の値は認識できません。';
					$cnved = RacerEntryStatus::$NORMAL; // hidden 出力時にエラーになるため仮の値を入れておく。
				} else {
					$cnved = (strtolower($val) === 'opn') ? RacerEntryStatus::$OPEN : RacerEntryStatus::$NORMAL;
				}
			}
			
			// データの格納
			$v = array(
				'original' => $val,
				'pos' => $pos,
				'key' => $key,
				'val' => $cnved,
			);
			if (!empty($err)) {
				$v['error'] = $err;
			}
			if (!empty($valexp)) {
				$v['valexp'] = $valexp;
			}
			
			$map[$key] = $v;
			
			// 名前の分割
			
			if (!isset($val['error']) && ($key === 'name' || $key === 'name_en')) {
				$names = $this->__splitName($val, $key, $pos);
				if (isset($names['error'])) {
					$map[$key] = $names;
				} else {
					foreach ($names as $k => $n) {
						$map[$k] = $n;
					}
				}
			}
		}
		
		if (isset($map['family_name']) && isset($map['first_name'])) {
			$map['name'] = $map['family_name']['val'] . ' ' . $map['first_name']['val'];
		}
		if (isset($map['family_name_en']) && isset($map['first_name_en'])) {
			$map['name_en'] = $map['family_name_en']['val'] . ' ' . $map['first_name_en']['val'];
		}
		
		return $map;
	}
	
	private function __splitName($name, $key, $cellpos)
	{
		// 半角 or 全角スペーズで区切る
		
		$pos = strpos($name, ' ');
		
		if ($pos === false) {
			$pos = strpos($name, '　');
			
			if ($pos === false) {
				return array('error' => array(
					'msg' => 'key:' . $key . ' の値は半角or全角スペースを含む必要があります。',
					'pos' => $cellpos,
					'key' => $key,
					'original_val' => $name,
				));
			}
		}
		
		if ($pos === 0) {
			// error
		} else if ($pos === strlen($name) - 1) {
			// error
		}
		
		$fam = substr($name, 0, $pos);
		$fir = substr($name, $pos + 1);
		
		return array(('family_' . $key) => $fam, ('first_' . $key) => $fir);
	}
	
	/**
	 * リザルト CSV のヘッダーから列インデックスとタイトル内容の対応を記した配列をかえす
	 * @param array(string) $line string を複数持った配列
	 * @return array key:col_index, value:タイトル内容の配列。key:$__TITLE_NOT_READ に対する value は配列で、読み込まれなかったタイトル行を格納する。
	 */
	private function __readResultCsvHeader($line)
	{
		$map = array(
			$this->__TITLE_NOT_READ => array()
		);
		
		$findsCode = false;
		$findsFamName = false;
		$finds1stName = false;
		
		for ($i = 0; $i < count($line); $i++) {
			$finds = false;
			$title = $line[$i];
			foreach ($this->_readUnits as $unit) {
				if ($title == $unit->key) {
					$map[$i] = $unit;
					$finds = true;
					break;
				}
			}
			
			if (!$finds) {
				$map[$this->__TITLE_NOT_READ][] = $title;
			} else {
				if ($title == 'racer_code') {
					$findsCode = true;
				} else if ($title == 'family_name') {
					$findsFamName = true;
				} else if ($title == 'first_name') {
					$finds1stName = true;
				} else if ($title == 'name') {
					$findsFamName = true;
					$finds1stName = true;
				}
			}
		}
		
		$err = array();
		if (!$findsCode) {
			$err[] = "[警告] 選手コードを指定する列がありません。";
		}
		
		if (!$findsFamName || !$finds1stName) {
			$err[] = "[警告] 選手の名前を指定する列が無いか、不十分です。";
		}
		
		$map[$this->__TITLE_ERRORS] = $err;
		
		return $map;
	}
}
