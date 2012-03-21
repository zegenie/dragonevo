<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\PlacableCards")
	 */
	abstract class PlaceableCard extends Card
	{

		/**
		 * Base health
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_base_health = 1;

		/**
		 * Whether the card is a special card or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_special_card = false;

		public function getBaseHealth()
		{
			return (int) $this->_base_health;
		}

		public function setBaseHealth($base_health)
		{
			$this->_base_health = (int) $base_health;
		}

		public function getIsSpecialCard()
		{
			return (bool) $this->_is_special_card;
		}

		public function setIsSpecialCard($is_special_card = true)
		{
			$this->_is_special_card = (bool) $is_special_card;
		}

	}
