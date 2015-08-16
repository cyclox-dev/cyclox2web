<div class="pointSeriesRacers view">
<h2><?php echo __('Point Series Racer'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pointSeriesRacer['Racer']['code'], array('controller' => 'racers', 'action' => 'view', $pointSeriesRacer['Racer']['code'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point Series'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pointSeriesRacer['PointSeries']['name'], array('controller' => 'point_series', 'action' => 'view', $pointSeriesRacer['PointSeries']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['point']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gained Date'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['gained_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expiry Date'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['expiry_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Racer Result'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pointSeriesRacer['RacerResult']['id'], array('controller' => 'racer_results', 'action' => 'view', $pointSeriesRacer['RacerResult']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($pointSeriesRacer['PointSeriesRacer']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Point Series Racer'), array('action' => 'edit', $pointSeriesRacer['PointSeriesRacer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Point Series Racer'), array('action' => 'delete', $pointSeriesRacer['PointSeriesRacer']['id']), array(), __('Are you sure you want to delete # %s?', $pointSeriesRacer['PointSeriesRacer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series Racers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series Racer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Point Series'), array('controller' => 'point_series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Point Series'), array('controller' => 'point_series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racer Results'), array('controller' => 'racer_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer Result'), array('controller' => 'racer_results', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Racers'), array('controller' => 'racers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Racer'), array('controller' => 'racers', 'action' => 'add')); ?> </li>
	</ul>
</div>
