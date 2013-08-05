<div class="page-header">
	<h2><?php echo $league['League']['name']; ?></h2>
</div>

<div class="page">
	<dl class="dl-horizontal">
		<dt><?php echo __d('tournament', 'Game'); ?></dt> <dd><?php echo $league['Game']['name']; ?></dd>
		<dt><?php echo __d('tournament', 'Region'); ?></dt> <dd><?php echo $league['Region']['name']; ?></dd>
	</dl>

	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo __d('tournament', 'Events'); ?></h3>
		</div>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __d('tournament', 'Event'); ?></th>
					<th><?php echo __d('tournament', 'Division'); ?></th>
					<th><?php echo __d('tournament', 'Type'); ?></th>
					<th><?php echo __d('tournament', 'Setup'); ?></th>
					<th><?php echo __d('tournament', 'Seed'); ?></th>
					<th><?php echo __d('tournament', 'Registration'); ?></th>
					<th><?php echo __d('tournament', 'Timeframe'); ?></th>
					<th><?php echo __d('tournament', 'Signed Up'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($events) {
					foreach ($events as $event) {
						echo $this->element('rows/event', array(
							'event' => $event
						));
					}
				} else { ?>

				<tr>
					<td colspan="8" class="no-results">
						<?php echo __d('tournament', 'There are no results to display'); ?>
					</td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
	</div>

</div>