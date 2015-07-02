<?php

App::uses('AppModel', 'Model');

/**
 * Racer Model
 *
 * @property CategoryRacer $CategoryRacer
 * @property EntryRacer $EntryRacer
 */
class Racer extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'code';
	
	public $actsAs = array('Search.Searchable', 'Utils.SoftDelete');
    
	// Search プラグイン設定
	public $filterArgs = array(
		'word' => array(
			'type' => 'like',
			'field' => array(
				'Racer.code',
				'Racer.family_name',
				'Racer.family_name_kana',
				'Racer.family_name_en',
				'Racer.first_name',
				'Racer.first_name_kana',
				'Racer.first_name_en',
			),
			'connectorAnd' => '+',
			'connectorOr' => ','
		),
	);
	
	public function multipleKeywords($keyword, $andor = null) {
		$connector = ($andor === 'or') ? ',' : '+';
		$keyword = preg_replace('/\s+/', $connector, trim(mb_convert_kana($keyword, 's', 'UTF-8')));
		return $keyword;
	}
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'code' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'gender' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => '性別を表す正の整数値を入力して下さい。',
				'allowEmpty' => true,
			),
		),
		'birth_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => '有効な日付形式を入力して下さい。',
				'allowEmpty' => true,
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CategoryRacer' => array(
			'className' => 'CategoryRacer',
			'foreignKey' => 'racer_code',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	
}
