<div class="meets form">
<?php echo $this->Form->create('Meet'); ?>
	<fieldset>
		<legend><?php echo __('大会データの編集'); ?></legend>
	<?php
		App::uses('MeetStatus', 'Cyclox/Const');
		$hs = array();
		foreach (MeetStatus::statusList() as $k => $s) {
			$hs[$k] = $s->name();
		}
		
		$mg = array();
		foreach ($meetGroups as $k => $v) {
			$mg[$k] = $k . ': ' . $v;
		}
		
		echo $this->Form->input('code');
		echo $this->Form->input('meet_group_code', array('options' => $mg, 'label' => '大会 Group', 'disabled' => 'disabled'));
		echo $this->Form->input('season_id');
		echo $this->Form->input('at_date', array(
			'label' => '開催日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'minYear' => date('Y') - 10,
			'maxYear' => date('Y') + 20,
		));
		echo $this->Form->input('name', array('type' => 'text', 'label' => '大会名'));
		echo $this->Form->input('short_name', array('type' => 'text', 'label' => 'Short Name'));
		echo $this->Form->input('location', array('type' => 'text', 'label' => '開催地'));
		echo $this->Form->input('organized_by', array('type' => 'text', 'label' => '主催'));
		echo $this->Form->input('homepage', array('type' => 'text'));
		echo $this->Form->input('start_frac_distance', array('label' => 'スタート端数距離 (km)'));
		echo $this->Form->input('lap_distance', array('label' => '周回距離 (km)'));
		echo $this->Form->input('holding_status', array('options' => $hs, 'label' => '開催状況'));
		echo $this->Form->input('publishes_on_ressys', array('label' => 'リザルト公開'));
		echo $this->Form->input('is_jcx', array('label' => 'JCX戦として登録する場合はチェック'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('この大会を削除'), array('action' => 'delete', $this->Form->value('Meet.code')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('Meet.code'))); ?></li>
		<li><?php echo $this->Html->link(__('大会リスト'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('> シーズンリスト'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> シーズンの追加'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループリスト'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループの追加'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループリスト'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループの追加'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
