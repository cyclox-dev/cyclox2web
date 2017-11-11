<div class="tmpAjoccptRacerSets index">
	<h2><?php echo __('Tmp Ajoccpt Racer Sets'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ajoccpt_local_setting_id'); ?></th>
			<th><?php echo $this->Paginator->sort('season_id'); ?></th>
			<th><?php echo $this->Paginator->sort('category_code'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('rank'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('team'); ?></th>
			<th><?php echo $this->Paginator->sort('point_json'); ?></th>
			<th><?php echo $this->Paginator->sort('sumup_json'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($tmpAjoccptRacerSets as $tmpAjoccptRacerSet): ?>
	<tr>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tmpAjoccptRacerSet['AjoccptLocalSetting']['name'], array('controller' => 'ajoccpt_local_settings', 'action' => 'view', $tmpAjoccptRacerSet['AjoccptLocalSetting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($tmpAjoccptRacerSet['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $tmpAjoccptRacerSet['Season']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['category_code'], array('controller' => 'categories', 'action' => 'view', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['category_code'])); ?>
		</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['type']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['rank']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['racer_code']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['name']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['team']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['point_json']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['sumup_json']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['created']); ?>&nbsp;</td>
		<td><?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Tmp Ajoccpt Racer Set'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ajoccpt Local Settings'), array('controller' => 'ajoccpt_local_settings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ajoccpt Local Setting'), array('controller' => 'ajoccpt_local_settings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
	</ul>
</div>
