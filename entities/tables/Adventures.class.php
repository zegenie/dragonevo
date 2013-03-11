<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="adventures")
	 * @Entity(class="\application\entities\Adventure")
	 */
	class Adventures extends \b2db\Table
	{

		public function getAll()
		{
			return $this->selectAll();
		}

	}