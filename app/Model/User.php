<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 */
class User extends AppModel
{

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';
	
    public $actsAs = array('Utils.SoftDelete');
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'minLength' => array(
				'rule' => array('minLength', 4),
				'message' => '4文字以上の名前を入力して下さい。'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'その名前はすでに使用されています。'
			)
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', 6),
				'message' => '6文字以上を入力して下さい。'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'そのメールアドレスはすでに使用されています。'
			)
		),
	);
	
	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}

}
