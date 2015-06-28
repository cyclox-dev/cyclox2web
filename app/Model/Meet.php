<?php
App::uses('AppModel', 'Model');
/**
 * Meet Model
 *
 * @property Season $Season
 * @property MeetGroup $MeetGroup
 * @property EntryGroup $EntryGroup
 */
class Meet extends AppModel {

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
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'meet_group_code' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'season_id' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => 'シーズン ID（正の自然数）を入力して下さい。',
			),
		),
		'at_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => '正しい日付形式で入力して下さい。',
			),
		),
		'name' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'short_name' => array(
			'rule' => array('notEmpty'),
			'message' => '必須項目です。',
		),
		'homepage' => array(
			'url' => array(
				'rule' => array('url'),
				'allowEmpty' => true,
			),
		),
		'start_frac_distance' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'allowEmpty' => true,
			),
		),
		'lap_distance' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'allowEmpty' => true,
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
		'Season' => array(
			'className' => 'Season',
			'foreignKey' => 'season_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'MeetGroup' => array(
			'className' => 'MeetGroup',
			'foreignKey' => 'meet_group_code',
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
		'EntryGroup' => array(
			'className' => 'EntryGroup',
			'foreignKey' => 'meet_code',
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
