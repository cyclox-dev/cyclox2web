<div class="timeRecordInfos view">
<h2><?php echo __('Time Record Info'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($timeRecordInfo['EntryGroup']['name'], array('controller' => 'entry_groups', 'action' => 'view', $timeRecordInfo['EntryGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time Start Datetime'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['time_start_datetime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skip Lap Count'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['skip_lap_count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Distance'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accuracy'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['accuracy']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Macine'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['macine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Operator'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['operator']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($timeRecordInfo['TimeRecordInfo']['note']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Time Record Info'), array('action' => 'edit', $timeRecordInfo['TimeRecordInfo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Time Record Info'), array('action' => 'delete', $timeRecordInfo['TimeRecordInfo']['id']), array(), __('Are you sure you want to delete # %s?', $timeRecordInfo['TimeRecordInfo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Record Infos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record Info'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
