<div class="tmpPointSeriesRacerSets index">
	<h2><?php echo __('Tmp Point Series Racer Sets'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('point_series_id'); ?></th>
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
	<?php foreach ($tmpPointSeriesRacerSets as $tmpPointSeriesRacerSet): ?>
	<tr>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tmpPointSeriesRacerSet['PointSeries']['name'], array('controller' => 'point_series', 'action' => 'view', $tmpPointSeriesRacerSet['PointSeries']['id'])); ?>
		</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['type']); ?>&nbsp;</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['rank']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tmpPointSeriesRacerSet['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $tmpPointSeriesRacerSet['Racer']['code'])); ?>
		</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['name']); ?>&nbsp;</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['team']); ?>&nbsp;</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['point_json']); ?>&nbsp;</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['sumup_json']); ?>&nbsp;</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['created']); ?>&nbsp;</td>
		<td><?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Tmp Point Series Racer Set'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
