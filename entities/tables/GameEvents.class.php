<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * Game invites table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="game_events")
	 * @Entity(class="\application\entities\GameEvent")
	 */
	class GameEvents extends \b2db\Table
	{

		public function getLatestEventsByGameId($game_id, $since_event_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_events.game_id', $game_id);
			$crit->addWhere('game_events.id', $since_event_id, Criteria::DB_GREATER_THAN);

			return $this->select($crit);
		}

	}
