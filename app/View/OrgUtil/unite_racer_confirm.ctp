<div class="orgUtil form">
	<h2><?php echo __($united['Racer']['code'] . ' の選手データを ' . $uniteTo['Racer']['code'] . ' のデータに統合します。') ?></h2>
	<p>カテゴリー所属、レースエントリー／リザルト、獲得ポイントが統合先の選手のものとなります。</p>
	<h3><?php echo __('統合される選手データ（削除されます！）'); ?></h3>
	<dl>
		<dt><?php echo __('選手 Code') ?></dt>
		<dd><?php echo h($united['Racer']['code']); ?> &nbsp; </dd>
		<dt><?php echo __('名前') ?></dt>
		<dd><?php echo h($united['Racer']['family_name'] . ' ' . $united['Racer']['first_name']); ?> &nbsp; </dd>
		<dt><?php echo __('ナマエ') ?></dt>
		<dd><?php echo h($united['Racer']['family_name_kana'] . ' ' . $united['Racer']['first_name_kana']); ?> &nbsp; </dd>
		<dt><?php echo __('Name') ?></dt>
		<dd><?php echo h($united['Racer']['family_name_en'] . ' ' . $united['Racer']['first_name_en']); ?> &nbsp; </dd>
		<dt><?php echo __('チーム') ?></dt>
		<dd><?php echo h($united['Racer']['team']); ?> &nbsp; </dd>
		<dt><?php echo __('生年月日') ?></dt>
		<dd><?php echo h($united['Racer']['birth_date']); ?> &nbsp; </dd>
		<dt><?php echo __('カテゴリー所属') ?></dt>
		<dd><?php 
			$catStr = '';
			foreach ($united['CategoryRacer'] as $cat) {
				if (!empty($catStr)) $catStr .= ', ';
				$catStr .= $cat['category_code'];
			}
			echo h($catStr); 
		?> &nbsp; </dd>
	</dl>
	<p style="height: 1em"></p>
	<h3><?php echo __('統合先の選手データ'); ?></h3>
	<dl>
		<dt><?php echo __('選手 Code') ?></dt>
		<dd><?php echo h($uniteTo['Racer']['code']); ?> &nbsp; </dd>
		<dt><?php echo __('名前') ?></dt>
		<dd><?php echo h($uniteTo['Racer']['family_name'] . ' ' . $uniteTo['Racer']['first_name']); ?> &nbsp; </dd>
		<dt><?php echo __('ナマエ') ?></dt>
		<dd><?php echo h($uniteTo['Racer']['family_name_kana'] . ' ' . $uniteTo['Racer']['first_name_kana']); ?> &nbsp; </dd>
		<dt><?php echo __('Name') ?></dt>
		<dd><?php echo h($uniteTo['Racer']['family_name_en'] . ' ' . $uniteTo['Racer']['first_name_en']); ?> &nbsp; </dd>
		<dt><?php echo __('チーム') ?></dt>
		<dd><?php echo h($uniteTo['Racer']['team']); ?> &nbsp; </dd>
		<dt><?php echo __('生年月日') ?></dt>
		<dd><?php echo h($uniteTo['Racer']['birth_date']); ?> &nbsp; </dd>
		<dt><?php echo __('カテゴリー所属') ?></dt>
		<dd><?php 
			$catStr = '';
			foreach ($uniteTo['CategoryRacer'] as $cat) {
				if (!empty($cat['cancel_date']) && $cat['cancel_date'] < date("Y-m-d")) continue;
				if (!empty($cat['apply_date']) && $cat['apply_date'] > date("Y-m-d")) continue;
				if (!empty($catStr)) $catStr .= ', ';
				$catStr .= $cat['category_code'];
			}
			echo h($catStr); 
		?> &nbsp; </dd>
	</dl>
	<p style="height: 1em"></p>
	<h3><?php echo __('メモ（この統合を行なう理由など）'); ?></h3>
	<p><?php echo h($note) ?></p>
	<p style="height: 1em"></p>
	<?php
		echo $this->Form->create(false, array('type' => 'post' , 'action' => 'do_unite_racer'
				, 'onsubmit' => 'return confirm("統合してよろしいですか？（この処理は元に戻せません。）")'));
		echo $this->Form->hidden('racer_code_united', array('value' => $united['Racer']['code']));
		echo $this->Form->hidden('racer_code_unite_to', array('value' => $uniteTo['Racer']['code']));
		echo $this->Form->hidden('note', array('value' => $note));
		echo $this->Form->button('前に戻る', array('type' => 'button', 'onClick' => 'history.back()'));
		echo $this->Form->end('統合する');
	?>
</div>