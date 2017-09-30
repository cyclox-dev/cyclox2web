<div class="tmpResultUpdateFlags form">
<?php echo $this->Form->create('TmpResultUpdateFlag'); ?>
	<fieldset>
		<legend><?php echo __('Add Tmp Result Update Flag'); ?></legend>
	<?php
		echo $this->Form->input('entry_category_id');
		echo $this->Form->input('result_updated');
		echo $this->Form->input('points_sumuped');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tmp Result Update Flags'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
