<div class="redLines view">
<h2><?php echo __('Red Line'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($redLine['RedLine']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Season'); ?></dt>
		<dd>
			<?php echo $this->Html->link($redLine['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $redLine['Season']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($redLine['Category']['name'], array('controller' => 'categories', 'action' => 'view', $redLine['Category']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('残留順位'); ?></dt>
		<dd>
			<?php echo h($redLine['RedLine']['end_rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($redLine['RedLine']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($redLine['RedLine']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Red Line'), array('action' => 'edit', $redLine['RedLine']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Red Line'), array('action' => 'delete', $redLine['RedLine']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $redLine['RedLine']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Red Lines'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Red Line'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
