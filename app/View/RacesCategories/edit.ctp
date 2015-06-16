<div class="racesCategories form">
<?php echo $this->Form->create('RacesCategory'); ?>
	<fieldset>
		<legend><?php echo __('Edit Races Category'); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('age_min');
		echo $this->Form->input('age_max');
		echo $this->Form->input('gender');
		echo $this->Form->input('needs_jcf');
		echo $this->Form->input('needs_uci');
		echo $this->Form->input('race_min');
		echo $this->Form->input('uci_age_limit');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('RacesCategory.code')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('RacesCategory.code'))); ?></li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
