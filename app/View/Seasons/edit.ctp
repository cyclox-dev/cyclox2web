<div class="seasons form">
<?php echo $this->Form->create('Season'); ?>
	<fieldset>
		<legend><?php echo __('Edit Season'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('type' => 'text'));
		echo $this->Form->input('short_name', array('type' => 'text'));
		echo $this->Form->input('start_date', array(
			'label' => 'シーズン開始日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
		));
		echo $this->Form->input('end_date', array(
			'label' => 'シーズン終了日（終了日は含む）',
			'dateFormat' => 'YMD',
			'monthNames' => false,
		));
		echo $this->Form->input('is_regular');
		echo $this->Form->input('updates_ajocc_ranking', array('label' => 'リザルト更新により Ajocc Ranking を更新する'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Season.id')), array(), __('[%s] のデータを削除してよろしいですか？', $this->Form->value('Season.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meet'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
