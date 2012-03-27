<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\PotionItemCards")
	 */
	class PotionItemCard extends ItemCard
	{

		protected $_number_of_uses = 1;

		protected $_is_one_time_item = true;

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

		protected function _preSave($is_new = false)
		{
			if ($is_new) {
				$this->setItemClass(ItemCard::CLASS_POTION);
			}
		}

	}
