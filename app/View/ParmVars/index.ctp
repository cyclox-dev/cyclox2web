<div class="parmVars index">
	<h2><?php echo __('Parm Vars'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('pkey'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($parmVars as $parmVar): ?>
	<tr>
		<td><?php echo h($parmVar['ParmVar']['id']); ?>&nbsp;</td>
		<td><?php echo h($parmVar['ParmVar']['pkey']); ?>&nbsp;</td>
		<td><?php echo h($parmVar['ParmVar']['value']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $parmVar['ParmVar']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $parmVar['ParmVar']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $parmVar['ParmVar']['id']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $parmVar['ParmVar']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Parm Var'), array('action' => 'add')); ?></li>
	</ul>
</div>
