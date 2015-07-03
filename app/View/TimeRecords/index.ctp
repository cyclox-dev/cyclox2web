<div class="timeRecords index">
	<h2><?php echo __('Time Records'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_racer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('time_milli'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($timeRecords as $timeRecord): ?>
	<tr>
		<td><?php echo h($timeRecord['TimeRecord']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($timeRecord['EntryRacer']['id'], array('controller' => 'entry_racers', 'action' => 'view', $timeRecord['EntryRacer']['id'])); ?>
		</td>
		<td><?php echo h($timeRecord['TimeRecord']['time_milli']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $timeRecord['TimeRecord']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $timeRecord['TimeRecord']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $timeRecord['TimeRecord']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $timeRecord['TimeRecord']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Time Record'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
