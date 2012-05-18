<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo news class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\News")
	 */
	class News extends \b2db\Saveable
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
		 * Posted by user
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var string
		 */
		protected $_posted_by;

		/**
		 * News title
		 *
		 * @Column(type="string", length=350)
		 * @var string
		 */
		protected $_title;

		/**
		 * News title
		 *
		 * @Column(type="string", length=250)
		 * @var string
		 */
		protected $_url;

		/**
		 * News title key
		 *
		 * @Column(type="string", length=350)
		 * @var string
		 */
		protected $_key;

		/**
		 * News content
		 *
		 * @Column(type="text")
		 * @var string
		 */
		protected $_content;

		protected function _construct(\b2db\Row $row, $foreign_key = null)
		{
			if (!$this->_created_at) {
				$this->_created_at = time();
			}
		}

		protected function _preSave($is_new)
		{
			if ($is_new && !$this->_created_at) {
				$this->_created_at = time();
			}
			$this->_key = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '_', $this->_title));
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

		public function getPostedBy()
		{
			return $this->_posted_by;
		}

		public function setPostedBy($posted_by)
		{
			$this->_posted_by = $posted_by;
		}

		public function getTitle()
		{
			return $this->_title;
		}

		public function setTitle($title)
		{
			$this->_title = $title;
		}

		public function getContent()
		{
			return $this->_content;
		}

		public function setContent($content)
		{
			$this->_content = $content;
		}

		public function getUrl()
		{
			return $this->_url;
		}

		public function setUrl($url)
		{
			$this->_url = $url;
		}

		public function hasUrl()
		{
			return (bool) $this->_url;
		}

		public function getYear()
		{
			return date('Y', $this->_created_at);
		}

		public function getMonth()
		{
			return date('n', $this->_created_at);
		}

		public function getDay()
		{
			return date('j', $this->_created_at);
		}

		public function getHour()
		{
			return date('H', $this->_created_at);
		}

		public function getMinute()
		{
			return date('i', $this->_created_at);
		}

		public function getKey()
		{
			return $this->_key;
		}

	}
