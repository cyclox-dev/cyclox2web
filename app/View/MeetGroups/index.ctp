<div class="meetGroups index">
	<h2><?php echo __('大会グループ'); ?></h2>
	<p>東北ならば TCX, 信州なら CCM などと、各地のシリーズごとに分けられる大会のまとまり。</p>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code', '大会グループ Code'); ?></th>
			<th><?php echo $this->Paginator->sort('name', '名称'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name', '短縮名'); ?></th>
			<th><?php echo $this->Paginator->sort('homepage', 'Homepage'); ?></th>
			<th><?php echo 'Action'; ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($meetGroups as $meetGroup): ?>
	<tr>
		<td><?php echo h($meetGroup['MeetGroup']['code']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['name']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['short_name']); ?>&nbsp;</td>
		<td><?php echo h($meetGroup['MeetGroup']['homepage']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $meetGroup['MeetGroup']['code'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $meetGroup['MeetGroup']['code'])); ?>
			<?php 
				// 削除しないものとしておく。
				//echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $meetGroup['MeetGroup']['code']), array('confirm' => __('[%s] のデータを削除してよろしいですか？', $meetGroup['MeetGroup']['code'])));
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Meet Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Meets'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
