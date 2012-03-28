<?php

	namespace application\entities\tables;

	/**
	 * Potion item cards table
	 *
	 * @static \application\entities\tables\PotionItemCards getTable()
	 *
	 * @Table(name="potion_item_cards")
	 * @Entity(class="\application\entities\PotionItemCard")
	 */
	class PotionItemCards extends \b2db\Table
	{

		public function getAll()
		{
			return $this->selectAll();
		}

	}