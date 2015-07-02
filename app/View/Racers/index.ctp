<?php
App::uses('Gender', 'Cyclox/Const');

function nameOrKana($name, $kana)
{
	if ($name) return $name;
	if ($kana) return $kana;
	return '？？？';
}
?>

<div class="racers index">
	<h2><?php echo __('選手一覧'); ?></h2>
	<div>
		<?php echo $this->Form->create('Racer', array('action'=>'index')); ?>
		<fieldset>
			<legend>検索</legend>
			<?php echo $this->Form->input('keyword', array('label' => 'キーワード', 'placeholder' => '選手 Code, 名前について検索')); ?>
			<?php
				$options = array('and' => 'AND', 'or' => 'OR');
				$attributes = array('type' => 'radio', 'default' => 'and', 'class' => 'radio inline');
				echo $this->Form->input('andor', array(
					'legend' => false,
					'type' => 'radio',
					'options' => $options,
					'default' => 'or',
				));
			?>
		</fieldset>
		<?php echo $this->Form->end('検索'); ?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('code', '選手 Code'); ?></th>
			<th><?php echo '姓'; ?></th>
			<th><?php echo '名前'; ?></th>
			<th><?php echo $this->Paginator->sort('family_name_en', "Family Name"); ?></th>
			<th><?php echo $this->Paginator->sort('first_name_en', "First Name"); ?></th>
			<th><?php echo $this->Paginator->sort('gender', '性別'); ?></th>
			<th><?php echo $this->Paginator->sort('birth_date', "生年月日"); ?></th>
			<th><?php echo 'Category'; ?></th>
			<th><?php echo $this->Paginator->sort('nationality_code', '国籍'); ?></th>
		<!--
			<th><?php echo $this->Paginator->sort('jcf_number'); ?></th>
			<th><?php echo $this->Paginator->sort('uci_number'); ?></th>
			<th><?php echo $this->Paginator->sort('uci_code'); ?></th>
			<th><?php echo $this->Paginator->sort('phone'); ?></th>
			<th><?php echo $this->Paginator->sort('mail'); ?></th>
			<th><?php echo $this->Paginator->sort('country_code'); ?></th>
			<th><?php echo $this->Paginator->sort('zip_code'); ?></th>			
		-->
			<th><?php echo $this->Paginator->sort('prefecture', "都道府県"); ?></th>
		<!--<th><?php echo $this->Paginator->sort('address'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('deleted'); ?></th>
		-->
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($racers as $racer): ?>
	<tr>
		<td><?php echo h($racer['Racer']['code']); ?>&nbsp;</td>
		<td><?php 
			echo h(nameOrKana($racer['Racer']['family_name'], $racer['Racer']['family_name_kana']));
		?>&nbsp;</td>
		<td><?php
			echo h(nameOrKana($racer['Racer']['first_name'], $racer['Racer']['first_name_kana']));
		?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['family_name_en']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['first_name_en']); ?>&nbsp;</td>
		<td><?php echo h(Gender::genderAt($racer['Racer']['gender'])->charExpJp()); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['birth_date']); ?>&nbsp;</td>
		<td><?php
			$cats = '';
			foreach ($racer['CategoryRacer'] as $cat) {
				if (strlen($cats) > 0) {
					$cats .= ',';
				}
				$cats .= $cat['category_code'];
			}
			echo h($cats);
		?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['nationality_code']); ?>&nbsp;</td>
	<!--
		<td><?php echo h($racer['Racer']['jcf_number']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['uci_number']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['uci_code']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['phone']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['mail']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['country_code']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['zip_code']); ?>&nbsp;</td>
	-->
		<td><?php echo h($racer['Racer']['prefecture']); ?>&nbsp;</td>
	<!--<td><?php echo h($racer['Racer']['address']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['note']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['created']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['modified']); ?>&nbsp;</td>
		<td><?php echo h($racer['Racer']['deleted']); ?>&nbsp;</td>
	-->
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $racer['Racer']['code'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $racer['Racer']['code'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $racer['Racer']['code'])
				, array('confirm' => __('この選手 [code:%s] を削除してよろしいですか？', $racer['Racer']['code']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('選手データを追加'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('> カテゴリー所属リスト'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('> カテゴリー所属を追加'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
