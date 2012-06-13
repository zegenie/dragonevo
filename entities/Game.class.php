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
		 * The player who won the game
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_winning_player_id;

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

		protected function _preSave($is_new)
		{
			if ($is_new && !$this->_created_at) {
				$this->_created_at = time();
				$this->_current_phase = 1;

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

		public function getOpponentGold()
		{
			return $this->_opponent_gold;
		}

		public function setOpponentGold($opponent_gold)
		{
			$this->_opponent_gold = $opponent_gold;
		}

		protected function _populatePlayerCards()
		{
			if ($this->_player_cards === null) {
				$user_id = $this->getPlayer()->getId();
				$creature = \application\entities\tables\CreatureCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$potion_item = \application\entities\tables\PotionItemCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$equippable_item = \application\entities\tables\EquippableItemCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$event = \application\entities\tables\EventCards::getTable()->getByUserIdAndGameId($user_id, $this->getId());
				$this->_player_cards = compact('creature', 'potion_item', 'equippable_item', 'event');
			}
		}

		public function getPlayerCards()
		{
			$this->_populatePlayerCards();
			return $this->_player_cards;
		}

		public function getPlayerCardSlot($slot)
		{
			foreach ($this->getPlayerCards() as $type => $cards) {
				foreach ($cards as $card) {
					if ($card->getSlot() == $slot) return $card;
				}
			}
		}

		public function setPlayerCardSlot($slot, $card_id)
		{
			$cards = $this->getPlayerCards();
			$this->_processCardSlotMoving($cards, $slot, $card_id);
		}

		public function hasPlayerCards()
		{
			$cards = $this->getPlayerCards();
			return (bool) count($cards['creature']) + count($cards['potion_item']) + count($cards['equippable_item']) + count($cards['event']);
		}
		
		public function getCurrentPlayerKey()
		{
			return ($this->getCurrentPlayerId() == $this->getPlayer()->getId()) ? 'player' : 'opponent';
		}

		public function getUserCurrentPlayerKey()
		{
			return ($this->getCurrentPlayerId() == $this->getUserPlayer()->getId()) ? 'player' : 'opponent';
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

		public function getWinningPlayer()
		{
			return $this->_b2dbLazyload('_winning_player_id');
		}

		public function getWinningPlayerId()
		{
			return ($this->_winning_player_id instanceof User) ? $this->_winning_player_id->getId() : $this->_winning_player_id;
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
				$this->_opponent_cards = compact('creature', 'potion_item', 'equippable_item', 'event');
			}
		}

		public function getOpponentCards()
		{
			$this->_populateOpponentCards();
			return $this->_opponent_cards;
		}

		public function getOpponentCardSlot($slot)
		{
			foreach ($this->getOpponentCards() as $type => $cards) {
				foreach ($cards as $card) {
					if ($card->getSlot() == $slot) return $card;
				}
			}
		}

		protected function _processCardSlotMoving($all_cards, $slot, $card_id)
		{
			foreach ($all_cards as $type => $cards) {
				foreach ($cards as $card) {
					if ($card->getSlot() == $slot && $card->getUniqueId() != $card_id) {
						$card->setSlot(0);
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_OFF_SLOT);
						$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName()));
						$this->addEvent($event);
					}
					if ($card->getUniqueId() == $card_id && $card->getSlot() != $slot) {
						$event = new GameEvent();
						$event->setEventType(GameEvent::TYPE_CARD_MOVED_ONTO_SLOT);
						$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'in_play' => $card->isInPlay(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'card_id' => $card->getUniqueId(), 'card_name' => $card->getName(), 'slot' => $slot));
						$this->addEvent($event);
						$card->setSlot($slot);
					}
					if ($card->getSlot() == $slot || $card->getUniqueId() == $card_id) {
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

		public function hasOpponentCards()
		{
			$cards = $this->getOpponentCards();
			return (bool) count($cards['creature']) + count($cards['potion_item']) + count($cards['equippable_item']) + count($cards['event']);
		}

		public function hasUserPlayerCards()
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->hasPlayerCards() : $this->hasOpponentCards();
		}

		public function getUserPlayerCards()
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getPlayerCards() : $this->getOpponentCards();
		}

		public function getUserPlayerCardSlot($slot)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getPlayerCardSlot($slot) : $this->getOpponentCardSlot($slot);
		}

		public function setUserPlayerCardSlot($slot, $card_id)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->setPlayerCardSlot($slot, $card_id) : $this->setOpponentCardSlot($slot, $card_id);
		}

		public function getUserOpponentCardSlot($slot)
		{
			return ($this->getUserPlayer()->getId() == $this->getPlayer()->getId()) ? $this->getOpponentCardSlot($slot) : $this->getPlayerCardSlot($slot);
		}

		public function getUserPlayerCardSlotId($slot)
		{
			$card = $this->getUserPlayerCardSlot($slot);
			return ($card instanceof Card) ? $card->getUniqueId() : 0;
		}

		public function getUserOpponentCardSlotId($slot)
		{
			$card = $this->getUserOpponentCardSlot($slot);
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
			$hp_cards = array();
			foreach ($p_cards as $card_type => $cards) {
				foreach ($cards as $card) {
					if (!$card->isInPlay()) continue;
					$gold += $card->getGPTIncreasePlayer();
					$gold -= $card->getGPTDecreasePlayer();
					if ($card instanceof CreatureCard) {
						$hp = $card->getInGameHealth();
						$base_hp = $card->getBaseHealth();
						if ($hp < $base_hp) {
							$hp *= floor(1.05);
							if ($hp > $base_hp) $hp = $base_hp;
							$card->setInGameHealth($hp);
							$hp_cards[] = array('card_id' => $card->getUniqueId(), 'hp' => $hp);
						}

					}
				}
			}
			foreach ($o_cards as $card_type => $cards) {
				foreach ($cards as $card) {
					if (!$card->isInPlay()) continue;
					$gold += $card->getGPTIncreaseOpponent();
					$gold -= $card->getGPTDecreaseOpponent();
				}
			}
			$new_gold = $old_gold + $gold;
			if ($new_gold < 0) $new_gold = 0;
			($this->getCurrentPlayerKey() == 'player') ? $this->setPlayerGold($new_gold) : $this->setOpponentGold($new_gold);
			
			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_REPLENISH);
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'gold' => array('from' => $old_gold, 'to' => $new_gold, 'diff' => $gold), 'hp' => $hp_cards));
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
			($old_phase < self::PHASE_RESOLUTION) ? $this->_current_phase++ : $this->_current_phase = 1;
			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_PHASE_CHANGE);
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername(), 'old_phase' => $old_phase, 'new_phase' => $this->_current_phase));
			$this->addEvent($event);
			if ($this->_current_phase == self::PHASE_REPLENISH) {
				$this->changePlayer();
				$this->_replenish();
			} elseif ($this->_current_phase == self::PHASE_RESOLUTION) {
				$this->_resolve();
			}
		}

		public function getCurrentPhase()
		{
			return $this->_current_phase;
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
			$event->setEventData(array('player_id' => $this->getCurrentPlayerId(), 'player_name' => $this->getCurrentPlayer()->getUsername()));
			$this->addEvent($event);
		}

	}
