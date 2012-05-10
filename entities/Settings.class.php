<?php

	namespace application\entities;

	use \caspar\core\Caspar,
		\application\entities\tables\Settings as SettingsTable;

	/**
	 * Settings class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Settings")
	 */
	class Settings
	{

		const SETTING_CARD_OF_THE_WEEK = 'card_of_the_week';

		protected static $_settings = null;
		protected static $_loadedsettings = array();

		public static function forceSettingsReload()
		{
			self::$_settings = null;
		}
		
		public static function loadSettings($uid = 0)
		{
			if (self::$_settings === null || ($uid > 0 && !array_key_exists($uid, self::$_loadedsettings))) {
				if (self::$_settings === null)
					self::$_settings = array();
				
				if ($res = SettingsTable::getTable()->getSettings($uid)) {
					$cc = 0;
					while ($row = $res->getNextRow()) {
						$cc++;
						self::$_settings[$row->get('settings.name')][$row->get('settings.user_id')] = $row->get('settings.value');
					}
				}
				self::$_loadedsettings[$uid] = true;
			}
		}

		public static function saveSetting($name, $value, $uid = 0)
		{
			SettingsTable::getTable()->saveSetting($name, $value, $uid);
			self::$_settings[$name][$uid] = $value;
		}
		
		public static function set($name, $value, $uid = 0)
		{
			self::$_settings[$name][$uid] = $value;
		}
	
		public static function get($name, $uid = 0)
		{
			if (self::$_settings === null)
				self::loadSettings();

			if ($uid > 0 && !array_key_exists($uid, self::$_loadedsettings))
				self::loadSettings($uid);

			if (!array_key_exists($name, self::$_settings))
				return null;

			if ($uid !== 0 && array_key_exists($uid, self::$_settings[$name]))
				return self::$_settings[$name][$uid];

			if (!array_key_exists($uid, self::$_settings[$name]))
				return null;

			return self::$_settings[$name][$uid];
		}
		
		public static function deleteSetting($name, $uid)
		{
			SettingsTable::getTable()->deleteSetting($name, $uid);
			unset(self::$_settings[$name][$uid]);
		}

		public static function getCardOfTheWeek()
		{
			$card = self::get(self::SETTING_CARD_OF_THE_WEEK);
			if ($card) {
				list($card_type, $card_id) = explode('_', $card);
				switch ($card_type) {
					case 'creature':
						$card = new CreatureCard($card_id);
						break;
					case 'event':
						$card = new EventCard($card_id);
						break;
					case 'item':
						$card = new PotionItemCard($card_id);
						break;
				}
			}
			return $card;
		}
	
	}
