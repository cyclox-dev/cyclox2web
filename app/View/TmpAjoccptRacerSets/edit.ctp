<div class="tmpAjoccptRacerSets form">
<?php echo $this->Form->create('TmpAjoccptRacerSet'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tmp Ajoccpt Racer Set'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ajoccpt_local_setting_id');
		echo $this->Form->input('season_id');
		echo $this->Form->input('type');
		echo $this->Form->input('rank');
		echo $this->Form->input('racer_code');
		echo $this->Form->input('name');
		echo $this->Form->input('team');
		echo $this->Form->input('point_json');
		echo $this->Form->input('sumup_json');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TmpAjoccptRacerSet.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('TmpAjoccptRacerSet.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Tmp Ajoccpt Racer Sets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Ajoccpt Local Settings'), array('controller' => 'ajoccpt_local_settings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ajoccpt Local Setting'), array('controller' => 'ajoccpt_local_settings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
	</ul>
</div>
