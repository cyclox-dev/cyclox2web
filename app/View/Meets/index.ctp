<h1>大会一覧</h1>

<?php echo $this->Html->link(
	'新規大会の登録',
	array('controller' => 'meets', 'action' => 'add')
); ?>

<table>
    <tr>
        <th>Code</th>
        <th>大会名</th>
		<th>Action</th>
		<th>Created</th>
		<th>Modified</th>
    </tr>

    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($meets as $meet): ?>
		<tr>
			<td>
				<?php echo $this->Html->link($meet['Meet']['code'], array('controller' => 'meets', 'action' => 'view', $meet['Meet']['code'])); ?>
			</td>
			<td>
				<?php echo $this->Html->link($meet['Meet']['name'] . ' (' . $meet['Meet']['short_name'] . ')'
					, array('controller' => 'meets', 'action' => 'view', $meet['Meet']['code'])); ?>
			</td>
			<td>
				<?php echo $this->Html->link('Edit', array('action' => 'edit', $meet['Meet']['code'])); ?>
				<?php echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $meet['Meet']['code']),
					array('confirm' => '削除してよろしいですか？'));
				?>
			</td>
			<td><?php echo $meet['Meet']['created']; ?></td>
			<td><?php echo $meet['Meet']['modified']; ?></td>
		</tr>
    <?php endforeach; ?>
    <?php unset($meet); ?>
</table>