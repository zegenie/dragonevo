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
	class ItemCard extends PlaceableCard
	{

		const TYPE_POTION = 1;
		const TYPE_ATTACK = 2;

		/**
		 * Item type
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_item_type = 1;

		public function getItemType()
		{
			return $this->_item_type;
		}

		public function setItemType($item_type)
		{
			$this->_item_type = $item_type;
		}


	}
