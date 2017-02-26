<div class="nameChangeLogs index">
	<h2><?php echo __('選手名変更ログ'); ?></h2>
	<p>
		Cyclox2 App のデータアップロードにより選手名が変更された場合、以下のログとして記録されます。<br>
		変更前のデータについては各データの[詳細]から確認できます。<br>
		※もし「ログを参考にして選手データを修正した」時は、ログごとの Note にその旨を記載しておいて下さい。<br>
		※Cyclox2 Web 上での選手データ書き換えについては記録していません。
	</p>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('racer_code', '選手コード'); ?></th>
			<th><?php echo $this->Paginator->sort('new_fam', '変更後の姓'); ?></th>
			<th><?php echo $this->Paginator->sort('new_fir', '変更後の名前'); ?></th>
			<th><?php echo $this->Paginator->sort('by_user', '変更者'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th><?php echo $this->Paginator->sort('created', '名前が書き換わった日時'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($nameChangeLogs as $nameChangeLog): ?>
	<tr>
		<td><?php echo h($nameChangeLog['NameChangeLog']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($nameChangeLog['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $nameChangeLog['Racer']['code'])); ?>
		</td>
		<td><?php
			$name = $nameChangeLog['NameChangeLog']['new_fam'];
			if (empty($name)) $name = '[変更なし]';
			echo h($name);
		?>&nbsp;</td>
		<td><?php
			$name = $nameChangeLog['NameChangeLog']['new_fir'];
			if (empty($name)) $name = '[変更なし]';
			echo h($name);
		?>&nbsp;</td>
		<td><?php echo h($nameChangeLog['NameChangeLog']['by_user']); ?>&nbsp;</td>
		<td><?php echo h($nameChangeLog['NameChangeLog']['note']); ?>&nbsp;</td>
		<td><?php echo h($nameChangeLog['NameChangeLog']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $nameChangeLog['NameChangeLog']['id'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $nameChangeLog['NameChangeLog']['id'])); ?>
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
