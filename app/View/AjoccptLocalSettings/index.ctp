<div class="ajoccptLocalSettings index">
	<h2><?php echo __('Ajoccpt Local Settings'); ?></h2>
	<p>全レース対象となる AJOCC ポイントランキングとは別に一部のレースでの AJOCC ランキングを作りたい場合、つまり関東のレースだけとか、そういった設定のページです。</p>
	<p>Setting の項目は key1:val1,key2:val2,key3:val3 という形式で記述してください。key値に使用できるのは 以下のとおり。</p>
	<p>meet_group: 大会グループを限定します。</br>
		exclude_meet: 大会コード指定でその大会を除外します。</p>
	<p>入力例1）関東と湘南のみの場合 = meet_group:CXK/SHN</br>
		入力例2）CCH-178-003 を除外したランキングを作成する場合 = exclude_meet:CCH-178-003</br>
		入力例3）meet_group:CCH/TKI,exclude_meet:TKI-178-003</p>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('short_name'); ?></th>
			<th><?php echo $this->Paginator->sort('season_id'); ?></th>
			<th><?php echo $this->Paginator->sort('setting'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($ajoccptLocalSettings as $ajoccptLocalSetting): ?>
	<tr>
		<td><?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['id']); ?>&nbsp;</td>
		<td><?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['name']); ?>&nbsp;</td>
		<td><?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['short_name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ajoccptLocalSetting['Season']['name'], array('controller' => 'seasons', 'action' => 'view', $ajoccptLocalSetting['Season']['id'])); ?>
		</td>
		<td><?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['setting']); ?>&nbsp;</td>
		<td><?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['created']); ?>&nbsp;</td>
		<td><?php echo h($ajoccptLocalSetting['AjoccptLocalSetting']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ajoccptLocalSetting['AjoccptLocalSetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ajoccptLocalSetting['AjoccptLocalSetting']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ajoccptLocalSetting['AjoccptLocalSetting']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $ajoccptLocalSetting['AjoccptLocalSetting']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Ajoccpt Local Setting'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Seasons'), array('controller' => 'seasons', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Season'), array('controller' => 'seasons', 'action' => 'add')); ?> </li>
	</ul>
</div>
