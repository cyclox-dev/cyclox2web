<div class="meetPointSeries form">
<?php echo $this->Form->create('MeetPointSeries'); ?>
	<fieldset>
		<legend><?php echo __('Add Meet Point Series'); ?></legend>
	<?php
		echo $this->Form->input('point_series_id');
		echo $this->Form->input('express_in_series');
		echo $this->Form->input('meet_code');
		echo $this->Form->input('entry_category_name');
		echo $this->Form->input('grade');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
