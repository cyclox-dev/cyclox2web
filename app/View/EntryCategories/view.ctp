<div class="entryCategories view">
<h2><?php echo __('出走カテゴリー'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('出走グループ'); ?></dt>
		<dd>
			<?php echo $this->Html->link(h($entryCategory['EntryGroup']['name']), array('controller' => 'entry_groups', 'action' => 'view', h($entryCategory['EntryGroup']['id']))); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('大会'); ?></dt>
		<dd>
			<?php echo $this->Html->link(h($entryCategory['EntryGroup']['meet_code']), array('controller' => 'meets', 'action' => 'view', h($entryCategory['EntryGroup']['meet_code']))); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('レースカテゴリー'); ?></dt>
		<dd>
			<?php echo $this->Html->link(h($entryCategory['RacesCategory']['name']), array('controller' => 'races_categories', 'action' => 'view', h($entryCategory['RacesCategory']['code']))); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('出走カテゴリー名'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('計測遅延(sec)'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['start_delay_sec']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ラップアウト処理'); ?></dt>
		<dd>
			<?php 
				App::uses('LapOutRule', 'Cyclox/Const');
				echo h(LapOutRule::ofVal($entryCategory['EntryCategory']['lapout_rule'])->expressJp());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('残留ポイント'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['applies_hold_pt'] ? '付与する' : '付与しない'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('リザルトによる昇格'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['applies_rank_up'] ? 'あり' : '無し'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('AJOCC ポイント'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['applies_ajocc_pt'] ? '付与する' : '付与しない'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['note']); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h(($entryCategory['EntryCategory']['deleted'] ? "Yes" : "No")); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('この出走カテゴリーを編集'), array('action' => 'edit', $entryCategory['EntryCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('この出走カテゴリーを削除'), array('action' => 'delete', $entryCategory['EntryCategory']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryCategory['EntryCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走カテゴリーリスト'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走カテゴリーを追加'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走グループリスト'), array('controller' => 'entry_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> レースカテゴリーリスト'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 出走選手リスト'), array('controller' => 'entry_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('◆◆◆ リザルト読込 ◆◆◆'), array('controller' => 'entry_categories', 'action' => 'select_result_file', $entryCategory['EntryCategory']['id'])
					, array('confirm' => __("既存の出走データ・リザルトは削除されますがよろしいですか？"))); ?></li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('出走選手一覧'); ?></h3>
	<?php if (!empty($entryCategory['EntryRacer'])): ?>
		<?php App::uses('RacerEntryStatus', 'Cyclox/Const'); ?>
		<?php App::uses('RacerResultStatus', 'Cyclox/Const'); ?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('BodyNo.'); ?></th>
				<th><?php echo __('選手 Code'); ?></th>
				<th><?php echo __('出走選手名'); ?></th>
				<th><?php echo __('カナ名'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('出走 Status'); ?></th>
				<th><?php echo __('チーム名'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($entryCategory['EntryRacer'] as $entryRacer): ?>
				<tr>
					<td><?php echo h($entryRacer['EntryRacer']['id']); ?></td>
					<td><?php echo h($entryRacer['EntryRacer']['body_number']); ?></td>
					<td><?php echo $this->Html->link($entryRacer['EntryRacer']['racer_code'], array('controller' => 'racers', 'action' => 'view', $entryRacer['EntryRacer']['racer_code'])); ?></td>
					<td><?php echo h($entryRacer['EntryRacer']['name_at_race']); ?></td>
					<td><?php echo h($entryRacer['EntryRacer']['name_kana_at_race']); ?></td>
					<td><?php echo h($entryRacer['EntryRacer']['name_en_at_race']); ?></td>
					<td><?php echo h(RacerEntryStatus::ofVal($entryRacer['EntryRacer']['entry_status'])->msg()); ?></td>
					<td><?php echo h($entryRacer['EntryRacer']['team_name']); ?></td>
					<td class="actions">
						<?php echo $this->Html->link('詳細', array('controller' => 'entry_racers', 'action' => 'view', $entryRacer['EntryRacer']['id'])); ?>
						<?php /*echo $this->Html->link(__('Edit'), array('controller' => 'entry_racers', 'action' => 'edit', $entryRacer['EntryRacer']['id']));//*/ ?>
						<?php /*echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_racers', 'action' => 'delete', $entryRacer['EntryRacer']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryRacer['EntryRacer']['id']));//*/ ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
<div class="related">
	<?php if (!empty($results)): ?>
	<p style="height: 1em"></p>
	<h3><?php echo __('リザルト'); ?></h3>
	<div><?php echo $this->Form->postLink(__('リザルトを再計算する'), array('controller' => 'entry_categories', 'action' => 'recalc_result', $entryCategory['EntryCategory']['id'])
				, array(), __("この出走カテゴリーに紐づく\n+ 昇格\n+ シリーズポイント\n+ 残留ポイント\nを再計算してよろしいですか？\n（現在の昇格やポイントは削除されます。）")); ?></div>
		<?php App::uses('Util', 'Cyclox/Util'); ?>
		<?php App::uses('RacerEntryStatus', 'Cyclox/Const'); ?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('順位'); ?></th>
				<th><?php echo __('Status'); ?></th>
				<th><?php echo __('BodyNo.'); ?></th>
				<th><?php echo __('選手 Code'); ?></th>
				<th><?php echo __('出走選手名'); ?></th>
				<th><?php echo __('周回数'); ?></th>
				<th><?php echo __('ゴールTime'); ?></th>
				<th><?php echo __('順位%'); ?></th>
				<th><?php echo __('走行%'); ?></th>
				<?php foreach ($psTitles as $psTitle) :?>
					<th><?php echo $this->Html->link($psTitle['name'], array('controller' => 'point_series', 'action' => 'view', $psTitle['id'])); ?></th>
				<?php endforeach; ?>
				<th><?php echo __('AjoccPt'); ?></th>
				<?php if ($holdPointCount > 0): ?>
					<th><?php echo __('残留Pt'); ?></th>
				<?php endif; ?>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($results as $result): ?>
				<tr>
					<td><?php echo h($result['RacerResult']['id']); ?></td>
					<td><?php 
						if (RacerEntryStatus::ofVal($result['EntryRacer']['entry_status']) == RacerEntryStatus::$OPEN) {
							echo h(RacerEntryStatus::$OPEN->msg());
						} else {
							echo h($result['RacerResult']['rank']);
						}
					?></td>
					<td><?php echo h(RacerResultStatus::ofVal($result['RacerResult']['status'])->code()); ?></td>
					<td><?php echo h($result['EntryRacer']['body_number']); ?></td>
					<td><?php echo $this->Html->link($result['EntryRacer']['racer_code'], array('controller' => 'racers', 'action' => 'view', $result['EntryRacer']['racer_code'])); ?></td>
					<td><?php echo h($result['EntryRacer']['name_at_race']); ?></td>
					<td><?php
						$isDns = RacerResultStatus::ofVal($result['RacerResult']['status'])->val() === RacerResultStatus::$DNS->val();
						echo h($isDns ? '' : $result['RacerResult']['lap']); ?>
					</td>
					<td><?php 
						if (empty($result['RacerResult']['goal_milli_sec'])) {
							echo '---';
						} else {
							echo h(Util::milli2Time($result['RacerResult']['goal_milli_sec']));
						}
					?></td>
					<td><?php echo is_null($result['RacerResult']['rank_per']) ? '--' : h($result['RacerResult']['rank_per'] . '%'); ?></td>
					<td><?php echo is_null($result['RacerResult']['run_per']) ? '--' : h((1 * $result['RacerResult']['run_per']) . '%'); ?></td>
					<?php for ($i = 0; $i < count($psTitles); $i++): ?>
						<td><?php
							if (empty($result['RacerResult']['points'][$i])) {
								echo '';
							} else {
								$pointStr = 1 * $result['RacerResult']['points'][$i]['pt'];
								if (!empty($result['RacerResult']['points'][$i]['bonus'])) {
									$pointStr .= '+' . (1 * $result['RacerResult']['points'][$i]['bonus']);
								}
								echo h($pointStr . 'pt');
							}
						?></td>
					<?php endfor; ?>
					<td><?php
						if (is_null($result['RacerResult']['ajocc_pt'])) {
							echo '';
						} else {
							$ptStr = $result['RacerResult']['ajocc_pt'] . 'pt';
							if (!empty($result['RacerResult']['as_category'])) {
								$ptStr .= '/' . $result['RacerResult']['as_category'];
							}
							echo h($ptStr);
						}
					?></td>
					<?php if ($holdPointCount > 0): ?>
						<td><?php 
							$str = '';
							foreach ($result['RacerResult']['HoldPoint'] as $hpt) {
								if (!empty($hpt['point'])) {
									if (!empty($str)) {
										$str .= ', ';
									}
									$str .= $hpt['point'] . 'pt/' . $hpt['category_code'];
								}
							}
							echo h($str);
						?></td>
					<?php endif; ?>
				<td class="actions">
						<?php echo $this->Html->link('詳細', array('controller' => 'racer_results', 'action' => 'view', $result['RacerResult']['id'])); ?>
						<?php /*echo $this->Html->link(__('Edit'), array('controller' => 'racer_results', 'action' => 'edit', $result['RacerResult']['id']));//*/ ?>
						<?php /*echo $this->Form->postLink(__('Delete'), array('controller' => 'racer_results', 'action' => 'delete', $result['RacerResult']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $result['RacerResult']['id']));//*/ ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
