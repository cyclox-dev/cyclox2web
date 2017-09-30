<div class="tmpPointSeriesRacerSets form">
<?php echo $this->Form->create('TmpPointSeriesRacerSet'); ?>
	<fieldset>
		<legend><?php echo __('Add Tmp Point Series Racer Set'); ?></legend>
	<?php
		echo $this->Form->input('point_series_id');
		echo $this->Form->input('type');
		echo $this->Form->input('rank');
		echo $this->Form->input('racer_code');
		echo $this->Form->input('name');
		echo $this->Form->input('team');
		echo $this->Form->input('point_json');
		echo $this->Form->input('sumup_json');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tmp Point Series Racer Sets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
