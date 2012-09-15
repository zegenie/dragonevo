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
							switch ($card_types[$card_id]) {
								case \application\entities\Card::TYPE_CREATURE:
									$card = CreatureCards::getTable()->selectById($card_id);
									break;
								case \application\entities\Card::TYPE_EVENT:
									$card = EventCards::getTable()->selectById($card_id);
									break;
								case \application\entities\Card::TYPE_EQUIPPABLE_ITEM:
									$card = EquippableItemCards::getTable()->selectById($card_id);
									$card->setPowerupSlot1(false);
									$card->setPowerupSlot2(false);
									break;
							}
							if (!$card->isInGame()) {
								$card->setGame($this->game);
								$card->setSlot(0);
								$card->save();
							}
						}
					}
				}
				if ($this->game->hasCards()) {
					return $this->forward($this->getRouting()->generate('board', array('game_id' => $this->game->getId())));
				}
				$this->cards = $this->getUser()->getCards();
			} else {
				return $this->forward($this->getRouting()->generate('board', array('game_id' => $this->game->getId())));
			}
		}

		public function runTraining(Request $request)
		{
			switch ($request['level']) {
				case 1:
					$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_easy');
					break;
				case 2:
					$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_normal');
					break;
				default:
					$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_hard');
			}
			$game = new Game();
			$game->setPlayer($this->getUser());
			$game->setOpponent($ai_player);
			$game->completeQuickmatch();
			$game->save();
			
			$creature_cards = \application\entities\tables\CreatureCards::getTable()->getByFaction($request['faction']);
			$c_cards = \application\entities\tables\Cards::pickCards($creature_cards, $ai_player->getId(), rand(3, 7));
			foreach ($c_cards as $card_id => $card) {
				$card->setGame($game);
				$card->save();
			}
			$equippable_item_cards = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$e_cards = \application\entities\tables\Cards::pickCards($equippable_item_cards, $ai_player->getId(), rand(5, 10));
			foreach ($e_cards as $card_id => $card) {
				$card->setGame($game);
				$card->save();
			}
			$this->forward($this->getRouting()->generate('board', array('game_id' => $game->getId())));
		}
		
		public function runLeaveGame(Request $request)
		{
			if ($this->game->isInProgress() && in_array($this->getUser()->getId(), array($this->game->getPlayer()->getId(), $this->game->getOpponentId()))) {
				if (!$this->game->getOpponentId()) {
					$this->game->resolve($this->game->getOpponentId());
				} else {
					$this->game->resolve($this->game->getUserOpponent()->getId());
				}
				$this->game->save();
				$this->game->resetUserCards();
			}

			$this->forward($this->getRouting()->generate('lobby'));
		}
		
	}