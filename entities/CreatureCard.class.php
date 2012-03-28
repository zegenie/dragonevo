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
		 * Base defence multiplier
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_base_dmp = 0;

		/**
		 * Creature class
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_creature_class = 1;

		protected $_faction = Card::FACTION_NEUTRALS;

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

		public function getBaseDMP()
		{
			return $this->_base_dmp;
		}

		public function setBaseDMP($base_dmp)
		{
			$this->_base_dmp = $base_dmp;
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

	}
