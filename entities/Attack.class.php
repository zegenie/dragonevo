<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo creature card attack class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Attacks")
	 */
	class Attack extends \b2db\Saveable
	{

		const TYPE_AIR = 10;
		const TYPE_DARK = 11;
		const TYPE_EARTH = 12;
		const TYPE_FIRE = 13;
		const TYPE_FREEZE = 14;
		const TYPE_MELEE = 15;
		const TYPE_POISON = 16;
		const TYPE_RANGED = 17;

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Attack name
		 *
		 * @Column(type="string", length=250)
		 * @var string
		 */
		protected $_name;

		/**
		 * Attack description
		 *
		 * @Column(type="text")
		 * @var string
		 */
		protected $_description;

		/**
		 * Attack type
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_type;

		/**
		 * Cost (gold)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_cost_gold;

		/**
		 * Cost (magic)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_cost_magic;

		/**
		 * Attack HP damage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_points_min;

		/**
		 * Attack HP damage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_points_max;

		/**
		 * Repeat attack HP damage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_attack_points_min;

		/**
		 * Repeat attack HP damage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_attack_points_max;

		/**
		 * Repeat rounds (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_rounds_min;

		/**
		 * Repeat rounds (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_rounds_max;

		/**
		 * Unblockable or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_unblockable;

		/**
		 * Stun percentage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_percentage_min;

		/**
		 * Stun percentage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_percentage_max;

		/**
		 * Stun duration (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_duration_min;

		/**
		 * Stun duration (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_duration_max;

		/**
		 * Belonging card
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\CreatureCard")
		 * 
		 * @var \application\entities\CreatureCard
		 */
		protected $_card_id;

		/**
		 * Attack level
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_level;

		/**
		 * Penalty rounds (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_penalty_rounds_min;

		/**
		 * Penalty rounds (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_penalty_rounds_max;

		/**
		 * Penalty damage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_penalty_dmg;

		/**
		 * Critical hit percentage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_critical_hit_percentage;

		/**
		 * Steal gold chance percentage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_gold_chance;

		/**
		 * Steal gold amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_gold_amount;

		/**
		 * Steal magic chance percentage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_magic_chance;

		/**
		 * Steal magic amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_magic_amount;

		public function getId()
		{
			return $this->_id;
		}

		public function getName()
		{
			return $this->_name;
		}

		public function getDescription()
		{
			return $this->_description;
		}

		public function getAttackType()
		{
			return $this->_attack_type;
		}

		public function setAttackType($attack_type)
		{
			$this->_attack_type = $attack_type;
		}

		public function hasCostGold()
		{
			return ($this->_cost_gold > 0);
		}

		public function getCostGold()
		{
			return (int) $this->_cost_gold;
		}

		public function hasCostMagic()
		{
			return ($this->_cost_magic > 0);
		}

		public function getCostMagic()
		{
			return (int) $this->_cost_magic;
		}

		public function hasAttackPointsRange()
		{
			return ($this->_attack_points_min != $this->_attack_points_max);
		}

		public function getAttackPointsMin()
		{
			return (int) $this->_attack_points_min;
		}

		public function getAttackPointsMax()
		{
			return (int) $this->_attack_points_max;
		}

		public function hasRepeatAttackPointsRange()
		{
			return ($this->_repeat_attack_points_min != $this->_repeat_attack_points_max);
		}

		public function getRepeatAttackPointsMin()
		{
			return (int) $this->_repeat_attack_points_min;
		}

		public function getRepeatAttackPointsMax()
		{
			return (int) $this->_repeat_attack_points_max;
		}

		public function isAvailable()
		{
			return true;
		}

		public function isUnblockable()
		{
			return $this->_unblockable;
		}

		public function isBlockable()
		{
			return !$this->isUnblockable();
		}

		public function hasStunPercentageRange()
		{
			return ($this->_stun_percentage_min != $this->_stun_percentage_max);
		}

		public function getStunPercentageMin()
		{
			return (int) $this->_stun_percentage_min;
		}

		public function getStunPercentageMax()
		{
			return (int) $this->_stun_percentage_max;
		}

		public function hasRepeatRange()
		{
			return ($this->_repeat_rounds_min != $this->_repeat_rounds_max);
		}

		public function getRepeatRoundsMin()
		{
			return (int) $this->_repeat_rounds_min;
		}

		public function getRepeatRoundsMax()
		{
			return (int) $this->_repeat_rounds_max;
		}

		public function setName($name)
		{
			$this->_name = $name;
		}

		public function setDescription($description)
		{
			$this->_description = $description;
		}

		public function setCostGold($cost_gold)
		{
			$this->_cost_gold = $cost_gold;
		}

		public function setCostMagic($cost_magic)
		{
			$this->_cost_magic = $cost_magic;
		}

		public function setAttackPointsMin($attack_points_min)
		{
			$this->_attack_points_min = $attack_points_min;
		}

		public function setAttackPointsMax($attack_points_max)
		{
			$this->_attack_points_max = $attack_points_max;
		}

		public function setRepeatAttackPointsMin($repeat_attack_points_min)
		{
			$this->_repeat_attack_points_min = $repeat_attack_points_min;
		}

		public function setRepeatAttackPointsMax($repeat_attack_points_max)
		{
			$this->_repeat_attack_points_max = $repeat_attack_points_max;
		}

		public function setUnblockable($unblockable)
		{
			$this->_unblockable = $unblockable;
		}

		public function setStunPercentageMin($stun_percentage_min)
		{
			$this->_stun_percentage_min = $stun_percentage_min;
		}

		public function setStunPercentageMax($stun_percentage_max)
		{
			$this->_stun_percentage_max = $stun_percentage_max;
		}

		public function setRepeatRoundsMin($repeat_rounds_min)
		{
			$this->_repeat_rounds_min = $repeat_rounds_min;
		}

		public function setRepeatRoundsMax($repeat_rounds_max)
		{
			$this->_repeat_rounds_max = $repeat_rounds_max;
		}

		public function setIntroductionLevel($introduction_level)
		{
			$this->_introduction_level = $introduction_level;
		}

		public function getCard()
		{
			$this->_b2dbLazyload('_card_id');
			return $this->_card_id;
		}

		public function getCardId()
		{
			return ($this->_card_id instanceof CreatureCard) ? $this->_card_id->getId() : $this->_card_id;
		}

		public function setCard(CreatureCard $card)
		{
			$this->_card_id = $card;
		}

		public function setCardId($card_id)
		{
			$this->_card_id = $card_id;
		}

		public function hasStunDurationRange()
		{
			return (bool) $this->_stun_duration_min != $this->_stun_duration_max;
		}

		public function getStunDurationMin()
		{
			return (int) $this->_stun_duration_min;
		}

		public function setStunDurationMin($stun_duration_min)
		{
			$this->_stun_duration_min = $stun_duration_min;
		}

		public function getStunDurationMax()
		{
			return (int) $this->_stun_duration_max;
		}

		public function setStunDurationMax($stun_duration_max)
		{
			$this->_stun_duration_max = $stun_duration_max;
		}

		public function getPenaltyRoundsMin()
		{
			return (int) $this->_penalty_rounds_min;
		}

		public function setPenaltyRoundsMin($penalty_rounds_min)
		{
			$this->_penalty_rounds_min = $penalty_rounds_min;
		}

		public function getPenaltyRoundsMax()
		{
			return (int) $this->_penalty_rounds_max;
		}

		public function setPenaltyRoundsMax($penalty_rounds_max)
		{
			$this->_penalty_rounds_max = $penalty_rounds_max;
		}

		public function getPenaltyDmg()
		{
			return (int) $this->_penalty_dmg;
		}

		public function setPenaltyDmg($penalty_dmg)
		{
			$this->_penalty_dmg = $penalty_dmg;
		}

		public function getCriticalHitPercentage()
		{
			return (int) $this->_critical_hit_percentage;
		}

		public function setCriticalHitPercentage($critical_hit_percentage)
		{
			$this->_critical_hit_percentage = $critical_hit_percentage;
		}

		public function canStealGold()
		{
			return (bool) $this->_steal_gold_chance > 0;
		}

		public function getStealGoldChance()
		{
			return (int) $this->_steal_gold_chance;
		}

		public function setStealGoldChance($steal_gold_chance)
		{
			$this->_steal_gold_chance = $steal_gold_chance;
		}

		public function getStealGoldAmount()
		{
			return (int) $this->_steal_gold_amount;
		}

		public function setStealGoldAmount($steal_gold_amount)
		{
			$this->_steal_gold_amount = $steal_gold_amount;
		}

		public function canStealMagic()
		{
			return (bool) $this->_steal_magic_chance > 0;
		}

		public function getStealMagicChance()
		{
			return (int) $this->_steal_magic_chance;
		}

		public function setStealMagicChance($steal_magic_chance)
		{
			$this->_steal_magic_chance = $steal_magic_chance;
		}

		public function getStealMagicAmount()
		{
			return (int) $this->_steal_magic_amount;
		}

		public function setStealMagicAmount($steal_magic_amount)
		{
			$this->_steal_magic_amount = $steal_magic_amount;
		}

		public function canStun()
		{
			return ($this->getStunPercentageMin() > 0);
		}

		public function getLevel()
		{
			return $this->_level;
		}

		public function setLevel($level)
		{
			$this->_level = $level;
		}

	}