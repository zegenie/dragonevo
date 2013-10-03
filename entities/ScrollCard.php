<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo action card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\ActionCards")
	 */
	class ScrollCard extends Card
	{

		const TYPE_POTION = 1;
		const TYPE_ATTACK_AIR = 10;
		const TYPE_ATTACK_DARK = 11;
		const TYPE_ATTACK_EARTH = 12;
		const TYPE_ATTACK_FIRE = 13;
		const TYPE_ATTACK_FREEZE = 14;
		const TYPE_ATTACK_MELEE = 15;
		const TYPE_ATTACK_POISON = 16;
		const TYPE_ATTACK_RANGED = 17;
		const TYPE_DEFENCE_AIR = 20;
		const TYPE_DEFENCE_DARK = 21;
		const TYPE_DEFENCE_EARTH = 22;
		const TYPE_DEFENCE_FIRE = 23;
		const TYPE_DEFENCE_FREEZE = 24;
		const TYPE_DEFENCE_MELEE = 25;
		const TYPE_DEFENCE_POISON = 26;
		const TYPE_DEFENCE_RANGED = 27;

		const CLASS_SCROLL = 1;
		const CLASS_POTION = 2;

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = \application\entities\Card::TYPE_ITEM;

		/**
		 * Item class
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_item_class = 1;

		/**
		 * How many uses an item has before it expires
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_number_of_uses = 1;

		/**
		 * Whether this is a one-time item that is completely
		 * discarded when it expires after use
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_one_time_item = false;

		public function getItemClass()
		{
			return $this->_item_class;
		}

		public function setItemClass($item_class)
		{
			$this->_item_class = $item_class;
		}

		public function getItemType()
		{
			return $this->_item_type;
		}

		public function setItemType($item_type)
		{
			$this->_item_type = $item_type;
		}

		public function getNumberOfUses()
		{
			return $this->_number_of_uses;
		}

		public function setNumberOfUses($number_of_uses)
		{
			$this->_number_of_uses = $number_of_uses;
		}

		public function getIsOneTimeItem()
		{
			return $this->_is_one_time_item;
		}

		public function isOneTimeItem()
		{
			return $this->getOneTimeItem();
		}

		public function setIsOneTimeItem($is_one_time_item)
		{
			$this->_is_one_time_item = $is_one_time_item;
		}

	}
