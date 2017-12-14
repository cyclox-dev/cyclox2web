<div class="pointSeriesGroups form">
<?php echo $this->Form->create('PointSeriesGroup'); ?>
	<fieldset>
		<legend><?php echo __('Edit Point Series Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('priority_value', array('after' => $priority_note));
		echo $this->Form->input('description');
		echo $this->Form->input('is_active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PointSeriesGroup.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('PointSeriesGroup.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
