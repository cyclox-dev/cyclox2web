<div class="entryCategories check_result">
	<h1><?php echo __('エントリー・リザルトデータのチェック'); ?></h1>
	<p>
		注意：この処理により、選手データ（名前など）は今回読み込んだ値により書き変わります。</br>
		（UCI ID 及び生年月日は上書きされません。）
	</p>
	<p>選手コードプレフィクスは <?php echo $results['rcode_prefix']; ?> です。</p>
	<p>
		新規選手に払い出される選手コード末尾番号の範囲は<?php echo $results['rcode_range'][0] . '〜' . $results['rcode_range'][1] ?>です。</br>
		Cyclox2Application の設定と重複していないよう、確認してください。
	</p>
	<p><?php // hidden 出力時にエラーになるため仮の値を入れておく
		echo '出走人数（OPN除く）: ';
		if ($results['started'] === false) {
			echo 'エラーがあるためカウント不可能でした。';
		} else {
			echo $results['started'] . '人';
		}
	?></p>
	
	<?php $haserr = false; ?>
	
	<h2>タイトルに関するエラー・警告</h2>
	
	<?php
		if (!empty($results['title_errors'])){
			foreach ($results['title_errors'] as $err) {
				echo '<p>' . $err . '</p>';
				$haserr = true;
			}
		}
	?>
	<?php
		if (!empty($results['title_warns'])){
			foreach ($results['title_warns'] as $err) {
				echo '<p>' . $err . '</p>';
			}
		}
	?>
	
	<?php
		if (!empty($results['not_read_titles'])) {
			echo '<h4>※以下のタイトルの行は読み込まれていません。</h4>';
			foreach ($results['not_read_titles'] as $title) {
				echo '<p>' . $title . '</p>';
			}
		}
	?>
	
	<h2>検出された違いは以下のとおりです。</h2>
	<?php foreach ($results['racers'] as $result): ?>
	<h3>
		<?php 
			if (isset($result['body_number']['error'])) {
				$bib = isset($result['body_number']['error']);
			} else {
				$bib = isset($result['body_number']['val']) ? $result['body_number']['val'] : '（No.無し）';
			}
			
			$code = isset($result['racer_code']['val']) ? $result['racer_code']['val'] : '新規選手';
			
			if (isset($result['name']['error'])) {
				$name = $result['name']['original'];
			} else {
				if (isset($result['name']['val'])) {
					$name = $result['name']['val'];
				} else {
					$fam = (empty($result['family_name']['val'])) ? '？' : $result['family_name']['val'];
					$fir = (empty($result['first_name']['val'])) ? '？' : $result['first_name']['val'];
					$name = $fam . ' ' . $fir;
				}
			}
			
			$birth = isset($result['birth_date']['val']) ? $result['birth_date']['val'] : '生年月日不明';
			echo 'Bib.' . $bib . ' ' . $name . ' [' . $code . '] ' . $birth . ' 生まれ';
		?>
	</h3>
	<div class="diff_tables">
		<?php $finds = false; ?>
		<?php foreach ($results['runits'] as $runit): ?>
		<?php
			if (!empty($result['racer_code']['original']) && isset($result['original']['error']['racer_code'])) {
				$haserr = true;
				echo '<p>[Error] ' . $result['original']['error']['racer_code'] . '</p>';
				break;
			}
		?>
		<?php
			$key = $runit->key;
			if ((!empty($result[$key]['val']) && !empty($result['original'][$key]) && $result[$key]['val'] !== $result['original'][$key])
				|| !empty($result[$key]['error'])):
		?>
		<?php if (!$finds): ?>
		<?php
			$finds = true;
			$rcode = isset($result['racer_code']['val']) ? '(' . $result['racer_code']['val'] . ')' : '';
			echo '<table cellpadding="0" cellspacing="0">';
			echo '<thead><tr><th>データ(title name)</th><th>読み込んだ値</th><th>既存値' . $rcode . '</th><th>備考</th></thead><tbody>';
		?>
		<?php endif; /* $finds? */ ?>
		<tr>
			<td><?php echo $runit->title . ' (' . $runit->key . ')'; ?></td>
			<?php if (!empty($result[$key]['error'])): ?>
				<?php $haserr = true; ?>
				<td><?php
					if (isset($result[$key]['valexp'])) echo $result[$key]['valexp'];
					else if (isset($result[$key]['original'])) echo $result[$key]['original'];
				?></td>
				<td><?php 
					if ($key == 'name') {
						echo $result['original']['family_name'] . ' ' . $result['original']['first_name'];
					} else if ($runit->checks) {
						echo isset($result['original'][$key]) ?$result['original'][$key] : '';
					}
				?></td>
				<td><?php echo '[Error] ' . $result[$key]['error'] . '(' . $result[$key]['pos'] . ')'; ?></td>
			<?php else: ?>
				<td><?php 
					if (isset($result[$key]['valexp'])) {
						echo $result[$key]['valexp']; 
					} else {
						echo $result[$key]['val']; 
					}
				?></td>
				<td><?php
					if ($key == 'gender') {
						echo (Gender::genderAt($result['original'][$key]))->charExp();
					} else {
						echo isset($result['original'][$key]) ? $result['original'][$key] : '';
					}
				?></td>
				<td></td>
			<?php endif; ?>
		</tr>
		<?php endif; /* if (diff) */ ?>
		<?php endforeach; /* units */ ?>
		<?php if ($finds) echo '</tbody></table>'; ?>
		<?php if (!empty($result['cddts'])): ?>
		<h4>同じ名前の選手が存在します。</h4>
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
	</div>
	<?php endforeach; /* results */ ?>
	<?php if (!$haserr): ?>
	<?php 
		App::uses('Gender', 'Cyclox/Const');
		
		echo $this->Form->create('EntryRacer', array('type' => 'post', 'url'=>'/entry_categories/write_results/' . $ecat_id));
		
		$self = $this;
		$puthid = function($index, $key, $val) use ($self) {
			echo $self->Form->hidden('EntryRacer.' . $index . '.' . $key, array('value' => $val));
		};
		
		$i = 0;
		foreach ($results['racers'] as $result)
		{
			$puthid($i, 'entry_category_id', $ecat_id);
			
			if (!empty($result['racer_code']['val'])) {
				$puthid($i, 'racer_code',  $result['racer_code']['val']);
			}
			
			$puthid($i, 'body_number', $result['body_number']['val']);
			$puthid($i, 'name_at_race', $result['name']['val']);
			// TODO: fill name_en_at_race, kana
			$puthid($i, 'checks_in', 1);
			
			$puthid($i, 'entry_status', $result['entry_status']['val']->val());
			
			if (isset($result['team']['val'])) {
				$puthid($i, 'team_name', $result['team']['val']);
			}
			$puthid($i, 'note', 'from web result read.');
			
			// リザルトパラメタ
			$puthid($i, 'RacerResult.' . 'order_index', $i+1);
			$puthid($i, 'RacerResult.' . 'status', $result['result_status']['val']->val());
			
			if (isset($result['rank']['val'])) {
				$puthid($i, 'RacerResult.' . 'rank', $result['rank']['val']);
			}
			
			$lap = empty($result['lap']['val']) ? 0 : $result['lap']['val']; // TODO: start-loop ありの場合には -1 設定？
			$puthid($i, 'RacerResult.' . 'lap', $lap);
			
			if (!empty($result['goal_time']['val'])) $puthid($i, 'RacerResult.' . 'goal_milli_sec', $result['goal_time']['val']);
			
			if (isset($result['rank_per'])) {
				$puthid($i, 'RacerResult.' . 'rank_per', $result['rank_per']);
			}
			
			if (isset($result['run_per'])) {
				$puthid($i, 'RacerResult.' . 'run_per', $result['run_per']);
			}
			
			// as_category は ResultParamCalc->asCategory() で自前設定する。
			
			$i++;
		}
		
		$puthid = function($index, $key, $val) use ($self) {
			echo $self->Form->hidden('Racer.' . $index . '.' . $key, array('value' => $val));
		};
		
		// TODO: 以下、変更の有無に関係なく書き換える要素を配置している。できれば有無を見るべし。
		
		$i = 0;
		foreach ($results['racers'] as $result)
		{
			if (!empty($result['racer_code']['val'])) {
				$puthid($i, 'code', $result['racer_code']['val']);
				// racer code empty の場合には保存時に新しい選手コードを付加する。
			}
			
			$puthid($i, 'family_name', $result['family_name']['val']);
			$puthid($i, 'first_name', $result['first_name']['val']);
			
			$ky = 'family_name_kana';	if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'first_name_kana';	if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'family_name_en';		if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'first_name_en';		if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			
			$ky = 'team';		if (isset($result[$ky]['val'])) { $puthid($i, $ky, $result[$ky]['val']); }
			
			$ky = 'gender';
			if (isset($result[$ky]['val'])) {
				$puthid($i, $ky, $result[$ky]['val']->val());
			} else {
				$puthid($i, $ky, Gender::$UNASSIGNED->val());
			}
			
			$ky = 'birth_date';		if (isset($result[$ky]['val'])) { $puthid($i, $ky, $result[$ky]['val']); }
			$ky = 'category_code';	if (isset($result[$ky]['val'])) { $puthid($i, $ky, $result[$ky]['val']); }
			
			$ky = 'uci_id';			if (isset($result[$ky]['val'])) { $puthid($i, $ky, $result[$ky]['val']); }
			
			$i++;
		}
			
		echo $this->Form->submit(__('Upload'));
		echo $this->Form->end(); 
	?>
	<?php else: /* !haserr */ ?>
	<p>上に記述されているエラーを修正し、再度読み込みし直してください。</br>エラー箇所についてはこのページ内で "Error" を検索してください。</p>
	<?php endif; /* !haserr */ ?> 
</div>
	