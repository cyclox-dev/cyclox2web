<?php
App::uses('AppModel', 'Model');
/**
 * ParmVar Model
 *
 */
class ParmVar extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'pkey';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pkey' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
