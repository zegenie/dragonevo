<?php 

	namespace application\modules\admin;

	use application\entities\EventCard,
		application\entities\table\EventCards;

	use caspar\core\Request;

	/**
	 * Actions for the market module
	 */
	class Actions extends \caspar\core\Actions
	{

		public function preExecute(Request $request, $action)
		{
			$this->forward403Unless($this->getUser()->isAdmin());
		}

		/**
		 * Index page
		 *  
		 * @param Request $request
		 */
		public function runIndex(Request $request)
		{
			$this->itemcards = \application\entities\tables\EquippableItemCards::getTable()->getNumberOfCards();
			$this->eventcards = \application\entities\tables\EventCards::getTable()->getNumberOfCards();
			$this->creaturecards = \application\entities\tables\CreatureCards::getTable()->getNumberOfCards();
		}

		/**
		 * Edit cards page
		 *
		 * @param Request $request
		 */
		public function runCards(Request $request)
		{
			switch ($request->getParameter('card_type')) {
				case 'event':
					$this->getResponse()->setTemplate('admin/eventcards');
					$this->redirect('editEventCards');
					break;
				case 'creature':
					$this->getResponse()->setTemplate('admin/creaturecards');
					$this->redirect('editCreatureCards');
					break;
				case 'item':
					$this->getResponse()->setTemplate('admin/itemcards');
					$this->redirect('editItemCards');
					break;
				case 'potion':
					$this->getResponse()->setTemplate('admin/potioncards');
					$this->redirect('editPotionCards');
					break;
			}
		}

		/**
		 * Edit card page
		 *
		 * @param Request $request
		 */
		public function runCard(Request $request)
		{
			switch ($request->getParameter('card_type')) {
				case 'event':
					$this->getResponse()->setTemplate('admin/eventcard');
					$this->redirect('editEventCard');
					break;
				case 'creature':
					$this->getResponse()->setTemplate('admin/creaturecard');
					$this->redirect('editCreatureCard');
					break;
				case 'item':
					$this->getResponse()->setTemplate('admin/itemcard');
					$this->redirect('editItemCard');
					break;
				case 'potion':
					$this->getResponse()->setTemplate('admin/potioncard');
					$this->redirect('editPotionCard');
					break;
			}
		}

		public function runUploadCardImage(Request $request)
		{
			// read contents from the input stream
			$inputHandler = fopen('php://input', "r");
			// create a temp file where to save data from the input stream
			$fileHandler = tmpfile();

			// save data from the input stream
			while(true) {
				$buffer = fgets($inputHandler, 4096);
				if (strlen($buffer) == 0) {
					fclose($inputHandler);
					fclose($fileHandler);
					return true;
				}

				fwrite($fileHandler, $buffer);
			}
		}

		public function runEditEventCards(Request $request)
		{
			$this->cards = \application\entities\tables\EventCards::getTable()->getAll();
		}

		public function runEditCreatureCards(Request $request)
		{
			$cards = array();
			foreach (\application\entities\Card::getFactions() as $faction => $description) {
				$cards[$faction] = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			}
			$this->cards = $cards;
		}

		public function runEditItemCards(Request $request)
		{
			$this->cards = \application\entities\tables\EquippableItemCards::getTable()->getAll();
		}

		public function runEditPotionCards(Request $request)
		{
			$this->cards = \application\entities\tables\PotionItemCards::getTable()->getAll();
		}

		public function runEditEventCard(Request $request)
		{
			$card_id = $request['card_id'];

			try {
				if ($card_id) {
					$this->card = new \application\entities\EventCard($card_id);
				} else {
					$this->card = new \application\entities\EventCard();
				}
			} catch (\Exception $e) {
				return $this->return404('This is not a valid event card');
			}

			try {
				if (!$this->card instanceof \application\entities\EventCard) {
					return $this->return404('This is not a valid event card');
				} else {
					if ($request->isPost()) {
						$this->card->mergeFormData($request);
						$this->card->save();
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'event')));
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runEditCreatureCard(Request $request)
		{
			$card_id = $request['card_id'];

			try {
				if ($card_id) {
					$this->card = new \application\entities\CreatureCard($card_id);
				} else {
					$this->card = new \application\entities\CreatureCard();
				}
			} catch (\Exception $e) {
				return $this->return404('This is not a valid creature card');
			}

			try {
				if (!$this->card instanceof \application\entities\CreatureCard) {
					return $this->return404('This is not a valid creature card');
				} else {
					if ($request->isPost()) {
						$this->card->mergeFormData($request);
						$this->card->save();
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'creature')));
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runEditItemCard(Request $request)
		{
			$card_id = $request['card_id'];

			try {
				if ($card_id) {
					$this->card = new \application\entities\EquippableItemCard($card_id);
				} else {
					$this->card = new \application\entities\EquippableItemCard();
				}
			} catch (\Exception $e) {
				return $this->return404('This is not a valid item card');
			}

			try {
				if (!$this->card instanceof \application\entities\EquippableItemCard) {
					return $this->return404('This is not a valid item card');
				} else {
					if ($request->isPost()) {
						$this->card->mergeFormData($request);
						$this->card->save();
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'item')));
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runEditPotionCard(Request $request)
		{
			$card_id = $request['card_id'];

			try {
				if ($card_id) {
					$this->card = new \application\entities\PotionItemCard($card_id);
				} else {
					$this->card = new \application\entities\PotionItemCard();
				}
			} catch (\Exception $e) {
				return $this->return404('This is not a valid potion card');
			}

			try {
				if (!$this->card instanceof \application\entities\PotionItemCard) {
					return $this->return404('This is not a valid potion card');
				} else {
					if ($request->isPost()) {
						$this->card->mergeFormData($request);
						$this->card->save();
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'potion')));
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runCardOfTheWeek(Request $request)
		{
			if ($request->isPost()) {
				$card = $request['selected_card'];
				\application\entities\Settings::saveSetting(\application\entities\Settings::SETTING_CARD_OF_THE_WEEK, $card);
			}
			$this->current_card = \application\entities\Settings::getCardOfTheWeek();
			$item = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$event = \application\entities\tables\EventCards::getTable()->getAll();
			$creature = array();
			foreach (\application\entities\Card::getFactions() as $faction => $description) {
				$creature[$faction] = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			}
			$this->cards = compact('item', 'event', 'creature');
		}

	}