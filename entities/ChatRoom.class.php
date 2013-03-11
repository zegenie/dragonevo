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

		protected function _generateTaunt($text)
		{
			$taunts = array(
				'%user%! Your father smelled of elderberries!',
				"Buckle up, %user%!, because you're going for a ride!",
				"There is no escape, don't make me destroy you, %user%!",
				"My my my, %user%, aren't we touchy today!",
				);
			$text = str_replace('%user%', $text, $taunt);

			return '/me &#9760; ' . $text;
		}

		public function say($text, $user_id, $time = null)
		{
//			if (substr($text, 0, 7) == "/taunt ") {
//				$text = $this->_generateTaunt(substr($text, 7));
//			}
			\application\entities\tables\ChatLines::getTable()->say($text, $user_id, $this->getId(), $time);
		}

		public function ping(User $user)
		{
			tables\ChatPings::getTable()->ping($this, $user);
			tables\ChatPings::getTable()->cleanRoomPings();
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
