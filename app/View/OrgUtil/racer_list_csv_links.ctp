
<!--
/* 
 *  created at 2015/10/30 by shun
 */
-->
<p>お好みの文字コードの選手リストを更新してからダウンロードしてください。</p>
<p>※選手ごとの AjoccPoint 表記をありにした場合、更新にかなり時間がかかる場合があります。</p>
<h2>文字コード: Shift-JIS</h2>
<p><?php echo $this->Form->postLink(h('選手リスト更新'), array('action' => 'create_racer_lists', 'sjis')); ?></p>

<p><?php
	echo $this->Form->postLink(
		h('全選手一覧ダウンロード'),
		array('action' => 'download_racers_csv', 'sjis')
	);
?></p>

<h2>文字コード: Shift-JIS（AjoccPtなし）</h2>
<p><?php echo $this->Form->postLink(h('選手リスト更新'), array('action' => 'create_racer_lists', 'sjis', 'no_points')); ?></p>

<p><?php
	echo $this->Form->postLink(
		h('全選手一覧ダウンロード'),
		array('action' => 'download_racers_csv', 'sjis', 'no_points')
	);
?></p>

<h2>文字コード: UTF-8</h2>
<p><?php echo $this->Form->postLink(h('選手リスト更新'), array('action' => 'create_racer_lists', 'utf8')); ?></p>

<p><?php
	echo $this->Form->postLink(
		h('全選手一覧ダウンロード'),
		array('action' => 'download_racers_csv', 'utf8')
	);
?></p>

<h2>文字コード: UTF-8（AjoccPtなし）</h2>
<p><?php echo $this->Form->postLink(h('選手リスト更新'), array('action' => 'create_racer_lists', 'utf8', 'no_points')); ?></p>

<p><?php
	echo $this->Form->postLink(
		h('全選手一覧ダウンロード'),
		array('action' => 'download_racers_csv', 'utf8', 'no_points')
	);
?></p>

<?php if (!empty($cats)): ?>
<?php foreach ($cats as $cat): ?>
	<p>
		<?php
		echo $this->Form->postLink(
			h($cat['Category']['name']),
			array('action' => 'download_racers_csv'),
			array('data' => array('category_code' => $cat['Category']['code']))
		);
		?>
	</p>
<?php endforeach; ?>
<?php endif;