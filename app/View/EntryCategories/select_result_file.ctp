<div class="entryCategories">
	<h2><?php echo __('出走カテゴリーへのエントリー・リザルト読込'); ?></h2>
	<p>以下の出走カテゴリーに読み込みます。</p>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($entryCategory['EntryCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('レース'); ?></dt>
		<dd>
			<?php echo $this->Html->link(h($entryCategory['EntryGroup']['meet_code']), array('controller' => 'meets', 'action' => 'view', h($entryCategory['EntryGroup']['meet_code'])))
				. ' - '. h($entryCategory['EntryCategory']['name'])
				. ' (RacesCategory=' . ($entryCategory['RacesCategory']['name']) . ')'; ?>
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
<div>
	<?php 
		echo $this->Form->create('File', array('type'=>'> file', 'enctype' => 'multipart/form-data', 'url'=>'/entry_categories/check_result_file/' . $entryCategory['EntryCategory']['id']));
		echo $this->Form->input('csv', array('type' => 'file', 'label' => false, 'before' => 'エントリー・リザルトデータのファイルを指定して下さい。'));
		echo $this->Form->submit(__('Upload'));
		echo $this->Form->end(); 
	?>
</div>