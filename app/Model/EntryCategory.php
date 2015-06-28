<?php
App::uses('AppModel', 'Model');
/**
 * EntryCategory Model
 *
 * @property EntryGroup $EntryGroup
 * @property RacesCategory $RacesCategory
 * @property EntryRacer $EntryRacer
 */
class EntryCategory extends AppModel {

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
		'races_category_code' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'start_delay_sec' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lapout_rule' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
		'EntryGroup' => array(
			'className' => 'EntryGroup',
			'foreignKey' => 'entry_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RacesCategory' => array(
			'className' => 'RacesCategory',
			'foreignKey' => 'races_category_code',
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
		'EntryRacer' => array(
			'className' => 'EntryRacer',
			'foreignKey' => 'entry_category_id',
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
