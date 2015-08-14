<div class="holdPoints index">
	<h2><?php echo __('Hold Points'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_result_id'); ?></th>
			<th><?php echo $this->Paginator->sort('point'); ?></th>
			<th><?php echo $this->Paginator->sort('category_code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($holdPoints as $holdPoint): ?>
	<tr>
		<td><?php echo h($holdPoint['HoldPoint']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($holdPoint['RacerResult']['id'], array('controller' => 'racer_results', 'action' => 'view', $holdPoint['RacerResult']['id'])); ?>
		</td>
		<td><?php echo h($holdPoint['HoldPoint']['point']); ?>&nbsp;</td>
		<td><?php echo h($holdPoint['HoldPoint']['category_code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $holdPoint['HoldPoint']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $holdPoint['HoldPoint']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $holdPoint['HoldPoint']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $holdPoint['HoldPoint']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Hold Point'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
