<div class="categoryRacesCategories form">
<?php echo $this->Form->create('CategoryRacesCategory'); ?>
	<fieldset>
		<legend><?php echo __('Add Category Races Category'); ?></legend>
	<?php
		$cats = array();
		foreach ($categories as $k => $v) {
			$cats[$k] = $k . ': ' . $v;
		}
	
		$rcats = array();
		foreach ($racesCategories as $k => $v) {
			$rcats[$k] = $k . ': ' . $v;
		}
		
		echo $this->Form->input('races_category_code', array('options' => $rcats, 'label' => 'レースカテゴリー'));
		echo $this->Form->input('category_code', array('options' => $cats, 'label' => '（選手）カテゴリー'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
