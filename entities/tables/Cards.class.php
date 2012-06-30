<?php

	namespace application\entities\tables;

	use application\entities\Card;

	/**
	 * @Table(name="cards")
	 * @Entity(class="\application\entities\Card")
	 */
	class Cards extends \b2db\Table
	{

		public function getCardByUniqueId($unique_id)
		{
			$delimiter = strrpos($unique_id, '_');
			$type = substr($unique_id, 0, $delimiter);
			$card_id = substr($unique_id, $delimiter + 1);

			switch ($type) {
				case Card::TYPE_EVENT:
					$card = \application\entities\tables\EventCards::getTable()->selectById($card_id);
					break;
				case Card::TYPE_CREATURE:
					$card = \application\entities\tables\CreatureCards::getTable()->selectById($card_id);
					break;
				case Card::TYPE_EQUIPPABLE_ITEM:
					$card = \application\entities\tables\EquippableItemCards::getTable()->selectById($card_id);
					break;
				case Card::TYPE_POTION_ITEM:
					$card = \application\entities\tables\PotionItemCards::getTable()->selectById($card_id);
					break;
			}

			return $card;
		}

	}