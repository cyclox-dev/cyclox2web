<?php
App::uses('AppModel', 'Model');
/**
 * TimeRecord Model
 *
 * @property EntryRacer $EntryRacer
 */
class TimeRecord extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'entry_racer_id' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'time_milli' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lap' => array(
			'numeric' => array(
				'rule' => 'numeric',
			)
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EntryRacer' => array(
			'className' => 'EntryRacer',
			'foreignKey' => 'entry_racer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
