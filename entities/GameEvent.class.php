<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo game invite class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\GameEvents")
	 */
	class GameEvent extends \b2db\Saveable
	{

		const TYPE_GAME_CREATED = 'game_created';
		const TYPE_PLAYER_CHANGE = 'player_change';
		const TYPE_INVITATION_ACCEPTED = 'invitation_accepted';
		const TYPE_PHASE_CHANGE = 'phase_change';
		const TYPE_REPLENISH = 'replenish';
		const TYPE_ATTACK = 'attack';
		const TYPE_DAMAGE = 'damage';
		const TYPE_RESTORE_HEALTH = 'restore_health';
		const TYPE_RESTORE_ENERGY = 'restore_energy';
		const TYPE_APPLY_EFFECT = 'apply_effect';
		const TYPE_REMOVE_EFFECT = 'remove_effect';
		const TYPE_STEAL_GOLD = 'steal_gold';
		const TYPE_STEAL_MAGIC = 'steal_magic';
		const TYPE_GAME_OVER = 'game_over';
		const TYPE_CARD_REMOVED = 'card_removed';
		const TYPE_CARD_MOVED_OFF_SLOT = 'card_moved_off_slot';
		const TYPE_CARD_MOVED_ONTO_SLOT = 'card_moved_onto_slot';

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

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
		 * The player who initiated the event
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_player_id;

		/**
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_created_at = 0;

		/**
		 * @Column(type="string", length=200)
		 */
		protected $_event_type;

		/**
		 * @Column(type="text")
		 */
		protected $_event_data;

		/**
		 * Amount of hp removed
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_hp = 0;

		/**
		 * If the attack killed a card
		 *
		 * @Column(type="boolean", default=false)
		 * @var integer
		 */
		protected $_killed_card = false;

		protected function _preSave($is_new)
		{
			if ($is_new) {
				$this->_created_at = time();
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

		public function setGameId($game_id)
		{
			$this->_game_id = $game_id;
		}
		
		public function setGame($game)
		{
			$this->_game_id = $game;
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

		public function getEventType()
		{
			return $this->_event_type;
		}

		public function setEventType($event_type)
		{
			$this->_event_type = $event_type;
		}

		public function getEventData()
		{
			return $this->_event_data;
		}

		public function setEventData($event_data)
		{
			if (is_array($event_data)) {
				if (array_key_exists('player_id', $event_data)) {
					$this->_player_id = $event_data['player_id'];
				}
				if ($this->getEventType() == self::TYPE_DAMAGE) {
					if (array_key_exists('hp', $event_data)) {
						if (array_key_exists('diff', $event_data['hp'])) $this->_hp = $event_data['hp']['diff'];
						if (array_key_exists('to', $event_data['hp']) && $event_data['hp']['to'] == 0) $this->_killed_card = true;
					}
				}
			}
			$this->_event_data = json_encode($event_data);
		}

		public function getCreatedAt()
		{
			return $this->_created_at;
		}

		public function setCreatedAt($created_at)
		{
			$this->_created_at = $created_at;
		}

	}
