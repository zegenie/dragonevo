<?php

	namespace application\entities\tables;

	/**
	 * Event cards table
	 *
	 * @static \application\entities\tables\EventCards getTable()
	 *
	 * @Table(name="event_cards")
	 * @Entity(class="\application\entities\EventCard")
	 */
	class EventCards extends \b2db\Table
	{
		
		public function getAll()
		{
			return $this->selectAll();
		}
		
		public function getNumberOfCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->count($crit);
		}

		public function getByFaction($faction)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.faction', $faction);
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->select($crit);
		}

		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('event_cards.user_id', $user_id);
			$crit->addWhere('event_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->select($crit);
		}

	}