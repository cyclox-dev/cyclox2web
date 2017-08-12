<?php
App::uses('AppModel', 'Model');
/**
 * NameChangeLog Model
 *
 * @property Racer $Racer
 */
class NameChangeLog extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'racer_code';
	
	public $order = 'NameChangeLog.created desc';
	
	// saveMany で insert した id の配列を取得する
	public $insertedIds = array();
 
    function afterSave($created, $options = array())
    {
        if($created)
        {
            $this->insertedIds[] = $this->getInsertID();
        }
        return parent::afterSave($created, $options);
    }
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'racer_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
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
		'Racer' => array(
			'className' => 'Racer',
			'foreignKey' => 'racer_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
