<div class="redLines form">
<?php echo $this->Form->create('RedLine'); ?>
	<fieldset>
		<legend><?php echo __('Add Red Line'); ?></legend>
	<?php
		echo $this->Form->input('season_id');
		echo $this->Form->input('category_code');
		echo $this->Form->input('end_rank');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Red Lines'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
