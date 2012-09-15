<?php

	namespace application\entities\tables;

	use b2db\Table,
		b2db\Criteria;

	/**
	 * @Table(name="creature_cards")
	 * @Entity(class="\application\entities\CreatureCard")
	 * @Entities(identifier="card_state")
	 * @SubClasses(template="\application\entities\CreatureCard", owned="\application\entities\UserCreatureCard")
	 */
	class CreatureCards extends \b2db\Table
	{
		
		public function getAll()
		{
			return $this->selectAll();
		}
		
		public function getNumberOfCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->count($crit);
		}

		public function getNumberOfUserCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->count($crit);
		}

		public function getByFaction($faction)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.faction', $faction);
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->select($crit);
		}

		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.user_id', $user_id);
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_OWNED);
			$crit->addOrderBy('creature_cards.original_card_id', Criteria::SORT_ASC);
			return $this->select($crit);
		}

		public function getByUserIdAndGameId($user_id, $game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.user_id', $user_id);
			$crit->addWhere('creature_cards.game_id', $game_id);
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_OWNED);
			$crit->addOrderBy('creature_cards.original_card_id', Criteria::SORT_ASC);
			$crit->addOrderBy('creature_cards.base_health', Criteria::SORT_ASC);
			$crit->addOrderBy('creature_cards.base_ep', Criteria::SORT_ASC);
			$crit->addOrderBy('creature_cards.base_dmp', Criteria::SORT_ASC);
			return $this->select($crit);
		}

		public function getById($id)
		{
			return $this->selectById($id);
		}

		public function getDescendantCards($card_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.original_card_id', $card_id);
			return $this->select($crit);
		}

		public function removeUserCards($user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id === null) {
				$crit->addWhere('creature_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			} else {
				$crit->addWhere('creature_cards.user_id', $user_id);
			}
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$card_id = $row->get('creature_cards.id');
					Attacks::getTable()->removeByCardId($card_id);
					$this->doDeleteById($card_id);
				}
			}
		}

		public function resetUserCards($game_id = null, $user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id !== null) {
				$crit->addWhere('creature_cards.user_id', $user_id);
			} else {
				$crit->addWhere('creature_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			}
			if ($game_id !== null) $crit->addWhere('creature_cards.game_id', $game_id);
			$crit->addUpdate('creature_card.slot', 0);
			$crit->addUpdate('creature_card.game_id', 0);
			$crit->addUpdate('creature_card.is_in_play', false);
			$this->doUpdate($crit);
		}

	}