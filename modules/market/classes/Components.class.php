<?php 

	namespace application\modules\market;

	/**
	 * market action components
	 */
	class Components extends \caspar\core\Components
	{

		/**
		 * Index page
		 *
		 * @param Request $request
		 */
		public function componentMarketContent()
		{
			$this->factions = \application\entities\Card::getFactions();
			$this->itemclasses = \application\entities\EquippableItemCard::getEquippableItemClasses();
			$this->allcards = array('creature' => \application\entities\tables\CreatureCards::getTable()->getAllCards(),
				'potion_cards' => \application\entities\tables\PotionItemCards::getTable()->getAll(),
				'item_cards' => \application\entities\tables\EquippableItemCards::getTable()->getAll());
		}

		/**
		 * Index page
		 *
		 * @param Request $request
		 */
		public function componentBuyContent()
		{
			$this->factions = \application\entities\Card::getFactions();
			$this->itemclasses = \application\entities\EquippableItemCard::getEquippableItemClasses();
		}

		/**
		 * Index page
		 *
		 * @param Request $request
		 */
		public function componentBuyCards()
		{
			$this->allcards = array('creature' => \application\entities\tables\CreatureCards::getTable()->getAllCards(),
				'potion_cards' => \application\entities\tables\PotionItemCards::getTable()->getAll(),
				'item_cards' => \application\entities\tables\EquippableItemCards::getTable()->getAll());
		}

		
	}
