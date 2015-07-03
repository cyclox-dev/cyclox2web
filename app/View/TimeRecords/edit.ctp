<div class="timeRecords form">
<?php echo $this->Form->create('TimeRecord'); ?>
	<fieldset>
		<legend><?php echo __('Edit Time Record'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entry_racer_id');
		echo $this->Form->input('time_milli');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TimeRecord.id')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('TimeRecord.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Time Records'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
