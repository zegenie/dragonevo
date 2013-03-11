<?php 

	namespace application\modules\game;

	use caspar\core\Request,
		application\entities\Game,
		application\entities\tables\Games,
		application\entities\tables\ModifierEffects,
		application\entities\tables\CreatureCards,
		application\entities\tables\EquippableItemCards,
		application\entities\tables\PotionItemCards,
		application\entities\tables\EventCards;

	/**
	 * Actions for the game module
	 */
	class Actions extends \caspar\core\Actions
	{

		/**
		 * The game
		 *
		 * @var \application\entities\Game
		 * @access protected
		 * @property $game
		 */

		public function preExecute(Request $request, $action)
		{
			$this->getResponse()->setFullscreen();
			if (!$this->getUser()->isAuthenticated()) {
				return $this->forward403();
			}

			$game_id = $request['game_id'];
			$this->game = null;
			try {
				$this->game = Games::getTable()->selectById($game_id);
			} catch (\Exception $e) {}
		}

		/**
		 * Index page
		 *  
		 * @param Request $request
		 */
		public function runIndex(Request $request)
		{
			$this->forward($this->getRouting()->generate('home'));
		}

		public function runNoBoard(Request $request)
		{
			
		}

		/**
		 * Board page
		 *  
		 * @param Request $request
		 */
		public function runBoard(Request $request)
		{
			if ($this->game instanceof Game) {
				if (in_array($this->getUser()->getId(), array($this->game->getPlayer()->getId(), $this->game->getOpponent()->getId()))) {
					if (!$this->game->isGameOver() && !$this->game->hasCards()) {
						return $this->forward($this->getRouting()->generate('pick_cards', array('game_id' => $this->game->getId())));
					}
				}
				if ($this->game->isGameOver()) {
					$this->statistics = $this->game->getStatistics($this->getUser()->getId());
				} else {
					$this->statistics = array('hp' => 0, 'cards' => 0, 'gold' => 0, 'xp' => 0);
				}
			}
			$this->event_id = 0;
		}

		public function runPickCards(Request $request)
		{
			if (!$this->game->isGameOver()) {
				if ($request->isPost()) {
					$cards = $request->getParameter('cards', array());
					$card_types = $request->getParameter('card_types', array());
					foreach ($cards as $card_id => $selected) {
						if ($selected) {
							$this->game->addCard($card_id, $this->getUser()->getId());
						}
					}
				}
				if (!$this->game->hasCards()) {
					return $this->renderJSON(array('game_id' => $this->game->getId()));
				}
				if ($this->game->isScenario()) {
					$level = 0;
					$cc = 0;
					foreach ($this->game->getPlayerCards() as $card) {
						if ($card instanceof \application\entities\CreatureCard) {
							$level += $card->getUserCardLevel();
							$cc++;
						}
					}
					$min_level = ($level > 0) ? ceil($level / $cc) : 1;
					$min_level = ($min_level >= 3) ? $level - 2 : $min_level;
					$max_level = $min_level + 2;
					$ai_player = $this->game->getOpponent();
					foreach ($this->game->getPart()->getCardOpponents() as $opponent) {
						$o_card = $ai_player->giveCard($opponent->getCard());
						$this->game->addCard($o_card, $ai_player);
						
						if ($o_card instanceof \application\entities\CreatureCard) {
							$level = ($opponent->getCardLevel() > 0) ? $opponent->getCardLevel() : rand($min_level, $max_level);
							if ($level > 1) {
								for ($cc = 1;$cc <= $level;$cc++) {
									$o_card->levelUp('both');
								}
							}
						}
						
						$o_card->save();
					}
				}
			}

			return $this->renderJSON(array('is_started' => 1, 'game_id' => $this->game->getId()));
		}

	}