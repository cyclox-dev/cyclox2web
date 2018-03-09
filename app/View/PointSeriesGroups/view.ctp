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
		<dt><?php echo __('詳細'); ?></dt>
		<dd>
			<?php echo h($pointSeriesGroup['PointSeriesGroup']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active?'); ?></dt>
		<dd>
			<?php echo $pointSeriesGroup['PointSeriesGroup']['is_active'] ? 'Yes' : 'No'; ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
	<h3>Status</h3>
	<dl>
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
		<li><?php echo $this->Html->link(__('この Series Group を編集'), array('action' => 'edit', $pointSeriesGroup['PointSeriesGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('この Series Group を削除'), array('action' => 'delete', $pointSeriesGroup['PointSeriesGroup']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeriesGroup['PointSeriesGroup']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('Series Groups リスト'), array('action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Point Series'); ?></h3>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('新規シリーズの作成'), array('controller' => 'point_series', 'action' => 'add', $pointSeriesGroup['PointSeriesGroup']['id'])); ?> </li>
		</ul>
	</div>
	<?php if (!empty($pointSeriesGroup['PointSeries'])): ?>
	<?php
		App::uses('PointCalculator', 'Cyclox/Util');
		App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
		App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');
	?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Short Name'); ?></th>
		<th><?php echo __('配点Rule'); ?></th>
		<th><?php echo __('集計Rule'); ?></th>
		<th><?php echo __('Season'); ?></th>
		<th><?php echo __('Point有効期間'); ?></th>
		<th><?php echo __('Hint'); ?></th>
		<th><?php echo __('Active?'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pointSeriesGroup['PointSeries'] as $pointSeries): ?>
		<tr>
			<td><?php echo $pointSeries['id']; ?></td>
			<td><?php echo $pointSeries['name']; ?></td>
			<td><?php echo $pointSeries['short_name']; ?></td>
			<td><?php
				echo h(PointCalculator::getCalculator($pointSeries['calc_rule'])->name());
			?></td>
			<td><?php
				echo h(PointSeriesSumUpRule::ruleAt($pointSeries['sum_up_rule'])->title());
			?></td>
			<td><?php
				if (!empty($seasons[$pointSeries['season_id']])) {
					echo h($seasons[$pointSeries['season_id']]);
				} else {
					echo $pointSeries['season_id'];
				}
			?></td>
			<td><?php
				echo h(PointSeriesTermOfValidityRule::ruleAt($pointSeries['point_term_rule'])->title());
			?></td>
			<td><?php echo $pointSeries['hint']; ?></td>
			<td><?php echo ($pointSeries['is_active'] ? 'Yes' : 'No'); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'point_series', 'action' => 'view', $pointSeries['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'point_series', 'action' => 'edit', $pointSeries['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'point_series', 'action' => 'delete', $pointSeries['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pointSeries['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
