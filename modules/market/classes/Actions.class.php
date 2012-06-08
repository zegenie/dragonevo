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
//			$user->setUsername('thondal');
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
//			\application\entities\tables\Attacks::getTable()->create();
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN attack_points_restored INT(5) DEFAULT 0');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN generate_magic_amount INT(5) DEFAULT 0');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN generate_gold_amount INT(5) DEFAULT 0');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN generate_hp_amount INT(5) DEFAULT 0');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN attack_all BOOLEAN DEFAULT false');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN requires_item_both BOOLEAN DEFAULT false');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks DROP COLUMN requires_item_card_type');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN requires_item_card_type_1 INT(5) DEFAULT 0');
//			\b2db\Core::simpleQuery('ALTER TABLE attacks ADD COLUMN requires_item_card_type_2 INT(5) DEFAULT 0');
//			\application\entities\tables\ChatRooms::getTable()->create();
//			\application\entities\tables\ChatLines::getTable()->create();
//			$lobby = new \application\entities\ChatRoom();
//			$lobby->setTopic('Welcome to the Dragon Evo lobby chat. This chat room is open for all users.');
//			$lobby->save();
//			\b2db\Core::simpleQuery('ALTER TABLE creature_cards ADD COLUMN user_card_level INT(10) DEFAULT 1');
//			\b2db\Core::simpleQuery('ALTER TABLE creature_cards ADD COLUMN user_dmp INT(5) DEFAULT 1');
//			-------------------
//			\application\entities\tables\Games::getTable()->create();
//			\application\entities\tables\GameInvites::getTable()->create();
//			\application\entities\tables\GameEvents::getTable()->create();
//			-------------------
			\b2db\Core::simpleQuery('ALTER TABLE games ADD COLUMN current_phase INT(10) DEFAULT 0');
			\b2db\Core::simpleQuery('ALTER TABLE creature_cards ADD COLUMN slot INT(10) DEFAULT 0');
			\b2db\Core::simpleQuery('ALTER TABLE equippable_item_cards ADD COLUMN slot INT(10) DEFAULT 0');
			\b2db\Core::simpleQuery('ALTER TABLE potion_item_cards ADD COLUMN slot INT(10) DEFAULT 0');
			\b2db\Core::simpleQuery('ALTER TABLE event_cards ADD COLUMN slot INT(10) DEFAULT 0');
		}

	}