<?php

App::uses('AppModel', 'Model');

/**
 * CategoryRacesCategory Model
 *
 * @property RacesCategory $RacesCategory
 * @property Category $Category
 */
class CategoryRacesCategory extends AppModel
{
	public $displayField = 'races_category_code';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'category_code' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
		'races_category_code' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'RacesCategory' => array(
			'className' => 'RacesCategory',
			'foreignKey' => 'races_category_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
