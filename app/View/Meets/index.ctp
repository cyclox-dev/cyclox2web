<div class="meets index">
	<h2><?php echo __('大会一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code', '大会 Code'); ?></th>
			<th><?php echo $this->Paginator->sort('at_date', '開催日'); ?></th>
			<th><?php echo $this->Paginator->sort('name', '大会名'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name', '短縮名'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_group_code', '大会 Group'); ?></th>
			<th><?php echo $this->Paginator->sort('season_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($meets as $meet): ?>
	<tr>
		<td><?php echo h($meet['Meet']['code']); ?>&nbsp;</td>
		<td><?php echo h($meet['Meet']['at_date']); ?>&nbsp;</td>
		<td><?php echo h($meet['Meet']['name']); ?>&nbsp;</td>
		<td><?php echo h($meet['Meet']['short_name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($meet['MeetGroup']['name'], array('controller' => 'meet_groups', 'action' => 'view', $meet['MeetGroup']['code'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($meet['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $meet['Season']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $meet['Meet']['code'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $meet['Meet']['code'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $meet['Meet']['code']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $meet['Meet']['code']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('大会データの追加'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('> シーズンリスト'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> シーズンの追加'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループリスト'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループの追加'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループリスト'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループの追加'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
