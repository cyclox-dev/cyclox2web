<div class="entryGroups form">
<?php echo $this->Form->create('EntryGroup'); ?>
	<fieldset>
		<legend><?php echo __('Edit Entry Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('meet_code');
		echo $this->Form->input('name');
		echo $this->Form->input('start_clock');
		echo $this->Form->input('start_frac_distance');
		echo $this->Form->input('lap_distance');
		echo $this->Form->input('skip_lap_count');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EntryGroup.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('EntryGroup.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Record Infos'), array('controller' => 'time_record_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record Info'), array('controller' => 'time_record_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
