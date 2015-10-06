<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property CategoryGroup $CategoryGroup
 * @property CategoryRacer $CategoryRacer
 * @property CategoryRacesCategory $CategoryRacesCategory
 */
class Category extends AppModel {

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
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須項目です。',
			),
			/*
			 * isUnique は update になってしまうので on => create は動かない。 Controller 側で処理する。
			 */
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須項目です。',
			),
		),
		'short_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須項目です。',
			),
		),
		'category_group_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須項目です。',
			),
		),
		'rank' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'allowEmpty' => true,
				'message' => '正の整数を入力して下さい。',
			),
		),
		'race_min' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => '正の整数を入力して下さい。',
				'allowEmpty' => true,
			)
		),
		'gender' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須項目です。',
			),
		),
		'age_min' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => '正の整数を入力して下さい。',
				'allowEmpty' => true,
			),
		),
		'age_max' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => '正の整数を入力して下さい。',
				'allowEmpty' => true,
			),
		),
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CategoryGroup' => array(
			'className' => 'CategoryGroup',
			'foreignKey' => 'category_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CategoryRacesCategory' => array(
			'className' => 'CategoryRacesCategory',
			'foreignKey' => 'category_code',
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
