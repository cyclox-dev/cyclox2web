<div class="meetGroups index">
	<h2><?php echo __('Meet Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('homepage'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($meetGroups as $meetGroup): ?>
	<tr>
		<td><?php echo h($meetGroup['MeetGroup']['code']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['name']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['short_name']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['description']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['homepage']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $meetGroup['MeetGroup']['code'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $meetGroup['MeetGroup']['code'])); ?>
			<?php 
				// 削除しないものとしておく。
				//echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $meetGroup['MeetGroup']['code']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $meetGroup['MeetGroup']['code'])));
			?>
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
		<li><?php echo $this->Html->link(__('New Meet Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
