<div class="timeRecordInfos form">
<?php echo $this->Form->create('TimeRecordInfo'); ?>
	<fieldset>
		<legend><?php echo __('Edit Time Record Info'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entry_group_id');
		echo $this->Form->input('time_start_datetime');
		echo $this->Form->input('skip_lap_count');
		echo $this->Form->input('distance');
		echo $this->Form->input('accuracy');
		echo $this->Form->input('macine');
		echo $this->Form->input('operator');
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TimeRecordInfo.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('TimeRecordInfo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Time Record Infos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
