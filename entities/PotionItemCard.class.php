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

		/**
		 * Turn duration
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_turn_duration = 1;

		/**
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_number_of_uses = 1;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_one_time_potion = true;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_restores_health_percentage = 0;

		/**
		 * Item class
		 *
		 * @Column(type="integer", length=10, not_null=true, default=10)
		 * @var integer
		 */
		protected $_item_class = ItemCard::CLASS_POTION_HEALTH;

		public static function getPotionTypes()
		{
			return array(
				self::CLASS_POTION_HEALTH => 'Health potion',
				self::CLASS_POTION_ALTERATION => 'Boost potion'
			);
		}

		public function getTurnDuration()
		{
			return $this->_turn_duration;
		}

		public function setTurnDuration($turn_duration)
		{
			$this->_turn_duration = $turn_duration;
		}

		public function getNumberOfUses()
		{
			return $this->_number_of_uses;
		}

		public function setNumberOfUses($number_of_uses)
		{
			$this->_number_of_uses = $number_of_uses;
		}

		public function getIsOneTimePotion()
		{
			return $this->_is_one_time_potion;
		}

		public function isOneTimePotion()
		{
			return $this->getIsOneTimePotion();
		}

		public function setIsOneTimePotion($is_one_time_potion)
		{
			$this->_is_one_time_potion = $is_one_time_potion;
		}

		public function getRestoresHealthPercentage()
		{
			return $this->_restores_health_percentage;
		}

		public function setRestoresHealthPercentage($restores_health_percentage)
		{
			$this->_restores_health_percentage = $restores_health_percentage;
		}

		public function getPotionType()
		{
			return $this->getItemClass();
		}

		public function setPotionType($potion_type)
		{
			$this->setItemClass($potion_type);
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->setPotionType($form_data['item_class']);
			$this->_is_one_time_potion = (bool) $form_data['is_one_time_potion'];
			$this->_number_of_uses = (bool) $form_data['number_of_uses'];
			if ($this->getPotionType() == ItemCard::CLASS_POTION_ALTERATION) {
				$this->_turn_duration = $form_data['turn_duration'];
			}
			elseif ($this->getPotionType() == ItemCard::CLASS_POTION_HEALTH) {
				$this->_restores_health_percentage = $form_data['restores_health_percentage'];
			}
		}

	}
