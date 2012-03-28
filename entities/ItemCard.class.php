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
		const CLASS_POTION_HEALTH = 10;
		const CLASS_POTION_ALTERATION = 11;

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = Card::TYPE_ITEM;

		/**
		 * Item class
		 *
		 * @Column(type="integer", length=10, not_null=true)
		 * @var integer
		 */
		protected $_item_class;

		public function getItemClass()
		{
			return $this->_item_class;
		}

		public function setItemClass($item_class)
		{
			$this->_item_class = $item_class;
		}

	}
