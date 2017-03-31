<div class="uniteRacerLogs form">
<?php echo $this->Form->create('UniteRacerLog'); ?>
	<fieldset>
		<legend><?php echo __('Add Unite Racer Log'); ?></legend>
	<?php
		echo $this->Form->input('united');
		echo $this->Form->input('unite_to');
		echo $this->Form->input('at_date', array(
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'timeFormat' => '24',
		));
		echo $this->Form->input('log');
		
		App::uses('UniteRacerStatus', 'Cyclox/Const');
		$statusArray = array();
		foreach (UniteRacerStatus::statuses() as $s) {
			$statusArray[$s->ID()] = $s->description();
		}
		echo $this->Form->input('status', array('options' => $statusArray, 'label' => '処理ステータス', 'value' => 1));
		
		echo $this->Form->input('by_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Unite Racer Logs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
