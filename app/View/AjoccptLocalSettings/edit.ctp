<div class="ajoccptLocalSettings form">
<?php echo $this->Form->create('AjoccptLocalSetting'); ?>
	<fieldset>
		<legend><?php echo __('Edit Ajoccpt Local Setting'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('short_name');
		echo $this->Form->input('season_id');
		echo $this->Form->input('setting');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AjoccptLocalSetting.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('AjoccptLocalSetting.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Ajoccpt Local Settings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
	</ul>
</div>
