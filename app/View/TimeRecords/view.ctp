<div class="timeRecords view">
<h2><?php echo __('Time Record'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($timeRecord['TimeRecord']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer Result'); ?></dt>
		<dd>
			<?php echo $this->Html->link($timeRecord['RacerResult']['id'], array('controller' => 'racer_results', 'action' => 'view', $timeRecord['RacerResult']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lap'); ?></dt>
		<dd>
			<?php echo h($timeRecord['TimeRecord']['lap']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time Milli'); ?></dt>
		<dd>
			<?php echo h($timeRecord['TimeRecord']['time_milli']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Time Record'), array('action' => 'edit', $timeRecord['TimeRecord']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Time Record'), array('action' => 'delete', $timeRecord['TimeRecord']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $timeRecord['TimeRecord']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Records'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
