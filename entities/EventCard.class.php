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
	class EventCard extends Card
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

		protected $_increases_basic_attack_damage_percentage = 0;
		protected $_decreases_basic_attack_damage_percentage = 0;
		protected $_increases_basic_attack_hit_percentage = 0;
		protected $_decreases_basic_attack_hit_percentage = 0;
		protected $_increases_basic_attack_dmp_percentage = 0;
		protected $_decreases_basic_attack_dmp_percentage = 0;

		protected $_increases_air_attack_damage_percentage = 0;
		protected $_decreases_air_attack_damage_percentage = 0;
		protected $_increases_air_attack_hit_percentage = 0;
		protected $_decreases_air_attack_hit_percentage = 0;
		protected $_increases_air_attack_dmp_percentage = 0;
		protected $_decreases_air_attack_dmp_percentage = 0;

		protected $_increases_dark_attack_damage_percentage = 0;
		protected $_decreases_dark_attack_damage_percentage = 0;
		protected $_increases_dark_attack_hit_percentage = 0;
		protected $_decreases_dark_attack_hit_percentage = 0;
		protected $_increases_dark_attack_dmp_percentage = 0;
		protected $_decreases_dark_attack_dmp_percentage = 0;

		protected $_increases_earth_attack_damage_percentage = 0;
		protected $_decreases_earth_attack_damage_percentage = 0;
		protected $_increases_earth_attack_hit_percentage = 0;
		protected $_decreases_earth_attack_hit_percentage = 0;
		protected $_increases_earth_attack_dmp_percentage = 0;
		protected $_decreases_earth_attack_dmp_percentage = 0;

		protected $_increases_fire_attack_damage_percentage = 0;
		protected $_decreases_fire_attack_damage_percentage = 0;
		protected $_increases_fire_attack_hit_percentage = 0;
		protected $_decreases_fire_attack_hit_percentage = 0;
		protected $_increases_fire_attack_dmp_percentage = 0;
		protected $_decreases_fire_attack_dmp_percentage = 0;

		protected $_increases_freeze_attack_damage_percentage = 0;
		protected $_decreases_freeze_attack_damage_percentage = 0;
		protected $_increases_freeze_attack_hit_percentage = 0;
		protected $_decreases_freeze_attack_hit_percentage = 0;
		protected $_increases_freeze_attack_dmp_percentage = 0;
		protected $_decreases_freeze_attack_dmp_percentage = 0;

		protected $_increases_melee_attack_damage_percentage = 0;
		protected $_decreases_melee_attack_damage_percentage = 0;
		protected $_increases_melee_attack_hit_percentage = 0;
		protected $_decreases_melee_attack_hit_percentage = 0;
		protected $_increases_melee_attack_dmp_percentage = 0;
		protected $_decreases_melee_attack_dmp_percentage = 0;

		protected $_increases_poison_attack_damage_percentage = 0;
		protected $_decreases_poison_attack_damage_percentage = 0;
		protected $_increases_poison_attack_hit_percentage = 0;
		protected $_decreases_poison_attack_hit_percentage = 0;
		protected $_increases_poison_attack_dmp_percentage = 0;
		protected $_decreases_poison_attack_dmp_percentage = 0;

		protected $_increases_ranged_attack_damage_percentage = 0;
		protected $_decreases_ranged_attack_damage_percentage = 0;
		protected $_increases_ranged_attack_hit_percentage = 0;
		protected $_decreases_ranged_attack_hit_percentage = 0;
		protected $_increases_ranged_attack_dmp_percentage = 0;
		protected $_decreases_ranged_attack_dmp_percentage = 0;

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

		public function mergeFormData($form_data = array())
		{
			parent::mergeFormData($form_data);
		}

		public function getIncreasesBasicAttackHitPercentage()
		{
			return $this->_increases_basic_attack_hit_percentage;
		}

		public function setIncreasesBasicAttackHitPercentage($increases_basic_attack_hit_percentage)
		{
			$this->_increases_basic_attack_hit_percentage = $increases_basic_attack_hit_percentage;
		}

		public function getDecreasesBasicAttackHitPercentage()
		{
			return $this->_decreases_basic_attack_hit_percentage;
		}

		public function setDecreasesBasicAttackHitPercentage($decreases_basic_attack_hit_percentage)
		{
			$this->_decreases_basic_attack_hit_percentage = $decreases_basic_attack_hit_percentage;
		}

		public function getBasicAttackHitPercentageModifier()
		{
			return $this->getIncreasesBasicAttackHitPercentage() + $this->getDecreasesBasicAttackHitPercentage();
		}

		public function getIncreasesAirAttackHitPercentage()
		{
			return $this->_increases_air_attack_hit_percentage;
		}

		public function setIncreasesAirAttackHitPercentage($increases_air_attack_hit_percentage)
		{
			$this->_increases_air_attack_hit_percentage = $increases_air_attack_hit_percentage;
		}

		public function getDecreasesAirAttackHitPercentage()
		{
			return $this->_decreases_air_attack_hit_percentage;
		}

		public function setDecreasesAirAttackHitPercentage($decreases_air_attack_hit_percentage)
		{
			$this->_decreases_air_attack_hit_percentage = $decreases_air_attack_hit_percentage;
		}

		public function getAirAttackHitPercentageModifier()
		{
			return $this->getIncreasesAirAttackHitPercentage() + $this->getDecreasesAirAttackHitPercentage();
		}

		public function getIncreasesDarkAttackHitPercentage()
		{
			return $this->_increases_dark_attack_hit_percentage;
		}

		public function setIncreasesDarkAttackHitPercentage($increases_dark_attack_hit_percentage)
		{
			$this->_increases_dark_attack_hit_percentage = $increases_dark_attack_hit_percentage;
		}

		public function getDecreasesDarkAttackHitPercentage()
		{
			return $this->_decreases_dark_attack_hit_percentage;
		}

		public function setDecreasesDarkAttackHitPercentage($decreases_dark_attack_hit_percentage)
		{
			$this->_decreases_dark_attack_hit_percentage = $decreases_dark_attack_hit_percentage;
		}

		public function getDarkAttackHitPercentageModifier()
		{
			return $this->getIncreasesDarkAttackHitPercentage() + $this->getDecreasesDarkAttackHitPercentage();
		}

		public function getIncreasesEarthAttackHitPercentage()
		{
			return $this->_increases_earth_attack_hit_percentage;
		}

		public function setIncreasesEarthAttackHitPercentage($increases_earth_attack_hit_percentage)
		{
			$this->_increases_earth_attack_hit_percentage = $increases_earth_attack_hit_percentage;
		}

		public function getDecreasesEarthAttackHitPercentage()
		{
			return $this->_decreases_earth_attack_hit_percentage;
		}

		public function setDecreasesEarthAttackHitPercentage($decreases_earth_attack_hit_percentage)
		{
			$this->_decreases_earth_attack_hit_percentage = $decreases_earth_attack_hit_percentage;
		}

		public function getEarthAttackHitPercentageModifier()
		{
			return $this->getIncreasesEarthAttackHitPercentage() + $this->getDecreasesEarthAttackHitPercentage();
		}

		public function getIncreasesFireAttackHitPercentage()
		{
			return $this->_increases_fire_attack_hit_percentage;
		}

		public function setIncreasesFireAttackHitPercentage($increases_fire_attack_hit_percentage)
		{
			$this->_increases_fire_attack_hit_percentage = $increases_fire_attack_hit_percentage;
		}

		public function getDecreasesFireAttackHitPercentage()
		{
			return $this->_decreases_fire_attack_hit_percentage;
		}

		public function setDecreasesFireAttackHitPercentage($decreases_fire_attack_hit_percentage)
		{
			$this->_decreases_fire_attack_hit_percentage = $decreases_fire_attack_hit_percentage;
		}

		public function getFireAttackHitPercentageModifier()
		{
			return $this->getIncreasesFireAttackHitPercentage() + $this->getDecreasesFireAttackHitPercentage();
		}

		public function getIncreasesFreezeAttackHitPercentage()
		{
			return $this->_increases_freeze_attack_hit_percentage;
		}

		public function setIncreasesFreezeAttackHitPercentage($increases_freeze_attack_hit_percentage)
		{
			$this->_increases_freeze_attack_hit_percentage = $increases_freeze_attack_hit_percentage;
		}

		public function getDecreasesFreezeAttackHitPercentage()
		{
			return $this->_decreases_freeze_attack_hit_percentage;
		}

		public function setDecreasesFreezeAttackHitPercentage($decreases_freeze_attack_hit_percentage)
		{
			$this->_decreases_freeze_attack_hit_percentage = $decreases_freeze_attack_hit_percentage;
		}

		public function getFreezeAttackHitPercentageModifier()
		{
			return $this->getIncreasesFreezeAttackHitPercentage() + $this->getDecreasesFreezeAttackHitPercentage();
		}

		public function getIncreasesMeleeAttackHitPercentage()
		{
			return $this->_increases_melee_attack_hit_percentage;
		}

		public function setIncreasesMeleeAttackHitPercentage($increases_melee_attack_hit_percentage)
		{
			$this->_increases_melee_attack_hit_percentage = $increases_melee_attack_hit_percentage;
		}

		public function getDecreasesMeleeAttackHitPercentage()
		{
			return $this->_decreases_melee_attack_hit_percentage;
		}

		public function setDecreasesMeleeAttackHitPercentage($decreases_melee_attack_hit_percentage)
		{
			$this->_decreases_melee_attack_hit_percentage = $decreases_melee_attack_hit_percentage;
		}

		public function getMeleeAttackHitPercentageModifier()
		{
			return $this->getIncreasesMeleeAttackHitPercentage() + $this->getDecreasesMeleeAttackHitPercentage();
		}

		public function getIncreasesPoisonAttackHitPercentage()
		{
			return $this->_increases_poison_attack_hit_percentage;
		}

		public function setIncreasesPoisonAttackHitPercentage($increases_poison_attack_hit_percentage)
		{
			$this->_increases_poison_attack_hit_percentage = $increases_poison_attack_hit_percentage;
		}

		public function getDecreasesPoisonAttackHitPercentage()
		{
			return $this->_decreases_poison_attack_hit_percentage;
		}

		public function setDecreasesPoisonAttackHitPercentage($decreases_poison_attack_hit_percentage)
		{
			$this->_decreases_poison_attack_hit_percentage = $decreases_poison_attack_hit_percentage;
		}

		public function getPoisonAttackHitPercentageModifier()
		{
			return $this->getIncreasesPoisonAttackHitPercentage() + $this->getDecreasesPoisonAttackHitPercentage();
		}

		public function getIncreasesRangedAttackHitPercentage()
		{
			return $this->_increases_ranged_attack_hit_percentage;
		}

		public function setIncreasesRangedAttackHitPercentage($increases_ranged_attack_hit_percentage)
		{
			$this->_increases_ranged_attack_hit_percentage = $increases_ranged_attack_hit_percentage;
		}

		public function getDecreasesRangedAttackHitPercentage()
		{
			return $this->_decreases_ranged_attack_hit_percentage;
		}

		public function setDecreasesRangedAttackHitPercentage($decreases_ranged_attack_hit_percentage)
		{
			$this->_decreases_ranged_attack_hit_percentage = $decreases_ranged_attack_hit_percentage;
		}

		public function getRangedAttackHitPercentageModifier()
		{
			return $this->getIncreasesRangedAttackHitPercentage() + $this->getDecreasesRangedAttackHitPercentage();
		}

		public function getIncreasesBasicAttackDamagePercentage()
		{
			return $this->_increases_basic_attack_damage_percentage;
		}

		public function setIncreasesBasicAttackDamagePercentage($increases_basic_attack_damage_percentage)
		{
			$this->_increases_basic_attack_damage_percentage = $increases_basic_attack_damage_percentage;
		}

		public function getDecreasesBasicAttackDamagePercentage()
		{
			return $this->_decreases_basic_attack_damage_percentage;
		}

		public function setDecreasesBasicAttackDamagePercentage($decreases_basic_attack_damage_percentage)
		{
			$this->_decreases_basic_attack_damage_percentage = $decreases_basic_attack_damage_percentage;
		}

		public function getBasicAttackDamagePercentageModifier()
		{
			return $this->getIncreasesBasicAttackDamagePercentage() + $this->getDecreasesBasicAttackDamagePercentage();
		}

		public function getIncreasesAirAttackDamagePercentage()
		{
			return $this->_increases_air_attack_damage_percentage;
		}

		public function setIncreasesAirAttackDamagePercentage($increases_air_attack_damage_percentage)
		{
			$this->_increases_air_attack_damage_percentage = $increases_air_attack_damage_percentage;
		}

		public function getDecreasesAirAttackDamagePercentage()
		{
			return $this->_decreases_air_attack_damage_percentage;
		}

		public function setDecreasesAirAttackDamagePercentage($decreases_air_attack_damage_percentage)
		{
			$this->_decreases_air_attack_damage_percentage = $decreases_air_attack_damage_percentage;
		}

		public function getAirAttackDamagePercentageModifier()
		{
			return $this->getIncreasesAirAttackDamagePercentage() + $this->getDecreasesAirAttackDamagePercentage();
		}

		public function getIncreasesDarkAttackDamagePercentage()
		{
			return $this->_increases_dark_attack_damage_percentage;
		}

		public function setIncreasesDarkAttackDamagePercentage($increases_dark_attack_damage_percentage)
		{
			$this->_increases_dark_attack_damage_percentage = $increases_dark_attack_damage_percentage;
		}

		public function getDecreasesDarkAttackDamagePercentage()
		{
			return $this->_decreases_dark_attack_damage_percentage;
		}

		public function setDecreasesDarkAttackDamagePercentage($decreases_dark_attack_damage_percentage)
		{
			$this->_decreases_dark_attack_damage_percentage = $decreases_dark_attack_damage_percentage;
		}

		public function getDarkAttackDamagePercentageModifier()
		{
			return $this->getIncreasesDarkAttackDamagePercentage() + $this->getDecreasesDarkAttackDamagePercentage();
		}

		public function getIncreasesEarthAttackDamagePercentage()
		{
			return $this->_increases_earth_attack_damage_percentage;
		}

		public function setIncreasesEarthAttackDamagePercentage($increases_earth_attack_damage_percentage)
		{
			$this->_increases_earth_attack_damage_percentage = $increases_earth_attack_damage_percentage;
		}

		public function getDecreasesEarthAttackDamagePercentage()
		{
			return $this->_decreases_earth_attack_damage_percentage;
		}

		public function setDecreasesEarthAttackDamagePercentage($decreases_earth_attack_damage_percentage)
		{
			$this->_decreases_earth_attack_damage_percentage = $decreases_earth_attack_damage_percentage;
		}

		public function getEarthAttackDamagePercentageModifier()
		{
			return $this->getIncreasesEarthAttackDamagePercentage() + $this->getDecreasesEarthAttackDamagePercentage();
		}

		public function getIncreasesFireAttackDamagePercentage()
		{
			return $this->_increases_fire_attack_damage_percentage;
		}

		public function setIncreasesFireAttackDamagePercentage($increases_fire_attack_damage_percentage)
		{
			$this->_increases_fire_attack_damage_percentage = $increases_fire_attack_damage_percentage;
		}

		public function getDecreasesFireAttackDamagePercentage()
		{
			return $this->_decreases_fire_attack_damage_percentage;
		}

		public function setDecreasesFireAttackDamagePercentage($decreases_fire_attack_damage_percentage)
		{
			$this->_decreases_fire_attack_damage_percentage = $decreases_fire_attack_damage_percentage;
		}

		public function getFireAttackDamagePercentageModifier()
		{
			return $this->getIncreasesFireAttackDamagePercentage() + $this->getDecreasesFireAttackDamagePercentage();
		}

		public function getIncreasesFreezeAttackDamagePercentage()
		{
			return $this->_increases_freeze_attack_damage_percentage;
		}

		public function setIncreasesFreezeAttackDamagePercentage($increases_freeze_attack_damage_percentage)
		{
			$this->_increases_freeze_attack_damage_percentage = $increases_freeze_attack_damage_percentage;
		}

		public function getDecreasesFreezeAttackDamagePercentage()
		{
			return $this->_decreases_freeze_attack_damage_percentage;
		}

		public function setDecreasesFreezeAttackDamagePercentage($decreases_freeze_attack_damage_percentage)
		{
			$this->_decreases_freeze_attack_damage_percentage = $decreases_freeze_attack_damage_percentage;
		}

		public function getFreezeAttackDamagePercentageModifier()
		{
			return $this->getIncreasesFreezeAttackDamagePercentage() + $this->getDecreasesFreezeAttackDamagePercentage();
		}

		public function getIncreasesMeleeAttackDamagePercentage()
		{
			return $this->_increases_melee_attack_damage_percentage;
		}

		public function setIncreasesMeleeAttackDamagePercentage($increases_melee_attack_damage_percentage)
		{
			$this->_increases_melee_attack_damage_percentage = $increases_melee_attack_damage_percentage;
		}

		public function getDecreasesMeleeAttackDamagePercentage()
		{
			return $this->_decreases_melee_attack_damage_percentage;
		}

		public function setDecreasesMeleeAttackDamagePercentage($decreases_melee_attack_damage_percentage)
		{
			$this->_decreases_melee_attack_damage_percentage = $decreases_melee_attack_damage_percentage;
		}

		public function getMeleeAttackDamagePercentageModifier()
		{
			return $this->getIncreasesMeleeAttackDamagePercentage() + $this->getDecreasesMeleeAttackDamagePercentage();
		}

		public function getIncreasesPoisonAttackDamagePercentage()
		{
			return $this->_increases_poison_attack_damage_percentage;
		}

		public function setIncreasesPoisonAttackDamagePercentage($increases_poison_attack_damage_percentage)
		{
			$this->_increases_poison_attack_damage_percentage = $increases_poison_attack_damage_percentage;
		}

		public function getDecreasesPoisonAttackDamagePercentage()
		{
			return $this->_decreases_poison_attack_damage_percentage;
		}

		public function setDecreasesPoisonAttackDamagePercentage($decreases_poison_attack_damage_percentage)
		{
			$this->_decreases_poison_attack_damage_percentage = $decreases_poison_attack_damage_percentage;
		}

		public function getPoisonAttackDamagePercentageModifier()
		{
			return $this->getIncreasesPoisonAttackDamagePercentage() + $this->getDecreasesPoisonAttackDamagePercentage();
		}

		public function getIncreasesRangedAttackDamagePercentage()
		{
			return $this->_increases_ranged_attack_damage_percentage;
		}

		public function setIncreasesRangedAttackDamagePercentage($increases_ranged_attack_damage_percentage)
		{
			$this->_increases_ranged_attack_damage_percentage = $increases_ranged_attack_damage_percentage;
		}

		public function getDecreasesRangedAttackDamagePercentage()
		{
			return $this->_decreases_ranged_attack_damage_percentage;
		}

		public function setDecreasesRangedAttackDamagePercentage($decreases_ranged_attack_damage_percentage)
		{
			$this->_decreases_ranged_attack_damage_percentage = $decreases_ranged_attack_damage_percentage;
		}

		public function getRangedAttackDamagePercentageModifier()
		{
			return $this->getIncreasesRangedAttackDamagePercentage() + $this->getDecreasesRangedAttackDamagePercentage();
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
