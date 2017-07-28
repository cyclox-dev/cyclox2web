<div class="seasons view">
<h2><?php echo __('Season'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
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
		<dt><?php echo __('シーズン分類'); ?></dt>
		<dd>
			<?php echo h($season['Season']['is_regular'] ? 'Regular' : 'Extra'); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($season['Season']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($season['Season']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h(($season['Season']['deleted'] ? "Yes" : "No")); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($season['Season']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Season'), array('action' => 'edit', $season['Season']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Season'), array('action' => 'delete', $season['Season']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $season['Season']['id'])); ?> </li>
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
			<td><?php echo h($meet['code']); ?></td>
			<td><?php echo h($meet['meet_group_code']); ?></td>
			<td><?php echo h($meet['season_id']); ?></td>
			<td><?php echo h($meet['at_date']); ?></td>
			<td><?php echo h($meet['name']); ?></td>
			<td><?php echo h($meet['short_name']); ?></td>
			<td><?php echo h($meet['location']); ?></td>
			<td><?php echo h($meet['organized_by']); ?></td>
			<td><?php echo h($meet['homepage']); ?></td>
			<td><?php echo h($meet['start_frac_distance']); ?></td>
			<td><?php echo h($meet['lap_distance']); ?></td>
			<td><?php echo h($meet['created']); ?></td>
			<td><?php echo h($meet['modified']); ?></td>
			<td><?php echo h($meet['deleted']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'meets', 'action' => 'view', $meet['code'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'meets', 'action' => 'edit', $meet['code'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'meets', 'action' => 'delete', $meet['code']), array(), __('[%s] のデータを削除してよろしいですか？', $meet['code'])); ?>
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
