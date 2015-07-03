<div class="entryGroups index">
	<h2><?php echo __('Entry Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('start_clock'); ?></th>
			<th><?php echo $this->Paginator->sort('start_frac_distance'); ?></th>
			<th><?php echo $this->Paginator->sort('lap_distance'); ?></th>
			<th><?php echo $this->Paginator->sort('skip_lap_count'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($entryGroups as $entryGroup): ?>
	<tr>
		<td><?php echo h($entryGroup['EntryGroup']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($entryGroup['Meet']['name'], array('controller' => 'meets', 'action' => 'view', $entryGroup['Meet']['code'])); ?>
		</td>
		<td><?php echo h($entryGroup['EntryGroup']['name']); ?>&nbsp;</td>
		<td><?php echo h($entryGroup['EntryGroup']['start_clock']); ?>&nbsp;</td>
		<td><?php echo h($entryGroup['EntryGroup']['start_frac_distance']); ?>&nbsp;</td>
		<td><?php echo h($entryGroup['EntryGroup']['lap_distance']); ?>&nbsp;</td>
		<td><?php echo h($entryGroup['EntryGroup']['skip_lap_count']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $entryGroup['EntryGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $entryGroup['EntryGroup']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $entryGroup['EntryGroup']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $entryGroup['EntryGroup']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Entry Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Record Infos'), array('controller' => 'time_record_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record Info'), array('controller' => 'time_record_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
