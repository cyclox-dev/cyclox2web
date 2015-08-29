<div class="meetGroups view">
<h2><?php echo __('大会グループ'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('名称'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homepage'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['homepage']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h(($meetGroup['MeetGroup']['deleted'] ? "Yes" : "No")); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($meetGroup['MeetGroup']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('この大会グループを編集'), array('action' => 'edit', $meetGroup['MeetGroup']['code'])); ?> </li>
		<!--
		<li><?php echo $this->Form->postLink(__('Delete Meet Group'), array('action' => 'delete', $meetGroup['MeetGroup']['code']), array(), __('[%s] のデータを削除してよろしいですか？', $meetGroup['MeetGroup']['code'])); ?> </li>
		-->
		<li><?php echo $this->Html->link(__('> 大会グループリスト'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループを追加'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会リスト'), array('controller' => 'meets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会を追加'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('開催する大会一覧'); ?></h3>
	<?php if (!empty($meetGroup['meets'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('大会 Code'); ?></th>
		<th><?php echo __('開催日'); ?></th>
		<th><?php echo __('大会名'); ?></th>
		<th><?php echo __('Short Name'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Distance'); ?></th>
	</tr>
	<?php foreach ($meetGroup['meets'] as $meets): ?>
		<tr>
			<td><?php echo $this->Html->link($meets['code'], array('controller' => 'meets', 'action' => 'view', $meets['code'])); ?></td>
			<td><?php echo $meets['at_date']; ?></td>
			<td><?php echo $meets['name']; ?></td>
			<td><?php echo $meets['short_name']; ?></td>
			<td><?php echo $meets['location']; ?></td>
			<td><?php echo (1 * $meets['start_frac_distance']) . '+' . (1 * $meets['lap_distance']) . 'km'; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('詳細'), array('controller' => 'meets', 'action' => 'view', $meets['code'])); ?>
				<?php echo $this->Html->link(__('編集'), array('controller' => 'meets', 'action' => 'edit', $meets['code'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'meets', 'action' => 'delete', $meets['code']), array(), __('[%s] のデータを削除してよろしいですか？', $meets['code'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Meets'), array('controller' => 'meets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
