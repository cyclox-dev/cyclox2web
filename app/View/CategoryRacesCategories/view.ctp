<div class="categoryRacesCategories view">
<h2><?php echo __('Category Races Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoryRacesCategory['CategoryRacesCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacesCategory['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoryRacesCategory['Category']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Races Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoryRacesCategory['RacesCategory']['name'], array('controller' => 'races_categories', 'action' => 'view', $categoryRacesCategory['RacesCategory']['code'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category Races Category'), array('action' => 'edit', $categoryRacesCategory['CategoryRacesCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category Races Category'), array('action' => 'delete', $categoryRacesCategory['CategoryRacesCategory']['id']), array(), __('[%s] のデータを削除してよろしいですか？', $categoryRacesCategory['CategoryRacesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Category Races Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category Races Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Races Categories'), array('controller' => 'races_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Races Category'), array('controller' => 'races_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
