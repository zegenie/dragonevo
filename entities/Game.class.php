<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo game class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Games")
	 */
	class Game extends \b2db\Saveable
	{

		const STATE_INITIATED = 0;
		const STATE_ONGOING = 1;
		const STATE_COMPLETED = 2;

		const PHASE_REPLENISH = 1;
		const PHASE_MOVE = 2;
		const PHASE_ACTION = 3;
		const PHASE_RESOLUTION = 4;

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Timestamp of when the game was created
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_created_at;

		/**
		 * Timestamp of when the game ended
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_ended_at;

		/** 
		 * The player who initiated the game
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_player_id;

		protected $_player_cards;

		/**
		 * Player gold
		 *
		 * @Column(type="integer", length=10)
		 *
		 * @var integer
		 */
		protected $_player_gold;

		/** 
		 * The opponent player
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_opponent_id;

		protected $_opponent_cards;

		/**
		 * Opponent gold
		 *
		 * @Column(type="integer", length=10)
		 *
		 * @var integer
		 */
		protected $_opponent_gold;

		/**
		 * Whether invitations have been sent
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_invitation_sent;

		/**
		 * Whether invitations have been confirmed
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_invitation_confirmed;

		/**
		 * Whether invitations have been rejected
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_invitation_rejected;

		/**
		 * Quickmatch state
		 *
		 * @Column(type="integer", default=0)
		 * @var integer
		 */
		protected $_quickmatch_state;

		/**
		 * The player who's turn it is
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_current_player_id;

		/**
		 * The current game turn phase
		 * 
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_current_phase;
		
		/**
		 * The current game turn
		 * 
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_turn_number = 1;

		/**
		 * The current players currently available actions
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_current_player_actions = 0;

		/**
		 * The player who won the game
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_winning_player_id;

		/**
		 * The player who lost the game
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_losing_player_id;

		/**
		 * Game name
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_name = '';

		/**
		 * Game state
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_state = self::STATE_INITIATED;

		/**
		 * @Relates(class="\application\entities\GameEvent", collection=true, foreign_column="game_id")
		 * @var array|\application\entities\GameEvent
		 */
		protected $_events;

		/**
		 * The related chatroom
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\ChatRoom")
		 * 
		 * @var ChatRoom
		 */
		protected $_chatroom_id;

		/**
		 * Whether the winning player has chosen his loot
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_loot_decided = false;

		protected function _preSave($is_new)
		{
			if ($is_new && !$this->_created_at) {
				$this->_created_at = time();
				$this->_current_phase = self::PHASE_MOVE;

				$chatroom = new ChatRoom();
				$chatroom->setUser($this->getUserPlayer());
				$chatroom->setTopic('Game chat');
				$chatroom->save();
				$this->_chatroom_id = $chatroom;
			}
		}

		protected function _postSave($is_new)
		{
			if ($is_new) {
				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_GAME_CREATED);
				$this->addEvent($event);
			}
		}

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		public function getCreatedAt()
		{
			return $this->_created_at;
		}

		public function setCreatedAt($created_at)
		{
			$this->_created_at = $created_at;
		}

		public function getEndedAt()
		{
			return $this->_ended_at;
		}

		public function setEndedAt($ended_at)
		{
			$this->_ended_at = $ended_at;
		}

		public function getName()
		{
			return $this->_name;
		}

		public function setName($name)
		{
			$this->_name = $name;
		}
		
		public function getTurnNumber()
		{
			return $this->_turn_number;
		}
		
		public function setTurnNumber($turn_number)
		{
			$this->_turn_number = $turn_number;
		}
		
		protected function resetUserCards()
		{
			\application\entities\tables\EventCards::getTable()->resetUserCards($this->getId());
			\application\entities\tables\CreatureCards::getTable()->resetUserCards($this->getId());
			\application\entities\tables\PotionItemCards::getTable()->resetUserCards($this->getId());
			\application\entities\tables\EquippableItemCards::getTable()->resetUserCards($this->getId());
			\application\entities\tables\ModifierEffects::getTable()->removeEffects($this->getId());
		}

		protected function _calculateWinningConditions()
		{
			$player_cards = $this->hasPlayerCardsInPlay();
			$opponent_cards = $this->hasOpponentCardsInPlay();

			if ($this->_turn_number > 2 && (!$player_cards || !$opponent_cards)) {
				return true;
			}

			return false;
		}

		public function resolve($winning_player_id)
		{
			$this->_current_phase = self::PHASE_RESOLUTION;
			$this->_state = self::STATE_COMPLETED;
			$this->_ended_at = time();
			$this->resetUserCards();
			$this->_winning_player_id = $winning_player_id;
			$this->_losing_player_id = ($this->getPlayer()->getId() == $winning_player_id) ? $this->getOpponent()->getId() : $this->getPlayer()->getId();

			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_GAME_OVER);
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'winning_player_id' => $this->getWinningPlayerId()));
			$this->addEvent($event);

			$this->_current_player_id = 0;

			$winner_statistics = $this->getStatistics($this->getWinningPlayerId());
			$this->getWinningPlayer()->addXp($winner_statistics['xp']);
			$this->getWinningPlayer()->addGold($winner_statistics['gold']);
			$this->getWinningPlayer()->save();

			$loser_statistics = $this->getStatistics($this->getLosingPlayerId());
			$this->getLosingPlayer()->addXp($loser_statistics['xp']);
			$this->getLosingPlayer()->addGold($loser_statistics['gold']);
			$this->getLosingPlayer()->save();
		}

		public function endTurn()
		{
			if (!$this->_calculateWinningConditions()) {
				$this->_current_phase = self::PHASE_REPLENISH;
				$this->_turn_number++;
			} else {
				$winning_player_id = ($this->hasPlayerCardsInPlay()) ? $this->getPlayer()->getId() : $this->getOpponent()->getId();
				$this->resolve($winning_player_id);
			}
		}
		
		public function setPlayerId($player_id)
		{
			$this->_player_id = $player_id;
		}
		
		public function setPlayer($user)
		{
			$this->_player_id = $user;
		}
		
		public function getPlayer()
		{
			return $this->_b2dbLazyload('_player_id');
		}

		public function getPlayerGold()
		{
			return $this->_player_gold;
		}

		public function setPlayerGold($player_gold)
		{
			$this->_player_gold = $player_gold;
		}

		public function getUserPlayerGold()
		{
			return ($this->getPlayer()->getId() == Caspar::getUser()->getId()) ? $this->getPlayerGold() : $this->getOpponentGold();
		}

		public function setUserPlayerGold($gold)
		{
			return ($this->getPlayer()->getId() == Caspar::getUser()->getId()) ? $this->setPlayerGold($gold) : $this->setOpponentGold($gold);
		}

		public function getOpponentGold()
		{
			return $this->_opponent_gold;
		}

		public function setOpponentGold($opponent_gold)
		{
			$this->_opponent_gold = $opponent_gold;
		}

		public function getUserOpponentGold()
		{
			return ($this->getOpponent()->getId() == Caspar::getUser()->getId()) ? $this->getOpponentGold() : $this->getPlayerGold();
		}

		public function setUserOpponentGold($gold)
		{
			return ($this->getOpponent()->getId() == Caspar::getUser()->getId()) ? $this->setOpponentGold($gold) : $this->setPlayerGold($gold);
		}

		protected function _populatePlayerCards()
		{
			if ($this->_player_cards === null) {
				$user_id = $this->getPlayer()->getId();
				$creature = \application\entities\tables\CreatureCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$potion_item = \application\entities\tables\PotionItemCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$equippable_item = \application\entities\tables\EquippableItemCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$event = \application\entities\tables\EventCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$this->_player_cards = compact('creature', 'equippable_item', 'potion_item', 'event');
			}
		}

		public function getPlayerCards()
		{
			$this->_populatePlayerCards();
			return $this->_player_cards;
		}

		public function getPlayerCardSlot($slot)
		{
			foreach ($this->getPlayerCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->getSlot() == $slot) return $card;
				}
			}
		}

		public function getPlayerCardSlotPowerup1($slot)
		{
			foreach ($this->getPlayerCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getSlot() == $slot && $card->isPowerupSlot1()) return $card;
				}
			}
		}

		public function getPlayerCardSlotPowerup2($slot)
		{
			foreach ($this->getPlayerCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getSlot() == $slot && $card->isPowerupSlot2()) return $card;
				}
			}
		}

		public function setPlayerCardSlot($slot, $card_id)
		{
			$cards = $this->getPlayerCards();
			$this->_processCardSlotMoving($cards, $slot, $card_id);
		}

		public function setPlayerCardSlotPowerup1($slot, $card_id)
		{
			$cards = $this->getPlayerCards();
			$this->_processCardSlotPowerupCard1Moving($cards, $slot, $card_id);
		}

		public function setPlayerCardSlotPowerup2($slot, $card_id)
		{
			$cards = $this->getPlayerCards();
			$this->_processCardSlotPowerupCard2Moving($cards, $slot, $card_id);
		}

		public function hasPlayerCards()
		{
			$cards = $this->getPlayerCards();
			return (bool) count($cards['creature']) + count($cards['potion_item']) + count($cards['equippable_item']) + count($cards['event']);
		}

		public function hasPlayerCardsInPlay()
		{
			foreach ($this->getPlayerCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->isInPlay()) return true;
				}
			}
			
			return false;
		}

		public function hasPlayerPlacedCards()
		{
			foreach ($this->getPlayerCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->getSlot() > 0) return true;
				}
			}

			return false;
		}

		public function getCurrentPlayerKey()
		{
			return ($this->getCurrentPlayerId() == $this->getPlayer()->getId()) ? 'player' : 'opponent';
		}

		public function getUserCurrentPlayerKey()
		{
			return ($this->getCurrentPlayerId() == $this->getUserPlayer()->getId()) ? 'player' : 'opponent';
		}

		public function getStatistics($player_id)
		{
			$statistics = tables\GameEvents::getTable()->getStatisticsByGameId($this->getId(), $player_id);
			$gold = ($this->getPlayer()->getId() == $player_id) ? $this->getPlayerGold() : $this->getOpponentGold();

			if ($player_id == $this->getWinningPlayerId()) {
				$statistics['xp'] = floor(($statistics['hp'] / 100) * 20) + floor(($statistics['hp'] / 100) * $statistics['cards']);
				$statistics['gold'] = floor(($gold / 100) * 7.5);
				if ($statistics['gold'] > 15) $statistics['gold'] = 15;
			} else {
				$statistics['xp'] = floor(($statistics['hp'] / 100) * 10);
				$statistics['gold'] = floor(($gold / 10) * 3.5);
				if ($statistics['gold'] > 5) $statistics['gold'] = 5;
			}

			return $statistics;
		}

		public function getUserPlayer()
		{
			return ($this->getPlayer()->getId() == Caspar::getUser()->getId()) ? $this->getPlayer() : $this->getOpponent();
		}

		public function getUserOpponent()
		{
			return ($this->getPlayer()->getId() == Caspar::getUser()->getId()) ? $this->getOpponent() : $this->getPlayer();
		}

		public function isPlayerTurn()
		{
			return ($this->getCurrentPlayerKey() == 'player');
		}

		public function isOpponentTurn()
		{
			return ($this->getCurrentPlayerKey() == 'opponent');
		}

		public function setWinningPlayerId($winning_player_id)
		{
			$this->_winning_player_id = $winning_player_id;
		}

		public function setWinningPlayer($user)
		{
			$this->_winning_player_id = $user;
		}

		/**
		 * Return the user who won the game
		 *
		 * @return User
		 */
		public function getWinningPlayer()
		{
			return $this->_b2dbLazyload('_winning_player_id');
		}

		public function getWinningPlayerId()
		{
			return ($this->_winning_player_id instanceof User) ? $this->_winning_player_id->getId() : $this->_winning_player_id;
		}

		public function setLosingPlayerId($losing_player_id)
		{
			$this->_losing_player_id = $losing_player_id;
		}

		public function setLosingPlayer($user)
		{
			$this->_losing_player_id = $user;
		}

		/**
		 * Return the user who won the game
		 *
		 * @return User
		 */
		public function getLosingPlayer()
		{
			return $this->_b2dbLazyload('_losing_player_id');
		}

		public function getLosingPlayerId()
		{
			return ($this->_losing_player_id instanceof User) ? $this->_losing_player_id->getId() : $this->_losing_player_id;
		}

		public function setCurrentPlayerId($current_player_id)
		{
			$this->_current_player_id = $current_player_id;
		}

		public function setCurrentPlayer($user)
		{
			$this->_current_player_id = $user;
		}

		public function getCurrentPlayer()
		{
			return $this->_b2dbLazyload('_current_player_id');
		}

		public function getCurrentPlayerId()
		{
			return ($this->_current_player_id instanceof User) ? $this->_current_player_id->getId() : $this->_current_player_id;
		}

		public function setOpponentId($opponent_id)
		{
			$this->_opponent_id = $opponent_id;
		}
		
		public function setOpponent($user)
		{
			$this->_opponent_id = $user;
		}

		public function isPvP()
		{
			return ($this->getPlayer() instanceof User && $this->getOpponent() instanceof User);
		}
		
		public function getOpponent()
		{
			return $this->_b2dbLazyload('_opponent_id');
		}

		protected function _populateOpponentCards()
		{
			if ($this->_opponent_cards === null) {
				$user_id = $this->getOpponent()->getId();
				$creature = \application\entities\tables\CreatureCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$potion_item = \application\entities\tables\PotionItemCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$equippable_item = \application\entities\tables\EquippableItemCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$event = \application\entities\tables\EventCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$this->_opponent_cards = compact('creature', 'equippable_item', 'potion_item', 'event');
			}
		}

		public function getOpponentCards()
		{
			$this->_populateOpponentCards();
			return $this->_opponent_cards;
		}

		/**
		 * Return user player card
		 *
		 * @param integer $slot
		 *
		 * @return CreatureCard
		 */
		public function getOpponentCardSlot($slot)
		{
			foreach ($this->getOpponentCards() as $type => $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->getSlot() == $slot) return $card;
				}
			}
		}

		/**
		 * Return user player card
		 *
		 * @param integer $slot
		 *
		 * @return CreatureCard
		 */
		public function getOpponentCardSlotPowerup1($slot)
		{
			foreach ($this->getOpponentCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getSlot() == $slot && $card->isPowerupSlot1()) return $card;
				}
			}
		}

		/**
		 * Return user player card
		 *
		 * @param integer $slot
		 *
		 * @return CreatureCard
		 */
		public function getOpponentCardSlotPowerup2($slot)
		{
			foreach ($this->getOpponentCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getSlot() == $slot && $card->isPowerupSlot2()) return $card;
				}
			}
		}

		protected function _processCardSlotMoving($all_cards, $slot, $card_id)
		{
			foreach ($all_cards as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->getSlot() == $slot && $card->getUniqueId() != $card_id) {
						$card->setSlot(0);
						$card->setIsInPlay(false);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_OFF_SLOT);
						$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'slot' => $slot, 'player_name' => $this->getCurrentPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName()));
						$this->addEvent($event);
					}
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->getUniqueId() == $card_id && $card->getSlot() != $slot) {
						$card->setSlot($slot);
						$card->setIsInPlay(false);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_ONTO_SLOT);
						$event->setEventData(array('player_id' => $this->getUserPlayer()->getId(), 'in_play' => $card->isInPlay(), 'turn_number' => $this->getTurnNumber(), 'player_name' => $this->getUserPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName(), 'slot' => $slot, 'is-item-1' => false, 'is-item-2' => false));
						$this->addEvent($event);
					}
					if ($card->getCardType() == Card::TYPE_CREATURE && ($card->getSlot() == $slot || $card->getUniqueId() == $card_id)) {
						$card->save();
					}
				}
			}
		}

		protected function _processCardSlotPowerupCard1Moving($all_cards, $slot, $card_id)
		{
			foreach ($all_cards as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getSlot() == $slot && $card->getUniqueId() != $card_id && $card->isPowerupSlot1()) {
						$card->setSlot(0);
						$card->setPowerupSlot1(false);
						$card->setPowerupSlot2(false);
						$card->setIsInPlay(false);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_OFF_SLOT);
						$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'slot' => $slot, 'player_name' => $this->getCurrentPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName()));
						$this->addEvent($event);
					}
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getUniqueId() == $card_id && $card->getSlot() != $slot) {
						$card->setSlot($slot);
						$card->setPowerupSlot1();
						$card->setPowerupSlot2(false);
						$card->setIsInPlay(true);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_ONTO_SLOT);
						$event->setEventData(array('player_id' => $this->getUserPlayer()->getId(), 'in_play' => true, 'turn_number' => $this->getTurnNumber(), 'player_name' => $this->getUserPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName(), 'slot' => $slot, 'is-item-1' => true, 'is-item-2' => false));
						$this->addEvent($event);
					}
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && (($card->getSlot() == $slot && $card->isPowerupSlot1()) || $card->getUniqueId() == $card_id)) {
						$card->save();
					}
				}
			}
		}

		protected function _processCardSlotPowerupCard2Moving($all_cards, $slot, $card_id)
		{
			foreach ($all_cards as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getSlot() == $slot && $card->getUniqueId() != $card_id && $card->isPowerupSlot2()) {
						$card->setSlot(0);
						$card->setPowerupSlot1(false);
						$card->setPowerupSlot2(false);
						$card->setIsInPlay(false);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_OFF_SLOT);
						$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'slot' => $slot, 'player_name' => $this->getCurrentPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName()));
						$this->addEvent($event);
					}
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && $card->getUniqueId() == $card_id && $card->getSlot() != $slot) {
						$card->setSlot($slot);
						$card->setPowerupSlot1(false);
						$card->setPowerupSlot2();
						$card->setIsInPlay(true);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_ONTO_SLOT);
						$event->setEventData(array('player_id' => $this->getUserPlayer()->getId(), 'in_play' => true, 'turn_number' => $this->getTurnNumber(), 'player_name' => $this->getUserPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName(), 'slot' => $slot, 'is-item-1' => false, 'is-item-2' => true));
						$this->addEvent($event);
					}
					if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM && (($card->getSlot() == $slot && $card->isPowerupSlot2()) || $card->getUniqueId() == $card_id)) {
						$card->save();
					}
				}
			}
		}

		public function setOpponentCardSlot($slot, $card_id)
		{
			$cards = $this->getOpponentCards();
			$this->_processCardSlotMoving($cards, $slot, $card_id);
		}

		public function setOpponentCardSlotPowerup1($slot, $card_id)
		{
			$cards = $this->getOpponentCards();
			$this->_processCardSlotPowerupCard1Moving($cards, $slot, $card_id);
		}

		public function setOpponentCardSlotPowerup2($slot, $card_id)
		{
			$cards = $this->getOpponentCards();
			$this->_processCardSlotPowerupCard2Moving($cards, $slot, $card_id);
		}

		public function hasOpponentCards()
		{
			$cards = $this->getOpponentCards();
			return (bool) count($cards['creature']) + count($cards['potion_item']) + count($cards['equippable_item']) + count($cards['event']);
		}

		public function hasOpponentCardsInPlay()
		{
			foreach ($this->getOpponentCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->isInPlay()) return true;
				}
			}

			return false;
		}

		public function hasOpponentPlacedCards()
		{
			foreach ($this->getOpponentCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getCardType() == Card::TYPE_CREATURE && $card->getSlot() > 0) return true;
				}
			}

			return false;
		}

		public function hasUserPlayerCards()
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->hasPlayerCards() : $this->hasOpponentCards();
		}

		public function hasUserPlayerCardsInPlay()
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->hasPlayerCardsInPlay() : $this->hasOpponentCardsInPlay();
		}

		public function hasUserPlayerPlacedCards()
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->hasPlayerPlacedCards() : $this->hasOpponentPlacedCards();
		}

		public function hasUserOpponentCardsInPlay()
		{
			return ($this->getUserPlayer()->getId() != $this->getPlayer()->getId()) ? $this->hasPlayerCardsInPlay() : $this->hasOpponentCardsInPlay();
		}

		public function hasUserOpponentPlacedCards()
		{
			return ($this->getUserPlayer()->getId() != $this->getPlayer()->getId()) ? $this->hasPlayerPlacedCards() : $this->hasOpponentPlacedCards();
		}

		public function getUserPlayerCards()
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getPlayerCards() : $this->getOpponentCards();
		}

		/**
		 * Return user player card
		 *
		 * @param integer $slot
		 *
		 * @return CreatureCard
		 */
		public function getUserPlayerCardSlot($slot)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getPlayerCardSlot($slot) : $this->getOpponentCardSlot($slot);
		}

		/**
		 * Return powerup card slot 1
		 *
		 * @param integer $slot
		 *
		 * @return EquippableItemCard
		 */
		public function getUserPlayerCardSlotPowerupCard1($slot)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getPlayerCardSlotPowerup1($slot) : $this->getOpponentCardSlotPowerup1($slot);
		}

		/**
		 * Return powerup card slot 2
		 *
		 * @param integer $slot
		 *
		 * @return EquippableItemCard
		 */
		public function getUserPlayerCardSlotPowerupCard2($slot)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getPlayerCardSlotPowerup2($slot) : $this->getOpponentCardSlotPowerup2($slot);
		}

		public function setUserPlayerCardSlot($slot, $card_id)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->setPlayerCardSlot($slot, $card_id) : $this->setOpponentCardSlot($slot, $card_id);
		}

		public function setUserPlayerCardSlotPowerupCard1($slot, $card_id)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->setPlayerCardSlotPowerup1($slot, $card_id) : $this->setOpponentCardSlotPowerup1($slot, $card_id);
		}

		public function setUserPlayerCardSlotPowerupCard2($slot, $card_id)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->setPlayerCardSlotPowerup2($slot, $card_id) : $this->setOpponentCardSlotPowerup2($slot, $card_id);
		}

		/**
		 * Return user player card
		 *
		 * @param integer $slot
		 *
		 * @return CreatureCard
		 */
		public function getUserOpponentCardSlot($slot)
		{
			if ($this->getTurnNumber() == 1 || ($this->getCurrentPhase() < self::PHASE_RESOLUTION && $this->getTurnNumber() == 2)) return 0;
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getOpponentCardSlot($slot) : $this->getPlayerCardSlot($slot);
		}

		/**
		 * Return powerup card slot 1
		 *
		 * @param integer $slot
		 *
		 * @return EquippableItemCard
		 */
		public function getUserOpponentCardSlotPowerupCard1($slot)
		{
			if ($this->getTurnNumber() == 1 || ($this->getCurrentPhase() < self::PHASE_RESOLUTION && $this->getTurnNumber() == 2)) return 0;
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getOpponentCardSlotPowerup1($slot) : $this->getPlayerCardSlotPowerup1($slot);
		}

		/**
		 * Return powerup card slot 2
		 *
		 * @param integer $slot
		 *
		 * @return EquippableItemCard
		 */
		public function getUserOpponentCardSlotPowerupCard2($slot)
		{
			if ($this->getTurnNumber() == 1 || ($this->getCurrentPhase() < self::PHASE_RESOLUTION && $this->getTurnNumber() == 2)) return 0;
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getOpponentCardSlotPowerup2($slot) : $this->getPlayerCardSlotPowerup2($slot);
		}

		public function getUserPlayerCardSlotId($slot)
		{
			$card = $this->getUserPlayerCardSlot($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function getUserPlayerCardSlotPowerupCard1Id($slot)
		{
			$card = $this->getUserPlayerCardSlotPowerupCard1($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function getUserPlayerCardSlotPowerupCard2Id($slot)
		{
			$card = $this->getUserPlayerCardSlotPowerupCard2($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function getUserOpponentCardSlotId($slot)
		{
			$card = $this->getUserOpponentCardSlot($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function getUserOpponentCardSlotPowerupCard1Id($slot)
		{
			$card = $this->getUserOpponentCardSlotPowerupCard1($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function getUserOpponentCardSlotPowerupCard2Id($slot)
		{
			$card = $this->getUserOpponentCardSlotPowerupCard2($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function hasCards()
		{
			return $this->hasUserPlayerCards();
		}

		public function getCards()
		{
			return $this->getUserPlayerCards();
		}

		public function getCurrentPlayerCards()
		{
			return ($this->getCurrentPlayerId() == $this->getPlayer()->getId()) ? $this->getPlayerCards() : $this->getOpponentCards();
		}

		public function getChatroom()
		{
			return $this->_b2dbLazyload('_chatroom_id');
		}

		public function isInProgress()
		{
			return (bool) ($this->_state == self::STATE_ONGOING);
		}

		public function getInvitationSent()
		{
			return $this->_invitation_sent;
		}

		public function isInvitationSent()
		{
			return $this->getInvitationSent();
		}

		public function setInvitationSent($invitation_sent = true)
		{
			$this->_invitation_sent = $invitation_sent;
		}

		public function getInvitationConfirmed()
		{
			return $this->_invitation_confirmed;
		}

		public function isInvitationConfirmed()
		{
			return $this->getInvitationConfirmed();
		}

		public function setInvitationConfirmed($invitation_confirmed = true)
		{
			$this->_invitation_confirmed = $invitation_confirmed;
			if ($invitation_confirmed) {
				$this->_state = self::STATE_ONGOING;
			}
		}

		public function getInvitationRejected()
		{
			return $this->_invitation_rejected;
		}

		public function isInvitationRejected()
		{
			return $this->getInvitationRejected();
		}

		public function setInvitationRejected($invitation_rejected = true)
		{
			$this->_invitation_rejected = $invitation_rejected;
		}

		public function invite(User $user)
		{
			$invitation = new GameInvite();
			$invitation->setFromPlayer($this->getPlayer());
			$invitation->setToPlayer($user);
			$invitation->setGame($this);
			$invitation->save();
			$this->setOpponent($user);
			$this->setInvitationSent();
		}

		public function cancel()
		{
			tables\GameInvites::getTable()->deleteInvitesByGameId($this->getId());
		}

		public function initiateQuickmatch()
		{
			$this->_quickmatch_state = 1;
		}

		public function completeQuickmatch()
		{
			$this->_quickmatch_state = 2;
			$this->setInvitationConfirmed();
			$this->changePlayer();
		}

		public function getEvents()
		{
			return $this->_b2dbLazyload('_events');
		}

		public function addEvent(GameEvent $event)
		{
			$event->setGame($this);
			$event->save();
		}

		public function replenish()
		{
			$this->_replenish();
		}

		protected function _replenish()
		{
			$gold = 0;
			$p_cards = ($this->getCurrentPlayerKey() == 'player') ? $this->getPlayerCards() : $this->getOpponentCards();
			$o_cards = ($this->getCurrentPlayerKey() == 'player') ? $this->getOpponentCards() : $this->getPlayerCards();
			$old_gold = ($this->getCurrentPlayerKey() == 'player') ? $this->getPlayerGold() : $this->getOpponentGold();
			$card_updates = array();
			foreach ($p_cards as $card_type => $cards) {
				foreach ($cards as $card) {
					if (!$card->isInPlay()) continue;
					if (!$card instanceof CreatureCard || !$card->hasEffect(ModifierEffect::TYPE_STUN)) {
						$gold += $card->getGPTIncreasePlayer();
						$gold -= $card->getGPTDecreasePlayer();
					}
					if ($card instanceof CreatureCard) {
						$can_regenerate = !(bool) ($card->hasEffect(ModifierEffect::TYPE_FIRE) || $card->hasEffect(ModifierEffect::TYPE_FREEZE) || $card->hasEffect(ModifierEffect::TYPE_POISON));
						$hp = $card->getInGameHealth();
						$hp_from = $hp;
						$base_hp = $card->getBaseHealth();
						$ep = $card->getInGameEP();
						$ep_from = $ep;
						$base_ep = $card->getBaseEP();
						$changed = false;
						if ($can_regenerate && ($hp < $base_hp || $ep < $base_ep)) {
							$changed = true;
						}
						if ($can_regenerate && $hp < $base_hp) {
							$hp += ceil(($base_hp / 100) * rand(5, 15));
							if ($hp > $base_hp) $hp = $base_hp;
							$card->setInGameHealth($hp);
						}
						if ($can_regenerate && $ep < $base_ep) {
							$ep += ceil(($base_ep / 100) * rand(15, 50));
							if ($ep > $base_ep) $ep = $base_ep;
							$card->setInGameEP($ep);
						}
						if ($card->hasEffects()) {
							$card->validateEffects();
							$changed = true;
							if ($card->hasEffects()) {
								$card->applyEffects();
							}
						}
						$hp_to = $card->getInGameHP();
						$hp_diff = ($hp_from > $hp_to) ? $hp_from - $hp_to : $hp_to - $hp_from;
						$ep_to = $card->getInGameEP();
						$ep_diff = ($ep_from > $ep_to) ? $ep_from - $ep_to : $ep_to - $ep_from;
						if ($changed) {
							$card_updates[] = array('card_id' => $card->getUniqueId(), 
													'hp' => array('from' => $hp_from, 'to' => $hp_to, 'diff' => $hp_diff),
													'ep' => array('from' => $ep_from, 'to' => $ep_to, 'diff' => $ep_diff),
													'effects' => $card->getValidEffects());
							$card->save();
						}
						if ($card->getInGameHP() <= 0) {
							$this->removeCard($card);
						}

					}
				}
			}
			foreach ($o_cards as $card_type => $cards) {
				foreach ($cards as $card) {
					if (!$card->isInPlay()) continue;
					$gold += $card->getGPTIncreaseOpponent();
					$gold -= $card->getGPTDecreaseOpponent();
					if ($card instanceof CreatureCard && $card->hasEffects()) {
						$card->validateEffects($this->getTurnNumber());
						$card_updates[] = array('card_id' => $card->getUniqueId(),
												'effects' => $card->getValidEffects());
					}
				}
			}
			$new_gold = $old_gold + $gold;
			if ($new_gold < 0) $new_gold = 0;
			($this->getCurrentPlayerKey() == 'player') ? $this->setPlayerGold($new_gold) : $this->setOpponentGold($new_gold);
			
			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_REPLENISH);
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'gold' => array('from' => $old_gold, 'to' => $new_gold, 'diff' => $gold), 'card_updates' => $card_updates));
			$this->addEvent($event);
		}

		protected function _resolve()
		{
			foreach ($this->getCurrentPlayerCards() as $cards) {
				foreach ($cards as $card) {
					if ($card->getSlot() && !$card->isInPlay()) {
						$card->setIsInPlay();
						$card->save();
					}
				}
			}
		}

		public function endPhase()
		{
			$old_phase = $this->_current_phase;
			if ($old_phase < self::PHASE_RESOLUTION) {
				$this->_current_phase++;
			} else {
				$this->endTurn();
			}

			if (!$this->isGameOver()) {
				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_PHASE_CHANGE);
				$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'current_turn' => $this->getTurnNumber(), 'old_phase' => $old_phase, 'new_phase' => $this->_current_phase));
				$this->addEvent($event);
				switch ($this->_current_phase) {
					case self::PHASE_REPLENISH:
						$this->changePlayer();
						$this->_replenish();
						break;
					case self::PHASE_MOVE:
						break;
					case self::PHASE_ACTION:
						$this->setCurrentPlayerActions(2);
						break;
					case self::PHASE_RESOLUTION:
						$this->_resolve();
						break;
				}
			}
		}

		public function isGameOver()
		{
			return (bool) ($this->_state == self::STATE_COMPLETED);
		}

		public function isCompleted()
		{
			return $this->isGameOver();
		}

		public function getCurrentPhase()
		{
			return $this->_current_phase;
		}

		public function getCurrentPlayerActions()
		{
			return $this->_current_player_actions;
		}

		public function setCurrentPlayerActions($actions)
		{
			$this->_current_player_actions = $actions;
		}

		public function useAction()
		{
			$this->_current_player_actions--;
		}

		public function changePlayer()
		{
			if (!$this->getCurrentPlayerId()) {
				$this->setCurrentPlayer((rand(0, 1)) ? $this->getPlayer() : $this->getOpponent());
			} else {
				$this->setCurrentPlayer(($this->getCurrentPlayerId() == $this->getPlayer()->getId()) ? $this->getOpponent() : $this->getPlayer());
			}
			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_PLAYER_CHANGE);
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'current_turn' => $this->getTurnNumber(), 'player_name' => $this->getCurrentPlayer()->getUsername()));
			$this->addEvent($event);
		}

		public function removeCard(Card $card)
		{
			if ($card->getCardType() == Card::TYPE_CREATURE) {
				foreach ($card->getPowerupCards() as $c) {
					$this->removeCard($c);
					$c->save();
				}
				$card->setInGameHP(0);
				$card->setInGameEP(0);
			}
			$card->setSlot(0);
			$card->setIsInPlay(false);
			if ($card->getCardType() == Card::TYPE_EQUIPPABLE_ITEM) {
				$card->setPowerupSlot1(false);
				$card->setPowerupSlot2(false);
			}
			$card->setGameId(0);

			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_CARD_REMOVED);
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'card_id' => $card->getUniqueId()));
			$this->addEvent($event);
		}

		public function setLootDecided($decided = true)
		{
			$this->_loot_decided = $decided;
		}

		public function isLootDecided()
		{
			return (bool) $this->_loot_decided;
		}

		public function canUserMove($user_id)
		{
			return (bool) (($this->getCurrentPlayerId() == $user_id && $this->getCurrentPhase() == Game::PHASE_MOVE) || ($this->getTurnNumber() <= 2 && !$this->hasUserPlayerCardsInPlay()));
		}

	}
