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
			<?php echo h($racer['Racer']['deleted']); ?>
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
		<li><?php echo $this->Html->link(__('> 新規選手の追加'), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('所属カテゴリー'); ?></h3>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('所属カテゴリーを追加'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
	<?php if (!empty($racer['CategoryRacer'])):	?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('ID'); ?></th>
			<th><?php echo __('選手 Code'); ?></th>
			<th><?php echo __('Category Code'); ?></th>
			<th><?php echo __('適用日'); ?></th>
			<th><?php echo __('解消日'); ?></th>
			<th><?php echo __('適用タイプ'); ?></th>
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
				if ($categoryRacer['deleted']) continue; // deleted があるものは表示しない
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
				<td><?php echo $categoryRacer['meet_code']; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'category_racers', 'action' => 'view', $categoryRacer['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'category_racers', 'action' => 'edit', $categoryRacer['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'category_racers', 'action' => 'delete', $categoryRacer['id']), array()
						, 'ID:' . $categoryRacer['id'] . "のデータを削除してよろしいですか？\n解消の場合には編集から解消日を設定して下さい。"); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
