<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\EventCards")
	 */
	class EventCard extends PlaceableCard
	{

		const TYPE_DAMAGE = 1;
		const TYPE_ALTERATION = 2;

		/**
		 * Event type
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_event_type = 1;

		public function getEventType()
		{
			return $this->_event_type;
		}

		public function setEventType($item_type)
		{
			$this->_event_type = $item_type;
		}


	}
