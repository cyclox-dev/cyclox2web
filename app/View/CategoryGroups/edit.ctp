<div class="categoryGroups form">
<?php echo $this->Form->create('CategoryGroup'); ?>
	<fieldset>
		<legend><?php echo __('Edit Category Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('lank_up_hint');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CategoryGroup.id')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('CategoryGroup.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Category Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
