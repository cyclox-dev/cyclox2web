<div class="meetPointSeries index">
	<h2><?php echo __('Meet Point Series'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('point_series_id'); ?></th>
			<th><?php echo $this->Paginator->sort('express_in_series'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_code'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_category_name'); ?></th>
			<th><?php echo $this->Paginator->sort('grade'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($meetPointSeries as $meetPointSeries): ?>
	<tr>
		<td><?php echo h($meetPointSeries['MeetPointSeries']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($meetPointSeries['PointSeries']['name'], array('controller' => 'point_series', 'action' => 'view', $meetPointSeries['PointSeries']['id'])); ?>
		</td>
		<td><?php echo h($meetPointSeries['MeetPointSeries']['express_in_series']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($meetPointSeries['Meet']['name'], array('controller' => 'meets', 'action' => 'view', $meetPointSeries['Meet']['code'])); ?>
		</td>
		<td><?php echo h($meetPointSeries['MeetPointSeries']['entry_category_name']); ?>&nbsp;</td>
		<td><?php echo h($meetPointSeries['MeetPointSeries']['grade']); ?>&nbsp;</td>
		<td><?php echo h($meetPointSeries['MeetPointSeries']['created']); ?>&nbsp;</td>
		<td><?php echo h($meetPointSeries['MeetPointSeries']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $meetPointSeries['MeetPointSeries']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $meetPointSeries['MeetPointSeries']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $meetPointSeries['MeetPointSeries']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $meetPointSeries['MeetPointSeries']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
