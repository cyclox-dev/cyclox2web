<div class="pointSeriesGroups view">
<h2><?php echo __('Point Series Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority Value'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['priority_value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo $pointSeriesGroup['PointSeriesGroup']['is_active'] ? 'yes' : 'no'; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['deleted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Point Series Group'), array('action' => 'edit', $pointSeriesGroup['PointSeriesGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Point Series Group'), array('action' => 'delete', $pointSeriesGroup['PointSeriesGroup']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeriesGroup['PointSeriesGroup']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Point Series'); ?></h3>
	<?php if (!empty($pointSeriesGroup['PointSeries'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Short Name'); ?></th>
		<th><?php echo __('Calc Rule'); ?></th>
		<th><?php echo __('Sum Up Rule'); ?></th>
		<th><?php echo __('Point To'); ?></th>
		<th><?php echo __('Season Id'); ?></th>
		<th><?php echo __('Point Term Rule'); ?></th>
		<th><?php echo __('Hint'); ?></th>
		<th><?php echo __('Is Active'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pointSeriesGroup['PointSeries'] as $pointSeries): ?>
		<tr>
			<td><?php echo $pointSeries['id']; ?></td>
			<td><?php echo $pointSeries['name']; ?></td>
			<td><?php echo $pointSeries['short_name']; ?></td>
			<td><?php echo $pointSeries['calc_rule']; ?></td>
			<td><?php echo $pointSeries['sum_up_rule']; ?></td>
			<td><?php echo $pointSeries['point_to']; ?></td>
			<td><?php echo $pointSeries['season_id']; ?></td>
			<td><?php echo $pointSeries['point_term_rule']; ?></td>
			<td><?php echo $pointSeries['hint']; ?></td>
			<td><?php echo $pointSeries['is_active']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'point_series', 'action' => 'view', $pointSeries['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'point_series', 'action' => 'edit', $pointSeries['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'point_series', 'action' => 'delete', $pointSeries['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeries['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
