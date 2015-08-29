<?php

App::uses('AppModel', 'Model');
App::uses('TimeRecord', 'Model');
App::uses('CategoryRacer', 'Model');
App::uses('HoldPoint', 'Model');
App::uses('PointSeriesRacer', 'Model');

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
		'status' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber', true),
				//'message' => 'Your custom message here',
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
				'allowEmpty' => true,
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
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'HoldPoint' => array(
			'className' => 'HoldPoint',
			'foreignKey' => 'racer_result_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PointSeriesRacer' => array(
			'className' => 'PointSeriesRacer',
			'foreignKey' => 'racer_result_id',
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
	
	/**
	 * 関連するオブジェクト削除のためのオーバーライド（dependent は使用できない）
	 * @param type $id
	 * @param type $cascade
	 * @return type
	 */
	public function delete($id = null, $cascade = true)
	{
		$delID = $this->id;
		if (!empty($id)) $delID = $id;
		
		if ($cascade) {
			$trModel = new TimeRecord();
			
			// TimeRecord は SoftDelete しないので、deleteAll() を直接コール
			$trModel->deleteAll(array('racer_result_id' => $delID), $cascade);
			
			// 昇格データについては削除しないものとする。
			/*
			// X: $ecModel->deleteAll(array('entry_group_id' => $delID));
			// SoftDelete のおかげで deleteAll が使えない（hard delete されてしまう）
			// ので手動で delete() をコール
			
			// 昇格データの削除
			$crModel = new CategoryRacer();
			
			$results = $crModel->find('list', array('conditions' => array('racer_result_id' => $delID)));
			foreach ($results as $key => $val) {
				if ($crModel->exists($key)) {
					$crModel->delete($key, true);
				}
			}
			//*/
			
			$hpModel = new HoldPoint();
			$hpModel->deleteAll(array('racer_result_id' => $delID), $cascade);
			
			$psrModel = new PointSeriesRacer();
			$psrModel->deleteAll(array('racer_result_id' => $delID), $cascade);
		}
		
		return parent::delete($id, $cascade);
	}
}
