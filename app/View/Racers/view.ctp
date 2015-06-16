<div class="racers view">
<h2><?php echo __('Racer'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Family Name'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Family Name Kana'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name_kana']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Family Name En'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['family_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name Kana'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['first_name_kana']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name En'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['first_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Birth Date'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['birth_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nationality Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['nationality_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Jcf Number'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['jcf_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uci Number'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['uci_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uci Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['uci_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['mail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['country_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip Code'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['zip_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prefecture'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['prefecture']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($racer['Racer']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Racer'), array('action' => 'edit', $racer['Racer']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Racer'), array('action' => 'delete', $racer['Racer']['code']), array(), __('Are you sure you want to delete # %s?', $racer['Racer']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Category Racers'); ?></h3>
	<?php if (!empty($racer['CategoryRacer'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Racer Code'); ?></th>
		<th><?php echo __('Category Code'); ?></th>
		<th><?php echo __('Apply Date'); ?></th>
		<th><?php echo __('Reason Id'); ?></th>
		<th><?php echo __('Reason Note'); ?></th>
		<th><?php echo __('Meet Code'); ?></th>
		<th><?php echo __('Cancel Date'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Deleted'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($racer['CategoryRacer'] as $categoryRacer): ?>
		<tr>
			<td><?php echo $categoryRacer['id']; ?></td>
			<td><?php echo $categoryRacer['racer_code']; ?></td>
			<td><?php echo $categoryRacer['category_code']; ?></td>
			<td><?php echo $categoryRacer['apply_date']; ?></td>
			<td><?php echo $categoryRacer['reason_id']; ?></td>
			<td><?php echo $categoryRacer['reason_note']; ?></td>
			<td><?php echo $categoryRacer['meet_code']; ?></td>
			<td><?php echo $categoryRacer['cancel_date']; ?></td>
			<td><?php echo $categoryRacer['created']; ?></td>
			<td><?php echo $categoryRacer['modified']; ?></td>
			<td><?php echo $categoryRacer['deleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'category_racers', 'action' => 'view', $categoryRacer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'category_racers', 'action' => 'edit', $categoryRacer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'category_racers', 'action' => 'delete', $categoryRacer['id']), array(), __('Are you sure you want to delete # %s?', $categoryRacer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
