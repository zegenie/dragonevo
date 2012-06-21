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

		public function getStatisticsByGameId($game_id, $player_id)
		{
			$stats = array('hp' => 0, 'cards' => 0);

			$crit = $this->getCriteria();
			$crit->addWhere('game_events.game_id', $game_id);
			$crit->addWhere('game_events.player_id', $player_id);

			$hp_crit = clone $crit;
			$hp_crit->addSelectionColumn('game_events.hp', 'hp', Criteria::DB_SUM);
			if ($row = $this->doSelectOne($hp_crit)) {
				$stats['hp'] = (int) $row->get('hp');
			}

			$card_crit = clone $crit;
			$card_crit->addSelectionColumn('game_events.killed_card', 'cards', Criteria::DB_SUM);
			if ($row = $this->doSelectOne($card_crit)) {
				$stats['cards'] = (int) $row->get('cards');
			}

			return $stats;
		}

	}
