<?php 

	namespace application\modules\ask;

	use caspar\core\Request,
		application\entities\Game,
		application\entities\tables\Games,
		application\entities\tables\Attacks,
		application\entities\tables\Cards,
		application\entities\tables\GameInvites;

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
			$removed_invites = array();
			if ($this->getUser()->isAuthenticated()) {
				$game_invites = GameInvites::getTable()->getInvitesByUserId($this->getUser()->getId(), $request->getParameter('invites', array()));
				$removed_invites = GameInvites::getTable()->getRemovedInvitesByUserId($this->getUser()->getId(), $request->getParameter('invites', array()));
				foreach ($game_invites as $invite_id => $invite) {
					$invites[$invite_id] = array('player_name' => $invite->getFromPlayer()->getName(), 'game_id' => $invite->getGameId(), 'invite_id' => $invite->getId());
				}
			}
			return $this->renderJSON(compact('invites', 'removed_invites'));
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

		protected function _processChatUsers(Request $request)
		{
			$chat_users = array();
			if ($this->getUser()->isAuthenticated()) {
				foreach ($request->getParameter('rooms', array()) as $room_id) {
					$room = new \application\entities\ChatRoom($room_id);
					$room->ping($this->getUser()->getId());
					$users = array();
					foreach ($room->getUsers() as $user) {
						$users[$user->getId()] = array('username' => $user->getUsername(), 'user_id' => $user->getId(), 'level' => $user->getLevel());
					}
					$chat_users[$room_id] = array(
						'users' => $users,
						'count' => $room->getNumberOfUsers()
					);
				}
			}
			return $this->renderJSON(compact('chat_users'));
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
				return $this->renderJSON(array('forward' => $this->getRouting()->generate('board', array('game_id' => $game->getId()))));
			} else {
				return $this->renderJSON(array('game' => 'not found'));
			}
		}

		protected function _processInvite(Request $request)
		{
			$user_id = $request['user_id'];
			$user = \application\entities\tables\Users::getTable()->selectById($user_id);
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
				$games[$game->getId()] = array('invitation_confirmed' => $game->isInvitationConfirmed(), 'invitation_rejected' => $game->isInvitationRejected(), 'turn' => array('opponent' => $game->isOpponentTurn(), 'player' => $game->isPlayerTurn()));
			}
			return $this->renderJSON(compact('games'));
		}

		protected function _processAcceptGameInvite(Request $request)
		{
			try {
				$invite = new \application\entities\GameInvite($request['invite_id']);
			} catch (\Exception $e) {
				return $this->renderJSON(array('accepted' => 'removed', 'invite_id' => $request['invite_id'], 'message' => 'This invite is no longer available'));
			}
			$invite->accept();
			$game_id = $invite->getGameId();
			$invite->delete();
			return $this->renderJSON(array('forward' => $this->getRouting()->generate('board', array('game_id' => $game_id))));
		}

		protected function _processRejectGameInvite(Request $request)
		{
			try {
				$invite = new \application\entities\GameInvite($request['invite_id']);
				$invite->reject();
				$invite->delete();
			} catch (\Exception $e) {}
			return $this->renderJSON(array('rejected' => 'ok', 'invite_id' => $request['invite_id']));
		}

		protected function _processCancelGame(Request $request)
		{
			$game = Games::getTable()->selectById($request['game_id']);
			$game->cancel();
			$game->delete();
			return $this->renderJSON(array('cancelled' => 'ok', 'game_id' => $game->getId()));
		}

		protected function _processPollGameData(Request $request)
		{
			$game_data = array();
			$game = Games::getTable()->selectById($request['game_id']);
			$game_data['current_player_id'] = $game->getCurrentPlayerId();
			$gameevents = \application\entities\tables\GameEvents::getTable()->getLatestEventsByGame($game, $request['latest_event_id']);
			$events = array();
			foreach ($gameevents as $event) {
				$events[] = array('id' => $event->getId(), 'type' => $event->getEventType(), 'data' => json_decode($event->getEventData()), 'event_content' => $this->getTemplateHTML('game/event', compact('event')));
			}
			return $this->renderJSON(array('game' => array('data' => $game_data, 'events' => $events)));
		}

		protected function _processGetCards(Request $request)
		{
			$game_data = array();
			$game = Games::getTable()->selectById($request['game_id']);
			$game_data['current_player_id'] = $this->getUser()->getId();
			$gameevents = \application\entities\tables\GameEvents::getTable()->getOpponentCardEventsByGame($game, $request['latest_event_id']);
			$events = array();
			foreach ($gameevents as $event) {
				$events[] = array('id' => $event->getId(), 'type' => $event->getEventType(), 'data' => json_decode($event->getEventData()), 'event_content' => $this->getTemplateHTML('game/event', compact('event')));
			}
			return $this->renderJSON(array('game' => array('data' => $game_data, 'events' => $events)));
		}

		protected function _processGetCard(Request $request)
		{
			$game = Games::getTable()->selectById($request['game_id']);
			try {
				$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
				$class = ($card->getUser()->getId() == $this->getUser()->getId()) ? '' : 'flipped';

				return $this->renderJSON(array('card' => $this->getTemplateHTML('game/card', array('card' => $card, 'ingame' => true, 'mode' => $class))));
			} catch (\Exception $e) {
				var_dump($e->getMessage());
				var_dump($e->getTraceAsString());
				die();
			}
		}

		protected function _processEndPhase(Request $request)
		{
			$game = Games::getTable()->selectById($request['game_id']);
			if ($game->getCurrentPlayerId() == $this->getUser()->getId() || $game->canUserMove($this->getUser()->getId())) {
				if ($game->getCurrentPhase() == \application\entities\Game::PHASE_MOVE || $game->getTurnNumber() <= 2) {
					$slots = $request['slots'];
					foreach ($slots as $slot_no => $slot) {
						$game->setUserPlayerCardSlot($slot_no, $slot['card_id']);
						$game->setUserPlayerCardSlotPowerupCard1($slot_no, $slot['powerupcard1_id']);
						$game->setUserPlayerCardSlotPowerupCard2($slot_no, $slot['powerupcard2_id']);
					}
				}
				$returns = array('end_phase' => 'ok');
				if ($game->getCurrentPlayerId() == $this->getUser()->getId()) {
					$game->endPhase();
					if ($game->getTurnNumber() <= 2) {
						if ($game->hasUserOpponentPlacedCards()) {
							$returns['advancing_past_2'] = true;
							while ($game->getTurnNumber() <= 2) {
								$game->endPhase();
							}
						} else {
							$returns['advancing_past_2'] = false;
							while (in_array($game->getCurrentPhase(), array(Game::PHASE_REPLENISH, Game::PHASE_RESOLUTION, Game::PHASE_ACTION))) {
								$game->endPhase();
							}
						}
					}
					$game->save();
				}
				return $this->renderJSON($returns);
			} else {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "It's not your turn"));
			}
		}

		protected function _processAttack(Request $request)
		{
			$game = Games::getTable()->selectById($request['game_id']);
			if ($game->getCurrentPlayerId() == $this->getUser()->getId()) {
				if ($game->getCurrentPhase() == \application\entities\Game::PHASE_ACTION) {
					if ($game->getCurrentPlayerActions() > 0) {
						$attack = \application\entities\tables\Attacks::getTable()->selectById($request['attack_id']);
						$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['attacked_card_id']);
						list($game, $attacking_card) = $attack->perform($card);
						$game->save();
						$card->save();
						$attacking_card->save();
					} else {
						$this->getResponse()->setHttpStatus(400);
						return $this->renderJSON(array('error' => "You don't have any attacks left"));
					}
				} else {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('error' => "You cannot attack during this phase"));
				}
				return $this->renderJSON(array('attack' => 'ok'));
			} else {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "It's not your turn"));
			}
		}

		protected function _processPotion(Request $request)
		{
			$game = Games::getTable()->selectById($request['game_id']);
//			if ($game->getCurrentPlayerId() == $this->getUser()->getId()) {
//				if ($game->getCurrentPhase() == \application\entities\Game::PHASE_ACTION) {
//					if ($game->getCurrentPlayerActions() > 0) {
			$potion_card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
			$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['attacked_card_id']);
			$potion_card->cast($game, $card);
			$game->save();
			$card->save();
			if ($potion_card->getNumberOfUses() == 0) {
				$game->removeCard($potion_card);
			}
			if ($potion_card->isOneTimePotion() && $potion_card->getNumberOfUses() == 0) {
				$potion_card->delete();
			} else {
				$potion_card->save();
			}
			return $this->renderJSON(array('potion' => 'ok'));
//					} else {
//						$this->getResponse()->setHttpStatus(400);
//						return $this->renderJSON(array('error' => "You don't have any attacks left"));
//					}
//				} else {
//					$this->getResponse()->setHttpStatus(400);
//					return $this->renderJSON(array('error' => "You cannot attack during this phase"));
//				}
//			} else {
//				$this->getResponse()->setHttpStatus(400);
//				return $this->renderJSON(array('error' => "It's not your turn"));
//			}
		}

		protected function _processGameStats(Request $request)
		{
			$game = Games::getTable()->selectById($request['game_id']);
			return $this->renderJSON(array('stats' => $game->getStatistics($this->getUser()->getId())));
		}

		protected function _processSaveSettings(Request $request)
		{
			$this->getUser()->setGameMusicEnabled($request['music_enabled']);
			return $this->renderJSON(array('message' => 'Settings saved!'));
		}

		/**
		 * Ask action
		 *  
		 * @param Request $request
		 */
		public function runAsk(Request $request)
		{
			try {
				switch ($request['for']) {
					case 'game_invites':
						return $this->_processGameInvites($request);
						break;
					case 'chat_lines':
						return $this->_processChatLines($request);
						break;
					case 'chat_users':
						return $this->_processChatUsers($request);
						break;
					case 'quickmatch':
						return $this->_processQuickmatch($request);
						break;
					case 'gamelist':
						return $this->_processGameList($request);
						break;
					case 'game_data':
						return $this->_processPollGameData($request);
						break;
					case 'get_cards':
						return $this->_processGetCards($request);
						break;
					case 'game_stats':
						return $this->_processGameStats($request);
						break;
					case 'card':
						return $this->_processGetCard($request);
						break;
					default:
						return $this->renderJSON(array('for' => $request['for']));
				}
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => $e->getMessage()));
				return $this->renderJSON(array('error' => 'An error occured'));
			}
			return $this->renderJSON(array($request['for'] => 'ok, no data'));
		}

		/**
		 * Say action
		 *
		 * @param Request $request
		 */
		public function runSay(Request $request)
		{
			try {
				switch ($request['topic']) {
					case 'invite':
						return $this->_processInvite($request);
						break;
					case 'reject_invite':
						return $this->_processRejectGameInvite($request);
						break;
					case 'cancel_game':
						return $this->_processCancelGame($request);
						break;
					case 'accept_invite':
						return $this->_processAcceptGameInvite($request);
						break;
					case 'end_phase':
						return $this->_processEndPhase($request);
						break;
					case 'attack':
						return $this->_processAttack($request);
						break;
					case 'potion':
						return $this->_processPotion($request);
						break;
					case 'savesettings':
						return $this->_processSaveSettings($request);
						break;
					default:
						return $this->renderJSON(array('topic' => $request['topic']));
				}
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured'));
			}
			return $this->renderJSON(array($request['topic'] => 'ok, no data'));
		}

	}