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

		public function getShowcasedCards()
		{
			$cards = array();
			foreach (CreatureCards::getTable()->getShowcasedCards() as $card) {
				$cards[] = $card;
			}
			foreach (EquippableItemCards::getTable()->getShowcasedCards() as $card) {
				$cards[] = $card;
			}
			foreach (PotionItemCards::getTable()->getShowcasedCards() as $card) {
				$cards[] = $card;
			}

			return $cards;
		}
		
		public static function pickCards($cards, $player, $num = 5)
		{
			if (!count($cards)) return array();
			$pickablecards = array();
			foreach ($cards as $card) {
				if ($card->getLikelihood() == 0) continue;
				for($cc = 1;$cc <= $card->getLikelihood();$cc++) {
					$pickablecards[] = $card->getId();
				}
			}

			$return_cards = array();
			$cc = 1;
			while ($cc <= $num) {
				if (empty($pickablecards)) break;

				$id = array_rand($pickablecards);
				$card_id = $pickablecards[$id];
				if (array_key_exists($card_id, $cards)) {
					$card = $cards[$card_id];
					$picked_card = $player->giveCard($card);
					$return_cards[$picked_card->getId()] = $picked_card;
					unset($pickablecards[$id]);
					$cc++;
				}
			}

			return $return_cards;
		}

	}