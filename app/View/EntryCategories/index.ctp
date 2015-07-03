<div class="entryCategories index">
	<h2><?php echo __('Entry Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('races_category_code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('start_delay_sec'); ?></th>
			<th><?php echo $this->Paginator->sort('lapout_rule'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($entryCategories as $entryCategory): ?>
	<tr>
		<td><?php echo h($entryCategory['EntryCategory']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($entryCategory['EntryGroup']['name'], array('controller' => 'entry_groups', 'action' => 'view', $entryCategory['EntryGroup']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($entryCategory['RacesCategory']['name'], array('controller' => 'races_categories', 'action' => 'view', $entryCategory['RacesCategory']['code'])); ?>
		</td>
		<td><?php echo h($entryCategory['EntryCategory']['name']); ?>&nbsp;</td>
		<td><?php echo h($entryCategory['EntryCategory']['start_delay_sec']); ?>&nbsp;</td>
		<td><?php echo h($entryCategory['EntryCategory']['lapout_rule']); ?>&nbsp;</td>
		<td><?php echo h($entryCategory['EntryCategory']['note']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $entryCategory['EntryCategory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $entryCategory['EntryCategory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $entryCategory['EntryCategory']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $entryCategory['EntryCategory']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Entry Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
