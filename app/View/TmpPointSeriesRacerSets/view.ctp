<div class="tmpPointSeriesRacerSets view">
<h2><?php echo __('Tmp Point Series Racer Set'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point Series'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tmpPointSeriesRacerSet['PointSeries']['name'], array('controller' => 'point_series', 'action' => 'view', $tmpPointSeriesRacerSet['PointSeries']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tmpPointSeriesRacerSet['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $tmpPointSeriesRacerSet['Racer']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['team']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point Json'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['point_json']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sumup Json'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['sumup_json']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tmp Point Series Racer Set'), array('action' => 'edit', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tmp Point Series Racer Set'), array('action' => 'delete', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tmpPointSeriesRacerSet['TmpPointSeriesRacerSet']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tmp Point Series Racer Sets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tmp Point Series Racer Set'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
