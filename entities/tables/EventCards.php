<?php

	namespace application\entities\tables;

	use b2db\Table,
		b2db\Criteria;

	/**
	 * Event cards table
	 *
	 * @static \application\entities\tables\EventCards getTable()
	 *
	 * @Table(name="event_cards")
	 * @Entity(class="\application\entities\EventCard")
	 * @Entities(identifier="card_state")
	 * @SubClasses(template="\application\entities\EventCard", owned="\application\entities\UserEventCard")
	 */
	class EventCards extends \b2db\Table
	{
		
		public function getAll()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			$crit->addOrderBy('event_cards.name', Criteria::SORT_ASC);
			return $this->select($crit);
		}
		
		public function getNumberOfCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->count($crit);
		}

		public function getNumberOfUserCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->count($crit);
		}

		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.user_id', $user_id);
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->select($crit);
		}
		
		public function getDescendantCards($card_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.original_card_id', $card_id);
			return $this->select($crit);
		}

		public function getByUserIdAndGameId($user_id, $game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.user_id', $user_id);
			$crit->addWhere('event_cards.game_id', $game_id);
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->select($crit);
		}

		public function removeUserCards($user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id === null) {
				$crit->addWhere('event_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			} else {
				$crit->addWhere('event_cards.user_id', $user_id);
			}
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$card_id = $row->get('event_cards.id');
					$this->doDeleteById($card_id);
				}
			}
		}

		public function resetUserCards($game_id = null, $user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id !== null) {
				$crit->addWhere('event_cards.user_id', $user_id);
			} else {
				$crit->addWhere('event_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			}
			if ($game_id !== null) $crit->addWhere('event_cards.game_id', $game_id);
			$crit->addUpdate('event_card.slot', 0);
			$crit->addUpdate('event_card.game_id', 0);
			$crit->addUpdate('event_card.is_in_play', false);
			$this->doUpdate($crit);
		}

		public function resetAICards($game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.game_id', $game_id);
			$ctn = $crit->returnCriterion('event_cards.user_id', 21);
			$ctn->addOr('event_cards.user_id', 22);
			$ctn->addOr('event_cards.user_id', 23);
			$crit->addWhere($ctn);
			$this->doDelete($crit);
		}

	}