<div class="entryCategories form">
<?php echo $this->Form->create('EntryCategory'); ?>
	<fieldset>
		<legend><?php echo __('Add Entry Category'); ?></legend>
	<?php
		echo $this->Form->input('entry_group_id', array('label' => 'Entry Group ID', 'type' => 'number'));
		echo $this->Form->input('races_category_code');
		echo $this->Form->input('name');
		echo $this->Form->input('start_delay_sec');
		echo $this->Form->input('lapout_rule');
		echo $this->Form->input('applies_hold_pt', array('label' => '残留ポイントを付与する（〜17-18）', 'checked' => true));
		echo $this->Form->input('applies_rank_up', array('label' => '昇格処理を行なう', 'checked' => true));
		echo $this->Form->input('applies_ajocc_pt', array('label' => 'AJOCC ポイントを付与する', 'checked' => true));
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Entry Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
