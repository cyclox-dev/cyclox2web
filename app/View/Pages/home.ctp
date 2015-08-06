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
<p><?php echo $this->Html->link("選手 = カテゴリー Bind", "/category_racers /index");?></p>

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
