<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\EquippableItemCards")
	 */
	class EquippableItemCard extends ItemCard
	{

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = Card::TYPE_EQUIPPABLE_ITEM;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_civilian_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_magic_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_military_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_physical_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_ranged_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_low_lvl_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_regular_lvl_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_equippable_by_power_lvl_cards = false;

		/**
		 * Whether this card is using powerup slot 1
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_powerup_slot_1 = false;

		/**
		 * Whether this card is using powerup slot 2
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_powerup_slot_2 = false;

		public static function getEquippableItemClasses()
		{
			return array(
				self::CLASS_ARMOR => 'Armor',
				self::CLASS_BOW => 'Bow',
				self::CLASS_SHIELD => 'Shield',
				self::CLASS_SPEAR => 'Spear',
				self::CLASS_SWORD => 'Sword'
			);
		}

		public function getEquippableByCivilianCards()
		{
			return $this->_equippable_by_civilian_cards;
		}

		public function isEquippableByCivilianCards()
		{
			return $this->_equippable_by_civilian_cards;
		}

		public function setEquippableByCivilianCards($equippable_by_civilian_cards)
		{
			$this->_equippable_by_civilian_cards = $equippable_by_civilian_cards;
		}

		public function getEquippableByMagicCards()
		{
			return $this->_equippable_by_magic_cards;
		}

		public function isEquippableByMagicCards()
		{
			return $this->_equippable_by_magic_cards;
		}

		public function setEquippableByMagicCards($equippable_by_magic_cards)
		{
			$this->_equippable_by_magic_cards = $equippable_by_magic_cards;
		}

		public function getEquippableByMilitaryCards()
		{
			return $this->_equippable_by_military_cards;
		}

		public function isEquippableByMilitaryCards()
		{
			return $this->_equippable_by_military_cards;
		}

		public function setEquippableByMilitaryCards($equippable_by_military_cards)
		{
			$this->_equippable_by_military_cards = $equippable_by_military_cards;
		}

		public function getEquippableByPhysicalCards()
		{
			return $this->_equippable_by_physical_cards;
		}

		public function isEquippableByPhysicalCards()
		{
			return $this->_equippable_by_physical_cards;
		}

		public function setEquippableByPhysicalCards($equippable_by_physical_cards)
		{
			$this->_equippable_by_physical_cards = $equippable_by_physical_cards;
		}

		public function getEquippableByRangedCards()
		{
			return $this->_equippable_by_ranged_cards;
		}

		public function isEquippableByRangedCards()
		{
			return $this->_equippable_by_ranged_cards;
		}

		public function setEquippableByRangedCards($equippable_by_ranged_cards)
		{
			$this->_equippable_by_ranged_cards = $equippable_by_ranged_cards;
		}

		public function getEquippableByLowLvlCards()
		{
			return $this->_equippable_by_low_lvl_cards;
		}

		public function isEquippableByLowLvlCards()
		{
			return $this->_equippable_by_low_lvl_cards;
		}

		public function setEquippableByLowLvlCards($equippable_by_low_lvl_cards)
		{
			$this->_equippable_by_low_lvl_cards = $equippable_by_low_lvl_cards;
		}

		public function getEquippableByRegularLvlCards()
		{
			return $this->_equippable_by_regular_lvl_cards;
		}

		public function isEquippableByRegularLvlCards()
		{
			return $this->_equippable_by_regular_lvl_cards;
		}

		public function setEquippableByRegularLvlCards($equippable_by_regular_lvl_cards)
		{
			$this->_equippable_by_regular_lvl_cards = $equippable_by_regular_lvl_cards;
		}

		public function getEquippableByPowerLvlCards()
		{
			return $this->_equippable_by_power_lvl_cards;
		}

		public function isEquippableByPowerLvlCards()
		{
			return $this->_equippable_by_power_lvl_cards;
		}

		public function setEquippableByPowerLvlCards($equippable_by_power_lvl_cards)
		{
			$this->_equippable_by_power_lvl_cards = $equippable_by_power_lvl_cards;
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->setItemClass($form_data['item_class']);
			foreach (array('low', 'regular', 'power') as $level) {
				$lvl_property = "_equippable_by_{$level}_lvl_cards";
				if ($form_data->hasParameter('level_equippable')) {
					$this->$lvl_property = array_key_exists($level, $form_data['level_equippable']);
				} else {
					$this->$lvl_property = false;
				}
			}
			foreach (array('civilian', 'magic', 'military', 'physical', 'ranged') as $class) {
				$class_property = "_equippable_by_{$class}_cards";
				if ($form_data->hasParameter('card_type_equippable')) {
					$this->$class_property = array_key_exists($class, $form_data['card_type_equippable']);
				} else {
					$this->$class_property = false;
				}
			}
		}

		public function getPowerupSlot1()
		{
			return $this->_powerup_slot_1;
		}

		public function isPowerupSlot1()
		{
			return $this->getPowerupSlot1();
		}

		public function setPowerupSlot1($powerup_slot_1 = true)
		{
			$this->_powerup_slot_1 = $powerup_slot_1;
		}

		public function getPowerupSlot2()
		{
			return $this->_powerup_slot_2;
		}

		public function isPowerupSlot2()
		{
			return $this->getPowerupSlot2();
		}

		public function setPowerupSlot2($powerup_slot_2 = true)
		{
			$this->_powerup_slot_2 = $powerup_slot_2;
		}

	}
