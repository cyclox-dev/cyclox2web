<div class="categoryRacers form">
<?php echo $this->Form->create('CategoryRacer'); ?>
	<fieldset>
		<legend><?php echo __('Add Category Racer'); ?></legend>
	<?php
		echo $this->Form->input('racer_code');
		echo $this->Form->input('category_code');
		echo $this->Form->input('apply_date');
		echo $this->Form->input('reason_id');
		echo $this->Form->input('reason_note');
		echo $this->Form->input('meet_code');
		echo $this->Form->input('cancel_date');
		echo $this->Form->input('deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Category Racers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
