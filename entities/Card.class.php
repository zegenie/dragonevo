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

	}
