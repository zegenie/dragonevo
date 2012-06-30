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
		}

		public function componentCardAttack()
		{
			$this->attack_types = \application\entities\Attack::getTypes();
		}
		
	}
