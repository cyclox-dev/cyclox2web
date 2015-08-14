<div class="holdPoints form">
<?php echo $this->Form->create('HoldPoint'); ?>
	<fieldset>
		<legend><?php echo __('Edit Hold Point'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('racer_result_id');
		echo $this->Form->input('point');
		echo $this->Form->input('category_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('HoldPoint.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('HoldPoint.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Hold Points'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
