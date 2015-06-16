<div class="entryCategories form">
<?php echo $this->Form->create('EntryCategory'); ?>
	<fieldset>
		<legend><?php echo __('Edit Entry Category'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entry_group_id');
		echo $this->Form->input('races_category_code');
		echo $this->Form->input('name');
		echo $this->Form->input('start_delay_sec');
		echo $this->Form->input('lapout_rule');
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EntryCategory.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('EntryCategory.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
