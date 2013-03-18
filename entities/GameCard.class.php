<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo game card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\GameCards")
	 */
	class GameCard extends \b2db\Saveable
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
		 * Unique card id
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_card_unique_id;

		/**
		 * The card
		 *
		 * @var \application\entities\Card
		 */
		protected $_card = null;

		/**
		 * Game id
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Game")
		 *
		 * @var \application\entities\Game
		 */
		protected $_game_id = '';

		/**
		 * The user_id who owns this card
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_user_id;

		/**
		 * Current in-game health
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_in_game_health = 1;

		/**
		 * Current in-game health
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_in_game_ep = 1;

		/**
		 * If in a game, the slot the card is on
		 *
		 * @Column(type="integer", length=10)
		 *
		 * @var integer
		 */
		protected $_slot = 0;

		/**
		 * Whether the card is a in play or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_in_play = false;

		/**
		 * Whether this card is using powerup slot 1
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_powerup_slot_1 = false;

		/**
		 * Whether this card is using powerup slot 2
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_powerup_slot_2 = false;

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		protected function _preSave($is_new)
		{
			if ($is_new) {
				if ($this->getCard()->getCardType() == Card::TYPE_CREATURE) {
					$this->_in_game_ep = $this->getCard()->getBaseEP();
					$this->_in_game_health = $this->getCard()->getBaseHP();
				}
			}
		}

		public function getCard()
		{
			if (!is_object($this->_card)) {
				$this->_card = tables\Cards::getTable()->getCardByUniqueId($this->_card_unique_id);
				if ($this->_card instanceof Card) {
					$this->_card->setGameCard($this);
					$this->_card->setSlot($this->_slot);
					$this->_card->setInGameEP($this->_in_game_ep);
					$this->_card->setInGameHP($this->_in_game_health);
					$this->_card->setIsInPlay($this->_is_in_play);
					$this->_card->setPowerupSlot1($this->_powerup_slot_1);
					$this->_card->setPowerupSlot2($this->_powerup_slot_2);
				}
			}
			return $this->_card;
		}

		public function getCardUniqueId()
		{
			return $this->_card_unique_id;
		}

		public function setCardUniqueId($card_unique_id)
		{
			if (is_object($card_unique_id)) {
				$this->_card = $card_unique_id;
				$this->_card_unique_id = $card_unique_id->getUniqueId();
			} else {
				$this->_card_unique_id = $card_unique_id;
			}
		}

		public function setGameId($game_id)
		{
			$this->_game_id = $game_id;
		}

		public function setGame($game)
		{
			$this->_game_id = $game;
		}

		/**
		 *
		 * @return Game
		 */
		public function getGame()
		{
			return $this->_b2dbLazyload('_game_id');
		}

		public function getGameId()
		{
			return ($this->_game_id instanceof Game) ? $this->_game_id->getId() : $this->_game_id;
		}

		public function setUserId($user_id)
		{
			$this->_user_id = $user_id;
		}

		public function setUser($user)
		{
			$this->_user_id = $user;
		}

		/**
		 * Return the user associated with this card
		 *
		 * @return User
		 */
		public function getUser()
		{
			return $this->_b2dbLazyload('_user_id');
		}

		public function getUserId()
		{
			return ($this->_user_id instanceof User) ? $this->_user_id->getId() : (int) $this->_user_id;
		}

		public function setSlot($slot)
		{
			$this->_slot = $slot;
		}

		public function getSlot()
		{
			return $this->_slot;
		}

		public function getPowerupSlot1()
		{
			return $this->_powerup_slot_1;
		}

		public function isPowerupSlot1()
		{
			return $this->getPowerupSlot1();
		}

		public function setPowerupSlot1($powerup_slot_1 = true)
		{
			$this->_powerup_slot_1 = $powerup_slot_1;
		}

		public function getPowerupSlot2()
		{
			return $this->_powerup_slot_2;
		}

		public function isPowerupSlot2()
		{
			return $this->getPowerupSlot2();
		}

		public function setPowerupSlot2($powerup_slot_2 = true)
		{
			$this->_powerup_slot_2 = $powerup_slot_2;
		}

		public function getIsInPlay()
		{
			return (bool) $this->_is_in_play;
		}

		public function isInPlay()
		{
			return $this->getIsInPlay();
		}

		public function setIsInPlay($is_in_play = true)
		{
			$this->_is_in_play = (bool) $is_in_play;
		}

		public function getInGameHealth()
		{
			return (int) $this->_in_game_health;
		}

		public function getInGameHP()
		{
			return $this->getInGameHealth();
		}

		public function setInGameHealth($in_game_health)
		{
			$this->_in_game_health = (int) $in_game_health;
		}

		public function setInGameHP($hp)
		{
			$this->setInGameHealth($hp);
		}

		public function getInGameEP()
		{
			return (int) $this->_in_game_ep;
		}

		public function setInGameEP($in_game_ep)
		{
			$this->_in_game_ep = (int) $in_game_ep;
		}

	}

