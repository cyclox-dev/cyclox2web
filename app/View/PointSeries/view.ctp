<div class="pointSeries view">
<h2><?php echo __('Point Series'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Series Group'); ?></dt>
		<dd>
			<?php
			if (empty($pointSeries['PointSeries']['point_series_group_id'])) {
				echo '';
			} else {
				echo $this->Html->link($pointSeries['PointSeriesGroup']['name'], array('controller' => 'point_series_groups', 'action' => 'view', $pointSeries['PointSeries']['point_series_group_id']));
			}
			?>
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
		<dt><?php echo __('Is Active?'); ?></dt>
		<dd>
			<?php echo ($pointSeries['PointSeries']['is_active'] ? 'Yes' : 'No'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ランキング公開？'); ?></dt>
		<dd>
			<?php echo ($pointSeries['PointSeries']['publishes_on_ressys'] ? 'Yes' : 'No'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('公開 Data-ID'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['public_psrset_group_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('公開日時'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['published_at']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('公開データの指定'); ?></dt>
		<dd>
			<?php echo h($pointSeries['PointSeries']['publishes_newest_asap'] ? 'Auto（最新）' : '手動'); ?>
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
		<li><?php echo $this->Html->link(__('このポイントシリーズを編集'), array('action' => 'edit', $pointSeries['PointSeries']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('このポイントシリーズを削除'), array('action' => 'delete', $pointSeries['PointSeries']['id']), array(), __('Are you sure you want to delete # %s?', $pointSeries['PointSeries']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('> シリーズリスト'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 新規シリーズを作成'), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('対象レース'); ?></h3>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('対象レースを追加')
				, '/meet_point_series/add/' . $pointSeries['PointSeries']['id']); ?> </li>
		</ul>
	</div>
	<?php if (!empty($mpss)): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('ID'); ?></th>
		<th><?php echo __('シリーズ内名称'); ?></th>
		<th><?php echo __('大会コード'); ?></th>
		<th><?php echo __('出走カテゴリー名'); ?></th>
		<th><?php echo __('Grade'); ?></th>
		<th><?php echo __('Pt開始日'); ?></th>
		<th><?php echo __('Pt終了日'); ?></th>
		<th><?php echo __('集計時ヒント'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($mpss as $mps): ?>
		<tr>
			<td><?php echo h($mps['MeetPointSeries']['id']); ?></td>
			<td><?php echo h($mps['MeetPointSeries']['express_in_series']); ?></td>
			<td><?php echo $this->Html->link($mps['MeetPointSeries']['meet_code'], '/meets/view/' . $mps['MeetPointSeries']['meet_code']); ?></td>
			<td><?php echo h($mps['MeetPointSeries']['entry_category_name']); ?></td>
			<td><?php echo h($mps['MeetPointSeries']['grade']); ?></td>
			<td><?php echo h($mps['MeetPointSeries']['point_term_begin']); ?></td>
			<td><?php echo h($mps['MeetPointSeries']['point_term_end']); ?></td>
			<td><?php echo h($mps['MeetPointSeries']['hint']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'meet_point_series', 'action' => 'view', $mps['MeetPointSeries']['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'meet_point_series', 'action' => 'edit', $mps['MeetPointSeries']['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'meet_point_series', 'action' => 'delete', $mps['MeetPointSeries']['id']), array(), __('Are you sure you want to delete # %s?', $mps['MeetPointSeries']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>
<div class="related">
	<h3><?php echo __('公開データの指定'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Data-ID'); ?></th>
		<th><?php echo __('更新日時'); ?></th>
		<th><?php echo __('公開状況'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php if (empty($psrSets)): ?>
	ランキングデータがありません。
	<?php else: ?>
	<?php foreach ($psrSets as $psrs): ?>
		<tr>
			<td><?php echo h($psrs['TmpPointSeriesRacerSet']['set_group_id']); ?></td>
			<td><?php echo h($psrs['TmpPointSeriesRacerSet']['modified']); ?></td>
			<td><?php
			$gid = $psrs['TmpPointSeriesRacerSet']['set_group_id'];
			if ($gid == $pointSeries['PointSeries']['public_psrset_group_id']) {
				echo '公開中';
			} else {
				echo $this->Form->postLink('これを公開に設定', array('controller' => 'point_series', 'action' => 'assign_public_ranking'
					, $pointSeries['PointSeries']['id'], $gid)
					, array(), __('Data-ID:%s のデータを公開に設定してよいですか？', $gid));
			}
			?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('ランキングを閲覧'), array('controller' => 'point_series', 'action' => 'view_ranking'
					, $psrs['PointSeries']['id'], $psrs['TmpPointSeriesRacerSet']['set_group_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php endif; ?>
	</table>
</div>
<div class="related">
	<h3><?php echo __('公開データ作成'); ?></h3>
	<div><?php echo $this->Form->postButton('最新リザルトでリザルト閲覧システム用のランキングデータを作成'
		, array('action' => 'updateRanking', $pointSeries['PointSeries']['id'])); ?></div>
</div>


