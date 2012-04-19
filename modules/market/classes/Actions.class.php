<?php 

	namespace application\modules\market;

	use \caspar\core\Request;

	/**
	 * Actions for the market module
	 */
	class Actions extends \caspar\core\Actions
	{

		/**
		 * Index page
		 *  
		 * @param Request $request
		 */
		public function runIndex(Request $request)
		{
			\application\entities\tables\EventCards::getTable()->create();
			\application\entities\tables\EquippableItemCards::getTable()->create();
			\application\entities\tables\PotionItemCards::getTable()->create();
			\application\entities\tables\CreatureCards::getTable()->create();
		}

	}