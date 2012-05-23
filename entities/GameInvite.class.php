<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo game invite class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\GameInvites")
	 */
	class GameInvite extends \b2db\Saveable
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
		 * The player who initiated the game
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_from_player_id;

		/** 
		 * The opponent player
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_to_player_id;

		/**
		 * Game id
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Game")
		 *
		 * @var \application\entities\Game
		 */
		protected $_game_id = '';

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
		
		public function getGame()
		{
			return $this->_b2dbLazyload('_game_id');
		}
		
		public function getGameId()
		{
			return ($this->_game_id instanceof Game) ? $this->_game_id->getId() : $this->_game_id;
		}

		public function setFromPlayerId($player_id)
		{
			$this->_from_player_id = $player_id;
		}

		public function setFromPlayer($user)
		{
			$this->_from_player_id = $user;
		}

		public function getFromPlayer()
		{
			return $this->_b2dbLazyload('_from_player_id');
		}

		public function setToPlayerId($player_id)
		{
			$this->_to_player_id = $player_id;
		}

		public function setToPlayer($user)
		{
			$this->_to_player_id = $user;
		}

		public function getToPlayer()
		{
			return $this->_b2dbLazyload('_to_player_id');
		}

	}
