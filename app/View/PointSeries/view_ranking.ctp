<div class="pointSeries view_ranking">
	<h2><?php echo __('Point Series Rnaking (Ranking-Data-ID:' . h($psrsets[0]['TmpPointSeriesRacerSet']['set_group_id']) . ')'); ?></h2>
	<p><?php echo h($psrsets[0]['TmpPointSeriesRacerSet']['modified']) . '更新'; ?><p>
	<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo '順位'; ?></th>
			<th><?php echo '選手コード'; ?></th>
			<th><?php echo '名前'; ?></th>
			<th><?php echo 'チーム'; ?></th>
			<?php 
				$ptTitles = json_decode($psrsets[0]['TmpPointSeriesRacerSet']['point_json'], true);
				foreach ($ptTitles as $title) :
			?>
				<th><?php echo $this->Html->link($title['name'], array('controller' => 'meets', 'action' => 'view', $title['code'])); ?></th>
			<?php endforeach; ?>
			<?php 
				$titles = json_decode($psrsets[0]['TmpPointSeriesRacerSet']['sumup_json'], true);
				foreach ($titles as $title) :
			?>
				<th><?php echo $title; ?></th>
			<?php endforeach; ?>
		</tr>
		<?php for ($i = 1; $i < count($psrsets); $i++): ?>
		<tr>
			<?php $set = $psrsets[$i]['TmpPointSeriesRacerSet']; ?>
			<td><?php echo h($set['rank']) ?></td>
			<td><?php echo h($set['racer_code']) ?></td>
			<td><?php echo h($set['name']) ?></td>
			<td><?php echo h($set['team']) ?></td>
			<?php 
				$points = json_decode($set['point_json'], true);
				for ($j = 0; $j < count($ptTitles); $j++):
			?>
				<td><?php echo empty($points[$j]) ? '' : $points[$j]; ?></td>
			<?php endfor; ?>
			<?php 
				$sumups = json_decode($set['sumup_json'], true);
				for ($j = 0; $j < count($titles); $j++):
			?>
				<td><?php echo empty($sumups[$j]) ? '' : $sumups[$j]; ?></td>
			<?php endfor; ?>
		</tr>
		<?php endfor; ?>
	</table>
</div>