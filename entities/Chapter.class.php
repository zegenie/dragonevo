<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo story chapter class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Chapters")
	 */
	class Chapter extends Tellable
	{

		/**
		 * Tellable type
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_tellable_type = Tellable::TYPE_CHAPTER;

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
		 * @Relates(class="\application\entities\Part", collection=true, foreign_column="chapter_id")
		 * @var array|\application\entities\Part
		 */
		protected $_parts;

		/**
		 * @Relates(class="\application\entities\TellableCardReward", collection=true, foreign_column="chapter_id")
		 * @var array|\application\entities\TellableCardReward
		 */
		protected $_card_rewards;

		/**
		 * @Relates(class="\application\entities\TellableCardOpponent", collection=true, foreign_column="chapter_id")
		 * @var array|\application\entities\TellableCardOpponent
		 */
		protected $_card_opponents;

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

		public function getParentId()
		{
			return $this->getStoryId();
		}

		public function getParentType()
		{
			return 'story';
		}

		public function getParts()
		{
			return $this->_b2dbLazyload('_parts');
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->_story_id = $form_data['story_id'];
		}

		public function resolvePart(Part $part, User $player)
		{
			$previous_attempts = tables\UserChapters::getTable()->getAttemptsByChapterIdAndUserId($this->getId(), $player->getId());
			$has_previous_attempts = !empty($previous_attempts);
			$parts = $this->getParts();
			$last_part = array_pop($parts);
			if ($last_part->getId() == $part->getId()) {
				$attempt = new UserChapter();
				$attempt->setChapter($this);
				$attempt->setUser($player);
				$attempt->setWinning(true);
				$attempt->save();
				if ($this->getRewardGold()) $player->addGold($this->getRewardGold());
				if ($this->getRewardXp()) $player->addXp($this->getRewardXp());
				if ($this->hasCardRewards()) {
					foreach ($this->getCardRewards() as $reward) {
						$player->giveCard($reward->getCard());
					}
				}
				$this->getStory()->resolveChapter($this, $player);
				if (!$has_previous_attempts) {
					$points = 5 * $this->getRequiredLevel();
					if ($points > 0) {
						$points -= $player->getLevel() / $this->getRequiredLevel();
						if ($points > 0) $player->addRankingPointsSp($points);
					}
				}
			}
		}

		public function getAvailablePreviousParts()
		{
			$parts = array();
			foreach ($this->getStory()->getChapters() as $chapter) {
				$c_parts = array();
				foreach ($chapter->getParts() as $part) {
					$c_parts[$part->getId()] = $part;
				}
				$parts[] = $c_parts;
			}

			return $parts;
		}

	}

