<div class="tmpResultUpdateFlags index">
	<h2><?php echo __('Tmp Result Update Flags'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('entry_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('result_updated'); ?></th>
			<th><?php echo $this->Paginator->sort('points_sumuped'); ?></th>
			<th><?php echo $this->Paginator->sort('ajoccpt_sumuped'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($tmpResultUpdateFlags as $tmpResultUpdateFlag): ?>
	<tr>
		<td><?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tmpResultUpdateFlag['EntryCategory']['name'], array('controller' => 'entry_categories', 'action' => 'view', $tmpResultUpdateFlag['EntryCategory']['id'])); ?>
		</td>
		<td><?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['result_updated']); ?>&nbsp;</td>
		<td><?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['points_sumuped']); ?>&nbsp;</td>
		<td><?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['ajoccpt_sumuped']); ?>&nbsp;</td>
		<td><?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['created']); ?>&nbsp;</td>
		<td><?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Tmp Result Update Flag'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
