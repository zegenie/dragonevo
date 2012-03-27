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
	class ItemCard extends Card
	{

		const CLASS_POTION = 1;
		const CLASS_SWORD = 2;
		const CLASS_BOW = 3;
		const CLASS_SHIELD = 4;
		const CLASS_SPEAR = 5;
		const CLASS_ARMOR = 6;

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = Card::TYPE_ITEM;

		/**
		 * Item class
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_item_class = 1;

		public function getItemClass()
		{
			return $this->_item_class;
		}

		public function setItemClass($item_class)
		{
			$this->_item_class = $item_class;
		}

	}
