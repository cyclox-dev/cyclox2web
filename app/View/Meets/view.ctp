<div class="meets view">
<h2><?php echo __('Meet'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meet Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($meet['MeetGroup']['name'], array('controller' => 'meet_groups', 'action' => 'view', $meet['MeetGroup']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Season'); ?></dt>
		<dd>
			<?php echo $this->Html->link($meet['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $meet['Season']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('At Date'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['at_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Organized By'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['organized_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homepage'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['homepage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Frac Distance'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['start_frac_distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lap Distance'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['lap_distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meet'), array('action' => 'edit', $meet['Meet']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Meet'), array('action' => 'delete', $meet['Meet']['code']), array(), __('Are you sure you want to delete # %s?', $meet['Meet']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meet Groups'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Group'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Groups'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Entry Groups'); ?></h3>
	<?php if (!empty($meet['EntryGroup'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Meet Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Start Clock'); ?></th>
		<th><?php echo __('Start Frac Distance'); ?></th>
		<th><?php echo __('Lap Distance'); ?></th>
		<th><?php echo __('Skip Lap Count'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($meet['EntryGroup'] as $entryGroup): ?>
		<tr>
			<td><?php echo $entryGroup['id']; ?></td>
			<td><?php echo $entryGroup['meet_code']; ?></td>
			<td><?php echo $entryGroup['name']; ?></td>
			<td><?php echo $entryGroup['start_clock']; ?></td>
			<td><?php echo $entryGroup['start_frac_distance']; ?></td>
			<td><?php echo $entryGroup['lap_distance']; ?></td>
			<td><?php echo $entryGroup['skip_lap_count']; ?></td>
			<td><?php echo $entryGroup['created']; ?></td>
			<td><?php echo $entryGroup['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'entry_groups', 'action' => 'view', $entryGroup['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'entry_groups', 'action' => 'edit', $entryGroup['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_groups', 'action' => 'delete', $entryGroup['id']), array(), __('Are you sure you want to delete # %s?', $entryGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Entry Group'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
