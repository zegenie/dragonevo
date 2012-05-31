<?php 

	namespace application\modules\ask;

	use \caspar\core\Request;

	/**
	 * Actions for the market module
	 */
	class Actions extends \caspar\core\Actions
	{

		public function preExecute(Request $request, $action)
		{
			if (!$this->getUser()->isAuthenticated()) {
				return $this->forward403();
			}
		}

		protected function _processGameInvites(Request $request)
		{
			$invites = array();
			if ($this->getUser()->isAuthenticated()) {
				$game_invites = \application\entities\tables\GameInvites::getTable()->getInvitesByUserId($this->getUser()->getId(), $request->getParameter('invites', array()));
				foreach ($game_invites as $invite_id => $invite) {
					$invites[$invite_id] = array('player_name' => $invite->getFromPlayer()->getName(), 'game_id' => $invite->getGameId(), 'invite_id' => $invite->getId());
				}
			}
			return $this->renderJSON(compact('invites'));
		}

		protected function _processChatLines(Request $request)
		{
			$chat_lines = array();
			if ($this->getUser()->isAuthenticated()) {
				$since = $request['since'];
				foreach ($request->getParameter('rooms', array()) as $room_id) {
					$room = new \application\entities\ChatRoom($room_id);
					$chat_lines[$room_id] = array(
						'users' => array('count' => $room->getNumberOfUsers()),
						'lines' => \application\entities\tables\ChatLines::getTable()->getLinesByRoomId($room_id, $since[$room_id])
					);
				}
			}
			return $this->renderJSON(compact('chat_lines'));
		}

		protected function _findQuickmatch(Request $request)
		{
			$user = $this->getUser();
			$qm_game = \application\entities\tables\Games::getTable()->getQuickmatchGameForUser($user->getId());
			if ($qm_game instanceof \application\entities\Game) {
				if ($qm_game->getOpponent() instanceof \application\entities\User) {
					$qm_game->completeQuickmatch();
					$qm_game->save();
					return $qm_game;
				}
			}
			$game = \application\entities\tables\Games::getTable()->getAvailableGameForQuickmatch($user->getId());
			if ($game instanceof \application\entities\Game) {
				$game->setOpponent($user);
				$game->save();
				if ($qm_game instanceof \application\entities\Game) {
					$qm_game->delete();
				}
				return $game;
			} else {
				if (!$qm_game instanceof \application\entities\Game) {
					$qm_game = new \application\entities\Game();
					$qm_game->setPlayer($user);
					$qm_game->initiateQuickmatch();
					$qm_game->save();
				}
			}
		}

		protected function _processQuickmatch(Request $request)
		{
			$game = $this->_findQuickmatch($request);
			if ($game instanceof \application\entities\Game) {
				return $this->renderJSON(array('forward' => $this->getRouting()->generate('pick_cards', array('game_id' => $game->getId()))));
			} else {
				return $this->renderJSON(array('game' => 'not found'));
			}
		}

		protected function _processInvite(Request $request)
		{
			$user_id = $request['user_id'];
			$user = new \application\entities\User($user_id);
			$game = new \application\entities\Game();
			$game->setPlayer($this->getUser());
			$game->save();
			$game->invite($user);
			$game->save();
			return $this->renderJSON(array('game' => $this->getTemplateHTML('lobby/game', compact('game'))));
		}

		protected function _processGameList(Request $request)
		{
			$games = array();
			foreach ($this->getUser()->getGames() as $game) {
				$games[$game->getId()] = array('invitation_confirmed' => $game->isInvitationConfirmed(), 'turn' => array('opponent' => $game->isOpponentTurn(), 'player' => $game->isPlayerTurn()));
			}
			return $this->renderJSON(compact('games'));
		}

		/**
		 * Index page
		 *  
		 * @param Request $request
		 */
		public function runIndex(Request $request)
		{
			try {
				switch ($request['for']) {
					case 'game_invites':
						return $this->_processGameInvites($request);
						break;
					case 'chat_lines':
						return $this->_processChatLines($request);
						break;
					case 'quickmatch':
						return $this->_processQuickmatch($request);
						break;
					case 'invite':
						return $this->_processInvite($request);
						break;
					case 'gamelist':
						return $this->_processGameList($request);
						break;
					default:
						return $this->renderJSON(array('for' => $request['for']));
				}
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured'));
			}
		}

	}