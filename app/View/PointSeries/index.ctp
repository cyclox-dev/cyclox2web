<div class="pointSeries index">
	<h2><?php echo __('Point Series'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('calc_rule'); ?></th>
			<th><?php echo $this->Paginator->sort('sum_up_rule'); ?></th>
			<th><?php echo $this->Paginator->sort('point_to'); ?></th>
			<th><?php echo $this->Paginator->sort('season_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pointSeries as $pointSeries): ?>
	<tr>
		<td><?php echo h($pointSeries['PointSeries']['id']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['name']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['short_name']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['description']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['calc_rule']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['sum_up_rule']); ?>&nbsp;</td>
		<td><?php echo h($pointSeries['PointSeries']['point_to']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pointSeries['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $pointSeries['Season']['id'])); ?>
			&nbsp;
		</td>
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
