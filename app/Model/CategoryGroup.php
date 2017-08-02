<?php

App::uses('AppModel', 'Model');

/**
 * CategoryGroup Model
 *
 * @property Category $Category
 */
class CategoryGroup extends AppModel {

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
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => '必須項目です。',
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'すでにその名前は使用されています。'
			)
		),
		'description' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_group_id',
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
