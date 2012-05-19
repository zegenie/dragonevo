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
//			$user = new \application\entities\User();
//			$user->setUsername('zegenie');
//			$user->setPassword('password');
//			$user->setIsAdmin();
//			$user->save();
//			\application\entities\tables\EventCards::getTable()->create();
//			\application\entities\tables\EquippableItemCards::getTable()->create();
//			\application\entities\tables\PotionItemCards::getTable()->create();
//			\application\entities\tables\CreatureCards::getTable()->create();
//			\application\entities\tables\Settings::getTable()->create();
//			\b2db\Core::simpleQuery('ALTER TABLE creature_cards ADD COLUMN base_ep INT(10) DEFAULT 0');
//			\b2db\Core::simpleQuery('ALTER TABLE creature_cards ADD COLUMN base_ep_randomness INT(10) DEFAULT 0');
//			\application\entities\tables\News::getTable()->create();
			\application\entities\tables\Attacks::getTable()->create();
		}

	}