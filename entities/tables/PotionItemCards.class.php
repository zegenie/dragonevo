<?php

	namespace application\entities\tables;

	use b2db\Table,
		b2db\Criteria;

	/**
	 * Potion item cards table
	 *
	 * @static \application\entities\tables\PotionItemCards getTable()
	 *
	 * @Table(name="potion_item_cards")
	 * @Entity(class="\application\entities\PotionItemCard")
	 * @Entities(identifier="card_state")
	 * @SubClasses(template="\application\entities\PotionItemCard", owned="\application\entities\UserPotionItemCard")
	 */
	class PotionItemCards extends Table
	{

		public function getAll()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('potion_item_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->select($crit);
		}
		
		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('potion_item_cards.user_id', $user_id);
			$crit->addWhere('potion_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			$crit->addOrderBy('potion_item_cards.original_card_id', Criteria::SORT_ASC);

			return $this->select($crit);
		}

		public function getDescendantCards($card_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('potion_item_cards.original_card_id', $card_id);
			return $this->select($crit);
		}

		public function removeUserCards($user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id === null) {
				$crit->addWhere('potion_item_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			} else {
				$crit->addWhere('potion_item_cards.user_id', $user_id);
			}
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$card_id = $row->get('potion_item_cards.id');
					$this->doDeleteById($card_id);
				}
			}
		}

		public function resetUserCards($game_id = null, $user_id = null)
		{
			$crit = $this->getCriteria();
			if ($user_id !== null) {
				$crit->addWhere('potion_item_cards.user_id', $user_id);
			} else {
				$crit->addWhere('potion_item_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			}
			if ($game_id !== null) $crit->addWhere('potion_item_cards.game_id', $game_id);
			$crit->addUpdate('potion_item_card.slot', 0);
			$crit->addUpdate('potion_item_card.game_id', 0);
			$crit->addUpdate('potion_item_card.is_in_play', false);
			$this->doUpdate($crit);
		}

	}