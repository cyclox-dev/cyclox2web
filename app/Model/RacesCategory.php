<?php
App::uses('AppModel', 'Model');
/**
 * RacesCategory Model
 *
 * @property CategoryRacesCategory $CategoryRacesCategory
 * @property EntryCategory $EntryCategory
 */
class RacesCategory extends AppModel
{
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
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
		'name' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
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
		'CategoryRacesCategory' => array(
			'className' => 'CategoryRacesCategory',
			'foreignKey' => 'races_category_code',
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
		'EntryCategory' => array(
			'className' => 'EntryCategory',
			'foreignKey' => 'races_category_code',
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
