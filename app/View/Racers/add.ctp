<div class="racers form">
<?php echo $this->Form->create('Racer'); ?>
	<fieldset>
		<legend><?php echo __('Add Racer'); ?></legend>
	<?php
		echo $this->Form->input('code', array('type' => 'text'));
		echo $this->Form->input('family_name', array('type' => 'text'));
		echo $this->Form->input('family_name_kana', array('type' => 'text'));
		echo $this->Form->input('family_name_en', array('type' => 'text'));
		echo $this->Form->input('first_name', array('type' => 'text'));
		echo $this->Form->input('first_name_kana', array('type' => 'text'));
		echo $this->Form->input('first_name_en', array('type' => 'text'));
		echo $this->Form->input('gender');
		echo $this->Form->input('birth_date');
		echo $this->Form->input('nationality_code', array('type' => 'text'));
		echo $this->Form->input('jcf_number', array('type' => 'text'));
		echo $this->Form->input('uci_number', array('type' => 'text'));
		echo $this->Form->input('uci_code', array('type' => 'text'));
		echo $this->Form->input('phone', array('type' => 'text'));
		echo $this->Form->input('mail', array('type' => 'text'));
		echo $this->Form->input('country_code', array('type' => 'text'));
		echo $this->Form->input('zip_code', array('type' => 'text'));
		echo $this->Form->input('prefecture', array('type' => 'text'));
		echo $this->Form->input('address', array('type' => 'text'));
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Racers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
