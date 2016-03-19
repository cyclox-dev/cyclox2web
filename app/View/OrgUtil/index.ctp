<?php

/* 
 *  created at 2015/10/04 by shun
 */

?>

<h2>選手一覧</h2>
<p><?php echo $this->Html->link("CSV ダウンロード", array('action' => 'racer_list_csv_links'));?></p>

<h2>AJOCC Point</h2>
<p><?php echo $this->Html->link("CSV ダウンロード", array('action' => 'ajocc_pt_csv_links'));?></p>

<h2>シリーズ Ranking</h2>
<p><?php echo $this->Html->link("CSV ダウンロード", array('action' => 'point_series_csv_links'));?></p>

<h2>選手データ統合（名寄せ）</h2>
<p><?php echo $this->Html->link("選手データを統合する", array('action' => 'unite_racer'));?></p>
<p><?php echo $this->Html->link("統合処理ログ", array('controller' => 'unite_racer_logs', 'action' => 'index'));?></p>
