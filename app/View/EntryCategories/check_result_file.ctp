<div class="entryCategories check_result">
	<?php App::uses('Gender', 'Cyclox/Const'); ?>
	<h1><?php echo __('エントリー・リザルトデータのチェック'); ?></h1>
	<p>
		注意：この処理により、選手データ（名前など）は今回読み込んだ値により書き変わります。</br>
		（UCI ID 及び生年月日は上書きされません。）
	</p>
	<p>選手コードプレフィクスは <?php echo h($results['rcode_prefix']); ?> です。</p>
	<p>
		新規選手に払い出される選手コード末尾番号の範囲は<?php echo h($results['rcode_range'][0] . '〜' . $results['rcode_range'][1]); ?>です。</br>
		Cyclox2Application の設定と重複していないよう、確認してください。
	</p>
	<p><?php // hidden 出力時にエラーになるため仮の値を入れておく
		echo '出走人数（OPN除く）: ';
		if ($results['started'] === false) {
			echo 'エラーがあるためカウント不可能でした。';
		} else {
			echo h($results['started']) . '人';
		}
	?></p>
	
	<?php $haserr = false; ?>
	
	<h2>タイトルに関するエラー・警告</h2>
	
	<?php
		if (!empty($results['title_errors'])){
			foreach ($results['title_errors'] as $err) {
				echo '<p>' . h($err) . '</p>';
				$haserr = true;
			}
		} else {
			echo '<p>エラーはありません。</p>';
		}
	?>
	<?php
		if (!empty($results['title_warns'])){
			foreach ($results['title_warns'] as $err) {
				echo '<p>' . h($err) . '</p>';
			}
		}
	?>
	
	<?php
		if (!empty($results['not_read_titles'])) {
			echo '<h4>※以下のタイトルの行は読み込まれていません。</h4>';
			foreach ($results['not_read_titles'] as $title) {
				echo '<p>' . h($title) . '</p>';
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
			} else { // TODO: else if isset('name_en' ?
				if (isset($result['name']['val'])) {
					$name = $result['name']['val'];
				} else {
					if (empty($result['family_name']['val'])) {
						$fam = empty($result['family_name_en']['val']) ? '？' : $result['family_name_en']['val'];
					} else {
						$fam = $result['family_name']['val'];
					}
					if (empty($result['first_name']['val'])) {
						$fir = empty($result['first_name_en']['val']) ? '？' : $result['first_name_en']['val'];
					} else {
						$fir = $result['first_name']['val'];
					}
					
					$name = $fam . ' ' . $fir;
				}
			}
			
			$birth = isset($result['birth_date']['val']) ? $result['birth_date']['val'] . ' 生まれ' : '生年月日不明';
			echo h('読込値 Bib.' . $bib . ' ' . $name . ' [' . $code . '] ' . $birth);
		?>
	</h3>
	<p>
		<?php
			if (isset($result['racer_code']['val'])) {
				echo h($result['racer_code']['val'] . 'の既存の名前: ' . $result['original']['family_name'] . ' ' . $result['original']['first_name']);
			}
		?>
	</p>
	<?php
		if (empty($result['racer_code']['val']) && empty($result['name']['val'])) {
			echo '<p>[Error] 新規選手には日本語の選手名 (family_name + first_name or name) が必要です。</p>';
			$haserr = true;
		}
	?>
	<div class="diff_tables">
		<?php $finds = false; ?>
		<?php foreach ($results['runits'] as $runit): ?>
		<?php
			if (!empty($result['racer_code']['original']) && isset($result['original']['error']['racer_code'])) {
				$haserr = true;
				echo '<p>[Error] ' . h($result['original']['error']['racer_code']) . '</p>';
				break;
			}
		?>
		<?php
			$key = $runit->key;
			
			$vis_empty = false;
			if (isset($result[$key]['val'])) {
				$kval = $result[$key]['val'];
				if ($kval === "" || $kval === null) {
					$vis_empty = true;
				}
			} else {
				$vis_empty = true;
			}
			
			$ois_empty = false;
			if (!$vis_empty) {
				if (isset($result['original'][$key])) {
					$oval = $result['original'][$key];
					if ($oval === "" || $oval === null || ($key === 'gender' && $oval == Gender::$UNASSIGNED->val())) {
						$ois_empty = true;
					}
				} else {
					$ois_empty = true;
				}
			}
			
			/*
			if (!$vis_empty && !$ois_empty) {
				$this->log('val:' . print_r($result[$key]['val'], true) . ' original:' . print_r($result['original'][$key], true) . ']'
					. ' diff?' . print_r(($kval === $oval), true) . ' diff?' . print_r(($kval == $oval), true)
					. ' type:' . gettype($kval) . ' vs ' . gettype($oval), LOG_DEBUG);
			}//*/
			
			if ((!$vis_empty && !$ois_empty && $kval != $oval)
				|| !empty($result[$key]['error'])):
		?>
		<?php if (!$finds): ?>
		<?php
			$finds = true;
			$rcode = isset($result['racer_code']['val']) ? '(' . $result['racer_code']['val'] . ')' : '';
			echo '<table cellpadding="0" cellspacing="0">';
			echo '<thead><tr><th>データ(title name)</th><th>読み込んだ値</th><th>既存値' . h($rcode) . '</th><th>備考</th></thead><tbody>';
		?>
		<?php endif; /* $finds? */ ?>
		<tr>
			<td><?php echo $runit->title . ' (' . $runit->key . ')'; ?></td>
			<?php if (!empty($result[$key]['error'])): ?>
				<?php $haserr = true; ?>
				<td><?php
					if (isset($result[$key]['valexp'])) echo $result[$key]['valexp'];
					else if (isset($result[$key]['original'])) echo h($result[$key]['original']);
				?></td>
				<td><?php 
					if ($key == 'name') {
						echo h($result['original']['family_name'] . ' ' . $result['original']['first_name']);
					} else if ($runit->checks) {
						echo isset($result['original'][$key]) ? h($result['original'][$key]) : '';
					}
				?></td>
				<td><?php
					$pos = empty($result[$key]['pos']) ? '' : '(' . $result[$key]['pos'] . ')';
					echo h('[Error] ' . $result[$key]['error'] . $pos);
				?></td>
			<?php else: ?>
				<td><?php 
					if (isset($result[$key]['valexp'])) {
						echo h($result[$key]['valexp']); 
					} else {
						echo h($result[$key]['val']); 
					}
				?></td>
				<td><?php
					if ($key == 'gender') {
						echo (Gender::genderAt($result['original'][$key]))->charExp();
					} else {
						echo isset($result['original'][$key]) ? h($result['original'][$key]) : '';
					}
				?></td>
				<td></td>
			<?php endif; ?>
		</tr>
		<?php endif; /* if (diff) */ ?>
		<?php endforeach; /* units */ ?>
		<?php
			if ($finds) {
				echo '</tbody></table>';
			} else if (!empty($result['racer_code']['val'])) {
				echo '<h4>既存データと異なるデータ値はありません。</h4>';
			}
		?>
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
					<td><?php echo h($cddt['Racer']['code']); ?></td>
					<td><?php echo h($cddt['Racer']['family_name']); ?></td>
					<td><?php echo h($cddt['Racer']['first_name']); ?></td>
					<td><?php echo h($cddt['Racer']['family_name_en']); ?></td>
					<td><?php echo h($cddt['Racer']['first_name_en']); ?></td>
					<td><?php echo h($cddt['Racer']['team']); ?></td>
					<td><?php echo h($cddt['Racer']['birth_date']); ?></td>
					<td><?php echo h($cddt['Racer']['uci_id']); ?></td>
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
		
		echo $this->Form->create('EntryRacer', array('type' => 'post', 'url'=>'/entry_categories/write_results/' . $ecat_id));
		
		$self = $this;
		$puthid = function($index, $key, $val) use ($self) {
			echo $self->Form->hidden('EntryRacer.' . $index . '.' . $key, array('value' => h($val)));
		};
		
		$i = 0;
		foreach ($results['racers'] as $result)
		{
			$puthid($i, 'entry_category_id', $ecat_id);
			
			if (!empty($result['racer_code']['val'])) {
				$puthid($i, 'racer_code',  $result['racer_code']['val']);
			}
			
			$puthid($i, 'body_number', $result['body_number']['val']);
			
			if (empty($result['name']['val'])) {
				if (!empty($result['original'])) {
					$nar = $result['original']['family_name'] . ' ' . $result['original']['first_name'];
				} else {
					$nar = empty($result['name_en']['val']) ? '名前未入力' : $result['name_en']['val'];
				}
			} else {
				$nar =  $result['name']['val'];
			}
			$puthid($i, 'name_at_race', $nar);
			
			if (empty($result['name_en']['val'])) {
				if (!empty($result['original']) && !empty($result['original']['family_name_en']) && !empty($result['original']['first_name_en'])) {
					$nar = $result['original']['family_name_en'] . ' ' . $result['original']['first_name_en'];
				} else {
					$nar = '名前未入力';
				}
			} else {
				$nar = $result['name_en']['val'];
			}
			$puthid($i, 'name_en_at_race', $nar);
			
			$puthid($i, 'checks_in', 1);
			
			$puthid($i, 'entry_status', $result['entry_status']['val']->val());
			
			if (isset($result['team']['val'])) {
				$puthid($i, 'team_name', $result['team']['val']);
			} else if (!empty($result['original']['team'])) {
				$puthid($i, 'team_name', $result['original']['team']);
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
			
			$puthid($i, 'RacerResult.' . 'as_category', $result['as_category']);
			
			$i++;
		}
		
		$puthid = function($index, $key, $val) use ($self) {
			echo $self->Form->hidden('Racer.' . $index . '.' . $key, array('value' => h($val)));
		};
		
		// TODO: 以下、変更の有無に関係なく書き換える要素を配置している。できれば有無を見るべし。
		
		$i = 0;
		foreach ($results['racers'] as $result)
		{
			if (!empty($result['racer_code']['val'])) {
				$puthid($i, 'code', $result['racer_code']['val']);
				// racer code empty の場合には保存時に新しい選手コードを付加する。
			}
			
			$ky = 'family_name';	if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'first_name';	if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			
			$ky = 'family_name_kana';	if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'first_name_kana';	if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'family_name_en';		if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			$ky = 'first_name_en';		if (!empty($result[$ky]['val'])) $puthid($i, $ky, $result[$ky]['val']);
			
			$ky = 'team';		if (isset($result[$ky]['val'])) { $puthid($i, $ky, $result[$ky]['val']); }
			$ky = 'gender';		if (isset($result[$ky]['val'])) { $puthid($i, $ky, $result[$ky]['val']); }
			
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
	