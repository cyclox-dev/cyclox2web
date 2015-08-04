<div class="entryRacers view">
<h2><?php echo __('Entry Racer'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($entryRacer['EntryCategory']['name'], array('controller' => 'entry_categories', 'action' => 'view', $entryRacer['EntryCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($entryRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $entryRacer['Racer']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body Number'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['body_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name At Race'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['name_at_race']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Kana At Race'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['name_kana_at_race']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En At Race'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['name_en_at_race']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Status'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['entry_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team Name'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['team_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($entryRacer['EntryRacer']['note']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry Racer'), array('action' => 'edit', $entryRacer['EntryRacer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Entry Racer'), array('action' => 'delete', $entryRacer['EntryRacer']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryRacer['EntryRacer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Racer Results'); ?></h3>
	<?php if (!empty($entryRacer['RacerResult'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Entry Racer Id'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['entry_racer_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Order Index'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['order_index']; ?>
&nbsp;</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['rank']; ?>
&nbsp;</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['status']; ?>
&nbsp;</dd>
		<dt><?php echo __('Lap'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['lap']; ?>
&nbsp;</dd>
		<dt><?php echo __('Goal Milli Sec'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['goal_milli_sec']; ?>
&nbsp;</dd>
		<dt><?php echo __('Lap Out Lap'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['lap_out_lap']; ?>
&nbsp;</dd>
		<dt><?php echo __('Lank At Lap Out'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['rank_at_lap_out']; ?>
&nbsp;</dd>
		<dt><?php echo __('順位パーセント'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['rank_per']; ?>
&nbsp;</dd>
		<dt><?php echo __('走行パーセント'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['run_per']; ?>
&nbsp;</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
	<?php echo $entryRacer['RacerResult']['note']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Racer Result'), array('controller' => 'racer_results', 'action' => 'edit', $entryRacer['RacerResult']['id'])); ?></li>
			</ul>
		</div>
	</div>
	

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Time Record'), array('controller' => 'time_records', 'action' => 'add')); ?> </li>
		</ul>
	</div>
