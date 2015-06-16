<div class="categoryGroups view">
<h2><?php echo __('Category Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoryGroup['CategoryGroup']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($categoryGroup['CategoryGroup']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($categoryGroup['CategoryGroup']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lank Up Hint'); ?></dt>
		<dd>
			<?php echo h($categoryGroup['CategoryGroup']['lank_up_hint']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category Group'), array('action' => 'edit', $categoryGroup['CategoryGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category Group'), array('action' => 'delete', $categoryGroup['CategoryGroup']['id']), array(), __('Are you sure you want to delete # %s?', $categoryGroup['CategoryGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Categories'); ?></h3>
	<?php if (!empty($categoryGroup['Category'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Short Name'); ?></th>
		<th><?php echo __('Category Group Id'); ?></th>
		<th><?php echo __('Lank'); ?></th>
		<th><?php echo __('Race Min'); ?></th>
		<th><?php echo __('Gender'); ?></th>
		<th><?php echo __('Age Min'); ?></th>
		<th><?php echo __('Age Max'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Needs Jcf'); ?></th>
		<th><?php echo __('Needs Uci'); ?></th>
		<th><?php echo __('Uci Age Limit'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($categoryGroup['Category'] as $category): ?>
		<tr>
			<td><?php echo $category['code']; ?></td>
			<td><?php echo $category['name']; ?></td>
			<td><?php echo $category['short_name']; ?></td>
			<td><?php echo $category['category_group_id']; ?></td>
			<td><?php echo $category['lank']; ?></td>
			<td><?php echo $category['race_min']; ?></td>
			<td><?php echo $category['gender']; ?></td>
			<td><?php echo $category['age_min']; ?></td>
			<td><?php echo $category['age_max']; ?></td>
			<td><?php echo $category['description']; ?></td>
			<td><?php echo $category['needs_jcf']; ?></td>
			<td><?php echo $category['needs_uci']; ?></td>
			<td><?php echo $category['uci_age_limit']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'categories', 'action' => 'view', $category['code'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'categories', 'action' => 'edit', $category['code'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'categories', 'action' => 'delete', $category['code']), array(), __('Are you sure you want to delete # %s?', $category['code'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
