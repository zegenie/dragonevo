<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo generic card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Cards")
	 */
	abstract class Card extends \b2db\Saveable
	{

		const TYPE_EVENT = 'event';
		const TYPE_CREATURE = 'creature';
		const TYPE_ITEM = 'item';

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Card name
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_name = '';

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = null;

		/**
		 * Gold per turn increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_increase_player = 0;

		/**
		 * Gold per turn decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_decrease_player = 0;

		/**
		 * Gold per turn increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_increase_opponent = 0;

		/**
		 * Gold per turn decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_decrease_opponent = 0;

		/**
		 * Magic per turn increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_increase_player = 0;

		/**
		 * Magic per turn decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_decrease_player = 0;

		/**
		 * Magic per turn increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_increase_opponent = 0;

		/**
		 * Magic per turn decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_decrease_opponent = 0;

		/**
		 * DMP (defence multiplier) increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_player = 0;

		/**
		 * DMP (defence multiplier) decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_player = 0;

		/**
		 * DMP (defence multiplier) increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_increase_opponent = 0;

		/**
		 * DMP (defence multiplier) decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_dmp_decrease_opponent = 0;

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

		public function getCardType()
		{
			return $this->_card_type;
		}

		public function setCardType($card_type)
		{
			$this->_card_type = $card_type;
		}

		public function getGPTIncreasePlayer()
		{
			return $this->_gpt_increase_player;
		}

		public function setGPTIncreasePlayer($gpt_increase_player)
		{
			$this->_gpt_increase_player = $gpt_increase_player;
		}

		public function getGPTDecreasePlayer()
		{
			return $this->_gpt_decrease_player;
		}

		public function setGPTDecreasePlayer($gpt_decrease_player)
		{
			$this->_gpt_decrease_player = $gpt_decrease_player;
		}

		public function getGPTIncreaseOpponent()
		{
			return $this->_gpt_increase_opponent;
		}

		public function setGPTIncreaseOpponent($gpt_increase_opponent)
		{
			$this->_gpt_increase_opponent = $gpt_increase_opponent;
		}

		public function getGPTDecreaseOpponent()
		{
			return $this->_gpt_decrease_opponent;
		}

		public function setGPTDecreaseOpponent($gpt_decrease_opponent)
		{
			$this->_gpt_decrease_opponent = $gpt_decrease_opponent;
		}

		public function getGPTPlayerModifier()
		{
			return $this->getGPTDecreasePlayer() + $this->getGPTIncreasePlayer();
		}

		public function getGPTOpponentModifier()
		{
			return $this->getGPTDecreaseOpponent() + $this->getGPTIncreaseOpponent();
		}

		public function getMPTIncreasePlayer()
		{
			return $this->_mpt_increase_player;
		}

		public function setMPTIncreasePlayer($mpt_increase_player)
		{
			$this->_mpt_increase_player = $mpt_increase_player;
		}

		public function getMPTDecreasePlayer()
		{
			return $this->_mpt_decrease_player;
		}

		public function setMPTDecreasePlayer($mpt_decrease_player)
		{
			$this->_mpt_decrease_player = $mpt_decrease_player;
		}

		public function getMPTIncreaseOpponent()
		{
			return $this->_mpt_increase_opponent;
		}

		public function setMPTIncreaseOpponent($mpt_increase_opponent)
		{
			$this->_mpt_increase_opponent = $mpt_increase_opponent;
		}

		public function getMPTDecreaseOpponent()
		{
			return $this->_mpt_decrease_opponent;
		}

		public function setMPTDecreaseOpponent($mpt_decrease_opponent)
		{
			$this->_mpt_decrease_opponent = $mpt_decrease_opponent;
		}

		public function getMPTPlayerModifier()
		{
			return $this->getMPTDecreasePlayer() + $this->getMPTIncreasePlayer();
		}

		public function getMPTOpponentModifier()
		{
			return $this->getMPTDecreaseOpponent() + $this->getMPTIncreaseOpponent();
		}

		public function getDMPIncreasePlayer()
		{
			return $this->_dmp_increase_player;
		}

		public function setDMPIncreasePlayer($dmp_increase_player)
		{
			$this->_dmp_increase_player = $dmp_increase_player;
		}

		public function getDMPDecreasePlayer()
		{
			return $this->_dmp_decrease_player;
		}

		public function setDMPDecreasePlayer($dmp_decrease_player)
		{
			$this->_dmp_decrease_player = $dmp_decrease_player;
		}

		public function getDMPIncreaseOpponent()
		{
			return $this->_dmp_increase_opponent;
		}

		public function setDMPIncreaseOpponent($dmp_increase_opponent)
		{
			$this->_dmp_increase_opponent = $dmp_increase_opponent;
		}

		public function getDMPDecreaseOpponent()
		{
			return $this->_dmp_decrease_opponent;
		}

		public function setDMPDecreaseOpponent($dmp_decrease_opponent)
		{
			$this->_dmp_decrease_opponent = $dmp_decrease_opponent;
		}

		public function getDMPPlayerModifier()
		{
			return $this->getDMPDecreasePlayer() + $this->getDMPIncreasePlayer();
		}

		public function getDMPOpponentModifier()
		{
			return $this->getDMPDecreaseOpponent() + $this->getDMPIncreaseOpponent();
		}

	}
