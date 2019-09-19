<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('code', array('type' => 'text'));
		echo $this->Form->input('name', array('type' => 'text'));
		echo $this->Form->input('short_name', array('type' => 'text'));
		echo $this->Form->input('category_group_id');
		echo $this->Form->input('rank');
		echo $this->Form->input('race_min');
		echo $this->Form->input('gender');
		echo $this->Form->input('is_aged_category');
		echo $this->Form->input('age_min');
		echo $this->Form->input('age_max');
		echo $this->Form->input('school_year_min');
		echo $this->Form->input('school_year_max');
		echo $this->Form->input('description');
		echo $this->Form->input('needs_jcf');
		echo $this->Form->input('needs_uci');
		echo $this->Form->input('uci_age_limit');
		echo $this->Form->input('publishes_ajocc_ranking_on_ressys', array('label' => 'Ajocc Ranking 公開データの作成／更新を行なう', 'default' => 1, 'type' => 'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Groups'), array('controller' => 'category_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Group'), array('controller' => 'category_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
