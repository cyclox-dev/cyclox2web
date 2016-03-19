<div class="uniteRacerLogs view">
<h2><?php echo __('Unite Racer Log'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($uniteRacerLog['UniteRacerLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('統合元（削除対象）'); ?></dt>
		<dd>
			<?php echo $this->Html->link($uniteRacerLog['UniteRacerLog']['united'], array('controller' => 'racers', 'action' => 'view', $uniteRacerLog['UniteRacerLog']['united'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('統合先選手データ'); ?></dt>
		<dd>
			<?php echo $this->Html->link($uniteRacerLog['UniteRacerLog']['unite_to'], array('controller' => 'racers', 'action' => 'view', $uniteRacerLog['UniteRacerLog']['unite_to'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('処理日時'); ?></dt>
		<dd>
			<?php echo h($uniteRacerLog['UniteRacerLog']['at_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Log'); ?></dt>
		<dd>
			<?php echo h($uniteRacerLog['UniteRacerLog']['log']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('データ作成日時'); ?></dt>
		<dd>
			<?php echo h($uniteRacerLog['UniteRacerLog']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('データ修正日時'); ?></dt>
		<dd>
			<?php echo h($uniteRacerLog['UniteRacerLog']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Unite Racer Log'), array('action' => 'edit', $uniteRacerLog['UniteRacerLog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Unite Racer Log'), array('action' => 'delete', $uniteRacerLog['UniteRacerLog']['id']), array(), __('Are you sure you want to delete # %s?', $uniteRacerLog['UniteRacerLog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Unite Racer Logs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Unite Racer Log'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
