<?php

App::uses('AppModel', 'Model');
App::uses('Constant', 'Cyclox/Const');
App::uses('CategoryReason', 'Cyclox/Const');

/**
 * CategoryRacer Model
 *
 * @property Category $Category
 * @property Racer $Racer
 */
class CategoryRacer extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'category_code';

	public $actsAs = array('Utils.SoftDelete');
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'racer_code' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'category_code' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'apply_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => '有効な日付形式で入力して下さい。',
				'allowEmpty' => false,
			),
		),
		'reason_id' => array(
			'rule' => array('numeric'),
			'message' => '整数値を入力して下さい。',
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Racer' => array(
			'className' => 'Racer',
			'foreignKey' => 'racer_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Meet' => array(
			'className' => 'Meet',
			'foreignKey' => 'meet_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RacerResult' => array(
			'className' => 'RacerResult',
			'foreignKey' => 'racer_result_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	 * 昇格を計算し、適用する。
	 * @param string $racerCode 選手コード
	 * @param int $racerResultId リザルト
	 * @param int $rank レースでの順位 null ok
	 * @param int $raceStartedCount レースの出走人数（Open 参加を除く）
	 * @param string $rcatCode レースカテゴリーコード
	 * @param date $meet 大会データ
	 * @return int Constant.RET_ のいずれか
	 */
	public function saveRankUp($racerCode, $racerResultId, $rank, $raceStartedCount, $rcatCode, $meet)
	{
		if (empty($racerCode) || empty($racerResultId) || empty($raceStartedCount) ||
			empty($rcatCode) || empty($meet)) {
			return Constant::RET_ERROR;
		}
		
		if (empty($rank)) {
			return Constant::RET_NO_ACTION;
		}
		
		// 選手のカテゴリー所属を取得
		$opt = array('conditions' => array('racer_code' => $racerCode), 'recursive' => -1);
		$catBinds = $this->find('all', $opt);
		//$this->log('cats:', LOG_DEBUG);
		//$this->log($catBinds, LOG_DEBUG);
		
		// TODO: 警告を出す？
		if (empty($catBinds)) {
			return Constant::RET_NO_ACTION;
		}
		
		// 出走人数と昇格のルール
		$rule0123 = array(10, 20, 30);
		$rule0112 = array(
			array(10 => 0), array(20 => 1), array(30 => 1), array(99999 => 2)
		);
		
		// 文字列で判断する
		// TODO: 処理改善。レースカテゴリーが含有するリザルト
		// racesCatCode => array('needs' => 必要な所属, 'to' =>昇格先)
		$map = array(
			'C2' => array('needs' => array('C2'), 'to' => 'C1', 'rule' => $rule0123),
			'C3' => array('needs' => array('C3'), 'to' => 'C2', 'rule' => $rule0123),
			'C4' => array('needs' => array('C4'), 'to' => 'C3', 'rule' => $rule0123),
			'C3+4' => array('needs' => array('C3', 'C4'), 'to' => 'C2', 'rule' => $rule0123),
			'CM2' => array('needs' => array('CM2'), 'to' => 'CM1', 'rule' => $rule0112),
			'CM3' => array('needs' => array('CM3'), 'to' => 'CM2', 'rule' => $rule0123),
			'CM2+3' => array('needs' => array('CM2', 'CM3'), 'to' => 'CM1', 'rule' => $rule0112),
			// TODO: 勝利したら CM1 表彰台で CM2 だっけ？
			//'CM1+2+3' => array('needs' => array('CM1', 'CM2', 'CM3'), 'to' => 'CM1'),
		);
		
		if (empty($map[$rcatCode])) {
			return Constant::RET_NO_ACTION;
		}
		
		// 人数と順位についてチェック
		$i = 0;
		for (; $i < count($map[$rcatCode]['rule']); $i++) {
			$maxRacerCount = $map[$rcatCode]['rule'][$i];
			if ($raceStartedCount <= $maxRacerCount) {
				break;
			}
		}
		$this->log($i . '人まで昇格 vs rank:' . $rank, LOG_DEBUG);
		
		if ($i == 0 || $i < $rank) {
			return Constant::RET_NO_ACTION;
		}
		
		// カテゴリーの所属を確認
		$hasCat = false;
		$breaks = false;
		foreach ($catBinds as $catBind) {
			foreach ($map[$rcatCode]['needs'] as $catName) {
				if ($catBind['CategoryRacer']['category_code'] === $catName) {
					$hasCat = true;
					$breaks = true;
					break;
				}
			}
		}
		
		if (!$hasCat) {
			// TODO: 警告を検討すること
			return Constant::RET_NO_ACTION;
		}
		
		
		$cr = array();
		$cr['CategoryRacer'] = array();
		$cr['CategoryRacer']['racer_code'] = $racerCode;
		$cr['CategoryRacer']['category_code'] = $map[$rcatCode]['to'];
		$cr['CategoryRacer']['apply_date'] = $meet['at_date'];
		$cr['CategoryRacer']['reason_id'] = CategoryReason::$RESULT_UP->ID();
		$cr['CategoryRacer']['reason_note'] = "";
		$cr['CategoryRacer']['racer_result_id'] = $racerResultId;
		$cr['CategoryRacer']['cancel_date'] = null;
		//$cr['CategoryRacer']
		
		$this->log('cr is,,,', LOG_DEBUG);
		$this->log($cr, LOG_DEBUG);
		
		if ($this->save($cr)) {
			return Constant::RET_SUCCEED;
		} else {
			return Constant::RET_FAILED;
		}
		
		//*/
	}
}
