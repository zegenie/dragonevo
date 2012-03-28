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
		 * Brief card description
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_brief_description = '';

		/**
		 * Card description
		 *
		 * @Column(type="text")
		 * @var string
		 */
		protected $_long_description = '';

		/**
		 * What the card costs to buy
		 *
		 * @Column(type="integer", default=50)
		 * @var integer
		 */
		protected $_cost = 50;

		/**
		 * Number of cards in the entire deck
		 *
		 * @Column(type="integer", default=50)
		 * @var integer
		 */
		protected $_likelihood = 50;

		/**
		 * Whether the card is a special card or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_special_card = false;

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

		public function getCost()
		{
			return $this->_cost;
		}

		public function setCost($cost)
		{
			$this->_cost = $cost;
		}

		public function getLikelihood()
		{
			return $this->_likelihood;
		}

		public function setLikelihood($likelihood)
		{
			$this->_likelihood = $likelihood;
		}

		public function getBriefDescription()
		{
			return $this->_brief_description;
		}

		public function setBriefDescription($brief_description)
		{
			$this->_brief_description = $brief_description;
		}

		public function getLongDescription()
		{
			return $this->_long_description;
		}

		public function setLongDescription($long_description)
		{
			$this->_long_description = $long_description;
		}

		public function getCardType()
		{
			return $this->_card_type;
		}

		public function setCardType($card_type)
		{
			$this->_card_type = $card_type;
		}

		public function getIsSpecialCard()
		{
			return (bool) $this->_is_special_card;
		}

		public function isSpecialCard()
		{
			return $this->getIsSpecialCard();
		}

		public function setIsSpecialCard($is_special_card = true)
		{
			$this->_is_special_card = (bool) $is_special_card;
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

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			foreach (array('name', 'brief_description', 'long_description') as $field) {
				$property_name = "_{$field}";
				$this->$property_name = (string) $form_data[$field];
			}
			$this->_is_special_card = (bool) $form_data['is_special_card'];
			foreach (array('cost', 'likelihood') as $field) {
				$property_name = "_{$field}";
				$this->$property_name = (integer) $form_data[$field];
			}
			foreach (array('gpt', 'mpt') as $resource) {
				foreach (array('player', 'opponent') as $pl) {
					$property_name = "_{$resource}_".$form_data["{$resource}_{$pl}"]."_{$pl}";
					$this->$property_name = (int) $form_data["{$resource}_{$pl}_modifier"];
				}
			}
		}

	}
