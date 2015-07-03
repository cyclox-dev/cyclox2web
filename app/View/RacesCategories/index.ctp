<div class="racesCategories index">
	<h2><?php echo __('Races Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('age_min'); ?></th>
			<th><?php echo $this->Paginator->sort('age_max'); ?></th>
			<th><?php echo $this->Paginator->sort('gender'); ?></th>
			<th><?php echo $this->Paginator->sort('needs_jcf'); ?></th>
			<th><?php echo $this->Paginator->sort('needs_uci'); ?></th>
			<th><?php echo $this->Paginator->sort('race_min'); ?></th>
			<th><?php echo $this->Paginator->sort('uci_age_limit'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($racesCategories as $racesCategory): ?>
	<tr>
		<td><?php echo h($racesCategory['RacesCategory']['code']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['name']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['description']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['age_min']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['age_max']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['gender']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['needs_jcf']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['needs_uci']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['race_min']); ?>&nbsp;</td>
		<td><?php echo h($racesCategory['RacesCategory']['uci_age_limit']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $racesCategory['RacesCategory']['code'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $racesCategory['RacesCategory']['code'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $racesCategory['RacesCategory']['code']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $racesCategory['RacesCategory']['code']))); ?>
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
		<li><?php echo $this->Html->link(__('New Races Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
