<div class="categoryRacers form">
<?php echo $this->Form->create('CategoryRacer'); ?>
	<fieldset>
		<legend><?php echo __('カテゴリー所属の編集'); ?></legend>
	<?php
		App::uses('CategoryReason', 'Cyclox/Const');
		
		$rs = array();
		foreach ($racers as $r) {
			$rs[$r['Racer']['code']] = $r['Racer']['code'] . ': ' . $r['Racer']['family_name'] . ' ' . $r['Racer']['first_name'];
		}
		
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
		echo $this->Form->input('racer_code', array('options' => $rs, 'label' => '選手 Code'));
		echo $this->Form->input('category_code', array('options' => $cats));
		echo $this->Form->input('apply_date', array(
			'label' => 'カテゴリー所属の適用日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
		));
		echo $this->Form->input('cancel_date', array(
			'label' => 'カテゴリー所属解消日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			// 以下空の値 (->null) の表示設定
			'empty' => array(0 => '–'),
		));
		echo $this->Form->input('reason_id', array('options' => $reasons, 'label' => '適用理由'));
		echo $this->Form->input('reason_note', array('label' => '適用理由詳細・メモ'));
		echo $this->Form->input('racer_result_id', array('label' => '根拠となったリザルトの ID（あれば）', 'type' => 'number'));
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

		<li><?php echo $this->Form->postLink(__('このカテゴリー所属を削除'), array('action' => 'delete', $this->Form->value('CategoryRacer.id')), array()
			, 'カテゴリー所属 [ID:' . $this->Form->value('CategoryRacer.id') . "] のデータを削除してよろしいですか？\n解消の場合には編集画面で解消日を設定して下さい。"); ?></li>
		<li><?php echo $this->Html->link(__('カテゴリー所属リスト'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('> カテゴリーリスト'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手リスト'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手データを追加'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
