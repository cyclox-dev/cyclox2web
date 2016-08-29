<div class="pointSeries view">
<h2><?php echo __('Point Series'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('シリーズタイトル'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('短縮名'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('詳細'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('配点ルール'); ?></dt>
		<dd>
			<?php
				App::uses('PointCalculator', 'Cyclox/Util');
				echo h(PointCalculator::getCalculator($pointSeries['PointSeries']['calc_rule'])->name());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('集計ルール'); ?></dt>
		<dd>
			<?php
				App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
				echo h(PointSeriesSumUpRule::ruleAt($pointSeries['PointSeries']['sum_up_rule'])->title());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('付与対象'); ?></dt>
		<dd>
			<?php
				App::uses('PointSeriesPointTo', 'Cyclox/Const');
				echo h(PointSeriesPointTo::pointToAt($pointSeries['PointSeries']['point_to'])->title());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pt有効期間ルール'); ?></dt>
		<dd>
			<?php
				App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');
				echo h(PointSeriesTermOfValidityRule::ruleAt($pointSeries['PointSeries']['point_term_rule'])->title());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Season'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pointSeries['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $pointSeries['Season']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ヒント'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['hint']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['deleted_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Point Series'), array('action' => 'edit', $pointSeries['PointSeries']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Point Series'), array('action' => 'delete', $pointSeries['PointSeries']['id']), array(), __('Are you sure you want to delete # %s?', $pointSeries['PointSeries']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('対象レース'); ?></h3>
	<?php if (!empty($pointSeries['MeetPointSeries'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('シリーズ内名称'); ?></th>
		<th><?php echo __('大会コード'); ?></th>
		<th><?php echo __('出走カテゴリー名'); ?></th>
		<th><?php echo __('Grade'); ?></th>
		<th><?php echo __('Pt開始日'); ?></th>
		<th><?php echo __('Pt終了日'); ?></th>
		<th><?php echo __('集計時ヒント'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pointSeries['MeetPointSeries'] as $meetPointSeries): ?>
		<tr>
			<td><?php echo $meetPointSeries['id']; ?></td>
			<td><?php echo $meetPointSeries['express_in_series']; ?></td>
			<td><?php echo $meetPointSeries['meet_code']; ?></td>
			<td><?php echo $meetPointSeries['entry_category_name']; ?></td>
			<td><?php echo $meetPointSeries['grade']; ?></td>
			<td><?php echo $meetPointSeries['point_term_begin']; ?></td>
			<td><?php echo $meetPointSeries['point_term_end']; ?></td>
			<td><?php echo $meetPointSeries['hint']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'meet_point_series', 'action' => 'view', $meetPointSeries['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'meet_point_series', 'action' => 'edit', $meetPointSeries['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'meet_point_series', 'action' => 'delete', $meetPointSeries['id']), array(), __('Are you sure you want to delete # %s?', $meetPointSeries['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
