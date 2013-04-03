<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo story class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Stories")
	 */
	class Story extends Tellable
	{

		/**
		 * Tellable type
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_tellable_type = Tellable::TYPE_STORY;

		/**
		 * @Relates(class="\application\entities\Chapter", collection=true, foreign_column="story_id")
		 * @var array|\application\entities\Chapter
		 */
		protected $_chapters;

		/**
		 * @Relates(class="\application\entities\TellableCardReward", collection=true, foreign_column="story_id")
		 * @var array|\application\entities\TellableCardReward
		 */
		protected $_card_rewards;

		/**
		 * @Relates(class="\application\entities\TellableCardOpponent", collection=true, foreign_column="story_id")
		 * @var array|\application\entities\TellableCardOpponent
		 */
		protected $_card_opponents;

		public function getChapters()
		{
			return $this->_b2dbLazyload('_chapters');
		}

		public function getParentId()
		{
			return 0;
		}

		public function getParentType()
		{
			return '';
		}

		public function resolveChapter(Chapter $chapter, User $player)
		{
			$previous_attempts = tables\UserStories::getTable()->getAttemptsByStoryIdAndUserId($this->getId(), $player->getId());
			$has_previous_attempts = !empty($previous_attempts);
			$chapters = $this->getChapters();
			$last_chapter = array_pop($chapters);
			if ($last_chapter->getId() == $chapter->getId()) {
				$attempt = new UserStory();
				$attempt->setStory($this);
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
				if (!$has_previous_attempts) {
					$points = 10 * $this->getRequiredLevel();
					if ($points > 0) {
						$points -= $player->getLevel() / $this->getRequiredLevel();
						if ($points > 0) $player->addRankingPointsSp($points);
					}
				}
			}
		}

	}

