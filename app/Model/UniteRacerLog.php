<?php
App::uses('AppModel', 'Model');
/**
 * UniteRacerLog Model
 *
 * @property Racer $Racer
 * @property Racer $Racer
 */
class UniteRacerLog extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'unite_racer_log';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'at_date';
	
	public $order = 'UniteRacerLog.at_date desc';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'united' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'unite_to' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'at_date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
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
		'United' => array(
			'className' => 'Racer',
			'foreignKey' => 'united',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UniteTo' => array(
			'className' => 'Racer',
			'foreignKey' => 'unite_to',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
