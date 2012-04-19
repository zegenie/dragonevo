<?php

	namespace application\entities\tables;

	/**
	 * Potion item cards table
	 *
	 * @static \application\entities\tables\PotionItemCards getTable()
	 *
	 * @Table(name="potion_item_cards")
	 * @Entity(class="\application\entities\PotionItemCard")
	 */
	class PotionItemCards extends \b2db\Table
	{

		public function getAll()
		{
			return $this->selectAll();
		}
		
		public function getByFaction($faction)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('potion_item_cards.faction', $faction);
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

	}