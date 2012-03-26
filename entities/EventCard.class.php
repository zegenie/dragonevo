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

		protected $_affects_civilian_cards = false;
		protected $_affects_magic_cards = false;
		protected $_affects_military_cards = false;
		protected $_affects_physical_cards = false;
		protected $_affects_ranged_cards = false;

		protected $_affects_low_lvl_cards = false;
		protected $_affects_regular_lvl_cards = false;
		protected $_affects_power_lvl_cards = false;

		protected $_increases_basic_attack_percentage = 0;
		protected $_decreases_basic_attack_percentage = 0;

		protected $_increases_air_attack_percentage = 0;
		protected $_decreases_air_attack_percentage = 0;

		protected $_increases_dark_attack_percentage = 0;
		protected $_decreases_dark_attack_percentage = 0;

		protected $_increases_earth_attack_percentage = 0;
		protected $_decreases_earth_attack_percentage = 0;

		protected $_increases_fire_attack_percentage = 0;
		protected $_decreases_fire_attack_percentage = 0;

		protected $_increases_freeze_attack_percentage = 0;
		protected $_decreases_freeze_attack_percentage = 0;

		protected $_increases_melee_attack_percentage = 0;
		protected $_decreases_melee_attack_percentage = 0;

		protected $_increases_poison_attack_percentage = 0;
		protected $_decreases_poison_attack_percentage = 0;

		protected $_increases_ranged_attack_percentage = 0;
		protected $_decreases_ranged_attack_percentage = 0;

		protected $_hp_damage_chance_percent = 0;
		protected $_hp_damage_percent_min = 0;
		protected $_hp_damage_percent_max = 0;

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

		public function setEventType($item_type)
		{
			$this->_event_type = $item_type;
		}

		public function getTurnDuration()
		{
			return $this->_turn_duration;
		}

		public function setTurnDuration($turn_duration)
		{
			$this->_turn_duration = $turn_duration;
		}

		public function mergeFormData($form_data = array())
		{
			parent::mergeFormData($form_data);
		}

		public function getIncreasesBasicAttackPercentage()
		{
			return $this->_increases_basic_attack_percentage;
		}

		public function setIncreasesBasicAttackPercentage($increases_basic_attack_percentage)
		{
			$this->_increases_basic_attack_percentage = $increases_basic_attack_percentage;
		}

		public function getDecreasesBasicAttackPercentage()
		{
			return $this->_decreases_basic_attack_percentage;
		}

		public function setDecreasesBasicAttackPercentage($decreases_basic_attack_percentage)
		{
			$this->_decreases_basic_attack_percentage = $decreases_basic_attack_percentage;
		}

		public function getBasicAttackModifier()
		{
			return $this->getIncreasesBasicAttackPercentage() + $this->getDecreasesBasicAttackPercentage();
		}

		public function getIncreasesAirAttackPercentage()
		{
			return $this->_increases_air_attack_percentage;
		}

		public function setIncreasesAirAttackPercentage($increases_air_attack_percentage)
		{
			$this->_increases_air_attack_percentage = $increases_air_attack_percentage;
		}

		public function getDecreasesAirAttackPercentage()
		{
			return $this->_decreases_air_attack_percentage;
		}

		public function setDecreasesAirAttackPercentage($decreases_air_attack_percentage)
		{
			$this->_decreases_air_attack_percentage = $decreases_air_attack_percentage;
		}

		public function getAirAttackModifier()
		{
			return $this->getIncreasesAirAttackPercentage() + $this->getDecreasesAirAttackPercentage();
		}

		public function getIncreasesDarkAttackPercentage()
		{
			return $this->_increases_dark_attack_percentage;
		}

		public function setIncreasesDarkAttackPercentage($increases_dark_attack_percentage)
		{
			$this->_increases_dark_attack_percentage = $increases_dark_attack_percentage;
		}

		public function getDecreasesDarkAttackPercentage()
		{
			return $this->_decreases_dark_attack_percentage;
		}

		public function setDecreasesDarkAttackPercentage($decreases_dark_attack_percentage)
		{
			$this->_decreases_dark_attack_percentage = $decreases_dark_attack_percentage;
		}

		public function getDarkAttackModifier()
		{
			return $this->getIncreasesDarkAttackPercentage() + $this->getDecreasesDarkAttackPercentage();
		}

		public function getIncreasesEarthAttackPercentage()
		{
			return $this->_increases_earth_attack_percentage;
		}

		public function setIncreasesEarthAttackPercentage($increases_earth_attack_percentage)
		{
			$this->_increases_earth_attack_percentage = $increases_earth_attack_percentage;
		}

		public function getDecreasesEarthAttackPercentage()
		{
			return $this->_decreases_earth_attack_percentage;
		}

		public function setDecreasesEarthAttackPercentage($decreases_earth_attack_percentage)
		{
			$this->_decreases_earth_attack_percentage = $decreases_earth_attack_percentage;
		}

		public function getEarthAttackModifier()
		{
			return $this->getIncreasesEarthAttackPercentage() + $this->getDecreasesEarthAttackPercentage();
		}

		public function getIncreasesFireAttackPercentage()
		{
			return $this->_increases_fire_attack_percentage;
		}

		public function setIncreasesFireAttackPercentage($increases_fire_attack_percentage)
		{
			$this->_increases_fire_attack_percentage = $increases_fire_attack_percentage;
		}

		public function getDecreasesFireAttackPercentage()
		{
			return $this->_decreases_fire_attack_percentage;
		}

		public function setDecreasesFireAttackPercentage($decreases_fire_attack_percentage)
		{
			$this->_decreases_fire_attack_percentage = $decreases_fire_attack_percentage;
		}

		public function getFireAttackModifier()
		{
			return $this->getIncreasesFireAttackPercentage() + $this->getDecreasesFireAttackPercentage();
		}

		public function getIncreasesFreezeAttackPercentage()
		{
			return $this->_increases_freeze_attack_percentage;
		}

		public function setIncreasesFreezeAttackPercentage($increases_freeze_attack_percentage)
		{
			$this->_increases_freeze_attack_percentage = $increases_freeze_attack_percentage;
		}

		public function getDecreasesFreezeAttackPercentage()
		{
			return $this->_decreases_freeze_attack_percentage;
		}

		public function setDecreasesFreezeAttackPercentage($decreases_freeze_attack_percentage)
		{
			$this->_decreases_freeze_attack_percentage = $decreases_freeze_attack_percentage;
		}

		public function getFreezeAttackModifier()
		{
			return $this->getIncreasesFreezeAttackPercentage() + $this->getDecreasesFreezeAttackPercentage();
		}

		public function getIncreasesMeleeAttackPercentage()
		{
			return $this->_increases_melee_attack_percentage;
		}

		public function setIncreasesMeleeAttackPercentage($increases_melee_attack_percentage)
		{
			$this->_increases_melee_attack_percentage = $increases_melee_attack_percentage;
		}

		public function getDecreasesMeleeAttackPercentage()
		{
			return $this->_decreases_melee_attack_percentage;
		}

		public function setDecreasesMeleeAttackPercentage($decreases_melee_attack_percentage)
		{
			$this->_decreases_melee_attack_percentage = $decreases_melee_attack_percentage;
		}

		public function getMeleeAttackModifier()
		{
			return $this->getIncreasesMeleeAttackPercentage() + $this->getDecreasesMeleeAttackPercentage();
		}

		public function getIncreasesPoisonAttackPercentage()
		{
			return $this->_increases_poison_attack_percentage;
		}

		public function setIncreasesPoisonAttackPercentage($increases_poison_attack_percentage)
		{
			$this->_increases_poison_attack_percentage = $increases_poison_attack_percentage;
		}

		public function getDecreasesPoisonAttackPercentage()
		{
			return $this->_decreases_poison_attack_percentage;
		}

		public function setDecreasesPoisonAttackPercentage($decreases_poison_attack_percentage)
		{
			$this->_decreases_poison_attack_percentage = $decreases_poison_attack_percentage;
		}

		public function getPoisonAttackModifier()
		{
			return $this->getIncreasesPoisonAttackPercentage() + $this->getDecreasesPoisonAttackPercentage();
		}

		public function getIncreasesRangedAttackPercentage()
		{
			return $this->_increases_ranged_attack_percentage;
		}

		public function setIncreasesRangedAttackPercentage($increases_ranged_attack_percentage)
		{
			$this->_increases_ranged_attack_percentage = $increases_ranged_attack_percentage;
		}

		public function getDecreasesRangedAttackPercentage()
		{
			return $this->_decreases_ranged_attack_percentage;
		}

		public function setDecreasesRangedAttackPercentage($decreases_ranged_attack_percentage)
		{
			$this->_decreases_ranged_attack_percentage = $decreases_ranged_attack_percentage;
		}

		public function getRangedAttackModifier()
		{
			return $this->getIncreasesRangedAttackPercentage() + $this->getDecreasesRangedAttackPercentage();
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

	}
