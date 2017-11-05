<!--
/* 
 *  created at 2015/10/04 by shun
 */
-->

<?php foreach ($links as $seasonPack): ?>
	<p><?php echo h($seasonPack['title']); ?></p>
	<?php foreach ($seasonPack['dat'] as $obj): ?>
		<p>
			<?php
				$data = array('season_id' => $seasonPack['season_id'], 'category_code' => $obj['category_code']);
				echo $this->Form->postLink(h($obj['title']), array('action' => 'download_ajocc_pt_csv'), array('data' => $data));
			?>
		</p>
<?php
	endforeach;
endforeach;

