<div class="racers form">
<?php echo $this->Form->create('Racer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Racer'); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('family_name');
		echo $this->Form->input('family_name_kana');
		echo $this->Form->input('family_name_en');
		echo $this->Form->input('first_name');
		echo $this->Form->input('first_name_kana');
		echo $this->Form->input('first_name_en');
		echo $this->Form->input('gender');
		echo $this->Form->input('birth_date');
		echo $this->Form->input('nationality_code');
		echo $this->Form->input('jcf_number');
		echo $this->Form->input('uci_number');
		echo $this->Form->input('uci_code');
		echo $this->Form->input('phone');
		echo $this->Form->input('mail');
		echo $this->Form->input('country_code');
		echo $this->Form->input('zip_code');
		echo $this->Form->input('prefecture');
		echo $this->Form->input('address');
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Racer.code')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Racer.code'))); ?></li>
		<li><?php echo $this->Html->link(__('List Racers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
