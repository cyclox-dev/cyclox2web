<div class="pointSeries form">
<?php echo $this->Form->create('PointSeries'); ?>
	<fieldset>
		<legend><?php echo __('Add Point Series'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('short_name');
		echo $this->Form->input('description');
		echo $this->Form->input('calc_rule');
		echo $this->Form->input('sum_up_rule');
		echo $this->Form->input('point_to');
		echo $this->Form->input('season_id', array('empty' => '--'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Point Series'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
