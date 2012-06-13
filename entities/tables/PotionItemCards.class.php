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
			return $this->select($crit);
		}

		public function getByUserIdAndGameId($user_id, $game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('potion_item_cards.user_id', $user_id);
			$crit->addWhere('potion_item_cards.game_id', $game_id);
			$crit->addWhere('potion_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->select($crit);
		}

		public function removeUserCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('potion_item_cards.user_id', 0, Criteria::DB_NOT_EQUALS);
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$card_id = $row->get('potion_item_cards.id');
					$this->doDeleteById($card_id);
				}
			}
		}

	}