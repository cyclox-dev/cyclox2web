<div class="uniteRacerLogs form">
<?php echo $this->Form->create('UniteRacerLog'); ?>
	<fieldset>
		<legend><?php echo __('Edit Unite Racer Log'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('united');
		echo $this->Form->input('unite_to');
		echo $this->Form->input('at_date', array(
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'timeFormat' => '24',
		));
		echo $this->Form->input('log');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UniteRacerLog.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('UniteRacerLog.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Unite Racer Logs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
