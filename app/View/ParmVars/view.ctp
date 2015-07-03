<div class="parmVars view">
<h2><?php echo __('Parm Var'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($parmVar['ParmVar']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pkey'); ?></dt>
		<dd>
			<?php echo h($parmVar['ParmVar']['pkey']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($parmVar['ParmVar']['value']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Parm Var'), array('action' => 'edit', $parmVar['ParmVar']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Parm Var'), array('action' => 'delete', $parmVar['ParmVar']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $parmVar['ParmVar']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Parm Vars'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parm Var'), array('action' => 'add')); ?> </li>
	</ul>
</div>
