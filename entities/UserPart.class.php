<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo user <-> part class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\UserParts")
	 */
	class UserPart extends \b2db\Saveable
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
		 * Attempt date
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_date;

		/**
		 * The part
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Part")
		 *
		 * @var \application\entities\Part
		 */
		protected $_part_id;

		/**
		 * If owned, the user_id who owns this card
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_user_id;

		/**
		 * Whether the user won
		 *
		 * @Column(type="boolean", deafult=true)
		 * @var boolean
		 */
		protected $_winning = false;

		/**
		 * If in a game, the game_id of the game
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Game")
		 *
		 * @var \application\entities\Game
		 */
		protected $_game_id;

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		public function setPart(Part $part)
		{
			$this->_part_id = $part;
		}

		public function setPartId($part_id)
		{
			$this->_part_id = $part_id;
		}

		public function getPart()
		{
			return $this->_b2dbLazyload('_part_id');
		}

		public function getPartId()
		{
			if ($this->_part_id instanceof Part)
				return $this->_part_id->getId();

			if ($this->_part_id)
				return (int) $this->_part_id;
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

		public function getWinning()
		{
			return $this->_winning;
		}

		public function setWinning($winning)
		{
			$this->_winning = $winning;
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
		 * Returns the currently assigned game
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

		protected function _preSave($is_new)
		{
			if ($is_new) {
				$this->_date = time();
			}
		}

	}

