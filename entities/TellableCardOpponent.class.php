<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo tellable card opponent class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\TellableCardOpponents")
	 */
	class TellableCardOpponent extends \b2db\Saveable
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
		 * Reward card id
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_card_unique_id;

		/**
		 * Card level
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_card_level = 0;

		/**
		 * If story reward, the story
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Story")
		 *
		 * @var \application\entities\Story
		 */
		protected $_story_id;

		/**
		 * If chapter reward, the chapter
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Chapter")
		 *
		 * @var \application\entities\Chapter
		 */
		protected $_chapter_id;

		/**
		 * If part reward, the part
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Part")
		 *
		 * @var \application\entities\Part
		 */
		protected $_part_id;

		/**
		 * If adventure reward, the adventure
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Adventure")
		 *
		 * @var \application\entities\Adventure
		 */
		protected $_adventure_id;

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

		public function hasStory()
		{
			return (bool) $this->getStoryId();
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

		public function hasChapter()
		{
			return (bool) $this->getChapterId();
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

		public function hasPart()
		{
			return (bool) $this->getPartId();
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

		public function hasAdventure()
		{
			return (bool) $this->getAdventureId();
		}

		public function getCardLevel()
		{
			return $this->_card_level;
		}

		public function setCardLevel($card_level)
		{
			$this->_card_level = $card_level;
		}

		public function getCard()
		{
			if (!is_object($this->_card_unique_id)) {
				$this->_card_unique_id = tables\Cards::getTable()->getCardByUniqueId($this->_card_unique_id);
			}
			return $this->_card_unique_id;
		}

		public function getCardUniqueId()
		{
			if (is_object($this->_card_unique_id)) {
				return $this->_card_unique_id->getUniqueId();
			}
			return $this->_card_unique_id;
		}

		public function setCardUniqueId($card_unique_id)
		{
			$this->_card_unique_id = $card_unique_id;
		}

	}

