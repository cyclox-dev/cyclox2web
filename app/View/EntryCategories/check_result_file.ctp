<div class="entryCategories">
	<h2><?php echo __('エントリー・リザルトデータのチェック'); ?></h2>
	<h3>タイトルに関するエラー</h3>
	
	<?php if (!empty($results['not_read_titles'])): ?>
	<?php 
		echo '<h4>以下のタイトルの行は読み込まれていません。</h4>';
		foreach ($results['not_read_titles'] as $title) {
			echo '<p>' . $title . '</p>';
		}
	?>
	<?php endif; ?>
	
	<?php if (!empty($results['title_errors'])): ?>
	<?php 
		foreach ($results['title_errors'] as $err) {
			echo '<h3>' . $err . '</h3>';
		}
	?>
	<?php endif; ?>
	
	<h3>検出された違いは以下のとおりです。</h3>
	<?php foreach ($results['racers'] as $result): ?>
	<h4>
		<?php 
			$code = isset($result['racer_code']) ? $result['racer_code'] : '新規選手';
			$name = isset($result['name']['error']) ? $result['name']['error']['original_val'] : (isset($result['name']) ? $result['name'] : '名前不明の選手');
			$birth = isset($result['birth_date']) ? $result['birth_date'] : '生年月日不明';
			echo 'BibNo.' . $result['body_number'] . ' ' . $name . ' [' . $code . '] Birth:' . $birth;
		?>
	</h4>
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
		<td><?php if(isset($result[$key]['error']['original_val'])) echo $result[$key]['error']['original_val']; ?></td>
		<td><?php 
			if ($key == 'name') {
				echo $result['original']['family_name'] . ' ' . $result['original']['first_name'];
			} else if ($runit->checks) {
				echo $result['original'][$key]; 
			}
		?></td>
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
	<?php if (!empty($result['cddts'])): ?>
	<t3>同じ名前の選手が存在します。</t3>
	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>選手コード</th>
				<th>姓</th>
				<th>名</th>
				<th>family_name</th>
				<th>first_name</th>
				<th>team</th>
				<th>birth</th>
				<th>UCI ID</th>
				<th>備考</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($result['cddts'] as $cddt): ?>
			<tr>
				<td><?php echo $cddt['Racer']['code']; ?></td>
				<td><?php echo $cddt['Racer']['family_name']; ?></td>
				<td><?php echo $cddt['Racer']['first_name']; ?></td>
				<td><?php echo $cddt['Racer']['family_name_en']; ?></td>
				<td><?php echo $cddt['Racer']['first_name_en']; ?></td>
				<td><?php echo $cddt['Racer']['team']; ?></td>
				<td><?php echo $cddt['Racer']['birth_date']; ?></td>
				<td><?php echo $cddt['Racer']['uci_id']; ?></td>
				<td><?php if ($cddt['Racer']['deleted']) echo '削除済み選手' ?></td>
			</tr>
		<?php endforeach; /* $result['cddts'] */ ?>
		</tbody>
	</table>
	<?php endif; ?>
	<?php endforeach; /* results */ ?>
</div>
	