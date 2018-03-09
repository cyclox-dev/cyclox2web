<div class="ajoccptLocalSettings form">
<?php echo $this->Form->create('AjoccptLocalSetting'); ?>
	<fieldset>
		<legend><?php echo __('Ajoccpt Local 設定の編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('short_name');
		echo $this->Form->input('season_id');
		echo $this->Form->input('setting');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('この設定を削除'), array('action' => 'delete', $this->Form->value('AjoccptLocalSetting.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('AjoccptLocalSetting.id')))); ?></li>
		<li><?php echo $this->Html->link(__('> Ajoccpt Local 設定リスト'), array('action' => 'index')); ?></li>
	</ul>
</div>
