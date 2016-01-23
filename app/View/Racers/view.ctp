<div class="racers view">
<h2><?php echo __('選手データ'); ?></h2>
	<dl>
		<dt><?php echo __('選手 Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('姓'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('名前'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('姓（カナ）'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name_kana']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('名前（カナ）'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['first_name_kana']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Family Name'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['first_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('チーム名'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['team']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('性別'); ?></dt>
		<dd>
			<?php
				App::uses('Gender', 'Cyclox/Const');
				echo h(Gender::genderAt($racer['Racer']['gender'])->express());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('生年月日'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['birth_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('国籍 (Nationality)'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['nationality_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('JCF Number'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['jcf_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uci Number'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['uci_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uci Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['uci_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('備考 (Note)'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['note']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>連絡先</h3>
	<dl>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['mail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('国'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['country_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('郵便番号 (Zip)'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['zip_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('都道府県 (Pref.)'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['prefecture']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('住所'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['address']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h(($racer['Racer']['deleted'] ? "Yes" : "No")); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('この選手データを編集'), array('action' => 'edit', $racer['Racer']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('この選手データを削除'), array('action' => 'delete', $racer['Racer']['code']), array(),
			__('この選手 [code:%s] を削除してよろしいですか？', $racer['Racer']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手リスト'), array('action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('カテゴリー所属'); ?></h3>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('カテゴリー所属を追加')
				, '/category_racers/add/' . $racer['Racer']['code']); ?> </li>
		</ul>
	</div>
	<?php if (!empty($racer['CategoryRacer'])):	?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('ID'); ?></th>
			<th><?php echo __('選手 Code'); ?></th>
			<th><?php echo __('Category Code'); ?></th>
			<th><?php echo __('所属開始日'); ?></th>
			<th><?php echo __('所属終了日'); ?></th>
			<th><?php echo __('適用タイプ'); ?></th>
			<th><?php echo __('関連リザルト ID'); ?></th>
			<th><?php echo __('関連大会 Code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php
			function compareAppDate($a, $b)
			{	
				if ($a['apply_date'] && $b['apply_date']) {
					if ($a['apply_date'] == $b['apply_date']) return 0;
					return ($a['apply_date'] < $b['apply_date']) ? 1 : -1;
				}
				if (!$a['apply_date']) {
					return -1;
				}
				if (!$b['apply_date']) {
					return 1;
				}
				return 0;
			}
			$sorted = usort($racer['CategoryRacer'], 'compareAppDate');
			foreach ($racer['CategoryRacer'] as $categoryRacer):
		?>
			<tr>
				<td><?php echo $categoryRacer['id']; ?></td>
				<td><?php echo $categoryRacer['racer_code']; ?></td>
				<td><?php echo $categoryRacer['category_code']; ?></td>
				<td><?php echo $categoryRacer['apply_date']; ?></td>
				<td><?php echo $categoryRacer['cancel_date']; ?></td>
				<td><?php
					App::uses('CategoryReason', 'Cyclox/Const');
					echo CategoryReason::reasonAt($categoryRacer['reason_id'])->name();
				?></td>
				<td><?php echo $categoryRacer['racer_result_id']; ?></td>
				<td><?php echo $categoryRacer['meet_code']; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'category_racers', 'action' => 'view', $categoryRacer['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'category_racers', 'action' => 'edit', $categoryRacer['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'category_racers', 'action' => 'delete', $categoryRacer['id']), array()
						, "【注意！！！】\n選手所属カテゴリー [ID:" . $categoryRacer['id'] . "] のデータを削除してよろしいですか？\n\n"
						. "リザルトの再アップロードなどでなれば、選手カテゴリー所属を削除することはまれです。\n"
								. '昇格や降格などで元のカテゴリー所属でなくなった場合には [Edit] から解消日を設定して下さい。'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
<?php if (!empty($entries)): ?>
<p style="height: 1em"></p>
<div class="related">
	<?php
		App::uses('Util', 'Cyclox/Util');
		App::uses('RacerEntryStatus', 'Cyclox/Const');
		App::uses('RacerResultStatus', 'Cyclox/Const');
	?>
	<h3><?php echo __('最近のエントリー／リザルト'); ?></h3>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('大会'); ?></th>
				<th><?php echo __('日付'); ?></th>
				<th><?php echo __('出走カテゴリー'); ?></th>
				<th><?php echo __('Entry'); ?></th>
				<th><?php echo __('順位'); ?></th>
				<th><?php echo __('周回数'); ?></th>
				<th><?php echo __('Time'); ?></th>
				<th><?php echo __('順位%'); ?></th>
				<th><?php echo __('AjoccPt'); ?></th>
				<th><?php echo __('残留Pt'); ?></th>
			</tr>
			<?php
				function compareResultDate($a, $b)
				{	
					if (empty($a['EntryCategory']['EntryGroup']['Meet']['at_date'])
							|| empty($b['EntryCategory']['EntryGroup']['Meet']['at_date'])) {
						return 0;
					}
					return ($a['EntryCategory']['EntryGroup']['Meet']['at_date'] < $b['EntryCategory']['EntryGroup']['Meet']['at_date']) ? 1 : -1;
				}
				$sorted = usort($entries, 'compareResultDate');
				
				$RESULT_MAX = 10;
				$resultCount = 0;
			?>
			<?php foreach ($entries as $entry): ?>
				<tr>
					<td><?php
						echo $this->Html->link(
								$entry['EntryCategory']['EntryGroup']['Meet']['short_name']
								, array('controller' => 'meets', 'action' => 'view', $entry['EntryCategory']['EntryGroup']['Meet']['code'])
						);
					?></td>
					<td><?php echo $entry['EntryCategory']['EntryGroup']['Meet']['at_date']; ?></td>
					<td><?php
						echo $this->Html->link(
								$entry['EntryCategory']['name']
								, array('controller' => 'entry_categories', 'action' => 'view', $entry['EntryCategory']['id'])
						); ?>
					</td>
					<td><?php echo RacerEntryStatus::ofVal($entry['EntryRacer']['entry_status'])->msg(); ?></td>
					<?php if (!empty($entry['RacerResult']['id'])): ?>
						<td><?php
							if (empty($entry['RacerResult']['rank'])) {
								echo RacerResultStatus::ofVal($entry['RacerResult']['rank'])->code();
							} else {
								echo $entry['RacerResult']['rank'];
							}
						?></td>
						<td><?php echo $entry['RacerResult']['lap']; ?></td>
						<td><?php
							if (empty($entry['RacerResult']['goal_milli_sec'])) {
								echo '---';
							} else {
								echo Util::milli2Time($entry['RacerResult']['goal_milli_sec']);
							}
						?></td>
						<td><?php echo $entry['RacerResult']['rank_per']; ?></td>
						<td><?php echo $entry['RacerResult']['ajocc_pt']; ?></td>
						<td><?php 
							$str = '';
							foreach ($entry['RacerResult']['HoldPoint'] as $hpt) {
								if (!empty($hpt['point'])) {
									if (!empty($str)) {
										$str .= ', ';
									}
									$str .= $hpt['point'] . 'pt/' . $hpt['category_code'];
								}
							}
							echo $str;
						?></td>
					<?php endif; ?>
				</tr>
				<?php
					++$resultCount;
					if ($resultCount >= $RESULT_MAX) break;
				?>
			<?php endforeach; ?>
		</table>
	<?php
		if ($entryCount > $resultCount) {
			echo $this->Html->link('全てのエントリー／リザルトを表示', array('controller' => 'racers', 'action' => 'results', $entry['EntryRacer']['racer_code']));
		} else {
			echo $this->Html->link('エントリー／リザルトを表示', array('controller' => 'racers', 'action' => 'results', $entry['EntryRacer']['racer_code']));
		}
	?>
</div>
<?php endif;
