
<?php echo $this->Html->scriptStart(); ?>
$(document).ready(function(){
	var r = $('<button name="new button" type="button">＜ 開始日を無しに設定</button>');
	r.click(function() {
		$("#MeetPointSeriesPointTermBeginYear option").each(function() { this.selected = (this.text == ""); });
		$("#MeetPointSeriesPointTermBeginMonth option").each(function() { this.selected = (this.text == ""); });
		$("#MeetPointSeriesPointTermBeginDay option").each(function() { this.selected = (this.text == ""); });
	});
	$(".point_term_begin").append(r);
	
	var b = $('<button name="new button" type="button">＜ 終了日を無しに設定</button>');
	b.click(function() {
		$("#MeetPointSeriesPointTermEndYear option").each(function() { this.selected = (this.text == ""); });
		$("#MeetPointSeriesPointTermEndMonth option").each(function() { this.selected = (this.text == ""); });
		$("#MeetPointSeriesPointTermEndDay option").each(function() { this.selected = (this.text == ""); });
	});
	$(".point_term_end").append(b);
});
<?php echo $this->Html->scriptEnd(); ?>

<div class="meetPointSeries form">
<?php echo $this->Form->create('MeetPointSeries'); ?>
	<fieldset>
		<legend><?php echo __('ポイントシリーズ - 大会設定の編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('point_series_id', array('label' => 'ポイントシリーズ'));
		echo $this->Form->input('express_in_series', array('label' => 'シリーズ内での名称（例：#2菅生／ランキング表上での大会タイトルとなる。）'));
		echo $this->Form->input('meet_code', array('label' => '大会コード'));
		echo $this->Form->input('entry_category_name', array('label' => '出走カテゴリー名'));
		echo $this->Form->input('grade', array('label' => 'ポイントテーブルのグレード／詳細は配点ルールを確認して下さい。'));
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
			),
			'div' => 'point_term_begin'
		));
		echo $this->Form->input('point_term_end', array(
			'label' => 'ポイント有効期間の終了日／終了日はポイント有効。シリーズ自体に期限設定がある場合、リザルト計算時に自動的に設定されます。',
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
			'div' => 'point_term_end',
		));
		echo $this->Form->input('hint', array('label' => '集計時ヒント／集計ルールを確認して下さい。半角カンマ区切りで複数入力可。'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MeetPointSeries.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('MeetPointSeries.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
