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
<h3>ポイントシリーズの hint 入力について</h3>
<p>ポイントシリーズの hint の入力により、所属カテゴリーを制限することができる。</p>
<p>つまり計算日時点でカテゴリーを持たない選手はランキングに集計されない。昇格してしまった選手を除外する場合などに有効である。</p>
<p>
	例えば C2 所属を条件とする場合は</br>
	cat_limit:C2</br>
	と入力する。C1 もしくは C2 ならば</br>
	cat_limit:C1/C2</br>
	のように / で区切る。cat_limit 意外のヒントを入力する場合は以下のようにカンマ区切りで入力する。</br>
	cat_limit:C1/C2,race_count:5</br>
</p>

<h3>配点ルール</h3>
<?php
	App::uses('PointCalculator', 'Cyclox/Util');
	foreach (PointCalculator::calculators() as $pc):
?>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($pc->val()); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo h($pc->name()); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo h($pc->description()); ?>
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
			<?php echo h($pss->val()); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo h($pss->title()); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo h($pss->description()); ?>
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
			<?php echo h($rule->val()); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('タイトル'); ?></dt>
		<dd>
			<?php echo h($rule->title()); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('概要'); ?></dt>
		<dd>
			<?php echo h($rule->description()); ?>
			&nbsp;
		</dd>
	</dl>
	<p style="height: 1em"></p>
<?php
	endforeach;


