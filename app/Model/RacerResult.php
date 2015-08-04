<?php

App::uses('AppModel', 'Model');
App::uses('TimeRecord', 'Model');

/**
 * RacerResult Model
 *
 * @property EntryRacer $EntryRacer
 */
class RacerResult extends AppModel
{
	public $actsAs = array('Utils.SoftDelete');

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
		'order_index' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber', true),
				'message' => 'ゼロ以上の整数を入力してください。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lap' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'goal_milli_sec' => array(
			'naturalNumber' => array(
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
		'EntryRacer' => array(
			'className' => 'EntryRacer',
			'foreignKey' => 'entry_racer_id',
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
		'TimeRecord' => array(
			'className' => 'TimeRecord',
			'foreignKey' => 'racer_result_id',
			'dependent' => true,
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
	
	/**
	 * 関連するオブジェクト削除のためのオーバーライド（dependent は使用できない）
	 * @param type $id
	 * @param type $cascade
	 * @return type
	 */
	public function delete($id = null, $cascade = true)
	{
		$resultModel = new TimeRecord();
		
		$delID = $this->id;
		if (!empty($id)) $delID = $id;
		
		if ($cascade) {
			// TimeRecord は SoftDelete しないので、deleteAll() を直接コール
			$resultModel->deleteAll(array('racer_result_id' => $delID), $cascade);
		}
		
		return parent::delete($id, $cascade);
	}
}
