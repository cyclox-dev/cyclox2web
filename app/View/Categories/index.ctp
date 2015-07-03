<div class="categories index">
	<h2><?php echo __('Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name'); ?></th>
			<th><?php echo $this->Paginator->sort('category_group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('lank'); ?></th>
			<th><?php echo $this->Paginator->sort('race_min'); ?></th>
			<th><?php echo $this->Paginator->sort('gender'); ?></th>
			<th><?php echo $this->Paginator->sort('age_min'); ?></th>
			<th><?php echo $this->Paginator->sort('age_max'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('needs_jcf'); ?></th>
			<th><?php echo $this->Paginator->sort('needs_uci'); ?></th>
			<th><?php echo $this->Paginator->sort('uci_age_limit'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categories as $category): ?>
	<tr>
		<td><?php echo h($category['Category']['code']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['name']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['short_name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($category['CategoryGroup']['name'], array('controller' => 'category_groups', 'action' => 'view', $category['CategoryGroup']['id'])); ?>
		</td>
		<td><?php echo h($category['Category']['lank']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['race_min']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['gender']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['age_min']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['age_max']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['description']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['needs_jcf']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['needs_uci']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['uci_age_limit']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $category['Category']['code'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['code'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $category['Category']['code']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $category['Category']['code']))); ?>
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
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Groups'), array('controller' => 'category_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Group'), array('controller' => 'category_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
