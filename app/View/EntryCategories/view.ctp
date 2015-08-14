<div class="entryCategories view">
<h2><?php echo __('Entry Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($entryCategory['EntryGroup']['name'], array('controller' => 'entry_groups', 'action' => 'view', $entryCategory['EntryGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Races Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($entryCategory['RacesCategory']['name'], array('controller' => 'races_categories', 'action' => 'view', $entryCategory['RacesCategory']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Delay Sec'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['start_delay_sec']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lapout Rule'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['lapout_rule']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('残留ポイント適用有無'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['applies_hold_pt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('昇格適用有無'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['applies_rank_up']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('AJOCC ポイント適用有無'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['applies_ajocc_pt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['note']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry Category'), array('action' => 'edit', $entryCategory['EntryCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Entry Category'), array('action' => 'delete', $entryCategory['EntryCategory']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryCategory['EntryCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Racers'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Entry Racers'); ?></h3>
	<?php if (!empty($entryCategory['EntryRacer'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Entry Category Id'); ?></th>
		<th><?php echo __('Racer Code'); ?></th>
		<th><?php echo __('Body Number'); ?></th>
		<th><?php echo __('Name At Race'); ?></th>
		<th><?php echo __('Entry Status'); ?></th>
		<th><?php echo __('Team Name'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($entryCategory['EntryRacer'] as $entryRacer): ?>
		<tr>
			<td><?php echo $entryRacer['id']; ?></td>
			<td><?php echo $entryRacer['entry_category_id']; ?></td>
			<td><?php echo $entryRacer['racer_code']; ?></td>
			<td><?php echo $entryRacer['body_number']; ?></td>
			<td><?php echo $entryRacer['name_at_race']; ?></td>
			<td><?php echo $entryRacer['entry_status']; ?></td>
			<td><?php echo $entryRacer['team_name']; ?></td>
			<td><?php echo $entryRacer['note']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'entry_racers', 'action' => 'view', $entryRacer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'entry_racers', 'action' => 'edit', $entryRacer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_racers', 'action' => 'delete', $entryRacer['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryRacer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Entry Racer'), array('controller' => 'entry_racers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
