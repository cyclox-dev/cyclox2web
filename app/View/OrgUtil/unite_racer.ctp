<div class="orgUtil form">
<?php echo $this->Form->create(false, array('type' => 'post')); ?>
	<fieldset>
		<legend><?php echo __('選手データの統合'); ?></legend>
	<?php
		echo $this->Form->input('racer_code_united', array('label' => '統合される選手コード'));
		echo $this->Form->input('racer_code_unite_to', array('label' => '統合先選手コード'));
		echo $this->Form->input('note', array('label' => 'メモ（この統合を行なう理由など）'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('確認')); ?>
</div>