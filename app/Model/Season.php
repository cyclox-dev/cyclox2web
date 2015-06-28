<?php
App::uses('AppModel', 'Model');
/**
 * Season Model
 *
 * @property Meet $Meet
 */
class Season extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'name' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'short_name' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'start_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => '有効な日付形式で入力して下さい。',
			),
		),
		'end_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => '有効な日付形式で入力して下さい。',
			),
		),
		'is_regular' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Meet' => array(
			'className' => 'Meet',
			'foreignKey' => 'season_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);//*/

}
