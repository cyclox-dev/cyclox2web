<div class="meetGroups form">
<?php echo $this->Form->create('MeetGroup'); ?>
	<fieldset>
		<legend><?php echo __('Edit Meet Group'); ?></legend>
	<?php
		echo $this->Form->input('code', array('type' => 'text'));
		echo $this->Form->input('name', array('type' => 'text'));
		echo $this->Form->input('short_name', array('type' => 'text'));
		echo $this->Form->input('description', array('type' => 'text'));
		echo $this->Form->input('homepage', array('type' => 'text'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MeetGroup.code')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('MeetGroup.code'))); ?></li>
		<li><?php echo $this->Html->link(__('List Meet Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
