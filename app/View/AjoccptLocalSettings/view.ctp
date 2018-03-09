<div class="ajoccptLocalSettings view">
<h2><?php echo __('Ajoccpt Local 設定'); ?></h2>
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
		<li><?php echo $this->Html->link(__('この Ajoccpt Local 設定を編集'), array('action' => 'edit', $ajoccptLocalSetting['AjoccptLocalSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('この Ajoccpt Local 設定を削除'), array('action' => 'delete', $ajoccptLocalSetting['AjoccptLocalSetting']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $ajoccptLocalSetting['AjoccptLocalSetting']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('> Ajoccpt Local 設定リスト'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> Ajoccpt Local 設定を作成'), array('action' => 'add')); ?> </li>
	</ul>
</div>
