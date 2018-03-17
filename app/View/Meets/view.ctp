<div class="meets view">
<h2><?php echo __('大会データ'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('大会 Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($meet['MeetGroup']['name'], array('controller' => 'meet_groups', 'action' => 'view', $meet['MeetGroup']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Season'); ?></dt>
		<dd>
			<?php echo $this->Html->link($meet['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $meet['Season']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('開催日'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['at_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('大会名'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('開催地'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('主催'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['organized_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homepage'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['homepage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('スタート端数距離 (km)'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['start_frac_distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('周回距離 (km)'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['lap_distance']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h(($meet['Meet']['deleted'] ? "Yes" : "No")); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($meet['Meet']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('この大会を編集'), array('action' => 'edit', $meet['Meet']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('この大会を削除'), array('action' => 'delete', $meet['Meet']['code']), array(), __('[%s] のデータを削除してよろしいですか？', $meet['Meet']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会リスト'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会を追加'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> シーズンリスト'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> シーズンを追加'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループリスト'), array('controller' => 'meet_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 大会グループを追加'), array('controller' => 'meet_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループリスト'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループを追加'), array('controller' => 'entry_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('出走カテゴリー'); ?></h3>
	<?php if (!empty($meet['EntryCategory'])): ?>
		<?php App::uses('LapOutRule', 'Cyclox/Const'); ?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('出走カテゴリー名'); ?></th>
				<th><?php echo __('レースカテゴリー'); ?></th>
				<th><?php echo __('スタート計測遅延(sec)'); ?></th>
				<th><?php echo __('ラップアウト処理'); ?></th>
				<th><?php echo __('出走グループ'); ?></th>
				<th><?php echo __('更新日時'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		<?php foreach ($meet['EntryCategory'] as $entryCategory): ?>
			<tr>
				<td><?php echo h($entryCategory['name']); ?></td>
				<td><?php echo h($entryCategory['races_category_code']); ?></td>
				<td><?php echo h($entryCategory['start_delay_sec']); ?></td>
				<td><?php echo h(LapOutRule::ofVal($entryCategory['lapout_rule'])->expressJp()); ?></td>
				<td><?php echo h($entryCategory['entry_group_id']); ?></td>
				<td><?php echo h($entryCategory['modified']); ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'entry_categories', 'action' => 'view', $entryCategory['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'entry_categories', 'action' => 'edit', $entryCategory['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_categories', 'action' => 'delete', $entryCategory['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryCategory['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
<?php if (!empty($meet['EntryGroup'])): ?>
	<div class="related">
		<p style="height: 1em"></p>
		<h3><?php echo __('出走グループ'); ?></h3>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Start Clock'); ?></th>
				<th><?php echo __('Start Frac Distance'); ?></th>
				<th><?php echo __('Lap Distance'); ?></th>
				<th><?php echo __('計測Skip回数'); ?></th>
				<th><?php echo __('更新日時'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($meet['EntryGroup'] as $entryGroup): ?>
			<tr>
				<td><?php echo h($entryGroup['id']); ?></td>
				<td><?php echo h($entryGroup['name']); ?></td>
				<td><?php echo h($entryGroup['start_clock']); ?></td>
				<td><?php echo h($entryGroup['start_frac_distance']); ?></td>
				<td><?php echo h($entryGroup['lap_distance']); ?></td>
				<td><?php echo h($entryGroup['skip_lap_count']); ?></td>
				<td><?php echo h($entryGroup['modified']); ?></td>
				<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'entry_groups', 'action' => 'view', $entryGroup['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('controller' => 'entry_groups', 'action' => 'edit', $entryGroup['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_groups', 'action' => 'delete', $entryGroup['id']),
								array(), __('[%s] のデータを削除してよろしいですか？', $entryGroup['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
<?php endif; ?>
<?php if (!empty($results)): ?>
	<div class="related">
		<p style="height: 1em"></p>
		<h3><?php echo __('カテゴリー適用（リザルトによる昇格）'); ?></h3>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('ID'); ?></th>
			<th><?php echo __('選手 Code'); ?></th>
			<th><?php echo __('名前'); ?></th>
			<th><?php echo __('昇格先カテゴリー'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($results as $result): ?>
			<tr>
				<td><?php echo h($result['CategoryRacer']['id']); ?></td>
				<td><?php echo $this->Html->link($result['CategoryRacer']['racer_code'], array('controller' => 'racers', 'action' => 'view', $result['CategoryRacer']['racer_code'])); ?></td>
				<td><?php echo h($result['Racer']['family_name'] . ' ' . $result['Racer']['first_name']); ?></td>
				<td><?php echo h($result['Category']['name']); ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'category_racers', 'action' => 'view', $result['CategoryRacer']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'category_racers', 'action' => 'edit', $result['CategoryRacer']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'category_racers', 'action' => 'delete', $result['CategoryRacer']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $result['CategoryRacer']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
</div>
<?php endif; ?>
