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

		/**
		 * Index page
		 *  
		 * @param Request $request
		 */
		public function runIndex(Request $request)
		{
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
			}
		}

		public function runEditEventCards(Request $request)
		{
			$this->cards = \application\entities\tables\EventCards::getTable()->getAll();
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

	}