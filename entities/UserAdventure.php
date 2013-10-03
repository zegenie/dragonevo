<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo user <-> adventure class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\UserAdventures")
	 */
	class UserAdventure extends \b2db\Saveable
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
		 * The adventure
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Adventure")
		 *
		 * @var \application\entities\Adventure
		 */
		protected $_adventure_id;

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

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		public function setAdventure(Adventure $adventure)
		{
			$this->_adventure_id = $adventure;
		}

		public function setAdventureId($adventure_id)
		{
			$this->_adventure_id = $adventure_id;
		}

		public function getAdventure()
		{
			return $this->_b2dbLazyload('_adventure_id');
		}

		public function getAdventureId()
		{
			if ($this->_adventure_id instanceof Adventure)
				return $this->_adventure_id->getId();

			if ($this->_adventure_id)
				return (int) $this->_adventure_id;
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

		protected function _preSave($is_new)
		{
			if ($is_new) {
				$this->_date = time();
			}
		}

	}

