<?php
App::uses('AppModel', 'Model');
/**
 * TmpResultUpdateFlag Model
 *
 * @property EntryCategory $EntryCategory
 */
class TmpResultUpdateFlag extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'entry_category_id';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

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
		)
	);
}
