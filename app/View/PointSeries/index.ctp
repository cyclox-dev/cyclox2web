<div class="pointSeries index">
	<?php 
		App::uses('PointCalculator', 'Cyclox/Util');
		App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
		App::uses('PointSeriesPointTo', 'Cyclox/Const');
		App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');
	?>
	<h2><?php echo __('Point Series'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('point_series_group_id', 'SeriesGroup'); ?></th>
			<th><?php echo $this->Paginator->sort('season_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'タイトル'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name', '短縮名'); ?></th>
			<th><?php echo $this->Paginator->sort('hint'); ?></th>
			<th><?php echo 'Active?'; ?></th>
			<th><?php echo '公開?'; ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pointSeries as $pointSeries): ?>
	<tr>
		<td><?php echo h($pointSeries['PointSeries']['id']); ?>&nbsp;</td>
		<td><?php
		if (empty($pointSeries['PointSeriesGroup']['id'])) {
			echo '--';
		} else {
			echo h($pointSeries['PointSeriesGroup']['name']);
		}
		?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pointSeries['Season']['short_name'], array('controller' => 'seasons', 'action' => 'view', $pointSeries['Season']['id'])); ?>
			&nbsp;
		</td>
		<td><?php echo h($pointSeries['PointSeries']['name']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['short_name']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['hint']); ?>&nbsp;</td>
		<td><?php echo ($pointSeries['PointSeries']['is_active'] ? 'Yes' : 'No'); ?>&nbsp;</td>
		<td><?php echo (empty($pointSeries['PointSeries']['public_psrset_group_id']) ? 'NOT' : '公開(' . $pointSeries['PointSeries']['public_psrset_group_id'] . ')'); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $pointSeries['PointSeries']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $pointSeries['PointSeries']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $pointSeries['PointSeries']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeries['PointSeries']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Point Series'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
