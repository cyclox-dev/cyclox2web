<div class="categories view">
<h2><?php echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($category['Category']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['short_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($category['CategoryGroup']['name'], array('controller' => 'category_groups', 'action' => 'view', $category['CategoryGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($category['Category']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Race Min'); ?></dt>
		<dd>
			<?php echo h($category['Category']['race_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($category['Category']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Aged Category?'); ?></dt>
		<dd>
			<?php echo h($category['Category']['is_aged_category'] == 1 ? 'Yes' : 'No'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age Min'); ?></dt>
		<dd>
			<?php echo h($category['Category']['age_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age Max'); ?></dt>
		<dd>
			<?php echo h($category['Category']['age_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('学年年齢 Min'); ?></dt>
		<dd>
			<?php echo h($category['Category']['school_year_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('学年年齢 Max'); ?></dt>
		<dd>
			<?php echo h($category['Category']['school_year_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($category['Category']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Needs Jcf'); ?></dt>
		<dd>
			<?php echo h($category['Category']['needs_jcf']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Needs Uci'); ?></dt>
		<dd>
			<?php echo h($category['Category']['needs_uci']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uci Age Limit'); ?></dt>
		<dd>
			<?php echo h($category['Category']['uci_age_limit']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['code'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['code']), array(), __('[%s] のデータを削除してよろしいですか？', $category['Category']['code'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Groups'), array('controller' => 'category_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Group'), array('controller' => 'category_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Racers'), array('controller' => 'category_racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Racer'), array('controller' => 'category_racers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('controller' => 'category_races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('controller' => 'category_races_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Category Races Categories'); ?></h3>
	<?php if (!empty($category['CategoryRacesCategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Category Code'); ?></th>
		<th><?php echo __('Races Category Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($category['CategoryRacesCategory'] as $categoryRacesCategory): ?>
		<tr>
			<td><?php echo $categoryRacesCategory['category_code']; ?></td>
			<td><?php echo $categoryRacesCategory['races_category_code']; ?></td>
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
