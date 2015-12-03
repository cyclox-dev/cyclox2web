<?php
/* 
 *  created at 2015/11/16 by shun
 */
?>

<?php if (!empty($links)): ?>
<?php foreach ($links as $id => $name): ?>
	<p>
		<?php
		echo $this->Form->postLink(
			h($name . ' Download'),
			array('controller' => 'PointSeries', 'action' => 'download_point_ranking_csv'),
			array('data' => array('point_series_id' => $id))
		);
		?>
	</p>
	<p>
		<?php
		echo $this->Form->postLink(
			h($name . 'ランキング更新'),
			array('controller' => 'PointSeries', 'action' => 'calcup'),
			array('data' => array('point_series_id' => $id))
		);
		?>
	</p>
	
<?php endforeach; ?>
<?php endif;