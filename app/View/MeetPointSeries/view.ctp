<div class="meetPointSeries view">
<h2><?php echo __('ポイントシリーズ - 大会設定の詳細'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ポイントシリーズ'); ?></dt>
		<dd>
			<?php echo $this->Html->link($meetPointSeries['PointSeries']['name'], array('controller' => 'point_series', 'action' => 'view', $meetPointSeries['PointSeries']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('シリーズ内名称'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['express_in_series']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('大会'); ?></dt>
		<dd>
			<?php echo $this->Html->link($meetPointSeries['Meet']['name'], array('controller' => 'meets', 'action' => 'view', $meetPointSeries['Meet']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('出走カテゴリー名'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['entry_category_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Grade'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['grade']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point 有効期間の開始日'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['point_term_begin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point 有効期間の終了日（終了日はポイント有効）'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['point_term_end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hint（集計時ヒント）'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['hint']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['deleted_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($meetPointSeries['MeetPointSeries']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meet Point Series'), array('action' => 'edit', $meetPointSeries['MeetPointSeries']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Meet Point Series'), array('action' => 'delete', $meetPointSeries['MeetPointSeries']['id']), array(), __('Are you sure you want to delete # %s?', $meetPointSeries['MeetPointSeries']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
