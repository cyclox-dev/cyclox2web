<div class="pointSeriesGroups index">
	<h2><?php echo __('Point Series Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('priority_value'); ?></th>
			<th><?php echo $this->Paginator->sort('is_active', 'Active?'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pointSeriesGroups as $pointSeriesGroup): ?>
	<tr>
		<td><?php echo h($pointSeriesGroup['PointSeriesGroup']['id']); ?>&nbsp;</td>
		<td><?php echo h($pointSeriesGroup['PointSeriesGroup']['name']); ?>&nbsp;</td>
		<td><?php echo h($pointSeriesGroup['PointSeriesGroup']['priority_value']); ?>&nbsp;</td>
		<td><?php echo $pointSeriesGroup['PointSeriesGroup']['is_active'] ? 'yes' : 'no'; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $pointSeriesGroup['PointSeriesGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $pointSeriesGroup['PointSeriesGroup']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $pointSeriesGroup['PointSeriesGroup']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeriesGroup['PointSeriesGroup']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Point Series Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
