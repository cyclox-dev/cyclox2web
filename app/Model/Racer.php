<?php
App::uses('LogicalDelModel', 'Model');
/**
 * Racer Model
 *
 * @property CategoryRacer $CategoryRacer
 * @property EntryRacer $EntryRacer
 */
class Racer extends LogicalDelModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'code';

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
