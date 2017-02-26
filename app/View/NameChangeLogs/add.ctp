<div class="nameChangeLogs form">
<?php echo $this->Form->create('NameChangeLog'); ?>
	<fieldset>
		<legend><?php echo __('選手名変更ログの追加'); ?></legend>
		<p>※一般に手動でこのログを追加することはありません！</p>
	<?php
		echo $this->Form->input('racer_code', array('label' => '選手コード'));
		echo $this->Form->input('new_fam', array('label' => '新しい姓'));
		echo $this->Form->input('new_fir', array('label' => '新しい名前'));
		echo $this->Form->input('old_data', array('after' => '※json 形式を想定しています。'));
		echo $this->Form->input('by_user', array('label' => '名前変更したUser.Mail'));
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('選手名変更ログ一覧'), array('action' => 'index')); ?></li>
	</ul>
</div>
