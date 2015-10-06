<div class="timeRecords form">
<?php echo $this->Form->create('TimeRecord'); ?>
	<fieldset>
		<legend><?php echo __('Add Time Record'); ?></legend>
	<?php
		echo $this->Form->input('racer_result_id', array('label' => 'Racer Result ID', 'type' => 'number'));
		echo $this->Form->input('lap');
		echo $this->Form->input('time_milli');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Time Records'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
