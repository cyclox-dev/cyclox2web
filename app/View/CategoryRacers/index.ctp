<div class="categoryRacers index">
	<h2><?php echo __('Category Racers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_code'); ?></th>
			<th><?php echo $this->Paginator->sort('category_code'); ?></th>
			<th><?php echo $this->Paginator->sort('apply_date'); ?></th>
			<th><?php echo $this->Paginator->sort('reason_id'); ?></th>
			<th><?php echo $this->Paginator->sort('reason_note'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_code'); ?></th>
			<th><?php echo $this->Paginator->sort('cancel_date'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('deleted'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categoryRacers as $categoryRacer): ?>
	<tr>
		<td><?php echo h($categoryRacer['CategoryRacer']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($categoryRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $categoryRacer['Racer']['code'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($categoryRacer['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoryRacer['Category']['code'])); ?>
		</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['apply_date']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['reason_id']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['reason_note']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['meet_code']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['cancel_date']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['created']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['modified']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['deleted']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $categoryRacer['CategoryRacer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $categoryRacer['CategoryRacer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $categoryRacer['CategoryRacer']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $categoryRacer['CategoryRacer']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Category Racer'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
