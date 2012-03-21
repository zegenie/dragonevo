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
					$this->getResponse()->setTemplate('admin/eventcard');
					$this->redirect('editEventCards');
					break;
			}
		}

		public function runEditEventCards(Request $request)
		{
			$this->cards = \application\entities\tables\EventCards::getTable()->getAll();
		}

	}