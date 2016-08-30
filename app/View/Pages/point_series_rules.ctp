<?php

/* 
 *  created at 2016/08/29 by shun
 */
?>

<h2>シリーズポイント設定etc</h2>
<h3>配点ルール</h3>
<?php
	App::uses('PointCalculator', 'Cyclox/Util');
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo PointCalculator::$JCX_156->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo PointCalculator::$JCX_156->name(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo PointCalculator::$JCX_156->description(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('説明'); ?></dt>
		<dd>
			<?php echo PointCalculator::$JCX_156->text(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo PointCalculator::$KNS_156->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo PointCalculator::$KNS_156->name(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo PointCalculator::$KNS_156->description(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('説明'); ?></dt>
		<dd>
			<?php echo PointCalculator::$KNS_156->text(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
<h3>集計ルール</h3>
<?php
	App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$JCX_156->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$JCX_156->title(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$JCX_156->description(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('説明'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$JCX_156->text(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$KNS_156->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$KNS_156->title(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$KNS_156->description(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('説明'); ?></dt>
		<dd>
			<?php echo PointSeriesSumUpRule::$KNS_156->text(); ?>
			&nbsp;
		</dd>
	</dl>
<p style="height: 1em"></p>
<h3>ポイント有効期間ルール</h3>
<?php
	App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo PointSeriesTermOfValidityRule::$ENDLESS->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo PointSeriesTermOfValidityRule::$ENDLESS->title(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo PointSeriesTermOfValidityRule::$ENDLESS->description(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo PointSeriesTermOfValidityRule::$ONE_YEAR->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo PointSeriesTermOfValidityRule::$ONE_YEAR->title(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo PointSeriesTermOfValidityRule::$ONE_YEAR->description(); ?>
			&nbsp;
		</dd>
	</dl>





