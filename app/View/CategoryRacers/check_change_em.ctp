<div class="categoryRacers">
	<h2><?php echo __('Elite ←→ Masters の乗り換え処理の確認'); ?></h2>
	<p>以下の選手のカテゴリーを変更します。</p>
	<dl>
		<dt><?php echo __('選手コード'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('名前'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name'] . ' ' . $racer['Racer']['first_name']); ?>
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
			<?php
				if (!empty($racer['Racer']['birth_date'])) {
					App::uses('Util', 'Cyclox/Util');
					$uciCxAge = Util::uciCXAgeAt(new DateTime($racer['Racer']['birth_date']));
					echo h($racer['Racer']['birth_date']) . '（CX年齢:' . $uciCxAge . '）';
				}
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('チーム'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['team']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('JCF Number'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['jcf_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UCI ID'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['uci_id']); ?>
			&nbsp;
		</dd>
	</dl>
	
	<p style="height: 1em"></p>
	
	<div>
		<h4>注意（18-19シーズンルールより）</h4>
		<p>すでにそのシーズンでElite/Mastersへの出走がある場合、シーズン途中での乗り換えは不可。</p>
		<p>
			to Elite: CM1→C2, CM2→C3, CM3→C4</br>
			to Masters: C1→CM1, C2→CM2, C3/C4→CM3
		</p>
	</div>
	
	<?php App::uses('CategoryReason', 'Cyclox/Const'); ?>
	
	<div class="change_cats">
		<h2>所属終了となるカテゴリー所属</h2>
		<?php if (empty($end_cats)): ?>
		<p><?php echo '終了となるカテゴリー所属はありません。'; ?></p>
		<?php else: ?>
		<p><?php echo '所属終了日[' . $end_date . ']がセットされます。'; ?></p>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('Category Code'); ?></th>
				<th><?php echo __('所属開始日'); ?></th>
				<th><?php echo __('所属終了日'); ?></th>
				<th><?php echo __('所属開始理由'); ?></th>
				<th><?php echo __('所属開始のリザルトID'); ?></th>
				<th><?php echo __('所属開始の大会'); ?></th>
			</tr>
			<?php foreach ($end_cats as $categoryRacer): ?>
				<tr>
					<td><?php echo h($categoryRacer['id']); ?></td>
					<td><?php echo h($categoryRacer['category_code']); ?></td>
					<td><?php echo h($categoryRacer['apply_date']); ?></td>
					<td class="end_date"><?php echo $end_date; ?></td>
					<td><?php
						echo h(CategoryReason::reasonAt($categoryRacer['reason_id'])->name());
					?></td>
					<td><?php echo h($categoryRacer['racer_result_id']); ?></td>
					<td><?php echo h($categoryRacer['meet_code']); ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
		
		<h2>新しく付与されるカテゴリー所属</h2>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Category Code'); ?></th>
				<th><?php echo __('所属開始日'); ?></th>
				<th><?php echo __('所属開始理由'); ?></th>
				<th><?php echo __('所属開始理由詳細'); ?></th>
			</tr>
			<tr>
				<td><?php echo $cat_to; ?></td>
				<td><?php echo $start_date; ?></td>
				<td><?php echo CategoryReason::$REQUEST_CHANGE->name(); ?></td>
				<td><?php echo $reason_note; ?></td>
			</tr>
		</table>
		
		<?php if (!empty($keep_cats)):	?>
		<h2>変更されないカテゴリー所属</h2>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('選手 Code'); ?></th>
				<th><?php echo __('Category Code'); ?></th>
				<th><?php echo __('所属開始日'); ?></th>
				<th><?php echo __('所属終了日'); ?></th>
				<th><?php echo __('所属開始理由'); ?></th>
				<th><?php echo __('所属開始のリザルトID'); ?></th>
				<th><?php echo __('所属開始の大会'); ?></th>
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
				foreach ($keep_cats as $categoryRacer):
			?>
				<tr>
					<td><?php echo h($categoryRacer['id']); ?></td>
					<td><?php echo h($categoryRacer['racer_code']); ?></td>
					<td><?php echo h($categoryRacer['category_code']); ?></td>
					<td><?php echo h($categoryRacer['apply_date']); ?></td>
					<td><?php echo h($categoryRacer['cancel_date']); ?></td>
					<td><?php
						App::uses('CategoryReason', 'Cyclox/Const');
						echo h(CategoryReason::reasonAt($categoryRacer['reason_id'])->name());
					?></td>
					<td><?php echo h($categoryRacer['racer_result_id']); ?></td>
					<td><?php echo h($categoryRacer['meet_code']); ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>

	<div>
		<div style="float:left;"><?php
			echo $this->Form->create(null, array('type' => 'post', 'url'=>'/category_racers/exec_change_em/' . $racer['Racer']['code']));
			
			$end_ids = array();
			foreach ($end_cats as $cr) {
				$end_ids[] = $cr['id'];
			}
			echo $this->Form->hidden('sub.end_ids_json', array('value' => json_encode($end_ids)));
			echo $this->Form->hidden('sub.end_date', array('value' => $end_date));
			
			echo $this->Form->hidden('racer_code', array('value' => $racer['Racer']['code']));
			echo $this->Form->hidden('category_code', array('value' => $cat_to));
			echo $this->Form->hidden('apply_date', array('value' => $start_date));
			echo $this->Form->hidden('reason_id', array('value' => CategoryReason::$REQUEST_CHANGE->ID()));
			echo $this->Form->hidden('reason_note', array('value' => $reason_note));
			
			echo $this->Form->submit('カテゴリー乗換を実行');
			echo $this->Form->end();
		?></div>
	</div>
</div>