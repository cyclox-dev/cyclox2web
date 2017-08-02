<?php

App::uses('AppModel', 'Model');
App::uses('EntryCategory', 'Model');

/**
 * EntryGroup Model
 *
 * @property TimeRecordInfo $TimeRecordInfo
 * @property Meet $Meet
 * @property EntryCategory $EntryCategory
 */
class EntryGroup extends AppModel
{
	public $actsAs = array('Utils.SoftDelete');

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
		'meet_code' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
		'start_clock' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start_frac_distance' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lap_distance' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'skip_lap_count' => array(
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
		'TimeRecordInfo' => array(
			'className' => 'TimeRecordInfo',
			'foreignKey' => 'entry_group_id',
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
		'Meet' => array(
			'className' => 'Meet',
			'foreignKey' => 'meet_code',
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
		'EntryCategory' => array(
			'className' => 'EntryCategory',
			'foreignKey' => 'entry_group_id',
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
	public function delete($id = null, $cascade = true) {
		
		$ecModel = new EntryCategory();
		
		$delID = $this->id;
		if (!empty($id)) $delID = $id;
		
		if ($cascade) {
			// X: $ecModel->deleteAll(array('entry_group_id' => $delID));
			// SoftDelete のおかげで deleteAll が使えない（hard delete されてしまう）
			// ので手動で delete() をコール
			
			$ecats = $ecModel->find('list', array('conditions' => array('entry_group_id' => $delID)));
			foreach ($ecats as $key => $val) {
				if ($ecModel->exists($key)) {
					$ecModel->delete($key, true);
				}
			}//*/
		}
		
		return parent::delete($id, $cascade);
	}
}
