<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		App::uses('UserRole', 'Cyclox/Const');
		
		$roles = array();
		foreach (UserRole::roles() as $r) {
			$roles[$r->val()] = $r->name();
		}
	
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('group_id');
		echo $this->Form->input('email');
		echo $this->Form->input('role', array('options' => $roles));
		echo $this->Form->input('active', array('default' => 1));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
