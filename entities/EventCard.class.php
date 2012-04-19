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
	class EventCard extends ModifierCard
	{

		const TYPE_DAMAGE = 1;
		const TYPE_ALTERATION = 2;

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = \application\entities\Card::TYPE_EVENT;

		/**
		 * Event type
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_event_type = 1;

		/**
		 * Turn duration
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_turn_duration = 1;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_civilian_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_magic_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_military_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_physical_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_ranged_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_low_lvl_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_regular_lvl_cards = false;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_affects_power_lvl_cards = false;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_hp_damage_chance_percent = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_hp_damage_percent_min = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_hp_damage_percent_max = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_stun_chance_percent = 0;

		public static function getEventTypes()
		{
			return array(
				self::TYPE_DAMAGE => 'Damage',
				self::TYPE_ALTERATION => 'Alteration'
			);
		}

		public function getEventType()
		{
			return $this->_event_type;
		}

		public function setEventType($event_type)
		{
			$this->_event_type = $event_type;
		}

		public function getTurnDuration()
		{
			return $this->_turn_duration;
		}

		public function setTurnDuration($turn_duration)
		{
			$this->_turn_duration = $turn_duration;
		}

		public function getAffectsCivilianCards()
		{
			return $this->_affects_civilian_cards;
		}

		public function affectsCivilianCards()
		{
			return $this->_affects_civilian_cards;
		}

		public function setAffectsCivilianCards($affects_civilian_cards)
		{
			$this->_affects_civilian_cards = $affects_civilian_cards;
		}

		public function getAffectsMagicCards()
		{
			return $this->_affects_magic_cards;
		}

		public function affectsMagicCards()
		{
			return $this->_affects_magic_cards;
		}

		public function setAffectsMagicCards($affects_magic_cards)
		{
			$this->_affects_magic_cards = $affects_magic_cards;
		}

		public function getAffectsMilitaryCards()
		{
			return $this->_affects_military_cards;
		}

		public function affectsMilitaryCards()
		{
			return $this->_affects_military_cards;
		}

		public function setAffectsMilitaryCards($affects_military_cards)
		{
			$this->_affects_military_cards = $affects_military_cards;
		}

		public function getAffectsPhysicalCards()
		{
			return $this->_affects_physical_cards;
		}

		public function affectsPhysicalCards()
		{
			return $this->_affects_physical_cards;
		}

		public function setAffectsPhysicalCards($affects_physical_cards)
		{
			$this->_affects_physical_cards = $affects_physical_cards;
		}

		public function getAffectsRangedCards()
		{
			return $this->_affects_ranged_cards;
		}

		public function affectsRangedCards()
		{
			return $this->_affects_ranged_cards;
		}

		public function setAffectsRangedCards($affects_ranged_cards)
		{
			$this->_affects_ranged_cards = $affects_ranged_cards;
		}

		public function getAffectsLowLvlCards()
		{
			return $this->_affects_low_lvl_cards;
		}

		public function affectsLowLvlCards()
		{
			return $this->_affects_low_lvl_cards;
		}

		public function setAffectsLowLvlCards($affects_low_lvl_cards)
		{
			$this->_affects_low_lvl_cards = $affects_low_lvl_cards;
		}

		public function getAffectsRegularLvlCards()
		{
			return $this->_affects_regular_lvl_cards;
		}

		public function affectsRegularLvlCards()
		{
			return $this->_affects_regular_lvl_cards;
		}

		public function setAffectsRegularLvlCards($affects_regular_lvl_cards)
		{
			$this->_affects_regular_lvl_cards = $affects_regular_lvl_cards;
		}

		public function getAffectsPowerLvlCards()
		{
			return $this->_affects_power_lvl_cards;
		}

		public function affectsPowerLvlCards()
		{
			return $this->_affects_power_lvl_cards;
		}

		public function setAffectsPowerLvlCards($affects_power_lvl_cards)
		{
			$this->_affects_power_lvl_cards = $affects_power_lvl_cards;
		}

		public function getHpDamageChancePercent()
		{
			return $this->_hp_damage_chance_percent;
		}

		public function setHpDamageChancePercent($hp_damage_chance_percent)
		{
			$this->_hp_damage_chance_percent = $hp_damage_chance_percent;
		}

		public function getHpDamagePercentMin()
		{
			return $this->_hp_damage_percent_min;
		}

		public function setHpDamagePercentMin($hp_damage_percent_min)
		{
			$this->_hp_damage_percent_min = $hp_damage_percent_min;
		}

		public function getHpDamagePercentMax()
		{
			return $this->_hp_damage_percent_max;
		}

		public function setHpDamagePercentMax($hp_damage_percent_max)
		{
			$this->_hp_damage_percent_max = $hp_damage_percent_max;
		}

		public function getStunChancePercent()
		{
			return $this->_stun_chance_percent;
		}

		public function setStunChancePercent($stun_chance_percent)
		{
			$this->_stun_chance_percent = $stun_chance_percent;
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->_event_type = $form_data['event_type'];
			foreach (array('low', 'regular', 'power') as $level) {
				$lvl_property = "_affects_{$level}_lvl_cards";
				if ($form_data->hasParameter('level_affection')) {
					$this->$lvl_property = array_key_exists($level, $form_data['level_affection']);
				} else {
					$this->$lvl_property = false;
				}
			}
			foreach (array('civilian', 'magic', 'military', 'physical', 'ranged') as $class) {
				$class_property = "_affects_{$class}_cards";
				if ($form_data->hasParameter('card_type_affection')) {
					$this->$class_property = array_key_exists($class, $form_data['card_type_affection']);
				} else {
					$this->$class_property = false;
				}
			}
			if ($this->getEventType() == self::TYPE_DAMAGE) {
				$this->_stun_chance_percent = $form_data['stun_chance_percent'];
				$this->_hp_damage_chance_percent = $form_data['hp_damage_chance_percent'];
				$this->_hp_damage_percent_min = $form_data['hp_damage_percent_min'];
				$this->_hp_damage_percent_max = $form_data['hp_damage_percent_max'];
			}
		}

	}
