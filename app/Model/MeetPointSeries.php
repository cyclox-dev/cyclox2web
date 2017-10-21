<?php
App::uses('AppModel', 'Model');
App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');

/**
 * MeetPointSeries Model
 *
 * @property PointSeries $PointSeries
 * @property Meet $Meet
 */
class MeetPointSeries extends AppModel
{
	public $actsAs = array('Utils.SoftDelete');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'express_in_series' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'point_series_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'meet_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'entry_category_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'grade' => array(
			'numeric' => array(
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
		'PointSeries' => array(
			'className' => 'PointSeries',
			'foreignKey' => 'point_series_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Meet' => array(
			'className' => 'Meet',
			'foreignKey' => 'meet_code',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function setupTermOfSeriesPoint($meetCode, $ecatName)
	{
		if (empty($meetCode) || empty($ecatName)) {
			return false;
		}
		
		$opt = array(
			'conditions' => array(
				'meet_code' => $meetCode,
			)
		);
		$mpss = $this->find('all', $opt);
		
		$tmpMpss = array();
		foreach ($mpss as $mps) {
			// mps.ecat_name にワイルドカードが含まれるのでプログラム側で走査
			$mpsEcat = $mps['MeetPointSeries']['entry_category_name'];
			if ($mpsEcat === $ecatName) {
				$tmpMpss[] = $mps;
			} else if ($this->__endsWith($mpsEcat, '*')) {
				$nameBody = substr($mpsEcat, 0, -1);
				if ($this->__startsWith($ecatName, $nameBody)) {
					$tmpMpss[] = $mps;
				}
			}
		}
		$mpss = $tmpMpss;
		
		if (empty($mpss)) {
			return true;
		}
		
		foreach ($mpss as $mps) {
			$termRuleVal = $mps['PointSeries']['point_term_rule'];
			$rule = PointSeriesTermOfValidityRule::ruleAt($termRuleVal);
			if (is_null($rule)) {
				$this->log('期間設定ルールを設定できません。', LOG_DEBUG);
				return false;
			}
			
			if (!empty($rule)) {
				$term = $rule->calc($mps['Meet']['at_date']);
				
				$newMps = array();
				$newMps['MeetPointSeries'] = array();
				
				if (!empty($term['begin'])) {
					$newMps['MeetPointSeries']['point_term_begin'] = $term['begin'];
				} else {
					$newMps['MeetPointSeries']['point_term_begin'] = null;
				}
				if (!empty($term['end'])) {
					$newMps['MeetPointSeries']['point_term_end'] = $term['end'];
				} else {
					$newMps['MeetPointSeries']['point_term_end'] = null;
				}
				
				//$this->log($mps, LOG_DEBUG);
				
				if (!empty($term['begin']) || !empty($term['end'])) {
					$this->id = $mps['MeetPointSeries']['id'];
					$ret = $this->save($newMps);
					
					if (!$ret) {
						$this->log('MeetPointSeries の保存に失敗しました。', LOG_ERR);
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	private function __startsWith($haystack, $needle) {
		return substr($haystack, 0, strlen($needle)) === $needle;
	}
	
	private function __endsWith($haystack, $needle) {
		return substr($haystack, - strlen($needle)) === $needle;
	}
}
