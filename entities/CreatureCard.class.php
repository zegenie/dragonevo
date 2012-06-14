<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\CreatureCards")
	 */
	class CreatureCard extends Card
	{

		const CLASS_CIVILIAN = 1;
		const CLASS_MAGIC = 2;
		const CLASS_MILITARY = 3;
		const CLASS_PHYSICAL = 4;
		const CLASS_RANGED = 5;
		const CLASS_ANIMAL = 6;
		const CLASS_MYTHICAL_ANIMAL = 7;

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = \application\entities\Card::TYPE_CREATURE;

		/**
		 * Base health
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_base_health = 1;

		/**
		 * Base health randomness factor
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_base_health_randomness = 0;

		/**
		 * Current in-game health
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_in_game_health = 1;

		/**
		 * Base ep
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_base_ep = 1;

		/**
		 * Base ep randomness factor
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_base_ep_randomness = 0;

		/**
		 * Current in-game health
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_in_game_ep = 1;

		/**
		 * Base defence multiplier
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_base_dmp = 0;

		/**
		 * Base defence multiplier randomness factor
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_base_dmp_randomness = 0;

		/**
		 * Creature class
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_creature_class = 1;

		/**
		 * @Column(type="string", length=20, default='regular')
		 * @var string
		 */
		protected $_card_level = 'regular';

		/**
		 * Creature faction
		 *
		 * @Column(type="string", length=20, default='neutrals')
		 * @var string
		 */
		protected $_faction = Card::FACTION_NEUTRALS;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_slot_1_available = false;
		
		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_slot_2_available = false;
		
		/**
		 * List of this card's attacks
		 * 
		 * @var array|Attack
		 * @Relates(class="\application\entities\Attack", collection=true, foreign_column="card_id")
		 */
		protected $_attacks;

		/**
		 * If owned, the original card id
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\CreatureCard")
		 *
		 * @var \application\entities\CreatureCard
		 */
		protected $_original_card_id;

		/**
		 * User card level
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_user_card_level = 1;

		/**
		 * User DMP
		 *
		 * @Column(type="integer", length=5, default=1)
		 * @var integer
		 */
		protected $_user_dmp = 1;

		public static function getCreatureClasses()
		{
			return array(
				self::CLASS_ANIMAL => 'Animal',
				self::CLASS_CIVILIAN => 'Civilian',
				self::CLASS_MAGIC => 'Magic',
				self::CLASS_MILITARY => 'Military',
				self::CLASS_MYTHICAL_ANIMAL => 'Mythical animal',
				self::CLASS_PHYSICAL => 'Physical',
				self::CLASS_RANGED => 'Ranged'
			);
		}

		public function getBaseHealth()
		{
			return (int) $this->_base_health;
		}

		public function getBaseHP()
		{
			return $this->getBaseHealth();
		}

		public function setBaseHealth($base_health)
		{
			$this->_base_health = (int) $base_health;
		}

		public function getInGameHealth()
		{
			return (int) $this->_in_game_health;
		}

		public function getInGameHP()
		{
			return $this->getInGameHealth();
		}

		public function getHP()
		{
			return ($this->isInPlay()) ? $this->getInGameHP() : $this->getBaseHealth();
		}

		public function setInGameHealth($in_game_health)
		{
			$this->_in_game_health = (int) $in_game_health;
		}

		public function removeHP($dmg)
		{
			$this->_in_game_health -= $dmg;
			if ($this->_in_game_health < 0) $this->_in_game_health = 0;
		}

		public function getBaseHealthRandomness()
		{
			return $this->_base_health_randomness;
		}

		public function setBaseHealthRandomness($base_health_randomness)
		{
			$this->_base_health_randomness = $base_health_randomness;
		}

		public function getBaseEP()
		{
			return $this->_base_ep;
		}

		public function setBaseEP($base_ep)
		{
			$this->_base_ep = (int) $base_ep;
		}

		public function getInGameEP()
		{
			return (int) $this->_in_game_ep;
		}

		public function getEP()
		{
			return ($this->isInPlay()) ? $this->getInGameEP() : $this->getBaseEP();
		}

		public function setInGameEP($in_game_ep)
		{
			$this->_in_game_ep = (int) $in_game_ep;
		}

		public function removeEP($dmg)
		{
			$this->_in_game_ep -= $dmg;
			if ($this->_in_game_ep < 0) $this->_in_game_ep = 0;
		}

		public function getBaseEPRandomness()
		{
			return $this->_base_ep_randomness;
		}

		public function setBaseEPRandomness($base_ep_randomness)
		{
			$this->_base_ep_randomness = $base_ep_randomness;
		}

		public function getBaseDMP()
		{
			return $this->_base_dmp;
		}

		public function setBaseDMP($base_dmp)
		{
			$this->_base_dmp = $base_dmp;
		}

		public function getBaseDMPRandomness()
		{
			return $this->_base_dmp_randomness;
		}

		public function setBaseDMPRandomness($base_dmp_randomness)
		{
			$this->_base_dmp_randomness = $base_dmp_randomness;
		}
				
		public function getCreatureClass()
		{
			return $this->_creature_class;
		}

		public function setCreatureClass($creature_class)
		{
			$this->_creature_class = $creature_class;
		}

		public function getFaction()
		{
			return $this->_faction;
		}

		public function setFaction($faction)
		{
			$this->_faction = $faction;
		}

		public function getCardLevel()
		{
			return $this->_card_level;
		}

		public function setCardLevel($card_level)
		{
			$this->_card_level = $card_level;
		}

		public function getSlot1Available()
		{
			return $this->_slot_1_available;
		}

		public function isSlot1Available()
		{
			return $this->getSlot1Available();
		}

		public function setSlot1Available($slot_1_available)
		{
			$this->_slot_1_available = $slot_1_available;
		}

		public function getSlot2Available()
		{
			return $this->_slot_2_available;
		}

		public function isSlot2Available()
		{
			return $this->getSlot2Available();
		}

		public function setSlot2Available($slot_2_available)
		{
			$this->_slot_2_available = $slot_2_available;
		}
		
		public function getAttacks()
		{
			$this->_b2dbLazyload('_attacks');
			return $this->_attacks;
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->_faction = $form_data['faction'];
			$this->_creature_class = $form_data['creature_class'];
			$this->_base_dmp = (int) $form_data['base_dmp'];
			$this->_base_dmp_randomness = (int) $form_data['base_dmp_randomness'];
			$this->_base_ep = (int) $form_data['base_ep'];
			$this->_base_ep_randomness = (int) $form_data['base_ep_randomness'];
			$this->_base_health = (int) $form_data['base_health'];
			$this->_base_health_randomness = $form_data['base_health_randomness'];
			$this->_card_level = $form_data['level'];
			$this->_slot_1_available = (bool) $form_data['slot_1_available'];
			$this->_slot_2_available = (bool) $form_data['slot_2_available'];
		}

		public function setUserDMP($multiplier)
		{
			$multiplier = ($multiplier > $this->_base_dmp) ? $this->_base_dmp : $multiplier;
			$this->_user_dmp = $multiplier;
		}

		public function getUserDMP()
		{
			return $this->_user_dmp;
		}

		public function getUserCardLevel()
		{
			return $this->_user_card_level;
		}

		public function setUserCardLevel($user_card_level)
		{
			$this->_user_card_level = $user_card_level;
		}

		public function setIsInPlay($is_in_play = true)
		{
			parent::setIsInPlay($is_in_play);
			if ($is_in_play) {
				$this->_in_game_health = $this->_base_health;
				$this->_in_game_ep = $this->_base_ep;
			}
		}

	}
