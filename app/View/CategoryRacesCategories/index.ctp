<div class="categoryRacesCategories index">
	<h2><?php echo __('レースカテゴリーへのカテゴリー配属一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('races_category_code', 'レースカテゴリー'); ?></th>
			<th><?php echo $this->Paginator->sort('category_code', '(選手)カテゴリー'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categoryRacesCategories as $categoryRacesCategory): ?>
	<tr>
		<td><?php echo h($categoryRacesCategory['CategoryRacesCategory']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($categoryRacesCategory['RacesCategory']['name'], array('controller' => 'races_categories', 'action' => 'view', $categoryRacesCategory['RacesCategory']['code'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($categoryRacesCategory['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoryRacesCategory['Category']['code'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $categoryRacesCategory['CategoryRacesCategory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $categoryRacesCategory['CategoryRacesCategory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $categoryRacesCategory['CategoryRacesCategory']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $categoryRacesCategory['CategoryRacesCategory']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
