<div class="parmVars form">
<?php echo $this->Form->create('ParmVar'); ?>
	<fieldset>
		<legend><?php echo __('Edit Parm Var'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('pkey');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ParmVar.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ParmVar.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Parm Vars'), array('action' => 'index')); ?></li>
	</ul>
</div>
