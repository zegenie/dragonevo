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

		public static function getEquippableItemClasses()
		{
			return array(
				ItemCard::CLASS_ARMOR => 'Armor',
				ItemCard::CLASS_ARROW => 'Arrow',
				ItemCard::CLASS_BOW => 'Bow',
				ItemCard::CLASS_SHIELD => 'Shield',
				ItemCard::CLASS_SPEAR => 'Spear',
				ItemCard::CLASS_STAFF => 'Staff',
				ItemCard::CLASS_SWORD => 'Sword'
			);
		}

		public function isDefensive()
		{
			return in_array($this->getItemClass(), array(self::CLASS_ARMOR, self::CLASS_SHIELD));
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
		
		public function isEquippableByCard(CreatureCard $card)
		{
			switch ($card->getCardType()) {
				case CreatureCard::CLASS_CIVILIAN:
					return $this->isEquippableByCivilianCards();
					break;
				case CreatureCard::CLASS_MAGIC:
					return $this->isEquippableByMagicCards();
					break;
				case CreatureCard::CLASS_MILITARY:
					return $this->isEquippableByMilitaryCards();
					break;
				case CreatureCard::CLASS_PHYSICAL:
					return $this->isEquippableByPhysicalCards();
					break;
				case CreatureCard::CLASS_RANGED:
					return $this->isEquippableByRangedCards();
					break;
			}
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

	}
