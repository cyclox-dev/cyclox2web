<div class="entryGroups view">
<h2><?php echo __('Entry Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($entryGroup['EntryGroup']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meet'); ?></dt>
		<dd>
			<?php echo $this->Html->link($entryGroup['Meet']['name'], array('controller' => 'meets', 'action' => 'view', $entryGroup['Meet']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($entryGroup['EntryGroup']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Clock'); ?></dt>
		<dd>
			<?php echo h($entryGroup['EntryGroup']['start_clock']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Frac Distance'); ?></dt>
		<dd>
			<?php echo h($entryGroup['EntryGroup']['start_frac_distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lap Distance'); ?></dt>
		<dd>
			<?php echo h($entryGroup['EntryGroup']['lap_distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skip Lap Count'); ?></dt>
		<dd>
			<?php echo h($entryGroup['EntryGroup']['skip_lap_count']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry Group'), array('action' => 'edit', $entryGroup['EntryGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Entry Group'), array('action' => 'delete', $entryGroup['EntryGroup']['id']), array(), __('Are you sure you want to delete # %s?', $entryGroup['EntryGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Record Infos'), array('controller' => 'time_record_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Record Info'), array('controller' => 'time_record_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Time Record Infos'); ?></h3>
	<?php if (!empty($entryGroup['TimeRecordInfo'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Entry Group Id'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['entry_group_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Time Start Datetime'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['time_start_datetime']; ?>
&nbsp;</dd>
		<dt><?php echo __('Skip Lap Count'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['skip_lap_count']; ?>
&nbsp;</dd>
		<dt><?php echo __('Distance'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['distance']; ?>
&nbsp;</dd>
		<dt><?php echo __('Accuracy'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['accuracy']; ?>
&nbsp;</dd>
		<dt><?php echo __('Macine'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['macine']; ?>
&nbsp;</dd>
		<dt><?php echo __('Operator'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['operator']; ?>
&nbsp;</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
	<?php echo $entryGroup['TimeRecordInfo']['note']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Time Record Info'), array('controller' => 'time_record_infos', 'action' => 'edit', $entryGroup['TimeRecordInfo']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php echo __('Related Entry Categories'); ?></h3>
	<?php if (!empty($entryGroup['EntryCategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Entry Group Id'); ?></th>
		<th><?php echo __('Races Category Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Start Delay Sec'); ?></th>
		<th><?php echo __('Lapout Rule'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($entryGroup['EntryCategory'] as $entryCategory): ?>
		<tr>
			<td><?php echo $entryCategory['id']; ?></td>
			<td><?php echo $entryCategory['entry_group_id']; ?></td>
			<td><?php echo $entryCategory['races_category_code']; ?></td>
			<td><?php echo $entryCategory['name']; ?></td>
			<td><?php echo $entryCategory['start_delay_sec']; ?></td>
			<td><?php echo $entryCategory['lapout_rule']; ?></td>
			<td><?php echo $entryCategory['note']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'entry_categories', 'action' => 'view', $entryCategory['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'entry_categories', 'action' => 'edit', $entryCategory['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_categories', 'action' => 'delete', $entryCategory['id']), array(), __('Are you sure you want to delete # %s?', $entryCategory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
