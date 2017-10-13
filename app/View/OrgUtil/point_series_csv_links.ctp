<?php
/* 
 *  created at 2015/11/16 by shun
 */
?>

<div id="date_nav">
	<div>
		<?php
		echo $this->Form->input('date', array(
				'label' => 'ランキング計算基準日',
				'type' => 'date',
				'dateFormat' => 'YMD',
				'monthNames' => false,
				'div' => array(
					'id' => 'calc_date'
				)
			));
		?>
	</div>
</div>
<div>
<?php if (!empty($links)): ?>
<table style="width:auto;">
	<?php foreach ($links as $id => $name): ?>
	<tr>
		<td>
			<?php echo $name; ?>
		</td>
		<td>
			<?php
			$opt = array(
				'url' => array('controller' => 'PointSeries', 'action' => 'calcup'),
				'id' => 'calcup_form' . $id
			);
			echo $this->Form->create(false, $opt);
			echo $this->Form->hidden('point_series_id', array('value' => $id));
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
				array('data' => array('point_series_id' => $id))
			);
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<script>
	$(function() {
		$(window).on('load resize scroll', function(){
			if ($(window).scrollTop() > 80) {
				$('#date_nav').addClass('fixed');
			} else {
				$('#date_nav').removeClass('fixed');
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
			return true;
		});
	});
</script>
