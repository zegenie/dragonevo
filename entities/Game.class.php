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

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Timestamp of when the news item was created
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_created_at;

		/** 
		 * The player who initiated the game
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_player_id;

		/** 
		 * The opponent player
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_opponent_id;

		/**
		 * Whether invitations have been sent
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_invitation_sent;

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
		 * Game name
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_name = '';

		protected function _preSave($is_new)
		{
			if ($is_new && !$this->_created_at) {
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

		public function getCreatedAt()
		{
			return $this->_created_at;
		}

		public function setCreatedAt($created_at)
		{
			$this->_created_at = $created_at;
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

		public function setOpponentId($opponent_id)
		{
			$this->_opponent_id = $opponent_id;
		}
		
		public function setOpponent($user)
		{
			$this->_opponent_id = $user;
		}
		
		public function getOpponent()
		{
			return $this->_b2dbLazyload('_opponent_id');
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

		public function initiateQuickmatch()
		{
			$this->_quickmatch_state = 1;
		}

		public function completeQuickmatch()
		{
			$this->_quickmatch_state = 2;
		}

	}
