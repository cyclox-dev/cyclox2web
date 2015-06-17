<div class="meets form">
<?php echo $this->Form->create('Meet'); ?>
	<fieldset>
		<legend><?php echo __('大会の新規登録'); ?></legend>
	<?php
		$mg = array();
		foreach ($meetGroups as $k => $v) {
			$mg[$k] = $k . ': ' . $v;
		}
		echo $this->Form->input('meet_group_code', array('options' => $mg));
		echo $this->Form->input('season_id');
		echo $this->Form->input('at_date');
		echo $this->Form->input('name', array('type' => 'text'));
		echo $this->Form->input('short_name', array('type' => 'text'));
		echo $this->Form->input('location', array('type' => 'text'));
		echo $this->Form->input('organized_by', array('type' => 'text'));
		echo $this->Form->input('homepage', array('type' => 'text'));
		echo $this->Form->input('start_frac_distance');
		echo $this->Form->input('lap_distance');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Meets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meet Groups'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Group'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
