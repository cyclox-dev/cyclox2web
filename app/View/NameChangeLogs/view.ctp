<div class="nameChangeLogs view">
<h2><?php echo __('選手名変更ログ詳細'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('選手コード'); ?></dt>
		<dd>
			<?php echo $this->Html->link($nameChangeLog['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $nameChangeLog['Racer']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('変更後の姓'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['new_fam']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('変更後の名前'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['new_fir']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Old Data (json)'); ?></dt>
		<dd>
			<pre>
			<?php echo h($nameChangeLog['NameChangeLog']['old_data']); ?>
			&nbsp;
			</pre>
		</dd>
		<dt><?php echo __('名前変更したUser.Mail'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['by_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note（処理履歴など）'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('名前書き換え日時'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('データ編集日時'); ?></dt>
		<dd>
			<?php echo h($nameChangeLog['NameChangeLog']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('このログを編集'), array('action' => 'edit', $nameChangeLog['NameChangeLog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('選手名変更ログ一覧'), array('action' => 'index')); ?> </li>
	</ul>
</div>
