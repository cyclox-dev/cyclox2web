<div class="tmpAjoccptRacerSets view">
<h2><?php echo __('Tmp Ajoccpt Racer Set'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ajoccpt Local Setting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tmpAjoccptRacerSet['AjoccptLocalSetting']['name'], array('controller' => 'ajoccpt_local_settings', 'action' => 'view', $tmpAjoccptRacerSet['AjoccptLocalSetting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Season'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tmpAjoccptRacerSet['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $tmpAjoccptRacerSet['Season']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer Code'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['racer_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['team']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point Json'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['point_json']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sumup Json'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['sumup_json']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tmpAjoccptRacerSet['TmpAjoccptRacerSet']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tmp Ajoccpt Racer Set'), array('action' => 'edit', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tmp Ajoccpt Racer Set'), array('action' => 'delete', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tmpAjoccptRacerSet['TmpAjoccptRacerSet']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tmp Ajoccpt Racer Sets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tmp Ajoccpt Racer Set'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ajoccpt Local Settings'), array('controller' => 'ajoccpt_local_settings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ajoccpt Local Setting'), array('controller' => 'ajoccpt_local_settings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
	</ul>
</div>
