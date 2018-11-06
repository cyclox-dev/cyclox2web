<div class="meetGroups form">
<?php echo $this->Form->create('MeetGroup'); ?>
	<fieldset>
		<legend><?php echo __('Add Meet Group'); ?></legend>
	<?php
		echo $this->Form->input('code', array('type' => 'text', 'label' => '大会 Code （半角英数3文字）'));
		echo $this->Form->input('name', array('type' => 'text'));
		echo $this->Form->input('short_name', array('type' => 'text'));
		echo $this->Form->input('description', array('type' => 'text'));
		echo $this->Form->input('homepage', array('type' => 'text'));
		echo $this->Form->input('racer_code_4num_min', array('label' => '選手コード末尾4桁最大値 (1-9999)'));
		echo $this->Form->input('racer_code_4num_max', array('label' => '選手コード末尾4桁最小値 (1-9999)'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Meet Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
