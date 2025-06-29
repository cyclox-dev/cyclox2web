<div class="racers form">
<?php echo $this->Form->create('Racer'); ?>
	<fieldset>
		<legend><?php echo __('新規選手データの追加'); ?></legend>
	<?php
		App::uses('Gender', 'Cyclox/Const');
		App::uses('Nation', 'Cyclox/Const');
		
		$genderArr = array();
		foreach (Gender::genders() as $g) {
			$genderArr[$g->val()] = $g->express();
		}
		
		$nats = array();
		foreach (Nation::nations() as $n) {
			$nats[$n->code()] = $n->code() . ':' . $n->nameJp();
		}
		
		echo $this->Form->input('code');
		echo $this->Form->input('family_name', array('type' => 'text', 'label' => '姓'));
		echo $this->Form->input('first_name', array('type' => 'text', 'label' => '名前'));
		echo $this->Form->input('family_name_kana', array('type' => 'text', 'label' => '姓（カナ）'));
		echo $this->Form->input('first_name_kana', array('type' => 'text', 'label' => '名前（カナ）'));
		echo $this->Form->input('family_name_en', array('type' => 'text', 'label' => 'Family Name'));
		echo $this->Form->input('first_name_en', array('type' => 'text', 'label' => 'First Name'));
		echo $this->Form->input('team', array('label' => 'チーム名'));
		echo $this->Form->input('team_en', array('label' => 'Team name(en)'));
		echo $this->Form->input('gender', array('options'=> $genderArr, 'label' => '性別'));
		echo $this->Form->input('birth_date', array(
			'label' => '生年月日',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'minYear' => date('Y') - 100,
			'maxYear' => date('Y'),
			// 以下空の値 (->null) の表示設定
			'empty' => array(0 => '–'),
			'selected' => array(
				'year' => 0,
				'month' => 0,
				'day' => 0
			)
		));
		echo $this->Form->input('nationality_code', array(
			'label' => '国籍',
			'options' => $nats,
			'selected' => Nation::JPN()->code()
		));
		echo $this->Form->input('jcf_number', array('type' => 'text', 'label' => 'JCF Number'));
		echo $this->Form->input('uci_id', array('type' => 'text', 'label' => 'UCI ID'));
		echo $this->Form->input('uci_nation_code', array('type' => 'text', 'label' => 'UCI 登録国コード（3文字）'));
		echo $this->Form->input('phone', array('type' => 'text'));
		echo $this->Form->input('mail', array('type' => 'text'));
		echo $this->Form->input('country_code', array(
			'label' => '国籍',
			'options' => $nats,
			'selected' => Nation::JPN()->code()
		));
		echo $this->Form->input('zip_code', array('type' => 'text', 'label' => '郵便番号 (Zip code)'));
		echo $this->Form->input('prefecture', array('type' => 'text', 'label' => '都道府県 (Prefecture)'));
		echo $this->Form->input('address', array('type' => 'text'));
		echo $this->Form->input('note');
		echo $this->Form->input('cat_limit', array('label' => 'エントリーに関するカテゴリー制限（2015-16〜シーズンごと／e:Elite, m:Masters, n:none'
			. '／自動で設定されるので手動設定は普通必要ない。）'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('選手リスト'), array('action' => 'index')); ?></li>
	</ul>
</div>
