<div class="racerResults view">
<h2><?php echo __('Racer Result'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Racer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($racerResult['EntryRacer']['id'], array('controller' => 'entry_racers', 'action' => 'view', $racerResult['EntryRacer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Index'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['order_index']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lap'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['lap']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Goal Milli Sec'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['goal_milli_sec']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lap Out Lap'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['lap_out_lap']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lank At Lap Out'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['rank_at_lap_out']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['note']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Racer Result'), array('action' => 'edit', $racerResult['RacerResult']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Racer Result'), array('action' => 'delete', $racerResult['RacerResult']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $racerResult['RacerResult']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
