<div class="entryRacers form">
<?php echo $this->Form->create('EntryRacer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Entry Racer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entry_category_id');
		echo $this->Form->input('racer_code');
		echo $this->Form->input('body_number');
		echo $this->Form->input('name_at_race');
		echo $this->Form->input('entry_status');
		echo $this->Form->input('team_name');
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EntryRacer.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('EntryRacer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Records'), array('controller' => 'time_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record'), array('controller' => 'time_records', 'action' => 'add')); ?> </li>
	</ul>
</div>
