<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo chat room class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\ChatRooms")
	 */
	class ChatRoom extends \b2db\Saveable
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
		 * The player who set up the room
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_user_id;

		/**
		 * Room topic
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_topic = '';

		protected $_history;

		public function getId()
		{
			return $this->_id;
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		public function getTopic()
		{
			return $this->_topic;
		}

		public function setTopic($topic)
		{
			$this->_topic = $topic;
		}

		public function setUserId($user_id)
		{
			$this->_user_id = $user_id;
		}
		
		public function setUser($user)
		{
			$this->_user_id = $user;
		}
		
		public function getUser()
		{
			return $this->_b2dbLazyload('_user_id');
		}

		public function getHistory($num_lines = 300)
		{
			if ($this->_history === null)
			{
				$this->_history = tables\ChatLines::getTable()->getLinesByRoomId($this->getId(), $num_lines);
			}
		}

		public function say($text, $user_id)
		{
			\application\entities\tables\ChatLines::getTable()->say($text, $user_id, $this->getId());
		}

		public function ping($user_id)
		{
			tables\ChatPings::getTable()->ping($this->getId(), $user_id);
			tables\ChatPings::getTable()->cleanRoomPings($this->getId());
		}

		public function getNumberOfUsers()
		{
			return tables\ChatPings::getTable()->getNumberOfUsersByRoomId($this->getId());
		}
		
		public function getUsers()
		{
			return tables\ChatPings::getTable()->getUsersByRoomId($this->getId());
		}

	}
