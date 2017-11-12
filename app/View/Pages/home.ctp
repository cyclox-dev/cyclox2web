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

<h2>カテゴリー設定</h2>
<p><?php echo $this->Html->link("カテゴリー", "/categories/index");?></p>
<p><?php echo $this->Html->link("カテゴリーグループ", "/category_groups/index");?></p>
<p><?php echo $this->Html->link("レースカテゴリー", "/races_categories/index");?></p>

<h2>ポイントシリーズ</h2>
<p><?php echo $this->Html->link("ポイントシリーズ", "/point_series/index");?></p>
<p><?php echo $this->Html->link("ポイントシリーズの設定・ルールetc", "/pages/point_series_rules");?></p>

<h2>AJOCC ランキング設定</h2>
<p><?php echo $this->Html->link("AJOCC ランキング個別設定", "/ajoccpt_local_settings/index");?></p>

<h2>その他</h2>
<p><?php echo $this->Html->link("ユティリティ【オーガナイザ用】", "/org_util");?></p>
<p><?php echo $this->Html->link("ページごと権限設定【管理者用】", "/admin/acl/aros/ajax_role_permissions");?></p>

