<?php

App::uses('AppModel', 'Model');

/**
 * MeetGroup Model
 *
 * @property Meet $meets
 */
class MeetGroup extends AppModel
{
	const MSG_INPUT_CODE = 'code は半角英数3文字を指定して下さい。';
	const MSG_NOT_EMPTY = '必須入力項目です。';
	
	public $actsAs = array('Utils.SoftDelete');
	
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'code';

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
		'code' => array(
			'threeChar' => array(
				'rule' => '/^[a-z0-9]{3}$/i',
				'message' => '半角英数3文字を指定して下さい。',
			),
		),
		'name' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
		'short_name' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
		'homepage' => array(
			'rule' => 'url',
			'message' => 'URL 形式が不正です。',
			'allowEmpty' => true
		),
		'racer_code_4num_max' => array(
			'rule' => array('naturalNumber', true),
			'message' => '1から9999までの数値を入力してください。',
		),
		'racer_code_4num_min' => array(
			'rule' => array('naturalNumber', true),
			'message' => '1から9999までの数値を入力してください。',
		),
		// TODO: min < max の保証
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'meets' => array(
			'className' => 'Meet',
			'foreignKey' => 'meet_group_code',
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
	);

}
