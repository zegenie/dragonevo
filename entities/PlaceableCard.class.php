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
		 * Whether the card is a special card or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_special_card = false;

		public function getIsSpecialCard()
		{
			return (bool) $this->_is_special_card;
		}

		public function isSpecialCard()
		{
			return $this->getIsSpecialCard();
		}

		public function setIsSpecialCard($is_special_card = true)
		{
			$this->_is_special_card = (bool) $is_special_card;
		}

	}
