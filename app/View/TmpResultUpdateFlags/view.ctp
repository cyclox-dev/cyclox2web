<div class="tmpResultUpdateFlags view">
<h2><?php echo __('Tmp Result Update Flag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tmpResultUpdateFlag['EntryCategory']['name'], array('controller' => 'entry_categories', 'action' => 'view', $tmpResultUpdateFlag['EntryCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Result Updated'); ?></dt>
		<dd>
			<?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['result_updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Points Sumuped'); ?></dt>
		<dd>
			<?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['points_sumuped']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tmpResultUpdateFlag['TmpResultUpdateFlag']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tmp Result Update Flag'), array('action' => 'edit', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tmp Result Update Flag'), array('action' => 'delete', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tmpResultUpdateFlag['TmpResultUpdateFlag']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tmp Result Update Flags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tmp Result Update Flag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
