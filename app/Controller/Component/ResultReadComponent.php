<?php

/*
 *  created at 2016/05/18 by shun
 */

App::uses('Component', 'Controller');
App::uses('Util', 'Cyclox/Util');
App::uses('AjoccUtil', 'Cyclox/Util');
App::uses('Gender', 'Cyclox/Const');
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
	
	public $components = array('ResultParamCalc');
	
	private $_readUnits;
	
	private $__TITLE_NOT_READ = '__title_not_read';
	private $__TITLE_WARNS = '__title_warns';
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
			new ResReadUnit("name_en",			'Name',			false),
			new ResReadUnit("family_name_en",	'FamilyName',	false,	true,	true),
			new ResReadUnit("first_name_en",	'FirstName',	false,	true,	true),
			new ResReadUnit("team",				'チーム',		false,	true,	false),
			new ResReadUnit("team_en",			'Team',			false,	true,	false),
			new ResReadUnit("uci_id",			'UCI_ID',		false,	true,	true),
			new ResReadUnit("gender",			'性別',			false,	true,	true),
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
			} else {
				$res = $this->__readResult($line, $titleMap, $i);
				
				// TODO: 日付フォーマット変換
				if (!empty($res["racer_code"])){
					$res['original'] = $this->__getOriginalRacer($res);
				}
				
				if (!empty($res['family_name']) && !empty($res['first_name'])) {
					$cddts = $this->__getSameNamedRacer($res);
					$res['cddts'] = $cddts;
				}

				// TODO: カテゴリー所持チェック？
				
				
				$eresults[] = $res;
			}
			
			$i++;
		}
		
		$started = $this->__countStarted($eresults);
		$eresults = $this->__makePers($eresults, $started);
		
		$eresults = $this->__makeAsCategory($eresults, $ecat['EntryCategory']['races_category_code'], $date);
		if (empty($eresults)) {
			return array('error' => array('msg' => 'カテゴリー所属の指定に失敗しました。管理者に連絡してください。'));
		}
		
		return array(
			'not_read_titles' => $titleMap[$this->__TITLE_NOT_READ],
			'title_warns' => $titleMap[$this->__TITLE_WARNS],
			'title_errors' => $titleMap[$this->__TITLE_ERRORS],
			'racers' => $eresults,
			'runits' => $this->_readUnits,
			'started' => $started,
			'rcode_range' => array($meet['MeetGroup']['racer_code_4num_min'], $meet['MeetGroup']['racer_code_4num_max']),
			'rcode_prefix' => $meet['MeetGroup']['code'] . '-' . AjoccUtil::seasonExp($date) . '-',
		);
	}
	
	/**
	 * as_category を設定する
	 * @param type $eresults
	 * @param type $racesCatCode
	 * @param type $date
	 * @return boolean
	 */
	private function __makeAsCategory($eresults, $racesCatCode, $date)
	{
		$ret = array();

		foreach ($eresults as $ere) {

		   // 新規選手に与えるカテゴリーがある場合にはそれを参照する。E.g. C3+4 レースで C3 所属から始まる場合
		   $rcode = empty($ere['racer_code']['val']) ? false : $ere['racer_code']['val'];
		   
		   $this->log('rcode:' . $rcode, LOG_DEBUG);
		   $this->log(print_r($ere['category_code'], true), LOG_DEBUG);
		   $newCatCode = false;
		   if (empty($rcode) && !empty($ere['category_code']['val'])) {
			   $newCatCode = $ere['category_code']['val'];
		   }
		   
		   $ascat = $this->ResultParamCalc->asCategory($rcode, $racesCatCode, $date, array($newCatCode));
		   if (empty($ascat)) {
			   return false;
		   }
		   $ere['as_category'] = $ascat;

		   $ret[] = $ere;
		}
		
		return $ret;
	}
	
	private function __makePers($eresults, $started)
	{
		$rets = array();
		
		$topLap = null;
		$topTime = null;
		foreach ($eresults as $ere) {
			
			//$this->log('eres:', LOG_DEBUG);
			//$this->log($ere, LOG_DEBUG);

			if (isset($ere['rank']['val']) && $ere['rank']['val'] == 1) {
				if (isset($ere['lap']['val'])) {
					$topLap = $ere['lap']['val'];
				}
				if (isset($ere['goal_time']['val'])) {
					$topTime = $ere['goal_time']['val'];
				}
				break;
			}
		}
		//$this->log('tops:' . $topLap . ', ' . $topTime, LOG_DEBUG);
		
		foreach ($eresults as $ere) {
			if (!empty($ere['rank']['val'])) {
				if (isset($ere['result_status']['val'])) {
					$pt = $this->__rankPer($started, $ere['rank']['val'], $ere['result_status']['val'], $ere['entry_status']['val']);
				} else {
					$pt = 0;
				}
				$ere['rank_per'] = $pt;

				if (!empty($ere['lap']['val']) && !empty($ere['goal_time']['val'])) {
					$pt = $this->__runPer($ere['lap']['val'], $ere['rank']['val'], $ere['goal_time']['val'], $topLap, $topTime);
					$ere['run_per'] = $pt;
				}
			}
			
			$rets[] = $ere;
		}
		
		return $rets;
	}
	
	private function __rankPer($started, $rank, $resStatus, $erStatus)
	{
		//$this->log('called:' . $started . ' ' . $rank . '-' . $resStatus->code() . '-' . $erStatus->val(), LOG_DEBUG);
		if ($started <= 0
				|| $erStatus == RacerEntryStatus::$OPEN
				|| empty($rank)
				|| !$resStatus->isRankedStatus()) {
			return null;
		}
		
		return bcdiv('' . ($rank * 100), '' . $started, 0);
	}
	
	private function __runPer($lap, $rank, $time, $topLap, $topTime)
	{
		if (empty($topLap) || empty($topTime)) {
			return null;
		}
		
		if (empty($time)
				|| $lap < $topLap
				|| empty($rank)
				|| empty($time)
				|| !is_int($time)
				|| !is_int($topTime)) {
			return null;
		}
		
		// 走行％＝トップの走行時間（1/10秒単位）÷走行時間（1/10秒単位）（1%未満は四捨五入）
		$dotOne = bcdiv('' . $time, '100', 0);
		$dotOneTop = bcdiv('' . $topTime, '100', 0);
		
		return round(bcmul(bcdiv('' . $dotOneTop, '' . $dotOne, 4), 100, 1)); // 割り算時、小数点2桁目まであればOK
	}
	
	/**
	 * 出走人数をカウントする
	 * @param type $eresults
	 * @return boolean|int エラーがあった場合には false をかえす
	 */
	private function __countStarted($eresults)
	{
		$count = 0;
		
		foreach ($eresults as $er) {
			if (isset($er['entry_status']['error']) || !isset($er['result_status']['val'])) {
				return false;
			}
			//$this->log('try:' . $er['entry_status']['val']->val() . ' and ' . $er['result_status']['val']->val(), LOG_DEBUG);
			if ($er['entry_status']['val']->val() != RacerEntryStatus::$OPEN->val()) {
				if ($er['result_status']['val']->val() != RacerResultStatus::$DNS->val()) {
					++$count;
				}
			}
		}
		
		//$this->log('出走人数:' . $count, LOG_DEBUG);
		
		return $count;
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
		
		if (!empty($dat['racer_code'])) {
			$opt['conditions']['NOT'] = array(
				'code' => $dat['racer_code'],
			);
		}
		
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
	 * @return array 選手コードをもつ登録済みデータ
	 */
	private function __getOriginalRacer($dat)
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
		$map = array(
			'name' => array(),
			'name_kana' => array(),
			'name_en' => array(),
		);
		
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
				if ($key == 'body_number' || $key == 'result_status') {
					$map[$key] = array(
						'original' => '',
						'pos' => $pos,
						'key' => $key,
						'val' => '',
						'error' => '値が必要です。',
					);
					continue;
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
				} else if ($key == 'gender') {
					$g = strtolower($val);
					if ($g === 'm' || $g === 'men' || $g === 'male') {
						$gen = Gender::$MALE;
					} else if ($g === 'w' || $g === 'f' || $g === 'women' || $g === 'female') {
						$gen = Gender::$FEMALE;
					} else {
						$gen = Gender::$UNASSIGNED;
					}
					$cnved = $gen->val();
					$valexp = $gen->charExp();
				} else if ($key == 'result_status') {
					$r = RacerResultStatus::ofExpress($val, false);
					if ($r === false) {
						$err .= '不正な値。マニュアルを確認のこと。';
						$cnved = RacerResultStatus::$DNF; // hidden 出力時にエラーになるため仮の値を入れておく。
					} else {
						$cnved = $r;
						$valexp = $r->code();
					}
				} else if ($key == 'goal_time') {
					$cnved = Util::time2milli($val);
					if ($cnved == false) {
						$err = '時間フォーマットが不正です。必要形式 = H:m:s.SSS or H:m:s';
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
			
			if (!isset($v['error']) && ($key === 'name' || $key === 'name_en')) {
				$names = $this->__splitName($val, $key, $pos);
				if (isset($names['error'])) {
					$map[$key]['error'] = $names['error'];
				} else {
					foreach ($names as $k => $n) {
						$map[$k] = array('val' => $n);
					}
				}
			}
		}
		
		if (isset($map['family_name']) && isset($map['first_name'])) {
			$map['name']['val'] = $map['family_name']['val'] . ' ' . $map['first_name']['val'];
		}
		if (isset($map['family_name_en']) && isset($map['first_name_en'])) {
			$map['name_en']['val'] = $map['family_name_en']['val'] . ' ' . $map['first_name_en']['val'];
		}
		
		if (!isset($map['name']['error'])) {
			if (!isset($map['family_name'])) {
				$map['family_name'] = array(
					'original' => '',
					'val' => '',
					'pos' => null,
					//'error' => '値が必要です。',
					'valexp' => '(読込値がありません)',
				);
			}
			if (!isset($map['first_name'])) {
				$map['first_name'] = array(
					'original' => '',
					'val' => '',
					'pos' => null,
					//'error' => '値が必要です。',
					'valexp' => '(読込値がありません)',
				);
			}
		}
		
		return $map;
	}
	
	private function __splitName($name, $key, $cellpos)
	{
		// 半角 or 全角スペーズで区切る
		
		$pos = mb_strpos($name, ' ');
		
		if ($pos === false) {
			$pos = mb_strpos($name, '　');
			
			if ($pos === false) {
				return array('error' => 'key:' . $key . ' の値は半角or全角スペースを含む必要があります。');
			}
		}
		
		if ($pos === 0) {
			// error
		} else if ($pos === mb_strlen($name) - 1) {
			// error
		}
		
		$fam = mb_substr($name, 0, $pos);
		$fir = mb_substr($name, $pos + 1);
		
		if (empty($fam)) {
			return array('error' => 'key:' . $key . ' の値から姓を検出できませんでした。');
		}
		if (empty($fir)) {
			return array('error' => 'key:' . $key . ' の値から名前（first_name) を検出できませんでした。');
		}
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
		// needs なカラムがあるかの確認
		foreach ($this->_readUnits as $unit) {
			if ($unit->needs) {
				$finds = false;
				foreach ($map as $k => $u) {
					if ($k === $this->__TITLE_NOT_READ) continue;
					if ($u->key === $unit->key) {
						$finds = true;
					}
				}
				
				if (!$finds) {
					$err[] = '[Error] タイトル:' . $unit->key . ' を持つ列が必要です。';
				}
			}
		}
		
		$map[$this->__TITLE_ERRORS] = $err;
		
		$warns= array();
		if (!$findsCode) {
			$warns[] = "[警告] 選手コードを指定する列がありません。";
		}
		
		if (!$findsFamName || !$finds1stName) {
			$warns[] = "[警告] 選手の名前を指定する列が無いか、不十分です。";
		}
		
		$map[$this->__TITLE_WARNS] = $warns;
		
		return $map;
	}
}
