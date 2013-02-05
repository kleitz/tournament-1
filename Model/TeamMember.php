<?php

App::uses('TournamentAppModel', 'Tournament.Model');

class TeamMember extends TournamentAppModel {

	// Roles
	const LEADER = 0;
	const CO_LEADER = 1;
	const MANAGER = 2;
	const MEMBER = 3;
	const SUB = 4;

	// Status
	const PENDING = 0;
	const ACTIVE = 1;
	const REMOVED = 2; // Removed by leader
	const QUIT = 3; // Left team personally

	/**
	 * Belongs to.
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Team' => array(
			'className' => 'Tournament.Team',
			'counterCache' => true
		),
		'Player' => array(
			'className' => 'Tournament.Player'
		)
	);

	/**
	 * Enum mappings.
	 *
	 * @var array
	 */
	public $enum = array(
		'role' => array(
			self::LEADER => 'LEADER',
			self::CO_LEADER => 'CO_LEADER',
			self::MANAGER => 'MANAGER',
			self::MEMBER => 'MEMBER',
			self::SUB => 'SUB'
		),
		'status' => array(
			self::PENDING => 'PENDING',
			self::ACTIVE => 'ACTIVE',
			self::REMOVED => 'REMOVED',
			self::QUIT => 'QUIT'
		)
	);

	/**
	 * Demote a member.
	 *
	 * @param int $id
	 * @param int $role
	 * @return mixed
	 */
	public function demote($id, $role) {
		$this->id = $id;

		return $this->save(array(
			'role' => $role,
			'promotedOn' => null
		), false);
	}

	/**
	 * Return all members of a team.
	 *
	 * @param int $team_id
	 * @return array
	 */
	public function getRoster($team_id) {
		return $this->find('all', array(
			'conditions' => array(
				'TeamMember.team_id' => $team_id,
				'TeamMember.status !=' => self::PENDING
			),
			'contain' => array('Player' => array('User')),
			'order' => array(
				'TeamMember.role' => 'ASC',
				'TeamMember.created' => 'ASC'
			),
			'cache' => array(__METHOD__, $team_id)
		));
	}

	/**
	 * Return a list of members based on role.
	 *
	 * @param int $team_id
	 * @param int $role
	 * @return array
	 */
	public function getListByRole($team_id, $role) {
		$list = array();
		$results = $this->find('all', array(
			'conditions' => array(
				'TeamMember.team_id' => $team_id,
				'TeamMember.status' => self::ACTIVE,
				'TeamMember.role' => $role
			),
			'contain' => array('Player' => array('User'))
		));

		if ($results) {
			foreach ($results as $result) {
				$list[$result['Player']['User']['id']] = sprintf('%s - %s',
					__d('tournament', 'team.role.' . strtolower($this->enum('role', $result['TeamMember']['role']))),
					$result['Player']['User'][Configure::read('Tournament.userMap.username')]);
			}
		}

		return $list;
	}

	/**
	 * Join a team.
	 *
	 * @param int $team_id
	 * @param int $player_id
	 * @param int $role
	 * @param int $status
	 * @return mixed
	 */
	public function join($team_id, $player_id, $role = self::MEMBER, $status = self::PENDING) {
		if ($this->isMember($team_id, $player_id)) {
			return true;
		}

		$this->create();

		$data = array(
			'team_id' => $team_id,
			'player_id' => $player_id,
			'role' => $role,
			'status' => $status
		);

		if ($role != self::MEMBER && $role != self::SUB) {
			$data['promotedOn'] = date('Y-m-d H:i:s');
		}

		return $this->save($data, false);
	}

	/**
	 * Check if the user is already a member of a team.
	 *
	 * @param int $team_id
	 * @param int $player_id
	 * @return bool
	 */
	public function isMember($team_id, $player_id) {
		return (bool) $this->find('count', array(
			'conditions' => array(
				'TeamMember.team_id' => $team_id,
				'TeamMember.player_id' => $player_id
			)
		));
	}

	/**
	 * Promote a member.
	 *
	 * @param int $id
	 * @param int $role
	 * @return mixed
	 */
	public function promote($id, $role) {
		$this->id = $id;

		return $this->save(array(
			'role' => $role,
			'promotedOn' => date('Y-m-d H:i:s')
		), false);
	}

	/**
	 * Change a members status.
	 *
	 * @param int $id
	 * @param int $status
	 * @return mixed
	 */
	public function updateStatus($id, $status) {
		$this->id = $id;

		return $this->saveField('status', $status);
	}

}