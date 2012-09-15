<?php 

	namespace application\modules\game;

	/**
	 * game action components
	 */
	class Components extends \caspar\core\Components
	{
		
		public function componentPlayerHand()
		{
		}
		
		public function componentPlayerPotions()
		{
			$this->cards = \application\entities\tables\PotionItemCards::getTable()->getByUserId($this->getUser()->getId());
		}

		public function componentCardAttack()
		{
			$this->attack_types = \application\entities\Attack::getTypes();
		}
		
	}
