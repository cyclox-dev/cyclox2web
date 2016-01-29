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
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['status']); ?>
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
		<dt><?php echo __('順位パーセント'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['rank_per']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('走行パーセント'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['run_per']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('獲得 AJOCC ポイント'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['ajocc_pt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('成績対象カテゴリー'); ?></dt>
		<dd>
			<?php echo h($racerResult['RacerResult']['as_category']); ?>
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
			<li><?php echo $this->Html->link(__('List Time Records'), array('controller' => 'time_records', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New Time Record'), array('controller' => 'time_records', 'action' => 'add')); ?> </li>
		</ul>
	</div>
<div class="related">
	<h3><?php echo __('Related Time Records'); ?></h3>
	<?php if (!empty($racerResult['TimeRecord'])): ?>
	<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Id'); ?></th>
			<th><?php echo __('Racer Result Id'); ?></th>
			<th><?php echo __('Time Milli'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	<?php foreach ($racerResult['TimeRecord'] as $timeRecord): ?>
		<tr>
			<td><?php echo $timeRecord['id']; ?></td>
			<td><?php echo $timeRecord['racer_result_id']; ?></td>
			<td><?php echo $timeRecord['time_milli']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'time_records', 'action' => 'view', $timeRecord['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'time_records', 'action' => 'edit', $timeRecord['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'time_records', 'action' => 'delete', $timeRecord['id']), array(), __('[%s] のデータを削除してよろしいですか？', $timeRecord['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
