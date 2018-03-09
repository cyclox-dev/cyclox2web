<div class="pointSeriesGroups form">
<?php echo $this->Form->create('PointSeriesGroup'); ?>
	<fieldset>
		<legend><?php echo __('Add Point Series Group'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('priority_value', array('after' => $priority_note));
		echo $this->Form->input('description', array('label' => '詳細'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Point Series Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
