<div class="entryCategories">
	<h2><?php echo __('エントリー・リザルトデータのチェック'); ?></h2>
	<p></p>
	<?php foreach ($results['racers'] as $result): ?>
	<h3>
		<?php 
			$code = isset($result['racer_code']) ? $result['racer_code'] : '新規選手';
			echo 'BibNo.' . $result['body_number'] . ' ' . $result['name'] . ' [' . $code . ']';
		?>
	</h3>
	<?php $finds = false; ?>
	<?php foreach ($results['runits'] as $runit): ?>
	<?php 
		$key = $runit->key;
		if ((!empty($result[$key]) && !empty($result['original'][$key]) && $result[$key] !== $result['original'][$key])
			|| !empty($result[$key]['error'])):
	?>
	<?php if (!$finds): ?>
	<?php
		$finds = true;
		
		echo '<table cellpadding="0" cellspacing="0">';
		echo '<thead><tr><th>種類</th><th>読み込んだ値</th><th>既存登録値</th><th>備考</th></thead><tbody>';
	?>
	<?php endif; /* $finds? */ ?>
	<tr>
		<td><?php echo $runit->title . ' (' . $runit->key . ')'; ?></td>
		<?php if (!empty($result[$key]['error'])): ?>
		<td></td>
		<td><?php if ($runit->checks) echo $result['original'][$key]; ?></td>
		<td><?php echo $result[$key]['error']['msg'] . '(' . $result[$key]['error']['pos'] . ')'; ?></td>
		<?php else: ?>
		<td><?php echo $result[$key]; ?></td>
		<td><?php echo $result['original'][$key]; ?></td>
		<td></td>
		<?php endif; ?>
	</tr>
	<?php endif; /* if (diff) */ ?>
	<?php endforeach; /* units */ ?>
	<?php if ($finds) echo '</tbody></table>'; ?>
	<?php endforeach; /* results */ ?>
</div>
	