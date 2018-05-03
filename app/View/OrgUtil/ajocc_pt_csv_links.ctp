<!--
/* 
 *  created at 2015/10/04 by shun
 */
-->

<?php foreach ($links as $seasonPack): ?>
	<h4><?php echo h($seasonPack['title']); ?></h4>
	<div style="margin-bottom: 1em;">
	<?php foreach ($seasonPack['dat'] as $obj): ?>
		<span style="margin-right: 5px;">
			<?php
				$data = array('season_id' => $seasonPack['season_id'], 'category_code' => $obj['category_code']);
				if (isset($seasonPack['local_setting_id'])) {
					$data['local_setting_id'] = $seasonPack['local_setting_id'];
				}
				echo $this->Form->postLink(h($obj['title']), array('action' => 'download_ajocc_pt_csv'), array('data' => $data));
			?>
		</span>
	<?php endforeach; ?>
	</div>
<?php endforeach; ?>

