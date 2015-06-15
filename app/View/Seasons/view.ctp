<div class="seasons view">
<h2><?php echo __('Season'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($season['Season']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($season['Season']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($season['Season']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($season['Season']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End Date'); ?></dt>
		<dd>
			<?php echo h($season['Season']['end_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Regular'); ?></dt>
		<dd>
			<?php echo h($season['Season']['is_regular']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Season'), array('action' => 'edit', $season['Season']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Season'), array('action' => 'delete', $season['Season']['id']), array(), __('Are you sure you want to delete # %s?', $season['Season']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Meets'); ?></h3>
	<?php if (!empty($season['Meet'])): ?>
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
	<?php foreach ($season['Meet'] as $meet): ?>
		<tr>
			<td><?php echo $meet['code']; ?></td>
			<td><?php echo $meet['meet_group_code']; ?></td>
			<td><?php echo $meet['season_id']; ?></td>
			<td><?php echo $meet['at_date']; ?></td>
			<td><?php echo $meet['name']; ?></td>
			<td><?php echo $meet['short_name']; ?></td>
			<td><?php echo $meet['location']; ?></td>
			<td><?php echo $meet['organized_by']; ?></td>
			<td><?php echo $meet['homepage']; ?></td>
			<td><?php echo $meet['start_frac_distance']; ?></td>
			<td><?php echo $meet['lap_distance']; ?></td>
			<td><?php echo $meet['created']; ?></td>
			<td><?php echo $meet['modified']; ?></td>
			<td><?php echo $meet['deleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'meets', 'action' => 'view', $meet['code'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'meets', 'action' => 'edit', $meet['code'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'meets', 'action' => 'delete', $meet['code']), array(), __('Are you sure you want to delete # %s?', $meet['code'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
