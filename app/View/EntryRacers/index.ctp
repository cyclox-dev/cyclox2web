<div class="entryRacers index">
	<h2><?php echo __('Entry Racers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_code'); ?></th>
			<th><?php echo $this->Paginator->sort('body_number'); ?></th>
			<th><?php echo $this->Paginator->sort('name_at_race'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_status'); ?></th>
			<th><?php echo $this->Paginator->sort('team_name'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($entryRacers as $entryRacer): ?>
	<tr>
		<td><?php echo h($entryRacer['EntryRacer']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($entryRacer['EntryCategory']['name'], array('controller' => 'entry_categories', 'action' => 'view', $entryRacer['EntryCategory']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($entryRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $entryRacer['Racer']['code'])); ?>
		</td>
		<td><?php echo h($entryRacer['EntryRacer']['body_number']); ?>&nbsp;</td>
		<td><?php echo h($entryRacer['EntryRacer']['name_at_race']); ?>&nbsp;</td>
		<td><?php echo h($entryRacer['EntryRacer']['entry_status']); ?>&nbsp;</td>
		<td><?php echo h($entryRacer['EntryRacer']['team_name']); ?>&nbsp;</td>
		<td><?php echo h($entryRacer['EntryRacer']['note']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $entryRacer['EntryRacer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $entryRacer['EntryRacer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $entryRacer['EntryRacer']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $entryRacer['EntryRacer']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Records'), array('controller' => 'time_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record'), array('controller' => 'time_records', 'action' => 'add')); ?> </li>
	</ul>
</div>
