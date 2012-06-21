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
					$card = new \application\entities\EventCard($card_id);
					break;
				case Card::TYPE_CREATURE:
					$card = new \application\entities\CreatureCard($card_id);
					break;
				case Card::TYPE_EQUIPPABLE_ITEM:
					$card = new \application\entities\EquippableItemCard($card_id);
					break;
				case Card::TYPE_POTION_ITEM:
					$card = new \application\entities\PotionItemCard($card_id);
					break;
			}

			return $card;
		}

	}