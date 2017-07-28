<div class="meets form">
<?php echo $this->Form->create('Meet'); ?>
	<fieldset>
		<legend>
			<?php 
				if (isset($meetGroupCode)) {
					echo __('大会グループ [%s] への大会の追加', h($meetGroupCode));
				} else {
					echo __('新規大会データの追加');
				}
			?>
		</legend>
	<?php
		$mg = array();
		foreach ($meetGroups as $k => $v) {
			$mg[$k] = $k . ': ' . $v;
		}
		
		if (isset($meetGroupCode)) {
			echo $this->Form->hidden('meet_group_code');
		} else {
			echo $this->Form->input('meet_group_code', array('options' => $mg, 'label' => '大会 Group'));
		}
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
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('大会リスト'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('> シーズンリスト'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> シーズンを追加'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループリスト'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループを追加'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループリスト'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループを追加'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
