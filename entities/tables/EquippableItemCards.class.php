<?php

	namespace application\entities\tables;

	use b2db\Table,
		b2db\Criteria;

	/**
	 * Equippable item cards table
	 *
	 * @static \application\entities\tables\EquippableItemCards getTable()
	 *
	 * @Table(name="equippable_item_cards")
	 * @Entity(class="\application\entities\EquippableItemCard")
	 * @Entities(identifier="card_state")
	 * @SubClasses(template="\application\entities\EquippableItemCard", owned="\application\entities\UserEquippableItemCard")
	 */
	class EquippableItemCards extends \b2db\Table
	{

		public function getAll()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			$crit->addOrderBy('equippable_item_cards.cost', Criteria::SORT_DESC);
			return $this->select($crit);
		}
		
		public function getNumberOfCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->count($crit);
		}

		public function getShowcasedCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			$crit->addWhere('equippable_item_cards.showcased', true);
			return $this->select($crit);
		}

		public function getNumberOfUserCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->count($crit);
		}

		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.user_id', $user_id);
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			$crit->addOrderBy('equippable_item_cards.original_card_id', Criteria::SORT_ASC);
			return $this->select($crit);
		}

		public function getByUserIdAndGameId($user_id, $game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.user_id', $user_id);
			$crit->addWhere('equippable_item_cards.game_id', $game_id);
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			$crit->addOrderBy('equippable_item_cards.original_card_id', Criteria::SORT_ASC);
			return $this->select($crit);
		}

		public function getDescendantCards($card_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.original_card_id', $card_id);
			return $this->select($crit);
		}

		public function removeUserCards($user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id === null) {
				$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			} else {
				$crit->addWhere('equippable_item_cards.user_id', $user_id);
			}
			$this->doDelete($crit);
		}

		public function resetUserCards($game_id = null, $user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id !== null) {
				$crit->addWhere('equippable_item_cards.user_id', $user_id);
			} else {
				$crit->addWhere('equippable_item_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			}
			if ($game_id !== null) $crit->addWhere('equippable_item_cards.game_id', $game_id);
			$crit->addUpdate('equippable_item_card.slot', 0);
			$crit->addUpdate('equippable_item_card.game_id', 0);
			$crit->addUpdate('equippable_item_card.is_in_play', false);
			$crit->addUpdate('equippable_item_card.powerup_slot_1', false);
			$crit->addUpdate('equippable_item_card.powerup_slot_2', false);
			$this->doUpdate($crit);
		}

		public function resetAICards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.game_id', 0);
			$ctn = $crit->returnCriterion('equippable_item_cards.user_id', 21);
			$ctn->addOr('equippable_item_cards.user_id', 22);
			$ctn->addOr('equippable_item_cards.user_id', 23);
			$crit->addWhere($ctn);
			$this->doDelete($crit);
		}

	}