
<?php echo $this->Html->scriptStart(); ?>
$(document).ready(function(){
	var r = $('<button name="new button" type="button">＜ 終了日を無しに設定</button>');
	r.click(function() {
		$("#CategoryRacerCancelDateYear option").each(function() { this.selected = (this.text == ""); });
		$("#CategoryRacerCancelDateMonth option").each(function() { this.selected = (this.text == ""); });
		$("#CategoryRacerCancelDateDay option").each(function() { this.selected = (this.text == ""); });
	});
	$(".cancel_date").append(r);
});
<?php echo $this->Html->scriptEnd(); ?>

<div class="categoryRacers form">
<?php echo $this->Form->create('CategoryRacer'); ?>
	<fieldset>
		<legend><?php echo __('カテゴリー所属の編集'); ?></legend>
	<?php
		App::uses('CategoryReason', 'Cyclox/Const');
		
		$cats = array();
		foreach ($categories as $key => $val) {
			$cats[$key] = $key . ': ' . $val;
		}
		
		$reasons = array();
		foreach (CategoryReason::reasons() as $r) {
			$reasons[$r->ID()] = '[' . $r->flag()->msg() . '] ' . $r->name();
		}
		
		$mts = array();
		foreach ($meets as $key => $val) {
			$mts[$key] = $key . ': ' . $val;
		}
		
		echo $this->Form->input('id');
		echo $this->Form->input('racer_code', array('label' => '選手 Code'));
		echo $this->Form->input('category_code', array('options' => $cats));
		echo $this->Form->input('apply_date', array(
			'label' => 'カテゴリー所属が開始した日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
		));
		echo $this->Form->input('cancel_date', array(
			'label' => 'カテゴリー所属の終了した日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			// 以下空の値 (->null) の表示設定
			'empty' => array(0 => '–'),
			'div' => 'cancel_date'
		));
		echo $this->Form->input('reason_id', array('options' => $reasons, 'label' => 'このカテゴリー所属開始の適用タイプ（適用理由）'));
		echo $this->Form->input('reason_note', array('label' => '適用理由詳細・メモ'));
		echo $this->Form->input('racer_result_id', array('label' => '適用根拠となったリザルトの ID（あれば）', 'type' => 'number'));
		echo $this->Form->input('meet_code', array(
			'options' => $mts,
			'label' => '適用根拠となった大会（あれば）',
			'empty' => 'なし'
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('カテゴリー所属リスト'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('> カテゴリー所属リスト'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手リスト'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
	</ul>
</div>
