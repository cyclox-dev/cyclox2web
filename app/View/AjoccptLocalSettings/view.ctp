<div class="ajoccptLocalSettings view">
<h2><?php echo __('Ajoccpt Local Setting'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Season'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ajoccptLocalSetting['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $ajoccptLocalSetting['Season']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Setting'); ?></dt>
		<dd>
			<?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['setting']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ajoccpt Local Setting'), array('action' => 'edit', $ajoccptLocalSetting['AjoccptLocalSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ajoccpt Local Setting'), array('action' => 'delete', $ajoccptLocalSetting['AjoccptLocalSetting']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $ajoccptLocalSetting['AjoccptLocalSetting']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Ajoccpt Local Settings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ajoccpt Local Setting'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
	</ul>
</div>
