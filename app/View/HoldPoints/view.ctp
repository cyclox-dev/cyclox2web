<div class="holdPoints view">
<h2><?php echo __('Hold Point'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($holdPoint['HoldPoint']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer Result'); ?></dt>
		<dd>
			<?php echo $this->Html->link($holdPoint['RacerResult']['id'], array('controller' => 'racer_results', 'action' => 'view', $holdPoint['RacerResult']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point'); ?></dt>
		<dd>
			<?php echo h($holdPoint['HoldPoint']['point']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('カテゴリー'); ?></dt>
		<dd>
			<?php echo h($holdPoint['HoldPoint']['category_code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Hold Point'), array('action' => 'edit', $holdPoint['HoldPoint']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Hold Point'), array('action' => 'delete', $holdPoint['HoldPoint']['id']), array(), __('Are you sure you want to delete # %s?', $holdPoint['HoldPoint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hold Points'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hold Point'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
