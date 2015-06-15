<?php

/*
 *  created at 2015/06/12 by shun
 */

/**
 * Description of Meet
 *
 * @author shun
 */
class Meet extends AppModel
{
	var $primaryKey = 'code';
	
	// TODO: 半角スペースのみ入力は notEmpty == true にひっかからない。
	
	public $validate = array(
		'code' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => '大会コードが必要です。'
			),
			/*'format'=> array(
				'// TODO: 大会コードの形式チェック
			),//*/
			
		),
		'meet_group_code' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => '大会開催者の指定が必要です。'
			)
			// TODO: 大会グループコード validation
		),
		'season_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'シーズン指定が必要です。'
			),
			'naturalNumber' => array(
				'rule' => 'naturalNumber',
				'message' => 'シーズン ID が不正です。'
			)
		),
		'at_date' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => '開催日が必要です。'
			),
			'date' => array(
				'rule' => 'date',
				'message' => '無効な日付入力です。'
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => '大会名を入力して下さい。'
			)
		),
		'short_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => '大会の短縮名を入力して下さい。'
			)
		),
		'homepage' => array(
			'rule' => 'url',
			'message' => 'URL 入力値が無効です。',
			'allowEmpty' => true
		),
		'start_frac_distance' => array(
			'rule' => 'numeric',
			'message' => '数値を入力して下さい。',
			'allowEmpty' => true
		),
		'lap_distance' => array(
			'rule' => 'numeric',
			'message' => '数値を入力して下さい。',
			'allowEmpty' => true
		),
		'deleted' => array(
			'rule' => 'date',
			'allowEmpty' => true,
			'message' => '無効な日時入力です。'
		)
	);
}
