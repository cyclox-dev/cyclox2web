<div class="meets form">
<?php echo $this->Form->create('Meet'); ?>
	<fieldset>
		<legend><?php echo __('Edit Meet'); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('meet_group_code');
		echo $this->Form->input('season_id');
		echo $this->Form->input('at_date');
		echo $this->Form->input('name');
		echo $this->Form->input('short_name');
		echo $this->Form->input('location');
		echo $this->Form->input('organized_by');
		echo $this->Form->input('homepage');
		echo $this->Form->input('start_frac_distance');
		echo $this->Form->input('lap_distance');
		echo $this->Form->input('deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Meet.code')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Meet.code'))); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meet Groups'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Group'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
