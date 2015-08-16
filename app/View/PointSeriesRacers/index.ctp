<div class="pointSeriesRacers index">
	<h2><?php echo __('Point Series Racers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_code'); ?></th>
			<th><?php echo $this->Paginator->sort('point_series_id'); ?></th>
			<th><?php echo $this->Paginator->sort('point'); ?></th>
			<th><?php echo $this->Paginator->sort('gained_date'); ?></th>
			<th><?php echo $this->Paginator->sort('expiry_date'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_result_id'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_point_series_id'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pointSeriesRacers as $pointSeriesRacer): ?>
	<tr>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pointSeriesRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $pointSeriesRacer['Racer']['code'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($pointSeriesRacer['PointSeries']['name'], array('controller' => 'point_series', 'action' => 'view', $pointSeriesRacer['PointSeries']['id'])); ?>
		</td>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['point']); ?>&nbsp;</td>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['gained_date']); ?>&nbsp;</td>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['expiry_date']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pointSeriesRacer['RacerResult']['id'], array('controller' => 'racer_results', 'action' => 'view', $pointSeriesRacer['RacerResult']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($pointSeriesRacer['MeetPointSeries']['id'], array('controller' => 'meet_point_series', 'action' => 'view', $pointSeriesRacer['MeetPointSeries']['id'])); ?>
		</td>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['note']); ?>&nbsp;</td>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['created']); ?>&nbsp;</td>
		<td><?php echo h($pointSeriesRacer['PointSeriesRacer']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $pointSeriesRacer['PointSeriesRacer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $pointSeriesRacer['PointSeriesRacer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $pointSeriesRacer['PointSeriesRacer']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeriesRacer['PointSeriesRacer']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Point Series Racer'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
