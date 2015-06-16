<div class="timeRecordInfos index">
	<h2><?php echo __('Time Record Infos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('time_start_datetime'); ?></th>
			<th><?php echo $this->Paginator->sort('skip_lap_count'); ?></th>
			<th><?php echo $this->Paginator->sort('distance'); ?></th>
			<th><?php echo $this->Paginator->sort('accuracy'); ?></th>
			<th><?php echo $this->Paginator->sort('macine'); ?></th>
			<th><?php echo $this->Paginator->sort('operator'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($timeRecordInfos as $timeRecordInfo): ?>
	<tr>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($timeRecordInfo['EntryGroup']['name'], array('controller' => 'entry_groups', 'action' => 'view', $timeRecordInfo['EntryGroup']['id'])); ?>
		</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['time_start_datetime']); ?>&nbsp;</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['skip_lap_count']); ?>&nbsp;</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['distance']); ?>&nbsp;</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['accuracy']); ?>&nbsp;</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['macine']); ?>&nbsp;</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['operator']); ?>&nbsp;</td>
		<td><?php echo h($timeRecordInfo['TimeRecordInfo']['note']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $timeRecordInfo['TimeRecordInfo']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $timeRecordInfo['TimeRecordInfo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $timeRecordInfo['TimeRecordInfo']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $timeRecordInfo['TimeRecordInfo']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Time Record Info'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
