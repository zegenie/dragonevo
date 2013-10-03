<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion,
		application\entities\Game,
		application\entities\GameEvent;

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

		public function getLatestEventsByGame(Game $game, $since_event_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_events.game_id', $game->getId());
			$crit->addWhere('game_events.id', $since_event_id, Criteria::DB_GREATER_THAN);
			$crit->addOrderBy('game_events.created_at', Criteria::SORT_ASC);
			$crit->addOrderBy('game_events.id', Criteria::SORT_ASC);

			return $this->select($crit);
		}

		public function getLatestEndPhaseEventByGame(Game $game)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_events.game_id', $game->getId());
			$crit->addSelectionColumn('game_events.created_at', 'created_at');
			$crit->addOrderBy('game_events.created_at', Criteria::SORT_DESC);
			$crit->addWhere('game_events.event_type', GameEvent::TYPE_PHASE_CHANGE);

			$row = $this->doSelectOne($crit);
			if ($row) {
				return $row['created_at'];
			} else {
				return 0;
			}
		}

		public function getOpponentCardEventsByGame(Game $game)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_events.game_id', $game->getId());
			$crit->addWhere('game_events.player_id', $game->getUserOpponentId());
			$crit->addWhere('game_events.turn_number', 3, Criteria::DB_LESS_THAN);
			$crit->addWhere('game_events.event_type', GameEvent::TYPE_CARD_MOVED_ONTO_SLOT);

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
