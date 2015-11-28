<div class="meetPointSeries form">
<?php echo $this->Form->create('MeetPointSeries'); ?>
	<fieldset>
		<legend><?php echo __('Add Meet Point Series'); ?></legend>
	<?php
		echo $this->Form->input('point_series_id', array('label' => 'ポイントシリーズ'));
		echo $this->Form->input('express_in_series', array('label' => 'シリーズ内での表示名（例：#2菅生）'));
		echo $this->Form->input('meet_code', array('label' => '大会コード'));
		echo $this->Form->input('entry_category_name', array('label' => '出走カテゴリー名'));
		echo $this->Form->input('grade', array('label' => 'ポイントテーブルのグレード／詳細は配点設定を確認して下さい。'));
		echo $this->Form->input('point_term_begin', array(
			'label' => 'ポイントの有効期間の開始日／未指定の場合は配点時に大会の翌日が設定されます。',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			// 以下空の値 (->null) の表示設定
			'empty' => array(0 => '–'),
			'div' => 'cancel_date',
			'selected' => array(
				'year' => 0,
				'month' => 0,
				'day' => 0
			)
		));
		echo $this->Form->input('point_term_end', array(
			'label' => 'ポイント有効期間の終了日／終了日はポイント有効',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			// 以下空の値 (->null) の表示設定
			'empty' => array(0 => '–'),
			'div' => 'cancel_date',
			'selected' => array(
				'year' => 0,
				'month' => 0,
				'day' => 0
			),
			'after' => $this->Html->tag('div', '終了日が必要な場合、配点時に自動的に設定されます。未指定で良いです。')
		));
		echo $this->Form->input('hint', array('label' => 'ヒント／詳細は集計設定を確認して下さい。半角カンマ区切りで複数入力可。'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
