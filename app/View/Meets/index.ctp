<div class="meets index">
	<h2><?php echo __('大会一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code', '大会 Code'); ?></th>
			<th><?php echo $this->Paginator->sort('at_date', '開催日'); ?></th>
			<th><?php echo $this->Paginator->sort('name', '大会名'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name', 'Short Name'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_group_code', '大会 Group'); ?></th>
			<th><?php echo $this->Paginator->sort('season_id'); ?></th>
			<th><?php echo $this->Paginator->sort('holding_status', '開催 Status'); ?></th>
			<th>Result 公開</th>
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
		<td>
			<?php
				App::uses('MeetStatus', 'Cyclox/Const');
				echo MeetStatus::statusAt($meet['Meet']['holding_status'])->name();
			?>
		</td>
		<td><?php echo $meet['Meet']['publishes_on_ressys'] ? 'yes' : 'no' ?></td>
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
		<li><?php echo $this->Html->link(__('> 大会グループリスト'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="actions">
	<h3><?php echo '大会グループごと'; ?></h3>
	<ul>
		<li><?php echo $this->Html->link('すべて', '/meets/index'); ?> </li>
		<?php foreach ($meet_groups as $code => $mg): ?>
		<li><?php echo $this->Html->link(h($mg), '/meets/index?group=' . $code); ?> </li>
		<?php endforeach; ?>
	</ul>
</div>
