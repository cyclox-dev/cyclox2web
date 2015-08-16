<div class="pointSeriesRacers form">
<?php echo $this->Form->create('PointSeriesRacer'); ?>
	<fieldset>
		<legend><?php echo __('Add Point Series Racer'); ?></legend>
	<?php
		echo $this->Form->input('racer_code');
		echo $this->Form->input('point_series_id');
		echo $this->Form->input('point');
		echo $this->Form->input('gained_date');
		echo $this->Form->input('expiry_date');
		echo $this->Form->input('racer_result_id');
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Point Series Racers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
