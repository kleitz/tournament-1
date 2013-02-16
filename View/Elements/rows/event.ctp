<tr>
	<td>
		<b><?php echo $this->Html->link($event['Event']['name'], array('controller' => 'events', 'action' => 'view', 'league' => $league['League']['slug'], 'event' => $event['Event']['slug'])); ?></b>
	</td>
	<td class="align-center"><?php echo $event['Division']['name']; ?></td>
	<td class="align-center"><?php echo $this->Tournament->options('Event.type', $event['Event']['type']); ?></td>
	<td class="align-center"><?php echo $this->Tournament->options('Event.for', $event['Event']['for']); ?></td>
	<td class="align-center"><?php echo $this->Tournament->options('Event.seed', $event['Event']['seed']); ?></td>
	<td class="align-center"><?php echo $this->Tournament->eventSignupDates($event); ?></td>
	<td class="align-center"><?php echo $this->Tournament->eventPlayDates($event); ?></td>
	<td class="align-center"><?php echo $event['Event']['event_participant_count']; ?></td>
</tr>