<?php

App::uses('AppModel', 'Model');
App::uses('EntryRacer', 'Model');

/**
 * EntryCategory Model
 *
 * @property EntryGroup $EntryGroup
 * @property RacesCategory $RacesCategory
 * @property EntryRacer $EntryRacer
 */
class EntryCategory extends AppModel
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
		'races_category_code' => array(
			'rule' => array('notBlank'),
			'message' => '必須項目です。',
		),
		'start_delay_sec' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lapout_rule' => array(
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
		'EntryGroup' => array(
			'className' => 'EntryGroup',
			'foreignKey' => 'entry_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RacesCategory' => array(
			'className' => 'RacesCategory',
			'foreignKey' => 'races_category_code',
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
		'EntryRacer' => array(
			'className' => 'EntryRacer',
			'foreignKey' => 'entry_category_id',
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
		$erModel = new EntryRacer();
		
		$delID = $this->id;
		if (!empty($id)) $delID = $id;
		
		if ($cascade) {
			// X: $ecModel->deleteAll(array('entry_group_id' => $delID));
			// SoftDelete のおかげで deleteAll が使えない（hard delete されてしまう）
			// ので手動で delete() をコール
			
			$ers = $erModel->find('list', array('conditions' => array('entry_category_id' => $delID)));
			foreach ($ers as $key => $val) {
				if ($erModel->exists($key)) {
					$erModel->delete($key, true);
				}
			}
		}
		
		return parent::delete($id, $cascade);
	}

}
