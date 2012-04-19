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
			$game_id = $request['game_id'];
			try {
				$this->game = new Game();
			} catch (Exception $e) {
				
			}
		}
		
	}