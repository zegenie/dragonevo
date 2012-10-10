<?php 

	namespace application\modules\game;

	use caspar\core\Request,
		application\entities\Game,
		application\entities\tables\Games,
		application\entities\tables\Attacks,
		application\entities\tables\Cards,
		application\entities\tables\GameInvites;

	/**
	 * game action components
	 */
	class Components extends \caspar\core\Components
	{
		
		public function componentPlayerHand()
		{
		}
		
		public function componentGameTopMenu()
		{
		}

		public function componentPickCardsContent()
		{
			$this->cards = $this->getUser()->getCards();
		}

		public function componentPlayerPotions()
		{
			$this->cards = \application\entities\tables\PotionItemCards::getTable()->getByUserId($this->getUser()->getId());
		}

		public function componentCardAttack()
		{
			$this->attack_types = \application\entities\Attack::getTypes();
		}

		public function componentBoardContent()
		{
			if ($this->game instanceof Game) {
				if ($this->game->isGameOver()) {
					$this->statistics = $this->game->getStatistics($this->getUser()->getId());
				} else {
					$this->statistics = array('hp' => 0, 'cards' => 0, 'gold' => 0, 'xp' => 0);
				}
			}
			$this->event_id = 0;
		}

	}
