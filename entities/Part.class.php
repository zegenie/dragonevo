<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo chapter part class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Parts")
	 */
	class Part extends Tellable
	{

		/**
		 * Tellable type
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_tellable_type = Tellable::TYPE_PART;

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
		 * The adventure
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Adventure")
		 *
		 * @var \application\entities\Adventure
		 */
		protected $_adventure_id;

		/**
		 * If not the first part, the previous part
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Part")
		 *
		 * @var \application\entities\Part
		 */
		protected $_previous_part_id;

		/**
		 * @Relates(class="\application\entities\TellableCardReward", collection=true, foreign_column="part_id")
		 * @var array|\application\entities\TellableCardReward
		 */
		protected $_card_rewards;

		/**
		 * @Relates(class="\application\entities\TellableCardOpponent", collection=true, foreign_column="part_id")
		 * @var array|\application\entities\TellableCardOpponent
		 */
		protected $_card_opponents;

		/**
		 * Max allowed creature cards
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_max_creature_cards = 0;

		/**
		 * Max allowed item cards
		 * 
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_max_item_cards = 0;

		/**
		 * Allow potion cards
		 *
		 * @Column(type="boolean")
		 * @var boolean
		 */
		protected $_allow_potions = true;

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

		public function hasChapter()
		{
			return (bool) (is_numeric($this->_chapter_id) && $this->_chapter_id > 0) || is_object($this->_chapter_id);
		}

		public function getParentId()
		{
			if ($this->hasChapter()) {
				return $this->getChapterId();
			} else {
				return $this->getAdventureId();
			}
		}

		public function getParentType()
		{
			return $this->getParent()->getTellableType();
		}

		public function getParent()
		{
			if ($this->hasChapter()) {
				return $this->getChapter();
			} else {
				return $this->getAdventure();
			}
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->_adventure_id = $form_data['adventure_id'];
			$this->_chapter_id = $form_data['chapter_id'];
			$this->_previous_part_id = $form_data['previous_part_id'];
			$this->_allow_potions = $form_data['allow_potions'];
			$this->_max_creature_cards = $form_data['max_creature_cards'];
			$this->_max_item_cards = $form_data['max_item_cards'];
		}

		public function resolve(User $player, Game $game, $winning)
		{
			$previous_attempts = tables\UserParts::getTable()->getAttemptsByPartIdAndUserId($this->getId(), $player->getId());
			$has_previous_attempts = !empty($previous_attempts);
			$attempt = new UserPart();
			$attempt->setPart($this);
			$attempt->setUser($player);
			$attempt->setGame($game);
			$attempt->setWinning($winning);
			$attempt->save();
			if ($winning) {
				$player->addXp($this->getRewardXp());
				$player->addGold($this->getRewardGold());
				if ($this->hasCardRewards()) {
					foreach ($this->getCardRewards() as $reward) {
						$player->giveCard($reward->getCard());
					}
				}
				if ($this->getTellableType() == Tellable::TYPE_ADVENTURE) {
					$points = 5;
					$points -= $player->getLevel() - $this->getRequiredLevel();
					if ($points > 0) $player->addRankingPointsSp($points);
				} elseif (!$has_previous_attempts) {
					$player->addRankingPointsSp(5);
				}
				$this->getParent()->resolvePart($this, $player);
				$player->save();
			}
		}

		public function setPreviousPart(Part $previous_part)
		{
			$this->_previous_part_id = $previous_part;
		}

		public function setPreviousPartId($previous_part_id)
		{
			$this->_previous_part_id = $previous_part_id;
		}

		/**
		 *
		 * @return Part
		 */
		public function getPreviousPart()
		{
			return $this->_b2dbLazyload('_previous_part_id');
		}

		public function getPreviousPartId()
		{
			if ($this->_previous_part_id instanceof Part)
				return $this->_previous_part_id->getId();

			if ($this->_previous_part_id)
				return (int) $this->_previous_part_id;
		}

		public function hasPreviousPart()
		{
			return (bool) $this->getPreviousPartId();
		}

		public function getMaxCreatureCards()
		{
			return $this->_max_creature_cards;
		}

		public function setMaxCreatureCards($max_creature_cards)
		{
			$this->_max_creature_cards = $max_creature_cards;
		}

		public function getMaxItemCards()
		{
			return $this->_max_item_cards;
		}

		public function setMaxItemCards($max_item_cards)
		{
			$this->_max_item_cards = $max_item_cards;
		}

		public function getAllowPotions()
		{
			return $this->_allow_potions;
		}

		public function setAllowPotions($allow_potions)
		{
			$this->_allow_potions = $allow_potions;
		}

	}

