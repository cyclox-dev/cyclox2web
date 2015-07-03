<div class="categoryRacesCategories form">
<?php echo $this->Form->create('CategoryRacesCategory'); ?>
	<fieldset>
		<legend><?php echo __('Edit Category Races Category'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('category_code');
		echo $this->Form->input('races_category_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CategoryRacesCategory.id')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('CategoryRacesCategory.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
