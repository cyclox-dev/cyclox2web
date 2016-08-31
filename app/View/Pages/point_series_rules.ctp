<?php

/* 
 *  created at 2016/08/29 by shun
 */
?>

<h2>ポイントシリーズの設定・ルールetc</h2>
<p>ポイントシリーズのポイントは</br>
1. Cyclox2 App からのリザルトアップロード時</br>
2. 各出走カテゴリーでのリザルト再計算時</br>
に再計算され、リザルトに付加されます。（集計はされません。）</p>
<p>各出走カテゴリー表示で、それぞれのリザルトごとに付与されたポイントが確認できます。</br>
（トップページ→大会→大会ごと[View]→出走カテゴリーごと[View]→でリザルト上に表示）
</p>
<p>ランキング表はトップページ→ユティリティ【オーガナイザ用】→シリーズ Ranking から CSV ファイルとしてダウンロードできます。</br>
（[ランキング更新]で集計し、[Download] で CSV ダウンロード。）
</p>

<h3>配点ルール</h3>
<?php
	App::uses('PointCalculator', 'Cyclox/Util');
	foreach (PointCalculator::calculators() as $pc):
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo $pc->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo $pc->name(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo $pc->description(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('説明'); ?></dt>
		<dd>
			<?php echo $pc->text(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
<?php
	endforeach;
?>
<h3>集計ルール</h3>
<?php
	App::uses('PointSeriesSumUpRule', 'Cyclox/Const');
	foreach (PointSeriesSumUpRule::rules() as $pss):
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo $pss->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo $pss->title(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo $pss->description(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('説明'); ?></dt>
		<dd>
			<?php echo $pss->text(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
<?php
	endforeach;
?>
<h3>ポイント有効期間ルール</h3>
<?php
	App::uses('PointSeriesTermOfValidityRule', 'Cyclox/Const');
	foreach (PointSeriesTermOfValidityRule::rules() as $rule):
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo $rule->val(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo $rule->title(); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo $rule->description(); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
<?php
	endforeach;


