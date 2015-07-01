<?php
App::uses('LogicalDelModel', 'Model');
/**
 * CategoryRacer Model
 *
 * @property Category $Category
 * @property Racer $Racer
 */
class CategoryRacer extends LogicalDelModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'category_code';

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
		)
	);
}
