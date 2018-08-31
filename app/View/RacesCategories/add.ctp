<div class="racesCategories form">
<?php echo $this->Form->create('RacesCategory'); ?>
	<fieldset>
		<legend><?php echo __('Add Races Category'); ?></legend>
	<?php
		App::uses('Gender', 'Cyclox/Const');
		App::uses('LicenseNecessity', 'Cyclox/Const');
		App::uses('UCIAge', 'Cyclox/Const');
		
		$genderArr = array();
		foreach (Gender::genders() as $g) {
			$genderArr[$g->val()] = $g->express();
		}
		
		$lices = array();
		foreach (LicenseNecessity::necessities() as $n) {
			$lices[$n->val()] = $n->msg();
		}
		
		$ages = array();
		foreach (UCIAge::uciAges() as $a) {
			$ages[$a->code()] = $a->name();
		}
		
		echo $this->Form->input('code', array('type' => 'text'));
		echo $this->Form->input('name', array('type' => 'text'));
		echo $this->Form->input('description');
		echo '※以下の制限はレースカテゴリーによるもの。カテゴリーを指定しているのであれば必要ない場合が多い。';
		echo $this->Form->input('age_min');
		echo $this->Form->input('age_max');
		echo $this->Form->input('gender', array('options'=> $genderArr, 'label' => '性別', 'selected' => Gender::$UNASSIGNED->val()));
		echo $this->Form->input('needs_jcf', array('options'=> $lices, 'label' => 'JCF ライセンス'));
		echo $this->Form->input('needs_uci', array('options'=> $lices, 'label' => 'UCI ライセンス'));
		echo $this->Form->input('race_min', array('label' => 'レース標準時間（分）'));
		echo $this->Form->input('uci_age_limit', array(
			'label' => 'UCI 年齢制限（チェックしたクラスのみ出場可／チェック全て OFF の状態では制限なし）',
			'type' => 'select',
			'multiple' => 'checkbox',
			'options' => $ages
		));
		echo $this->Form->input('display_rank');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Races Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
