<div class="categoryRacers view">
<h2><?php echo __('カテゴリー所属'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('選手'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $categoryRacer['Racer']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacer['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoryRacer['Category']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('適用日'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['apply_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('解消日'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['cancel_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('適用タイプ'); ?></dt>
		<dd>
			<?php 
				App::uses('CategoryReason', 'Cyclox/Const');
				echo h(CategoryReason::reasonAt($categoryRacer['CategoryRacer']['reason_id'])->name());
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('適用に関する Note'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['reason_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('適用リザルト ID'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacer['CategoryRacer']['racer_result_id'], array('controller' => 'racer_results', 'action' => 'view', $categoryRacer['CategoryRacer']['racer_result_id'])); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('適用根拠大会 Code'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacer['CategoryRacer']['meet_code'], array('controller' => 'meets', 'action' => 'view', $categoryRacer['CategoryRacer']['meet_code'])); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>Status</h3>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h(($categoryRacer['CategoryRacer']['deleted'] ? "Yes" : "No")); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($categoryRacer['CategoryRacer']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('このカテゴリー所属を編集'), array('action' => 'edit', $categoryRacer['CategoryRacer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('このカテゴリー所属を削除'), array('action' => 'delete', $categoryRacer['CategoryRacer']['id']), array()
			, "【注意！！！】\n選手所属カテゴリー [ID:" . $categoryRacer['CategoryRacer']['id'] . "] のデータを削除してよろしいですか？\n\n"
						. "リザルトの再アップロードなどでなれば、選手カテゴリー所属を削除することはまれです。\n"
								. '昇格や降格などで元のカテゴリー所属でなくなった場合には [Edit] から解消日を設定して下さい。'); ?> </li>
		<li><?php echo $this->Html->link(__('> カテゴリー所属リスト'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> カテゴリー所属を追加'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('> カテゴリーリスト'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> 選手リスト'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
	</ul>
</div>
