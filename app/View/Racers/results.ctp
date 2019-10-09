<div class="racers view">
	<?php
		App::uses('Util', 'Cyclox/Util');
		App::uses('RacerEntryStatus', 'Cyclox/Const');
		App::uses('RacerResultStatus', 'Cyclox/Const');
	?>
	<h2><?php echo h($racer['Racer']['family_name'] . ' ' . $racer['Racer']['first_name'] . ' [' . $racer['Racer']['code'] . '] のエントリー／リザルト'); ?></h2>
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
			?>
			<?php 
				App::uses('MeetStatus', 'Cyclox/Const');
				App::uses('RaceStatus', 'Cyclox/Const');
			?>
			<?php foreach ($entries as $entry): ?>
				<tr>
					<td><?php
					$addstr = '';
						$stid = $entry['EntryCategory']['EntryGroup']['Meet']['holding_status'];
						if ($stid != MeetStatus::$NORMAL->ID()) {
							$addstr = '（大会' . MeetStatus::statusAt($stid)->name() . '）';
						}
						echo $this->Html->link(
								$entry['EntryCategory']['EntryGroup']['Meet']['short_name']
								, array('controller' => 'meets', 'action' => 'view', $entry['EntryCategory']['EntryGroup']['Meet']['code'])
						) . $addstr;
					?></td>
					<td><?php echo h($entry['EntryCategory']['EntryGroup']['Meet']['at_date']); ?></td>
					<td><?php
						$addstr = '';
						$stid = $entry['EntryCategory']['holding_status'];
						if ($stid != RaceStatus::$NORMAL->ID()) {
							$addstr = '（' . RaceStatus::statusAt($stid)->name() . '）';
						}
						echo $this->Html->link(
								$entry['EntryCategory']['name']
								, array('controller' => 'entry_categories', 'action' => 'view', $entry['EntryCategory']['id'])
						) . $addstr; ?>
					</td>
					<td><?php echo h(RacerEntryStatus::ofVal($entry['EntryRacer']['entry_status'])->msg()); ?></td>
					<?php if (!empty($entry['RacerResult']['id'])): ?>
						<td><?php
							if (empty($entry['RacerResult']['rank'])) {
								echo h(RacerResultStatus::ofVal($entry['RacerResult']['status'])->code());
							} else {
								echo h($entry['RacerResult']['rank']);
							}
						?></td>
						<td><?php echo h($entry['RacerResult']['lap']); ?></td>
						<td><?php
							if (empty($entry['RacerResult']['goal_milli_sec'])) {
								echo '---';
							} else {
								echo h(Util::milli2Time($entry['RacerResult']['goal_milli_sec']));
							}
						?></td>
						<td><?php echo h($entry['RacerResult']['rank_per']); ?></td>
						<td><?php echo h($entry['RacerResult']['ajocc_pt']); ?></td>
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
							echo h($str);
						?></td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('選手データ詳細'), array('action' => 'view', $racer['Racer']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手リスト'), array('action' => 'index')); ?> </li>
	</ul>
</div>