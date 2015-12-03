<?php
App::uses('AppModel', 'Model');
/**
 * PointSeriesRacer Model
 *
 * @property PointSeries $PointSeries
 * @property RacerResult $RacerResult
 * @property Racer $Racer
 */
class PointSeriesRacer extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'racer_code' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'point_series_id' => array(
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
		'bonus' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'racer_result_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
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
		'PointSeries' => array(
			'className' => 'PointSeries',
			'foreignKey' => 'point_series_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RacerResult' => array(
			'className' => 'RacerResult',
			'foreignKey' => 'racer_result_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Racer' => array(
			'className' => 'Racer',
			'foreignKey' => 'racer_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'MeetPointSeries' => array(
			'className' => 'MeetPointSeries',
			'foreignKey' => 'meet_point_series_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
