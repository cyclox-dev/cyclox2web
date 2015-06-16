<div class="categoryRacers view">
<h2><?php echo __('Category Racer'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $categoryRacer['Racer']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacer['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoryRacer['Category']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apply Date'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['apply_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reason Id'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['reason_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reason Note'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['reason_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meet Code'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['meet_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cancel Date'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['cancel_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category Racer'), array('action' => 'edit', $categoryRacer['CategoryRacer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category Racer'), array('action' => 'delete', $categoryRacer['CategoryRacer']['id']), array(), __('Are you sure you want to delete # %s?', $categoryRacer['CategoryRacer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
