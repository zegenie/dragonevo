<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo user <-> user class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\UserFriends")
	 */
	class UserFriend extends \b2db\Saveable
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
		 * The user_id of the user
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_user_id;

		/**
		 * The user_id of the friend
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 *
		 * @var \application\entities\User
		 */
		protected $_friend_user_id;

		/**
		 * Whether the friend request is accepted
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_accepted = false;

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
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

		public function setFriendUserId($friend_user_id)
		{
			$this->_friend_user_id = $friend_user_id;
		}

		public function setFriendUser($friend_user)
		{
			$this->_friend_user_id = $friend_user;
		}

		/**
		 * Return the friend_user associated with this card
		 *
		 * @return FriendUser
		 */
		public function getFriendUser()
		{
			return $this->_b2dbLazyload('_friend_user_id');
		}

		public function getFriendUserId()
		{
			return ($this->_friend_user_id instanceof FriendUser) ? $this->_friend_user_id->getId() : (int) $this->_friend_user_id;
		}

		public function getAccepted()
		{
			return $this->_accepted;
		}

		public function isAccepted()
		{
			return $this->getAccepted();
		}

		public function setAccepted($accepted)
		{
			$this->_accepted = $accepted;
		}

		protected function _preSave($is_new)
		{
			if ($is_new) {
				$this->_date = time();
			}
		}

		public function getFriend()
		{
			return (Caspar::getUser()->getId() == $this->getUserId()) ? $this->getFriendUser() : $this->getUser();
		}

	}

