<?php 

	namespace application\modules\game;

	use \caspar\core\Request;
	
	use \application\entities\Game;

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
				$this->game = new Game($game_id);
			} catch (\Exception $e) {

			}
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

		/**
		 * Board page
		 *  
		 * @param Request $request
		 */
		public function runBoard(Request $request)
		{
			if (!$this->game->hasCards()) {
				return $this->forward($this->getRouting()->generate('pick_cards', array('game_id' => $this->game->getId())));
			}
			$this->event_id = 0;
		}

		public function runPickCards(Request $request)
		{
			if ($request->isPost()) {
				$cards = $request->getParameter('cards', array());
				$card_types = $request->getParameter('card_types', array());
				foreach ($cards as $card_id => $selected) {
					if ($selected) {
						switch ($card_types[$card_id]) {
							case \application\entities\Card::TYPE_CREATURE:
								$card = new \application\entities\CreatureCard($card_id);
								break;
							case \application\entities\Card::TYPE_EVENT:
								$card = new \application\entities\EventCard($card_id);
								break;
							case \application\entities\Card::TYPE_EQUIPPABLE_ITEM:
								$card = new \application\entities\EquippableItemCard($card_id);
								break;
							case \application\entities\Card::TYPE_POTION_ITEM:
								$card = new \application\entities\PotionItemCard($card_id);
								break;
						}
						if (!$card->isInGame()) {
							$card->setGame($this->game);
							$card->save();
						}
					}
				}
			}
			if ($this->game->hasCards()) {
				return $this->forward($this->getRouting()->generate('board', array('game_id' => $this->game->getId())));
			}
			$this->cards = $this->getUser()->getCards();
		}
		
	}