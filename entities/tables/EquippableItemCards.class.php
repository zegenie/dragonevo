<?php

	namespace application\entities\tables;

	/**
	 * Equippable item cards table
	 *
	 * @static \application\entities\tables\EquippableItemCards getTable()
	 *
	 * @Table(name="equippable_item_cards")
	 * @Entity(class="\application\entities\EquippableItemCard")
	 */
	class EquippableItemCards extends \b2db\Table
	{

		public function getAll()
		{
			return $this->selectAll();
		}

	}