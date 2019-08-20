<div class="categoryRacers">
	<h2><?php echo __('Elite ←→ Masters の乗り換え処理'); ?></h2>
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
	<div class="related">
		<h4>現在のカテゴリー所属</h4>
		<?php if (!empty($racer['CategoryRacer'])):	?>
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
					<td><?php echo h($categoryRacer['id']); ?></td>
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
		<h4>注意（18-19シーズンルールより）</h4>
		<p>すでにそのシーズンでElite/Mastersへの出走がある場合、シーズン途中での乗り換えは不可。</p>
		<p>
			to Elite: CM1→C2, CM2→C3, CM3→C4</br>
			to Masters: C1→CM1, C2→CM2, C3/C4→CM3
		</p>
	</div>
	<h3><?php echo __('カテゴリー乗り換え先指定'); ?></h3>
	<p>※指定後、確認画面に遷移します。</p>
	<div class="related">
		<?php if (empty($cat_tos)): ?>
			<h4>現在所属カテゴリーから推測される乗り換え先はありません。</h4>
		<?php else: ?>
			<h4>現在所属カテゴリーから推測される乗り換え先</h4>
			<div class="actions">
				<ul>
					<?php foreach ($cat_tos as $cat_to): ?>
					<li><?php
						echo $this->Form->create('CategoryRacer', array('type' => 'post', 'url'=>'/category_racers/check_change_em/' . $racer['Racer']['code']));
						echo $this->Form->hidden('cat_to', array('value' => $cat_to['to']));
						echo $this->Form->submit($cat_to['from'] . '→' . $cat_to['to']);
						echo $this->Form->end();
					?> </li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
	<div class="related">
		<h4>カスタムで移行先を指定</h4>
		<?php $cats = array('C1', 'C2', 'C3', 'C4', 'CM1', 'CM2', 'CM3'); ?>
		<div>
			<?php foreach ($cats as $cat): ?>
			<div style="float:left;"><?php
				echo $this->Form->create('CategoryRacer', array('type' => 'post', 'url'=>'/category_racers/check_change_em/' . $racer['Racer']['code']));
				echo $this->Form->hidden('cat_to', array('value' => $cat));
				echo $this->Form->submit('→ ' . $cat);
				echo $this->Form->end();
			?></div>
			<?php endforeach; ?>
		</div>
	</div>
</div>