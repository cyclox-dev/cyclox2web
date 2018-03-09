<?php

/*
 *  created at 2015/07/04 by shun
 */

/**
 * ページタイトルを設定するコンポーネント
 *
 * @author shun
 */
class PageTitleComponent extends Component
{
	private $__ctrls = array(
		'Categories' => 'カテゴリー',
		'CategoryGroups' => 'カテゴリーグループ',
		'CategoryRacesCategories' => 'カテゴリー=レースカテゴリー関連',
		'EntryCategories' => '出走カテゴリー',
		'EntryGroups' => '出走グループ',
		'EntryRacers' => '出走選手データ',
		'MeetGroups' => '大会グループ',
		'Meets' => '大会',
		'RacerResults' => '選手結果データ',
		'Racers' => '選手データ',
		'CategoryRacers' => 'カテゴリー所属',
		'Seasons' => 'シーズン',
		'TimeRecordInfos' => '計測時情報',
		'TimeRecords' => '計測データ',
		'Users' => 'ユーザー',
		'PointSeries' => 'ポイントシリーズ',
		'PointSeriesGroups' => 'ポイントシリーズグループ',
		'AjoccptLocalSettings' => 'Ajocc Point Local 設定',
		
	);
	
	private $__actions = array(
		'add' => '追加',
		'edit' => '編集',
		'index' => 'リスト',
		'view' => '詳細',
		'login' => 'ログイン',
		'logout' => 'ログアウト'
	);

    /**
	 * ページタイトルを設定する
	 * @param type $ctrlName
	 * @param type $action
	 * @param type $param
	 * @return type
	 */
	public function getPageTitle($ctrlName, $action, $param = null)
	{
		$c = (empty($this->__ctrls[$ctrlName])) ? '' : $this->__ctrls[$ctrlName];
		$a = (empty($this->__actions[$action])) ? '' : $this->__actions[$action];
		
		$p = '';
		if (!empty($param)) {
			$p = ' - ' . $param;
		}
		
		return 'CYCLOX - ' . $c . $a . $p;
    }
}
