<?php 

	namespace application\modules\lobby;

	use \caspar\core\Request;

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

		public function runSay(Request $request)
		{
			try {
				$room = new \application\entities\ChatRoom($request['room_id']);
				$room->say($request['text'], $this->getUser()->getId());
				return $this->renderJSON(array('say' => 'ok'));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => $e->getMessage()));
			}
		}

	}