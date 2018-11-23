<div class="entryCategories form">
<?php echo $this->Form->create('EntryCategory'); ?>
	<fieldset>
		<legend><?php echo __('空の出走カテゴリーの作成（リザルト読込用）'); ?></legend>
	<?php
		App::uses('LapOutRule', 'Cyclox/Const');
		
		$luRules = array();
		foreach (LapOutRule::rules() as $r) {
			$luRules[$r->val()] = $r->expressJp();
		}
	
		echo $this->Form->hidden('EntryGroup.meet_code', array('value' => $meetCode));
		echo $this->Form->input('EntryCategory.0.races_category_code', array('label' => 'カテゴリーCode', 'options' => $cats));
		echo $this->Form->input('EntryCategory.0.name', array('label' => 'レース名'));
		echo $this->Form->input('EntryGroup.start_clock', array('label' => 'Start時刻', 'timeFormat' => 24));
		echo $this->Form->input('EntryGroup.start_frac_distance', array('label' => 'StartLoop距離(km)'));
		echo $this->Form->input('EntryGroup.lap_distance', array('label' => '周回距離(km)'));
		echo $this->Form->input('EntryCategory.0.lapout_rule', array('label' => 'ラップアウト処理', 'options' => $luRules));
		echo $this->Form->input('EntryCategory.0.applies_hold_pt', array('label' => '残留ポイントを付与する（〜17-18）', 'checked' => true));
		echo $this->Form->input('EntryCategory.0.applies_rank_up', array('label' => '昇格処理を行なう', 'checked' => true));
		echo $this->Form->input('EntryCategory.0.applies_ajocc_pt', array('label' => 'AJOCC ポイントを付与する', 'checked' => true));
		echo $this->Form->input('EntryCategory.0.note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('作成')); ?>
</div>