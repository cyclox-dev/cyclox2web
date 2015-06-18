<div class="categoryRacers form">
<?php echo $this->Form->create('CategoryRacer'); ?>
	<fieldset>
		<legend><?php echo __('Add Category Racer'); ?></legend>
	<?php
		App::uses('CategoryReason', 'Cyclox/Const');
		App::uses('CategoryReason', 'Cyclox/Const');
		
		$rs = array();
		foreach ($racers as $r) {
			$rs[$r['Racer']['code']] = $r['Racer']['code'] . ': ' . $r['Racer']['family_name'] . ' ' . $r['Racer']['first_name'];
		}
		
		$cats = array();
		foreach ($categories as $c) {
			$cats[$c['Category']['code']] = $c['Category']['code'] . ': ' . $c['Category']['name'];
		}
		
		$reasons = array();
		foreach (CategoryReason::reasons() as $r) {
			$reasons[$r->ID()] = '[' . $r->flag()->msg() . '] ' . $r->name();
		}
		
		$mts = array();
		foreach ($meets as $m) {
			$mts[$m['Meet']['code']] = $m['Meet']['code'] . ': ' . $m['Meet']['name'];
		}
		
		echo $this->Form->input('racer_code', array('options' => $rs));
		echo $this->Form->input('category_code', array('options' => $cats));
		echo $this->Form->input('apply_date', array(
			'label' => 'カテゴリー所属の適用日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
		));
		echo $this->Form->input('reason_id', array('options' => $reasons, 'label' => '適用理由'));
		echo $this->Form->input('reason_note', array('label' => '適用理由詳細・メモ'));
		echo $this->Form->input('meet_code', array(
			'options' => $mts,
			'label' => '適用根拠となった大会（あれば）',
			'empty' => 'なし'
			));
		echo $this->Form->input('cancel_date', array(
			'label' => 'カテゴリー所属解消日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			// 以下空の値 (->null) の表示設定
			'empty' => array(0 => '–'),
			'selected' => array(
				'year' => 0,
				'month' => 0,
				'day' => 0
			)
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Category Racers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
