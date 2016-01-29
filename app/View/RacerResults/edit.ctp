<div class="racerResults form">
<?php echo $this->Form->create('RacerResult'); ?>
	<fieldset>
		<legend><?php echo __('Edit Racer Result'); ?></legend>
	<?php
		$cats = array();
		foreach ($categories as $key => $val) {
			$cats[$key] = $key . ': ' . $val;
		}
	
		echo $this->Form->input('id');
		echo $this->Form->input('entry_racer_id', array('label' => 'Entry Racer ID', 'type' => 'number'));
		echo $this->Form->input('order_index');
		echo $this->Form->input('rank');
		echo $this->Form->input('status');
		echo $this->Form->input('lap');
		echo $this->Form->input('goal_milli_sec');
		echo $this->Form->input('lap_out_lap');
		echo $this->Form->input('rank_at_lap_out');
		echo $this->Form->input('rank_per');
		echo $this->Form->input('run_per');
		echo $this->Form->input('ajocc_pt');
		echo $this->Form->input('as_category', array('label' => '成績対象カテゴリー', 'options' => $cats, 'empty' => '---'));
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('RacerResult.id')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('RacerResult.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Records'), array('controller' => 'time_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record'), array('controller' => 'time_records', 'action' => 'add')); ?> </li>
	</ul>
</div>
