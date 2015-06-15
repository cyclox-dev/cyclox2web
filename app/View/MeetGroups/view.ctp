<div class="meetGroups view">
<h2><?php echo __('Meet Group'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homepage'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['homepage']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meet Group'), array('action' => 'edit', $meetGroup['MeetGroup']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Meet Group'), array('action' => 'delete', $meetGroup['MeetGroup']['code']), array(), __('Are you sure you want to delete # %s?', $meetGroup['MeetGroup']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meet Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Meets'); ?></h3>
	<?php if (!empty($meetGroup['meets'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Meet Group Code'); ?></th>
		<th><?php echo __('Season Id'); ?></th>
		<th><?php echo __('At Date'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Short Name'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Organized By'); ?></th>
		<th><?php echo __('Homepage'); ?></th>
		<th><?php echo __('Start Frac Distance'); ?></th>
		<th><?php echo __('Lap Distance'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Deleted'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($meetGroup['meets'] as $meets): ?>
		<tr>
			<td><?php echo $meets['code']; ?></td>
			<td><?php echo $meets['meet_group_code']; ?></td>
			<td><?php echo $meets['season_id']; ?></td>
			<td><?php echo $meets['at_date']; ?></td>
			<td><?php echo $meets['name']; ?></td>
			<td><?php echo $meets['short_name']; ?></td>
			<td><?php echo $meets['location']; ?></td>
			<td><?php echo $meets['organized_by']; ?></td>
			<td><?php echo $meets['homepage']; ?></td>
			<td><?php echo $meets['start_frac_distance']; ?></td>
			<td><?php echo $meets['lap_distance']; ?></td>
			<td><?php echo $meets['created']; ?></td>
			<td><?php echo $meets['modified']; ?></td>
			<td><?php echo $meets['deleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'meets', 'action' => 'view', $meets['code'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'meets', 'action' => 'edit', $meets['code'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'meets', 'action' => 'delete', $meets['code']), array(), __('Are you sure you want to delete # %s?', $meets['code'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
