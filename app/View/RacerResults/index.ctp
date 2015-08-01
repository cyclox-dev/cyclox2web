<div class="racerResults index">
	<h2><?php echo __('Racer Results'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_racer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('order_index'); ?></th>
			<th><?php echo $this->Paginator->sort('rank'); ?></th>
			<th><?php echo $this->Paginator->sort('lap'); ?></th>
			<th><?php echo $this->Paginator->sort('goal_milli_sec'); ?></th>
			<th><?php echo $this->Paginator->sort('lap_out_lap'); ?></th>
			<th><?php echo $this->Paginator->sort('rank_at_lap_out'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($racerResults as $racerResult): ?>
	<tr>
		<td><?php echo h($racerResult['RacerResult']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($racerResult['EntryRacer']['id'], array('controller' => 'entry_racers', 'action' => 'view', $racerResult['EntryRacer']['id'])); ?>
		</td>
		<td><?php echo h($racerResult['RacerResult']['order_index']); ?>&nbsp;</td>
		<td><?php echo h($racerResult['RacerResult']['rank']); ?>&nbsp;</td>
		<td><?php echo h($racerResult['RacerResult']['lap']); ?>&nbsp;</td>
		<td><?php echo h($racerResult['RacerResult']['goal_milli_sec']); ?>&nbsp;</td>
		<td><?php echo h($racerResult['RacerResult']['lap_out_lap']); ?>&nbsp;</td>
		<td><?php echo h($racerResult['RacerResult']['rank_at_lap_out']); ?>&nbsp;</td>
		<td><?php echo h($racerResult['RacerResult']['note']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $racerResult['RacerResult']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $racerResult['RacerResult']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $racerResult['RacerResult']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $racerResult['RacerResult']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Racer Result'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Records'), array('controller' => 'time_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record'), array('controller' => 'time_records', 'action' => 'add')); ?> </li>
	</ul>
</div>
