<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Skill class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Skills")
	 */
	class Skill extends \b2db\Saveable
	{

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Skill name
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_name = '';

		/**
		 * Skill description
		 *
		 * @Column(type="text")
		 * @var string
		 */
		protected $_description = '';

		/** 
		 * If learnt, the user_id who has the skill
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_user_id;

		/**
		 * If not a top-level skill, the parent skill needed to unlock this
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Skill")
		 *
		 * @var \application\entities\Skill
		 */
		protected $_parent_skill_id;

		/**
		 * Required user level to learn this skill
		 *
		 * @Column(type="integer", length=10)
		 *
		 * @var integer
		 */
		protected $_required_level;

		/**
		 * Whether or not the skill is available for human races
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_race_human;

		/**
		 * Whether or not the skill is available for lizard races
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_race_lizard;

		/**
		 * Whether or not the skill is available for beast races
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_race_beast;

		/**
		 * Whether or not the skill is available for elf races
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_race_elf;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_basic_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_basic_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_basic_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_basic_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_basic_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_basic_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_air_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_air_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_air_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_air_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_air_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_air_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_dark_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_dark_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_dark_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_dark_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_dark_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_dark_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_earth_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_earth_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_earth_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_earth_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_earth_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_earth_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_fire_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_fire_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_fire_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_fire_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_fire_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_fire_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_freeze_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_freeze_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_freeze_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_freeze_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_freeze_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_freeze_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_melee_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_melee_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_melee_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_melee_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_melee_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_melee_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_poison_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_poison_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_poison_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_poison_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_poison_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_poison_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_ranged_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_ranged_attack_damage_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_ranged_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_ranged_attack_hit_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_increases_ranged_attack_dmp_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_decreases_ranged_attack_dmp_percentage = 0;

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		public function getName()
		{
			return $this->_name;
		}

		public function setName($name)
		{
			$this->_name = $name;
		}

		public function getDescription()
		{
			return $this->_description;
		}

		public function setDescription($description)
		{
			$this->_description = $description;
		}

		public function setUserId($user_id)
		{
			$this->_user_id = $user_id;
		}

		public function setUser($user)
		{
			$this->_user_id = $user;
		}

		public function getUser()
		{
			return $this->_b2dbLazyload('_user_id');
		}

		public function getUserId()
		{
			return ($this->_user_id instanceof User) ? $this->_user_id->getId() : (int) $this->_user_id;
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

		public function getIncreasesBasicAttackDmpPercentage()
		{
			return $this->_increases_basic_attack_dmp_percentage;
		}

		public function setIncreasesBasicAttackDmpPercentage($increases_basic_attack_dmp_percentage)
		{
			$this->_increases_basic_attack_dmp_percentage = $increases_basic_attack_dmp_percentage;
		}

		public function getDecreasesBasicAttackDmpPercentage()
		{
			return $this->_decreases_basic_attack_dmp_percentage;
		}

		public function setDecreasesBasicAttackDmpPercentage($decreases_basic_attack_dmp_percentage)
		{
			$this->_decreases_basic_attack_dmp_percentage = $decreases_basic_attack_dmp_percentage;
		}

		public function getBasicAttackDmpPercentageModifier()
		{
			return $this->getIncreasesBasicAttackDmpPercentage() + $this->getDecreasesBasicAttackDmpPercentage();
		}

		public function getIncreasesAirAttackDmpPercentage()
		{
			return $this->_increases_air_attack_dmp_percentage;
		}

		public function setIncreasesAirAttackDmpPercentage($increases_air_attack_dmp_percentage)
		{
			$this->_increases_air_attack_dmp_percentage = $increases_air_attack_dmp_percentage;
		}

		public function getDecreasesAirAttackDmpPercentage()
		{
			return $this->_decreases_air_attack_dmp_percentage;
		}

		public function setDecreasesAirAttackDmpPercentage($decreases_air_attack_dmp_percentage)
		{
			$this->_decreases_air_attack_dmp_percentage = $decreases_air_attack_dmp_percentage;
		}

		public function getAirAttackDmpPercentageModifier()
		{
			return $this->getIncreasesAirAttackDmpPercentage() + $this->getDecreasesAirAttackDmpPercentage();
		}

		public function getIncreasesDarkAttackDmpPercentage()
		{
			return $this->_increases_dark_attack_dmp_percentage;
		}

		public function setIncreasesDarkAttackDmpPercentage($increases_dark_attack_dmp_percentage)
		{
			$this->_increases_dark_attack_dmp_percentage = $increases_dark_attack_dmp_percentage;
		}

		public function getDecreasesDarkAttackDmpPercentage()
		{
			return $this->_decreases_dark_attack_dmp_percentage;
		}

		public function setDecreasesDarkAttackDmpPercentage($decreases_dark_attack_dmp_percentage)
		{
			$this->_decreases_dark_attack_dmp_percentage = $decreases_dark_attack_dmp_percentage;
		}

		public function getDarkAttackDmpPercentageModifier()
		{
			return $this->getIncreasesDarkAttackDmpPercentage() + $this->getDecreasesDarkAttackDmpPercentage();
		}

		public function getIncreasesEarthAttackDmpPercentage()
		{
			return $this->_increases_earth_attack_dmp_percentage;
		}

		public function setIncreasesEarthAttackDmpPercentage($increases_earth_attack_dmp_percentage)
		{
			$this->_increases_earth_attack_dmp_percentage = $increases_earth_attack_dmp_percentage;
		}

		public function getDecreasesEarthAttackDmpPercentage()
		{
			return $this->_decreases_earth_attack_dmp_percentage;
		}

		public function setDecreasesEarthAttackDmpPercentage($decreases_earth_attack_dmp_percentage)
		{
			$this->_decreases_earth_attack_dmp_percentage = $decreases_earth_attack_dmp_percentage;
		}

		public function getEarthAttackDmpPercentageModifier()
		{
			return $this->getIncreasesEarthAttackDmpPercentage() + $this->getDecreasesEarthAttackDmpPercentage();
		}

		public function getIncreasesFireAttackDmpPercentage()
		{
			return $this->_increases_fire_attack_dmp_percentage;
		}

		public function setIncreasesFireAttackDmpPercentage($increases_fire_attack_dmp_percentage)
		{
			$this->_increases_fire_attack_dmp_percentage = $increases_fire_attack_dmp_percentage;
		}

		public function getDecreasesFireAttackDmpPercentage()
		{
			return $this->_decreases_fire_attack_dmp_percentage;
		}

		public function setDecreasesFireAttackDmpPercentage($decreases_fire_attack_dmp_percentage)
		{
			$this->_decreases_fire_attack_dmp_percentage = $decreases_fire_attack_dmp_percentage;
		}

		public function getFireAttackDmpPercentageModifier()
		{
			return $this->getIncreasesFireAttackDmpPercentage() + $this->getDecreasesFireAttackDmpPercentage();
		}

		public function getIncreasesFreezeAttackDmpPercentage()
		{
			return $this->_increases_freeze_attack_dmp_percentage;
		}

		public function setIncreasesFreezeAttackDmpPercentage($increases_freeze_attack_dmp_percentage)
		{
			$this->_increases_freeze_attack_dmp_percentage = $increases_freeze_attack_dmp_percentage;
		}

		public function getDecreasesFreezeAttackDmpPercentage()
		{
			return $this->_decreases_freeze_attack_dmp_percentage;
		}

		public function setDecreasesFreezeAttackDmpPercentage($decreases_freeze_attack_dmp_percentage)
		{
			$this->_decreases_freeze_attack_dmp_percentage = $decreases_freeze_attack_dmp_percentage;
		}

		public function getFreezeAttackDmpPercentageModifier()
		{
			return $this->getIncreasesFreezeAttackDmpPercentage() + $this->getDecreasesFreezeAttackDmpPercentage();
		}

		public function getIncreasesMeleeAttackDmpPercentage()
		{
			return $this->_increases_melee_attack_dmp_percentage;
		}

		public function setIncreasesMeleeAttackDmpPercentage($increases_melee_attack_dmp_percentage)
		{
			$this->_increases_melee_attack_dmp_percentage = $increases_melee_attack_dmp_percentage;
		}

		public function getDecreasesMeleeAttackDmpPercentage()
		{
			return $this->_decreases_melee_attack_dmp_percentage;
		}

		public function setDecreasesMeleeAttackDmpPercentage($decreases_melee_attack_dmp_percentage)
		{
			$this->_decreases_melee_attack_dmp_percentage = $decreases_melee_attack_dmp_percentage;
		}

		public function getMeleeAttackDmpPercentageModifier()
		{
			return $this->getIncreasesMeleeAttackDmpPercentage() + $this->getDecreasesMeleeAttackDmpPercentage();
		}

		public function getIncreasesPoisonAttackDmpPercentage()
		{
			return $this->_increases_poison_attack_dmp_percentage;
		}

		public function setIncreasesPoisonAttackDmpPercentage($increases_poison_attack_dmp_percentage)
		{
			$this->_increases_poison_attack_dmp_percentage = $increases_poison_attack_dmp_percentage;
		}

		public function getDecreasesPoisonAttackDmpPercentage()
		{
			return $this->_decreases_poison_attack_dmp_percentage;
		}

		public function setDecreasesPoisonAttackDmpPercentage($decreases_poison_attack_dmp_percentage)
		{
			$this->_decreases_poison_attack_dmp_percentage = $decreases_poison_attack_dmp_percentage;
		}

		public function getPoisonAttackDmpPercentageModifier()
		{
			return $this->getIncreasesPoisonAttackDmpPercentage() + $this->getDecreasesPoisonAttackDmpPercentage();
		}

		public function getIncreasesRangedAttackDmpPercentage()
		{
			return $this->_increases_ranged_attack_dmp_percentage;
		}

		public function setIncreasesRangedAttackDmpPercentage($increases_ranged_attack_dmp_percentage)
		{
			$this->_increases_ranged_attack_dmp_percentage = $increases_ranged_attack_dmp_percentage;
		}

		public function getDecreasesRangedAttackDmpPercentage()
		{
			return $this->_decreases_ranged_attack_dmp_percentage;
		}

		public function setDecreasesRangedAttackDmpPercentage($decreases_ranged_attack_dmp_percentage)
		{
			$this->_decreases_ranged_attack_dmp_percentage = $decreases_ranged_attack_dmp_percentage;
		}

		public function getRangedAttackDmpPercentageModifier()
		{
			return $this->getIncreasesRangedAttackDmpPercentage() + $this->getDecreasesRangedAttackDmpPercentage();
		}

		public function getParentSkill()
		{
			return $this->_b2dbLazyload('_parent_skill_id');
		}

		public function getParentSkillId()
		{
			$parent_skill = $this->getParentSkill();
			return ($parent_skill instanceof Skill) ? $parent_skill->getId() : '';
		}

		public function setParentSkill($parent_skill)
		{
			$this->_parent_skill_id = $parent_skill;
		}

		public function getRequiredLevel()
		{
			return $this->_required_level;
		}

		public function setRequiredLevel($required_level)
		{
			$this->_required_level = $required_level;
		}

		public function getRaceHuman()
		{
			return $this->_race_human;
		}

		public function setRaceHuman($race_human = true)
		{
			$this->_race_human = $race_human;
		}

		public function getRaceLizard()
		{
			return $this->_race_lizard;
		}

		public function setRaceLizard($race_lizard = true)
		{
			$this->_race_lizard = $race_lizard;
		}

		public function getRaceBeast()
		{
			return $this->_race_beast;
		}

		public function setRaceBeast($race_beast = true)
		{
			$this->_race_beast = $race_beast;
		}

		public function getRaceElf()
		{
			return $this->_race_elf;
		}

		public function setRaceElf($race_elf = true)
		{
			$this->_race_elf = $race_elf;
		}

		public function getAppliesTo()
		{
			$applies_to = array();
			if ($this->_race_human) $applies_to[] = 'Human';
			if ($this->_race_lizard) $applies_to[] = 'Lacerta';
			if ($this->_race_beast) $applies_to[] = 'Beast';
			if ($this->_race_elf) $applies_to[] = 'Elves';

			return $applies_to;
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			foreach (array('basic', 'air', 'dark', 'earth', 'fire', 'freeze', 'melee', 'poison', 'ranged') as $element) {
				$hit_percentage_property = '_'.$form_data['modifies_'.$element.'_attacks_hit_percentage']."s_{$element}_attack_hit_percentage";
				$damage_percentage_property = '_'.$form_data['modifies_'.$element.'_attacks_damage_percentage']."s_{$element}_attack_damage_percentage";
				$dmp_percentage_property = '_'.$form_data['modifies_'.$element.'_attacks_dmp_percentage']."s_{$element}_attack_dmp_percentage";

				$this->$hit_percentage_property = $form_data['hit_percentage_'.$element.'_modifier'];
				$this->$damage_percentage_property = $form_data['damage_percentage_'.$element.'_modifier'];
				$this->$dmp_percentage_property = $form_data['dmp_percentage_'.$element.'_modifier'];
			}
			$this->_name = $form_data['name'];
			$this->_description = $form_data['description'];
			$this->_required_level = $form_data['required_level'];
			$this->_parent_skill_id = $form_data['parent_skill_id'];
			$this->_race_human = (bool) $form_data['race_human'];
			$this->_race_lizard = (bool) $form_data['race_lizard'];
			$this->_race_beast = (bool) $form_data['race_beast'];
			$this->_race_elf = (bool) $form_data['race_elf'];
		}

	}
