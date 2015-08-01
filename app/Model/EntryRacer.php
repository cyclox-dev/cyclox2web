<?php
App::uses('AppModel', 'Model');
/**
 * EntryRacer Model
 *
 * @property RacerResult $RacerResult
 * @property EntryCategory $EntryCategory
 * @property Racer $Racer
 * @property TimeRecord $TimeRecord
 */
class EntryRacer extends AppModel
{
	public $actsAs = array('Utils.SoftDelete');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'entry_category_id' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'racer_code' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'entry_status' => array(
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
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'RacerResult' => array(
			'className' => 'RacerResult',
			'foreignKey' => 'entry_racer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EntryCategory' => array(
			'className' => 'EntryCategory',
			'foreignKey' => 'entry_category_id',
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
		)
	);

}
