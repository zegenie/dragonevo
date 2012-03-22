<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\PlacableCards")
	 */
	abstract class ModifierCard extends Card
	{

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_basic_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_basic_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_basic_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_basic_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_air_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_air_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_air_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_air_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_dark_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_dark_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_dark_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_dark_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_earth_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_earth_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_earth_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_earth_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_fire_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_fire_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_fire_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_fire_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_freeze_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_freeze_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_freeze_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_freeze_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_melee_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_melee_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_melee_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_melee_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_poison_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_poison_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_poison_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_poison_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_ranged_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_ranged_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_ranged_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_ranged_opponent = 0;

		public function getDMPIncreaseBasicPlayer()
		{
			return $this->_dmp_increase_basic_player;
		}

		public function setDMPIncreaseBasicPlayer($dmp_increase_basic_player)
		{
			$this->_dmp_increase_basic_player = $dmp_increase_basic_player;
		}

		public function getDMPDecreaseBasicPlayer()
		{
			return $this->_dmp_decrease_basic_player;
		}

		public function setDMPDecreaseBasicPlayer($dmp_decrease_basic_player)
		{
			$this->_dmp_decrease_basic_player = $dmp_decrease_basic_player;
		}

		public function getDMPIncreaseBasicOpponent()
		{
			return $this->_dmp_increase_basic_opponent;
		}

		public function setDMPIncreaseBasicOpponent($dmp_increase_basic_opponent)
		{
			$this->_dmp_increase_basic_opponent = $dmp_increase_basic_opponent;
		}

		public function getDMPDecreaseBasicOpponent()
		{
			return $this->_dmp_decrease_basic_opponent;
		}

		public function setDMPDecreaseBasicOpponent($dmp_decrease_basic_opponent)
		{
			$this->_dmp_decrease_basic_opponent = $dmp_decrease_basic_opponent;
		}

		public function getDMPPlayerBasicModifier()
		{
			return $this->getDMPDecreaseBasicPlayer() + $this->getDMPIncreaseBasicPlayer();
		}

		public function getDMPOpponentBasicModifier()
		{
			return $this->getDMPDecreaseBasicOpponent() + $this->getDMPIncreaseBasicOpponent();
		}

		public function getDMPIncreaseAirPlayer()
		{
			return $this->_dmp_increase_air_player;
		}

		public function setDMPIncreaseAirPlayer($dmp_increase_air_player)
		{
			$this->_dmp_increase_air_player = $dmp_increase_air_player;
		}

		public function getDMPDecreaseAirPlayer()
		{
			return $this->_dmp_decrease_air_player;
		}

		public function setDMPDecreaseAirPlayer($dmp_decrease_air_player)
		{
			$this->_dmp_decrease_air_player = $dmp_decrease_air_player;
		}

		public function getDMPIncreaseAirOpponent()
		{
			return $this->_dmp_increase_air_opponent;
		}

		public function setDMPIncreaseAirOpponent($dmp_increase_air_opponent)
		{
			$this->_dmp_increase_air_opponent = $dmp_increase_air_opponent;
		}

		public function getDMPDecreaseAirOpponent()
		{
			return $this->_dmp_decrease_air_opponent;
		}

		public function setDMPDecreaseAirOpponent($dmp_decrease_air_opponent)
		{
			$this->_dmp_decrease_air_opponent = $dmp_decrease_air_opponent;
		}

		public function getDMPPlayerAirModifier()
		{
			return $this->getDMPDecreaseAirPlayer() + $this->getDMPIncreaseAirPlayer();
		}

		public function getDMPOpponentAirModifier()
		{
			return $this->getDMPDecreaseAirOpponent() + $this->getDMPIncreaseAirOpponent();
		}

		public function getDMPIncreaseDarkPlayer()
		{
			return $this->_dmp_increase_dark_player;
		}

		public function setDMPIncreaseDarkPlayer($dmp_increase_dark_player)
		{
			$this->_dmp_increase_dark_player = $dmp_increase_dark_player;
		}

		public function getDMPDecreaseDarkPlayer()
		{
			return $this->_dmp_decrease_dark_player;
		}

		public function setDMPDecreaseDarkPlayer($dmp_decrease_dark_player)
		{
			$this->_dmp_decrease_dark_player = $dmp_decrease_dark_player;
		}

		public function getDMPIncreaseDarkOpponent()
		{
			return $this->_dmp_increase_dark_opponent;
		}

		public function setDMPIncreaseDarkOpponent($dmp_increase_dark_opponent)
		{
			$this->_dmp_increase_dark_opponent = $dmp_increase_dark_opponent;
		}

		public function getDMPDecreaseDarkOpponent()
		{
			return $this->_dmp_decrease_dark_opponent;
		}

		public function setDMPDecreaseDarkOpponent($dmp_decrease_dark_opponent)
		{
			$this->_dmp_decrease_dark_opponent = $dmp_decrease_dark_opponent;
		}

		public function getDMPPlayerDarkModifier()
		{
			return $this->getDMPDecreaseDarkPlayer() + $this->getDMPIncreaseDarkPlayer();
		}

		public function getDMPOpponentDarkModifier()
		{
			return $this->getDMPDecreaseDarkOpponent() + $this->getDMPIncreaseDarkOpponent();
		}

		public function getDMPIncreaseEarthPlayer()
		{
			return $this->_dmp_increase_earth_player;
		}

		public function setDMPIncreaseEarthPlayer($dmp_increase_earth_player)
		{
			$this->_dmp_increase_earth_player = $dmp_increase_earth_player;
		}

		public function getDMPDecreaseEarthPlayer()
		{
			return $this->_dmp_decrease_earth_player;
		}

		public function setDMPDecreaseEarthPlayer($dmp_decrease_earth_player)
		{
			$this->_dmp_decrease_earth_player = $dmp_decrease_earth_player;
		}

		public function getDMPIncreaseEarthOpponent()
		{
			return $this->_dmp_increase_earth_opponent;
		}

		public function setDMPIncreaseEarthOpponent($dmp_increase_earth_opponent)
		{
			$this->_dmp_increase_earth_opponent = $dmp_increase_earth_opponent;
		}

		public function getDMPDecreaseEarthOpponent()
		{
			return $this->_dmp_decrease_earth_opponent;
		}

		public function setDMPDecreaseEarthOpponent($dmp_decrease_earth_opponent)
		{
			$this->_dmp_decrease_earth_opponent = $dmp_decrease_earth_opponent;
		}

		public function getDMPPlayerEarthModifier()
		{
			return $this->getDMPDecreaseEarthPlayer() + $this->getDMPIncreaseEarthPlayer();
		}

		public function getDMPOpponentEarthModifier()
		{
			return $this->getDMPDecreaseEarthOpponent() + $this->getDMPIncreaseEarthOpponent();
		}

		public function getDMPIncreaseFirePlayer()
		{
			return $this->_dmp_increase_fire_player;
		}

		public function setDMPIncreaseFirePlayer($dmp_increase_fire_player)
		{
			$this->_dmp_increase_fire_player = $dmp_increase_fire_player;
		}

		public function getDMPDecreaseFirePlayer()
		{
			return $this->_dmp_decrease_fire_player;
		}

		public function setDMPDecreaseFirePlayer($dmp_decrease_fire_player)
		{
			$this->_dmp_decrease_fire_player = $dmp_decrease_fire_player;
		}

		public function getDMPIncreaseFireOpponent()
		{
			return $this->_dmp_increase_fire_opponent;
		}

		public function setDMPIncreaseFireOpponent($dmp_increase_fire_opponent)
		{
			$this->_dmp_increase_fire_opponent = $dmp_increase_fire_opponent;
		}

		public function getDMPDecreaseFireOpponent()
		{
			return $this->_dmp_decrease_fire_opponent;
		}

		public function setDMPDecreaseFireOpponent($dmp_decrease_fire_opponent)
		{
			$this->_dmp_decrease_fire_opponent = $dmp_decrease_fire_opponent;
		}

		public function getDMPPlayerFireModifier()
		{
			return $this->getDMPDecreaseFirePlayer() + $this->getDMPIncreaseFirePlayer();
		}

		public function getDMPOpponentFireModifier()
		{
			return $this->getDMPDecreaseFireOpponent() + $this->getDMPIncreaseFireOpponent();
		}

		public function getDMPIncreaseFreezePlayer()
		{
			return $this->_dmp_increase_freeze_player;
		}

		public function setDMPIncreaseFreezePlayer($dmp_increase_freeze_player)
		{
			$this->_dmp_increase_freeze_player = $dmp_increase_freeze_player;
		}

		public function getDMPDecreaseFreezePlayer()
		{
			return $this->_dmp_decrease_freeze_player;
		}

		public function setDMPDecreaseFreezePlayer($dmp_decrease_freeze_player)
		{
			$this->_dmp_decrease_freeze_player = $dmp_decrease_freeze_player;
		}

		public function getDMPIncreaseFreezeOpponent()
		{
			return $this->_dmp_increase_freeze_opponent;
		}

		public function setDMPIncreaseFreezeOpponent($dmp_increase_freeze_opponent)
		{
			$this->_dmp_increase_freeze_opponent = $dmp_increase_freeze_opponent;
		}

		public function getDMPDecreaseFreezeOpponent()
		{
			return $this->_dmp_decrease_freeze_opponent;
		}

		public function setDMPDecreaseFreezeOpponent($dmp_decrease_freeze_opponent)
		{
			$this->_dmp_decrease_freeze_opponent = $dmp_decrease_freeze_opponent;
		}

		public function getDMPPlayerFreezeModifier()
		{
			return $this->getDMPDecreaseFreezePlayer() + $this->getDMPIncreaseFreezePlayer();
		}

		public function getDMPOpponentFreezeModifier()
		{
			return $this->getDMPDecreaseFreezeOpponent() + $this->getDMPIncreaseFreezeOpponent();
		}

		public function getDMPIncreaseMeleePlayer()
		{
			return $this->_dmp_increase_melee_player;
		}

		public function setDMPIncreaseMeleePlayer($dmp_increase_melee_player)
		{
			$this->_dmp_increase_melee_player = $dmp_increase_melee_player;
		}

		public function getDMPDecreaseMeleePlayer()
		{
			return $this->_dmp_decrease_melee_player;
		}

		public function setDMPDecreaseMeleePlayer($dmp_decrease_melee_player)
		{
			$this->_dmp_decrease_melee_player = $dmp_decrease_melee_player;
		}

		public function getDMPIncreaseMeleeOpponent()
		{
			return $this->_dmp_increase_melee_opponent;
		}

		public function setDMPIncreaseMeleeOpponent($dmp_increase_melee_opponent)
		{
			$this->_dmp_increase_melee_opponent = $dmp_increase_melee_opponent;
		}

		public function getDMPDecreaseMeleeOpponent()
		{
			return $this->_dmp_decrease_melee_opponent;
		}

		public function setDMPDecreaseMeleeOpponent($dmp_decrease_melee_opponent)
		{
			$this->_dmp_decrease_melee_opponent = $dmp_decrease_melee_opponent;
		}

		public function getDMPPlayerMeleeModifier()
		{
			return $this->getDMPDecreaseMeleePlayer() + $this->getDMPIncreaseMeleePlayer();
		}

		public function getDMPOpponentMeleeModifier()
		{
			return $this->getDMPDecreaseMeleeOpponent() + $this->getDMPIncreaseMeleeOpponent();
		}

		public function getDMPIncreasePoisonPlayer()
		{
			return $this->_dmp_increase_poison_player;
		}

		public function setDMPIncreasePoisonPlayer($dmp_increase_poison_player)
		{
			$this->_dmp_increase_poison_player = $dmp_increase_poison_player;
		}

		public function getDMPDecreasePoisonPlayer()
		{
			return $this->_dmp_decrease_poison_player;
		}

		public function setDMPDecreasePoisonPlayer($dmp_decrease_poison_player)
		{
			$this->_dmp_decrease_poison_player = $dmp_decrease_poison_player;
		}

		public function getDMPIncreasePoisonOpponent()
		{
			return $this->_dmp_increase_poison_opponent;
		}

		public function setDMPIncreasePoisonOpponent($dmp_increase_poison_opponent)
		{
			$this->_dmp_increase_poison_opponent = $dmp_increase_poison_opponent;
		}

		public function getDMPDecreasePoisonOpponent()
		{
			return $this->_dmp_decrease_poison_opponent;
		}

		public function setDMPDecreasePoisonOpponent($dmp_decrease_poison_opponent)
		{
			$this->_dmp_decrease_poison_opponent = $dmp_decrease_poison_opponent;
		}

		public function getDMPPlayerPoisonModifier()
		{
			return $this->getDMPDecreasePoisonPlayer() + $this->getDMPIncreasePoisonPlayer();
		}

		public function getDMPOpponentPoisonModifier()
		{
			return $this->getDMPDecreasePoisonOpponent() + $this->getDMPIncreasePoisonOpponent();
		}

		public function getDMPIncreaseRangedPlayer()
		{
			return $this->_dmp_increase_ranged_player;
		}

		public function setDMPIncreaseRangedPlayer($dmp_increase_ranged_player)
		{
			$this->_dmp_increase_ranged_player = $dmp_increase_ranged_player;
		}

		public function getDMPDecreaseRangedPlayer()
		{
			return $this->_dmp_decrease_ranged_player;
		}

		public function setDMPDecreaseRangedPlayer($dmp_decrease_ranged_player)
		{
			$this->_dmp_decrease_ranged_player = $dmp_decrease_ranged_player;
		}

		public function getDMPIncreaseRangedOpponent()
		{
			return $this->_dmp_increase_ranged_opponent;
		}

		public function setDMPIncreaseRangedOpponent($dmp_increase_ranged_opponent)
		{
			$this->_dmp_increase_ranged_opponent = $dmp_increase_ranged_opponent;
		}

		public function getDMPDecreaseRangedOpponent()
		{
			return $this->_dmp_decrease_ranged_opponent;
		}

		public function setDMPDecreaseRangedOpponent($dmp_decrease_ranged_opponent)
		{
			$this->_dmp_decrease_ranged_opponent = $dmp_decrease_ranged_opponent;
		}

		public function getDMPPlayerRangedModifier()
		{
			return $this->getDMPDecreaseRangedPlayer() + $this->getDMPIncreaseRangedPlayer();
		}

		public function getDMPOpponentRangedModifier()
		{
			return $this->getDMPDecreaseRangedOpponent() + $this->getDMPIncreaseRangedOpponent();
		}

		public function mergeFormData($form_data = array())
		{
			parent::mergeFormData($form_data);
		}

	}
