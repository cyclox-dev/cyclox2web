<?php
/* 
 *  created at 2015/11/16 by shun
 */
?>

<div id="date_nav">
	<?php
	echo $this->Form->input('date', array(
			'label' => 'ランキング計算基準日',
			'type' => 'date',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'div' => array(
				'id' => 'calc_date',
			)
		));
	echo $this->Form->input('divides_bonus', array(
			'label' => 'ボーナス表記',
			'type' => 'select',
			'options' => array(0 => "列内にPt+Bonus", 1 => '列を分ける'),
			'div' => array(
				'id' => 'bonusexp_container',
			),
		));
	$opt = array(
		'url' => array('controller' => 'OrgUtil', 'action' => 'point_series_csv_links'),
		'type' => 'get',
	);
	echo '<div id="search_box">';
	echo $this->Form->create(false, $opt);
	
	$opt = array('type' => 'text', 'label' => false, 'placeholder' => 'キーワード');
	if (isset($search)) {
		$opt['value'] = $search;
	}
	echo $this->Form->input('search', $opt);
	echo $this->Form->end(array(
		'label' => 'シリーズを絞り込む'
	));
	echo '</div>';
	?>
</div>
<?php if (empty($pss)): ?>
<p>表示するポイントシリーズがありません。</p>
<?php else: ?>
<div id="pss_container">
	<?php $noseason = false; ?>
	<?php foreach ($pss as $ps): ?>

		<?php
			$sname = $ps['Season']['name'];

			if (!$noseason) {
				if (isset($seasonExp) && $sname != $seasonExp) {
					echo '</table>';
				}
				if (!isset($seasonExp) || $sname != $seasonExp) {
					$name = empty($sname) ? 'シーズン指定なし' : $sname;
					echo '<h3>' . h($name) . '</h3>';
					echo '<table style="width:auto;">';
					$seasonExp = $sname;

					if (empty($sname)) {
						$noseason = true;
					}
				}
			}
		?>
		<tr>
			<td>
				<?php echo h($ps['PointSeries']['name']); ?>
				<?php
					if (!$ps['PointSeries']['is_active']) {
						echo '(NOT Active)';
					}
				?>
			</td>
			<td>
				<?php
				$opt = array(
					'url' => array('controller' => 'PointSeries', 'action' => 'calcup'),
					'id' => 'calcup_form' . $ps['PointSeries']['id']
				);
				echo $this->Form->create(false, $opt);
				echo $this->Form->hidden('point_series_id', array('value' => $ps['PointSeries']['id']));
				echo $this->Form->end(array(
					'label' => 'ランキングファイルを更新', 
					'div' => array(
						'style' => 'padding:0; margin-bottom:0; margin-top:0;'
					)
				));
				?>
			</td>
			<td>
				<?php
				echo $this->Form->postButton(
					h('Download'),
					array('controller' => 'PointSeries', 'action' => 'download_point_ranking_csv'),
					array('data' => array('point_series_id' => $ps['PointSeries']['id']))
				);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php if (count($pss) > 0) echo '</table>'; ?>
</div>
<?php endif; ?>
<script>
	$(function() {
		$(window).on('load resize scroll', function(){
			if ($(window).scrollTop() > 80) {
				$('#date_nav').addClass('fixed');
				$('#pss_container').css('margin-top', $('#date_nav').outerHeight());
				$('#pss_container').css('margin-bottom', 0);
			} else {
				$('#date_nav').removeClass('fixed');
				$('#pss_container').css('margin-top', 0);
				$('#pss_container').css('margin-bottom', 80); // スクロール飛び防止
			}
		});
		
		$('[id^=calcup_form]').submit(function() {
			var y = $('#calc_date > #dateYear').val();
			$(this).prepend($('<input />')
					.attr('type', 'hidden')
					.attr('name', 'data[date][year]')
					.attr('value', y));
			//console.log(y);
			var m = $('#calc_date > #dateMonth').val();
			$(this).prepend($('<input />')
					.attr('type', 'hidden')
					.attr('name', 'data[date][month]')
					.attr('value', m));
			//console.log(m);
			var d = $('#calc_date > #dateDay').val();
			$(this).prepend($('<input />')
					.attr('type', 'hidden')
					.attr('name', 'data[date][day]')
					.attr('value', d));
			//console.log(d);
			var bexp = $('#divides_bonus').val();
			$(this).prepend($('<input />')
					.attr('type', 'hidden')
					.attr('name', 'data[divides_bonus]')
					.attr('value', bexp));
			return true;
		});
	});
</script>
