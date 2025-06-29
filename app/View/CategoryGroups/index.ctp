<div class="categoryGroups index">
	<h2><?php echo __('Category Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('lank_up_hint'); ?></th>
			<th><?php echo $this->Paginator->sort('display_rank'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categoryGroups as $categoryGroup): ?>
	<tr>
		<td><?php echo h($categoryGroup['CategoryGroup']['id']); ?>&nbsp;</td>
		<td><?php echo h($categoryGroup['CategoryGroup']['name']); ?>&nbsp;</td>
		<td><?php echo h($categoryGroup['CategoryGroup']['description']); ?>&nbsp;</td>
		<td><?php echo h($categoryGroup['CategoryGroup']['lank_up_hint']); ?>&nbsp;</td>
		<td><?php echo h($categoryGroup['CategoryGroup']['display_rank']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $categoryGroup['CategoryGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $categoryGroup['CategoryGroup']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $categoryGroup['CategoryGroup']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $categoryGroup['CategoryGroup']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Category Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
