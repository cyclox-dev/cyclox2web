<?php
App::uses('AppModel', 'Model');
/**
 * HoldPoint Model
 *
 * @property RacerResult $RacerResult
 */
class HoldPoint extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'racer_result_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'point' => array(
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
		'RacerResult' => array(
			'className' => 'RacerResult',
			'foreignKey' => 'racer_result_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
