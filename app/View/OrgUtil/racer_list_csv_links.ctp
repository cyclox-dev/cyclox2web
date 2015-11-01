
<!--
/* 
 *  created at 2015/10/30 by shun
 */
-->

<p><?php echo $this->Form->postLink(h('選手リスト更新'), array('action' => 'create_racer_lists')); ?></p>

<p><?php
	echo $this->Form->postLink(
		h('全選手一覧'),
		array('action' => 'download_racers_csv')
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