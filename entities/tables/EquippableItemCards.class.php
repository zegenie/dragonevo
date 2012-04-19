<?php

	namespace application\entities\tables;

	/**
	 * Equippable item cards table
	 *
	 * @static \application\entities\tables\EquippableItemCards getTable()
	 *
	 * @Table(name="equippable_item_cards")
	 * @Entity(class="\application\entities\EquippableItemCard")
	 */
	class EquippableItemCards extends \b2db\Table
	{

		public function getAll()
		{
			return $this->selectAll();
		}
		
		public function getByFaction($faction)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.faction', $faction);
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->select($crit);
		}

		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('equippable_item_cards.user_id', $user_id);
			$crit->addWhere('equippable_item_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->select($crit);
		}

	}