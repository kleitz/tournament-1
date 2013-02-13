
<div class="container">
	<div class="container-head">
		<h2><?php echo __d('tournament', 'Leagues'); ?></h2>
	</div>

	<div class="container-body">
		<?php echo $this->element('pagination'); ?>

		<div class="table">
			<table>
				<thead>
					<tr>
						<th colspan="2"><?php echo $this->Paginator->sort('League.name', __d('tournament', 'League')); ?></th>
						<th><?php echo $this->Paginator->sort('Game.name', __d('tournament', 'Game')); ?></th>
						<th><?php echo $this->Paginator->sort('Region.name', __d('tournament', 'Region')); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($leagues) {
						foreach ($leagues as $league) { ?>

					<tr>
						<td>
							<?php if ($logo = $league['League']['logo']) {
								echo $this->Html->image($logo, array('url' => array('action' => 'view', 'league' => $league['League']['slug'])));
							} ?>
						</td>
						<td>
							<h3><?php echo $this->Html->link($league['League']['name'], array('action' => 'view', 'league' => $league['League']['slug'])); ?></h3>
							<?php echo $league['League']['description']; ?>
						</td>
						<td><?php echo $league['Game']['name']; ?></td>
						<td><?php echo $league['Region']['name']; ?></td>
					</tr>

						<?php }
					} else { ?>

					<tr>
						<td colspan="4" class="no-results">
							<?php echo __d('tournament', 'There are no results to display'); ?>
						</td>
					</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>

		<?php echo $this->element('pagination'); ?>
	</div>
</div>