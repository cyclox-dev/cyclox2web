<div class="racesCategories view">
<h2><?php echo __('Races Category'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age Min'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['age_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age Max'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['age_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Needs Jcf'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['needs_jcf']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Needs Uci'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['needs_uci']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Race Min'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['race_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uci Age Limit'); ?></dt>
		<dd>
			<?php echo h($racesCategory['RacesCategory']['uci_age_limit']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Races Category'), array('action' => 'edit', $racesCategory['RacesCategory']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Races Category'), array('action' => 'delete', $racesCategory['RacesCategory']['code']), array(), __('[%s] のデータを削除してよろしいですか？', $racesCategory['RacesCategory']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Categories'), array('controller' => 'entry_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Category Races Categories'); ?></h3>
	<?php if (!empty($racesCategory['CategoryRacesCategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Category Code'); ?></th>
		<th><?php echo __('Races Category Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($racesCategory['CategoryRacesCategory'] as $categoryRacesCategory): ?>
		<tr>
			<td><?php echo h($categoryRacesCategory['id']); ?></td>
			<td><?php echo h($categoryRacesCategory['category_code']); ?></td>
			<td><?php echo h($categoryRacesCategory['races_category_code']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'category_races_categories', 'action' => 'view', $categoryRacesCategory['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'category_races_categories', 'action' => 'edit', $categoryRacesCategory['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'category_races_categories', 'action' => 'delete', $categoryRacesCategory['id']), array(), __('[%s] のデータを削除してよろしいですか？', $categoryRacesCategory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Entry Categories'); ?></h3>
	<?php if (!empty($racesCategory['EntryCategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Entry Group Id'); ?></th>
		<th><?php echo __('Races Category Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Start Delay Sec'); ?></th>
		<th><?php echo __('Lapout Rule'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($racesCategory['EntryCategory'] as $entryCategory): ?>
		<tr>
			<td><?php echo h($entryCategory['id']); ?></td>
			<td><?php echo h($entryCategory['entry_group_id']); ?></td>
			<td><?php echo h($entryCategory['races_category_code']); ?></td>
			<td><?php echo h($entryCategory['name']); ?></td>
			<td><?php echo h($entryCategory['start_delay_sec']); ?></td>
			<td><?php echo h($entryCategory['lapout_rule']); ?></td>
			<td><?php echo h($entryCategory['note']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'entry_categories', 'action' => 'view', $entryCategory['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'entry_categories', 'action' => 'edit', $entryCategory['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'entry_categories', 'action' => 'delete', $entryCategory['id']), array(), __('[%s] のデータを削除してよろしいですか？', $entryCategory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Entry Category'), array('controller' => 'entry_categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
