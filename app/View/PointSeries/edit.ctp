<div class="pointSeries form">
<?php echo $this->Form->create('PointSeries'); ?>
	<fieldset>
		<legend><?php echo __('Edit Point Series'); ?></legend>
	<?php
		App::uses('PointSeriesPointTo', 'Cyclox/Const');

		echo $this->Form->input('id');
		echo $this->Form->input('point_series_group_id', array('empty' => '--'));
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
		
		// hidden にして値を to team に固定
		//echo $this->Form->input('point_to', array('label' => '付与対象', 'options' => $toRules));
		echo $this->Form->hidden('point_to', array('value' => PointSeriesPointTo::$TO_RACER->val()));
		
		$termSelects = array();
		foreach ($termRules as $rule) {
			$termSelects[$rule->val()] = $rule->title();
		}
		echo $this->Form->input('point_term_rule', array('label' => 'Pt有効期間ルール', 'options' => $termSelects));
		echo $this->Form->input('season_id', array('empty' => '--'));
		echo $this->Form->input('hint');
		echo $this->Form->input('is_active');
		echo $this->Form->input('publishes_on_ressys', array('label' => 'リザルト閲覧システム上でランキングを公開する。'));
		echo $this->Form->input('publishes_newest_asap', array('label' => 'リザルトから計算された最新のランキングデータをすぐに公開する。'));
		echo '<p>※以下の項目は通常の場合、この画面で値を入力する必要はありません。</p>';
		echo $this->Form->input('public_psrset_group_id', array('type' => 'text', 'label' => '公開データID'));
		echo $this->Form->input('published_at', array(
			'label' => '公開日時',
			'type' => 'datetime',
			'dateFormat' => 'YMD',
			'timeFormat' => '24',
			'monthNames' => false,
			'empty' => '--'
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PointSeries.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('PointSeries.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet Point Series'), array('controller' => 'meet_point_series', 'action' => 'add')); ?> </li>
	</ul>
</div>
