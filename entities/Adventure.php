<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo adventure class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Adventures")
	 */
	class Adventure extends Tellable
	{

		/**
		 * Tellable type
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_tellable_type = Tellable::TYPE_ADVENTURE;

		/**
		 * @Relates(class="\application\entities\Part", collection=true, foreign_column="adventure_id")
		 * @var array|\application\entities\Part
		 */
		protected $_parts;

		/**
		 * @Relates(class="\application\entities\TellableCardReward", collection=true, foreign_column="adventure_id")
		 * @var array|\application\entities\TellableCardReward
		 */
		protected $_card_rewards;

		/**
		 * @Relates(class="\application\entities\TellableCardOpponent", collection=true, foreign_column="adventure_id")
		 * @var array|\application\entities\TellableCardOpponent
		 */
		protected $_card_opponents;

		public function getParentId()
		{
			return 0;
		}

		public function getParentType()
		{
			return '';
		}

		public function getParts()
		{
			return $this->_b2dbLazyload('_parts');
		}

		public function resolvePart(Part $part, User $player)
		{
			$parts = $this->getParts();
			$last_part = array_pop($parts);
			if ($last_part->getId() == $part->getId()) {
				$attempt = new UserAdventure();
				$attempt->setAdventure($this);
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
				$points = 7 * $this->getRequiredLevel();
				if ($points > 0) {
					$points -= $player->getLevel() / $this->getRequiredLevel();
					if ($points > 0) $player->addRankingPointsSp($points);
				}
			}
		}

		public function getAvailablePreviousParts()
		{
			return $this->getParts();
		}

	}

