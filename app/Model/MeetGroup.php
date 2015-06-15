<?php
App::uses('AppModel', 'Model');
/**
 * MeetGroup Model
 *
 * @property Meet $meets
 */
class MeetGroup extends AppModel
{
	const MSG_INPUT_CODE = 'code は半角英数3文字を指定して下さい。';
	const MSG_NOT_EMPTY = '必須入力項目です。';
	
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
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須入力です。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => '/^[a-z0-9]{3}$/i',
				'message' => 'code は半角英数3文字を指定して下さい。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isPKUnique' => array( // isUnique では update になってしまうので自前で。
				'rule' => array('isPKUnique'),
				'message' => 'その code はすでに使用されています。'
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須入力です。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'short_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '必須入力です。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'homepage' => array(
			'rule' => 'url',
			'message' => 'URL 形式が不正です。',
			'allowEmpty' => true
		)
	);
	
	/**
	 * 大会グループコードがまだ登録されていないかをかえす
	 * @param string $code
	 */
	public function isPKUnique($code) {
		//return !$this->exists($code);
		
		$mg = $this->findByCode($code);
		return !$mg;
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'meets' => array(
			'className' => 'Meet',
			'foreignKey' => 'meet_group_code',
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
