<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\ItemCards")
	 */
	class ItemCard extends ModifierCard
	{

		const CLASS_SWORD = 1;
		const CLASS_BOW = 2;
		const CLASS_SHIELD = 3;
		const CLASS_SPEAR = 4;
		const CLASS_ARMOR = 5;
		const CLASS_ARROW = 6;
		const CLASS_STAFF = 7;
		const CLASS_MAGIC = 8;
		const CLASS_POTION_HEALTH = 10;
		const CLASS_POTION_ALTERATION = 11;

		/**
		 * Item class
		 *
		 * @Column(type="integer", length=10, not_null=true)
		 * @var integer
		 */
		protected $_item_class;

		public static function getItemClasses()
		{
			$classes = array(
				self::CLASS_ARMOR => 'Armor',
				self::CLASS_ARROW => 'Arrow',
				self::CLASS_BOW => 'Bow',
				self::CLASS_SHIELD => 'Shield',
				self::CLASS_SPEAR => 'Spear',
				self::CLASS_STAFF => 'Staff',
				self::CLASS_SWORD => 'Sword',
				self::CLASS_MAGIC => 'Magic',
				);
			
			return $classes;
		}

		public function getItemClass()
		{
			return $this->_item_class;
		}

		public function setItemClass($item_class)
		{
			$this->_item_class = $item_class;
		}

	}
