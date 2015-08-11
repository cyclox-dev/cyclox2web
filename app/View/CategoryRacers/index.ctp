<?php
App::uses('CategoryReason', 'Cyclox/Const');
?>
<div class="categoryRacers index">
	<h2><?php echo __('カテゴリー所属一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_code', '選手 Code'); ?></th>
			<th><?php echo $this->Paginator->sort('category_code'); ?></th>
			<th><?php echo $this->Paginator->sort('apply_date', '適用日'); ?></th>
			<th><?php echo $this->Paginator->sort('cancel_date', '解消日'); ?></th>
			<th><?php echo $this->Paginator->sort('reason_id', '適用タイプ'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_result_id', 'リザルト ID'); ?></th>
			<th><?php echo $this->Paginator->sort('meet_code', '関連大会 Code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categoryRacers as $categoryRacer): ?>
	<tr>
		<td><?php echo h($categoryRacer['CategoryRacer']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($categoryRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $categoryRacer['Racer']['code'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($categoryRacer['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoryRacer['Category']['code'])); ?>
		</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['apply_date']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['cancel_date']); ?>&nbsp;</td>
		<td><?php
			echo CategoryReason::reasonAt($categoryRacer['CategoryRacer']['reason_id'])->name();
		?></td>
		<td><?php echo h($categoryRacer['CategoryRacer']['racer_result_id']); ?>&nbsp;</td>
		<td><?php echo h($categoryRacer['CategoryRacer']['meet_code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $categoryRacer['CategoryRacer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $categoryRacer['CategoryRacer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $categoryRacer['CategoryRacer']['id'])
				, array('confirm' => 'カテゴリー所属 [ID:' . $categoryRacer['CategoryRacer']['id'] . "] のデータを削除してよろしいですか？\n解消の場合には編集画面で解消日を設定して下さい。")); ?>
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
		<li><?php echo $this->Html->link(__('カテゴリー所属を追加'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('> カテゴリーリスト'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手リスト'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手データを追加'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
