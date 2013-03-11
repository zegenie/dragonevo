<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo user <-> story class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\UserStories")
	 */
	class UserStory extends \b2db\Saveable
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
		 * The story
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Story")
		 *
		 * @var \application\entities\Story
		 */
		protected $_story_id;

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

		public function setStory(Story $story)
		{
			$this->_story_id = $story;
		}

		public function setStoryId($story_id)
		{
			$this->_story_id = $story_id;
		}

		public function getStory()
		{
			return $this->_b2dbLazyload('_story_id');
		}

		public function getStoryId()
		{
			if ($this->_story_id instanceof Story)
				return $this->_story_id->getId();

			if ($this->_story_id)
				return (int) $this->_story_id;
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

