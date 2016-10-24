<?php
/* 
 *  created at 2015/11/16 by shun
 */
?>

<?php if (!empty($links)): ?>
<?php foreach ($links as $id => $name): ?>
	<p>
		<?php
		echo $this->Form->create(false, array('url' => array('controller' => 'PointSeries', 'action' => 'calcup')));
		echo $this->Form->input('date', array(
			'label' => 'ランキング計算基準日',
			'type' => 'date',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'div' => array(
				'style' => 'padding:0; margin-bottom:0'
			)
		));
		echo $this->Form->hidden('point_series_id', array('value' => $id));
		echo $this->Form->end(array(
			'label' => $name . 'のランキングファイルを更新', 
			'div' => array(
				'style' => 'padding:0; margin-bottom:0; margin-top:0;'
			)));
		?>
	</p>
	<p>
		<?php
		echo $this->Form->postLink(
			h($name . ' Download'),
			array('controller' => 'PointSeries', 'action' => 'download_point_ranking_csv'),
			array('data' => array('point_series_id' => $id))
		);
		?>
	</p>
	
<?php endforeach; ?>
<?php endif;