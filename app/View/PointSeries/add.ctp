<div class="pointSeries form">
<?php echo $this->Form->create('PointSeries'); ?>
	<fieldset>
		<legend><?php echo __('Add Point Series'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => 'シリーズタイトル'));
		echo $this->Form->input('short_name', array('label' => '短縮タイトル'));
		echo $this->Form->input('description', array('label' => '詳細'));
		
		$calcRules = array();
		foreach ($pointCalculators as $calc) {
			$calcRules[$calc->val()] = $calc->name();
		}
		echo $this->Form->input('calc_rule', array('label' => '配点ルール', 'options' => $calcRules));
		
		$suRules = array();
		foreach ($sumUpRules as $rule) {
			$suRules[$rule->val()] = $rule->title();
		}
		echo $this->Form->input('sum_up_rule', array('label' => '集計ルール', 'options' => $suRules));
		
		$toRules = array();
		foreach ($pointTos as $to) {
			$toRules[$to->val()] = $to->title();
		}
		echo $this->Form->input('point_to', array('label' => '付与対象', 'options' => $toRules));
		
		$termSelects = array();
		foreach ($termRules as $rule) {
			$termSelects[$rule->val()] = $rule->title();
		}
		echo $this->Form->input('point_term_rule', array('label' => 'Pt有効期間ルール', 'options' => $termSelects));
		echo $this->Form->input('season_id', array('empty' => '--'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Point Series'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
