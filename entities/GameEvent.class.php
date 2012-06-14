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
