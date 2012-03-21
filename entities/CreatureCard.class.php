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
	class CreatureCard extends PlaceableCard
	{

		const CLASS_CIVILIAN = 1;
		const CLASS_RANGED = 2;
		const CLASS_PHYSICAL = 3;
		const CLASS_MAGIC = 4;
		const CLASS_MILITARY = 5;

		/**
		 * Creature class
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_creature_class = 1;

		public function getCreatureClass()
		{
			return $this->_creature_class;
		}

		public function setCreatureClass($creature_class)
		{
			$this->_creature_class = $creature_class;
		}

	}
