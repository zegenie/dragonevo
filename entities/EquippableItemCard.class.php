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

		protected $_equippable_by_civilian_cards = false;
		protected $_equippable_by_magic_cards = false;
		protected $_equippable_by_military_cards = false;
		protected $_equippable_by_physical_cards = false;
		protected $_equippable_by_ranged_cards = false;

		protected $_equippable_by_low_lvl_cards = false;
		protected $_equippable_by_regular_lvl_cards = false;
		protected $_equippable_by_power_lvl_cards = false;

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

	}
