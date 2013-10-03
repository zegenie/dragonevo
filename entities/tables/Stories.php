<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="stories")
	 * @Entity(class="\application\entities\Story")
	 */
	class Stories extends \b2db\Table
	{

		public function getAll()
		{
			return $this->selectAll();
		}

	}