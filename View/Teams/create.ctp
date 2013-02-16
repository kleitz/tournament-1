<div class="page-title">
	<h2><?php echo __d('tournament', 'Create Team'); ?></h2>
</div>

<div class="page-body">
	<?php
	echo $this->Form->create('Team');
	echo $this->Form->input('name');
	echo $this->Form->input('password');
	echo $this->Form->input('description');
	echo $this->Form->submit(__d('tournament', 'Create'), array('class' => 'button large'));
	echo $this->Form->end(); ?>
</div>