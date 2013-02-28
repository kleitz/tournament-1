<?php

App::uses('Tournament', 'Tournament.Lib');

class Swiss extends Tournament {

	/**
	 * Event type.
	 *
	 * @var int
	 */
	protected $_type = Event::SWISS;

	/**
	 * Generate matches for a swiss event.
	 *
	 * 	- Event participants will be paired each round with opponents of similar point score
	 *
	 * @return void
	 * @throws Exception
	 */
	public function generateMatches() {
		if ($this->_event['isFinished']) {
			throw new Exception('Event has already finished');
		}

		$nextRound = (int) $this->_event['round'] + 1;
		$maxRounds = (int) $this->_event['maxRounds'];

		// End the event if the max rounds is reached
		if ($maxRounds && $nextRound > $maxRounds) {
			$this->endEvent();
		}

		// First round order by seed
		if ($nextRound == 1) {
			$participants = $this->getParticipants();

			// Set the seed order
			foreach ($participants as $i => $participant_id) {
				$this->flagParticipant($participant_id, ($i + 1));
			}

		// Other rounds order by current event points
		} else {
			$participants = $this->getParticipants(array(
				'EventParticipant.points' => 'DESC',
				'EventParticipant.wins' => 'DESC',
				'EventParticipant.ties' => 'DESC'
			));
		}

		// Create matches
		$half = ceil(count($participants) / 2);

		for ($i = 0; $i < $half; $i++) {
			$home_id = array_shift($participants);
			$away_id = array_shift($participants);

			$this->createMatch($home_id, $away_id, $nextRound);
		}

		// Update event status
		$this->Event->id = $this->_id;
		$this->Event->save(array(
			'isGenerated' => Event::YES,
			'round' => $nextRound
		), false);
	}

	/**
	 * Validate the event is the correct type for the class.
	 */
	public function validate() {
		if ($this->_event['type'] != Event::SWISS) {
			throw new Exception('Event is not Swiss');
		}
	}

}