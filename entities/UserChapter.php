<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo user <-> chapter class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\UserChapters")
	 */
	class UserChapter extends \b2db\Saveable
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
		 * The chapter
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Chapter")
		 *
		 * @var \application\entities\Chapter
		 */
		protected $_chapter_id;

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

		public function setChapter(Chapter $chapter)
		{
			$this->_chapter_id = $chapter;
		}

		public function setChapterId($chapter_id)
		{
			$this->_chapter_id = $chapter_id;
		}

		public function getChapter()
		{
			return $this->_b2dbLazyload('_chapter_id');
		}

		public function getChapterId()
		{
			if ($this->_chapter_id instanceof Chapter)
				return $this->_chapter_id->getId();

			if ($this->_chapter_id)
				return (int) $this->_chapter_id;
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

