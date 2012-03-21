<?php

	namespace application\entities\tables;

	/**
	 * Event cards table
	 *
	 * @static \application\entities\tables\EventCards getTable()
	 *
	 * @Table(name="event_cards")
	 * @Entity(class="\application\entities\EventCard")
	 */
	class EventCards extends \b2db\Table
	{
		
		public function getAll()
		{
			return $this->selectAll();
		}

	}