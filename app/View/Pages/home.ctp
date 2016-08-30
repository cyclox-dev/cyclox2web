<?php

/* 
 *  created at 2015/06/28 by shun
 */
?>

<h2>大会</h2>
<p><?php echo $this->Html->link("シーズン", "/seasons/index");?></p>
<p><?php echo $this->Html->link("大会グループ", "/meet_groups/index");?></p>
<p><?php echo $this->Html->link("大会", "/meets/index");?></p>

<h2>選手</h2>
<p><?php echo $this->Html->link("選手情報", "/racers/index");?></p>
<p><?php echo $this->Html->link("選手カテゴリー所属", "/category_racers /index");?></p>

<h2>カテゴリー設定</h2>
<p><?php echo $this->Html->link("カテゴリー", "/categories/index");?></p>
<p><?php echo $this->Html->link("カテゴリーグループ", "/category_groups/index");?></p>
<p><?php echo $this->Html->link("レースカテゴリー", "/races_categories/index");?></p>
<p><?php echo $this->Html->link("カテゴリー = レースカテゴリー Bind", "/category_races_categories/index");?></p>

<h2>エントリー</h2>
<p><?php echo $this->Html->link("出走グループ", "/entry_groups/index");?></p>
<p><?php echo $this->Html->link("出走カテゴリー", "/entry_categories/index");?></p>
<p><?php echo $this->Html->link("出走選手", "/entry_racers/index");?></p>

<h2>リザルト</h2>
<p><?php echo $this->Html->link("計測時情報（出走グループ単位）", "/time_record_infos/index");?></p>
<p><?php echo $this->Html->link("計測データ", "/time_records/index");?></p>
<p><?php echo $this->Html->link("選手リザルト（出走選手ごと）", "/racer_results/index");?></p>

<h2>ポイントシリーズ</h2>
<p><?php echo $this->Html->link("ポイントシリーズ", "/point_series/index");?></p>
<p><?php echo $this->Html->link("ポイントシリーズ大会設定", "/meet_point_series/index");?></p>
<p><?php echo $this->Html->link("選手ごとポイント", "/point_series_racers/index");?></p>
<p><?php echo $this->Html->link("ポイントシリーズの設定・ルールetc", "/pages/point_series_rules");?></p>

<h2>その他</h2>
<p><?php echo $this->Html->link("ユティリティ【オーガナイザ用】", "/org_util");?></p>
<p><?php echo $this->Html->link("ページごと権限設定【管理者用】", "/admin/acl/aros/ajax_role_permissions");?></p>

