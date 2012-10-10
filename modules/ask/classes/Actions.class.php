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

		/**
		 * The currently selected game
		 *
		 * @var \application\entities\Game
		 * @access protected
		 * @property $game
		 */
		
		/**
		 * Pre execute action
		 * 
		 * @param \caspar\core\Request $request
		 * @param string $action
		 * 
		 * @return integer
		 */
		public function preExecute(Request $request, $action)
		{
			if (!$this->getUser()->isAuthenticated()) {
				return $this->forward403();
			}
			try {
				if ($request['game_id']) {
					$this->game = Games::getTable()->selectById($request['game_id']);
					if ($this->game instanceof Game) {
						if ($this->game->isUserOffline($this->getUser()->getId())) {
							$this->game->setUserOnline($this->getUser()->getId());
							$this->game->save();
						}
					}
				}
			} catch (\Exception $e) { }
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
						'users' => array(
							'count' => $room->getNumberOfUsers(),
							'ingame_count' => \application\entities\tables\ChatPings::getTable()->getNumberOfUsersInGames()
						),
						'lines' => \application\entities\tables\ChatLines::getTable()->getLinesByRoomId($room_id, $since[$room_id], 200)
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
					$room->ping($this->getUser());
					$users = array();
					foreach ($room->getUsers() as $user) {
						$users[$user->getId()] = array('username' => $user->getUsername(), 'avatar' => $user->getAvatar(), 'charactername' => $user->getCharactername(), 'race' => $user->getRaceName(), 'user_id' => $user->getId(), 'is_admin' => $user->isAdmin(), 'level' => $user->getLevel());
					}
					$chat_users[$room_id] = array(
						'users' => $users,
						'count' => $room->getNumberOfUsers(),
						'ingame_count' => \application\entities\tables\ChatPings::getTable()->getNumberOfUsersInGames()
					);
				}
			}
			return $this->renderJSON(compact('chat_users'));
		}

		protected function _processInviteUser(Request $request)
		{
			try {
				if (filter_var($request->getParameter('invite_email'), FILTER_VALIDATE_EMAIL)) {
					$invite_code = substr($this->getUser()->getPassword(), -10);
					require_once CASPAR_APPLICATION_PATH . 'swift/lib/swift_required.php';
					$message = \Swift_Message::newInstance('Dragon Evo: The Card Game invitation');
					$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
					$message->setTo($request->getParameter('invite_email'));
					$plain_content = str_replace(array('%code%', '%user%'), array($invite_code, $this->getUser()->getCharactername()), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'invitation_email.txt'));
					$message->setBody($plain_content, 'text/plain');
					$transport = \Swift_SmtpTransport::newInstance('smtp.domeneshop.no', 587)
						->setUsername('dragonevo1')
						->setPassword('sDf47nQ5');
					$mailer = \Swift_Mailer::newInstance($transport);
					$retval = $mailer->send($message);
					return $this->renderJSON(array('invite' => 'ok', 'message' => 'Invite sent successfully!'));
				} else {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('invite' => 'failed', 'error' => 'Not a valid email address!'));
				}
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('invite' => 'failed', 'error' => 'An error occured. Pleaes try again in a little while.'));
				var_dump($e->getMessage());
				die();
			}
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
				return $this->renderJSON(array('game_id' => $game->getId()));
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
			return $this->renderJSON(array('game_id' => $game_id));
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
			$this->game->cancel();
			$this->game->delete();
			return $this->renderJSON(array('cancelled' => 'ok', 'game_id' => $this->game->getId()));
		}

		protected function _processPollGameData(Request $request)
		{
			$game_data = array();
			$events = array();
			$game = Games::getTable()->selectById($request['game_id']);
			if ($game instanceof Game) {
				$game_data['current_player_id'] = $game->getCurrentPlayerId();
				$gameevents = \application\entities\tables\GameEvents::getTable()->getLatestEventsByGame($game, $request['latest_event_id']);
				foreach ($gameevents as $event) {
					$events[] = array('id' => $event->getId(), 'type' => $event->getEventType(), 'data' => json_decode($event->getEventData()), 'event_content' => $this->getTemplateHTML('game/event', compact('event')));
				}
			}
			return $this->renderJSON(array('game' => array('data' => $game_data, 'events' => $events)));
		}

		protected function _processGetCards(Request $request)
		{
			$game_data = array();
			$game = Games::getTable()->selectById($request['game_id']);
			$game_data['current_player_id'] = $this->getUser()->getId();
			$gameevents = \application\entities\tables\GameEvents::getTable()->getOpponentCardEventsByGame($game);
			$events = array();
			foreach ($gameevents as $event) {
				$events[] = array('id' => $event->getId(), 'type' => $event->getEventType(), 'data' => json_decode($event->getEventData()), 'event_content' => $this->getTemplateHTML('game/event', compact('event')));
			}
			return $this->renderJSON(array('game' => array('data' => $game_data, 'events' => $events)));
		}

		protected function _processGetCard(Request $request)
		{
			try {
				$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
				$class = ($card->getUserId() == $this->getUser()->getId()) ? '' : 'flipped';

				return $this->renderJSON(array('card' => $this->getTemplateHTML('game/card', array('card' => $card, 'ingame' => true, 'mode' => $class))));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured while trying to retrieve a card. Try reloading the page.'));
			}
		}

		protected function _processEndPhase(Request $request)
		{
			if ($this->game->getCurrentPlayerId() == $this->getUser()->getId() || $this->game->canUserMove($this->getUser()->getId())) {
				$returns = array('end_phase' => 'ok');
				if ($this->game->getCurrentPhase() == \application\entities\Game::PHASE_MOVE || $this->game->getTurnNumber() <= 2) {
					$cards_to_save = array();
					$slots = $request['slots'];
					foreach ($slots as $slot_no => $slot) {
						$slot_card = $this->game->getUserPlayerCardSlot($slot_no);
						if (!$slot_card || ($slot_card instanceof Card && $slot_card->getUniqueId() != $slot['card_id'])) {
							if ($slot_card instanceof Card) {
								$this->game->setUserPlayerCardSlot(0, $slot_card);
								$cards_to_save[$slot_card->getUniqueId()] = $slot_card;
							}
							if ($slot['card_id']) {
								$card = Cards::getTable()->getCardByUniqueId($slot['card_id']);
								$this->game->setUserPlayerCardSlot($slot_no, $card);
								$cards_to_save[$card->getUniqueId()] = $card;
							}
						}
						$p1_slot_card = $this->game->getUserPlayerCardSlotPowerupCard1($slot_no);
						if (!$p1_slot_card || ($p1_slot_card instanceof Card && $p1_slot_card->getUniqueId() != $slot['powerupcard1_id'])) {
							if ($p1_slot_card instanceof Card) {
								$this->game->setUserPlayerCardSlotPowerupCard1(0, $p1_slot_card);
								$cards_to_save[$p1_slot_card->getUniqueId()] = $p1_slot_card;
							}
							if ($slot['powerupcard1_id']) {
								$card = Cards::getTable()->getCardByUniqueId($slot['powerupcard1_id']);
								$this->game->setUserPlayerCardSlotPowerupCard1($slot_no, $card);
								$cards_to_save[$card->getUniqueId()] = $card;
							}
						}
						$p2_slot_card = $this->game->getUserPlayerCardSlotPowerupCard2($slot_no);
						if (!$p2_slot_card || ($p2_slot_card instanceof Card && $p2_slot_card->getUniqueId() != $slot['powerupcard2_id'])) {
							if ($p2_slot_card instanceof Card) {
								$this->game->setUserPlayerCardSlotPowerupCard2(0, $p2_slot_card);
								$cards_to_save[$p2_slot_card->getUniqueId()] = $p2_slot_card;
							}
							if ($slot['powerupcard2_id']) {
								$card = Cards::getTable()->getCardByUniqueId($slot['powerupcard2_id']);
								$this->game->setUserPlayerCardSlotPowerupCard2($slot_no, $card);
								$cards_to_save[$card->getUniqueId()] = $card;
							}
						}
					}
					$returns['cards'] = array();
					foreach ($cards_to_save as $card_id => $card) {
						if ($card->getSlot()) {
							if ($card instanceof \application\entities\CreatureCard) {
								if ($card->isInPlay()) {
									$card->setIsInPlay(false);
								} else {
									$card->setInGameHP($card->getBaseHP());
									$card->setInGameEP($card->getBaseEP());
								}
							}
						} else {
							$card->setIsInPlay(false);
						}
						$this->game->addAffectedCard($card);
						$returns['cards'][$card->getUniqueId()] = array('slot' => $card->getSlot(), 'in_play' => $card->isInPlay());
					}
				}
				if ($this->game->getCurrentPlayerId() == $this->getUser()->getId() || ($this->game->getUserOpponent()->isAI() && $this->game->getTurnNumber() <= 2)) {
					$this->game->endPhase();
					if ($this->game->getTurnNumber() <= 2) {
						if ($this->game->hasUserOpponentPlacedCards()) {
							$returns['advancing_past_2'] = true;
							while ($this->game->getTurnNumber() <= 2) {
								$this->game->endPhase();
							}
						} else {
							$returns['advancing_past_2'] = false;
							while (in_array($this->game->getCurrentPhase(), array(Game::PHASE_REPLENISH, Game::PHASE_RESOLUTION, Game::PHASE_ACTION))) {
								$this->game->endPhase();
							}
						}
					}
				}
				if ($this->game->getUserOpponent()->isAI() && $this->game->isInProgress() && $this->game->getCurrentPlayerId() == $this->game->getUserOpponent()->getId() && ($this->game->getCurrentPhase() == Game::PHASE_REPLENISH || $this->game->getTurnNumber() <= 2)) {
					$opponent = $this->game->getUserOpponent();
					$me = $this->getUser();
					\caspar\core\Caspar::setUser($opponent);
					$opponent->aiPerformTurn($this->game);
					\caspar\core\Caspar::setUser($me);
				}
				if ($this->game->getCurrentPhase() == Game::PHASE_REPLENISH) $this->game->endPhase();
				$this->game->save();
				$this->game->saveAffectedCards();
				return $this->renderJSON($returns);
			} else {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "It's not your turn"));
			}
		}

		protected function _processAttack(Request $request)
		{
			$attack = \application\entities\tables\Attacks::getTable()->selectById($request['attack_id']);
			$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['attacked_card_id']);

			if ($this->game->getCurrentPlayerId() != $this->getUser()->getId()) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "It's not your turn"));
			}

			if ($this->game->getCurrentPhase() != \application\entities\Game::PHASE_ACTION) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "You cannot attack during this phase"));
			}

			if ($this->game->getCurrentPlayerActions() <= 0) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "You don't have any attacks left"));
			}

			if (!$card->isInPlay()) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "That card is no longer in play"));
			}

			if ($attack->getCard()->hasEffect(\application\entities\ModifierEffect::TYPE_STUN)) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "This card is stunned, and cannot attack"));
			}

			if (!$attack->canAfford()) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "This attack is not available"));
			}

			$attack->perform($card);
			$this->game->save();
			$this->game->saveAffectedCards();
			return $this->renderJSON(array('attack' => 'ok'));
		}

		protected function _processPotion(Request $request)
		{
			$potion_card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
			$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['attacked_card_id']);
			if ($card->isInGame() && $card->isInPlay() && $card->getHP() > 0) {
				$potion_card->cast($this->game, $card);
				if ($potion_card->getNumberOfUses() == 0) {
					$this->game->removeCard($potion_card);
				}
				$this->game->save();
				$this->game->saveAffectedCards();
				if ($potion_card->isOneTimePotion() && $potion_card->getNumberOfUses() == 0) {
					$potion_card->delete();
				}
				return $this->renderJSON(array('potion' => 'ok'));
			} else {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "That card is no longer in play", 'in_game' => $card->isInGame(), 'in_play' => $card->isInPlay(), 'hp' => $card->getHP()));
			}
		}

		protected function _processGameStats(Request $request)
		{
			return $this->renderJSON(array('stats' => $this->game->getStatistics($this->getUser()->getId())));
		}

		protected function _processSaveSettings(Request $request)
		{
			$this->getUser()->setGameMusicEnabled($request['music_enabled']);
			$this->getUser()->setSystemChatMessagesEnabled($request['system_chat_messages_enabled']);
			return $this->renderJSON(array('message' => 'Settings saved!'));
		}

		protected function _processOpponentAvatar(Request $request)
		{
			$avatar_url = '/images/avatars/'.$this->game->getUserOpponent()->getAvatar();
//			$avatar_url = '/images/avatars/avatar_1.png';
			return $this->renderJSON(array('avatar_url' => $avatar_url));
		}

		protected function _processGameTopMenu(Request $request)
		{
			return $this->renderJSON(array('menu' => $this->getComponentHTML('game/gametopmenu', array('game' => $this->game))));
		}

		protected function _processTrainSkill(Request $request)
		{
			$skill_id = $request['selected_skill'];
			$skill = \application\entities\tables\Skills::getTable()->selectById((int) $skill_id);
			if ($this->getUser()->hasTrainedSkill($skill) || !$skill->isTrainable()) {
				return $this->renderJSON(array('message' => 'This skill is not available for training'));
			}

			$this->getUser()->trainSkill($skill);
			$this->getUser()->levelUp();
			$this->getUser()->save();
			return $this->renderJSON(array('message' => 'Skill training completed!', 'skill_trained' => (int) $skill_id, 'levelup_available' => $this->getUser()->canLevelUp()));
		}

		protected function _processLeaveGame(Request $request)
		{
			if ($this->game instanceof Game) {
				if ($this->game->isInProgress() && in_array($this->getUser()->getId(), array($this->game->getPlayer()->getId(), $this->game->getOpponentId()))) {
					if (!$this->game->getOpponentId()) {
						$this->game->resolve($this->game->getOpponentId());
					} else {
						$this->game->resolve($this->game->getUserOpponent()->getId());
					}
					$this->game->save();
					$this->game->resetUserCards();
				}
			}

			return $this->renderJSON(array('leave_game' => 'ok'));
		}

		protected function _processTraining(Request $request)
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
			$game->setCurrentPlayer($this->getUser());
			$game->save();

			$factions = array('resistance', 'neutrals', 'rutai');
			$faction = $factions[array_rand($factions)];
			$creature_cards = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
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
			return $this->renderJSON(array('game_id' => $game->getId()));
		}

		protected function _processGameInterface(Request $request)
		{
			$interface_part = $request['part'];
			$interface_content = '';
			if ($request['game_id']) {
				$game = Games::getTable()->selectById($request['game_id']);
			}
			switch ($interface_part) {
				case 'lobby':
					$interface_content = $this->getComponentHTML('lobby/lobbycontent');
					break;
				case 'chat_room':
					$room = \application\entities\tables\ChatRooms::getTable()->selectById($request['room_id']);
					$interface_content = $this->getComponentHTML('lobby/chatroom', array('room' => $room));
					break;
				case 'profile':
					$interface_content = $this->getComponentHTML('main/profilecontent');
					break;
				case 'profile_cards':
					$interface_content = $this->getComponentHTML('main/profilecardscontent');
					break;
				case 'profile_skills':
					$interface_content = $this->getComponentHTML('main/profileskillscontent');
					break;
				case 'cardpicker':
					if ($game->isGameOver() || $game->hasCards()) {
						return $this->renderJSON(array('is_started' => 1));
					} else {
						$interface_content = $this->getComponentHTML('game/pickcardscontent', array('game' => $game));
					}
					break;
				case 'board':
					if (in_array($this->getUser()->getId(), array($this->game->getPlayer()->getId(), $this->game->getOpponent()->getId()))) {
						if (!$this->game->isGameOver() && !$this->game->hasCards()) {
							return $this->renderJSON(array('state' => 'no_cards'));
						}
					}
					$interface_content = $this->getComponentHTML('game/boardcontent', array('game' => $game));
					$event_id = max(array_keys($game->getEvents()));
					$user = $this->getUser();
					$options = array(
						'game_id' => $game->getId(),
						'room_id' => ($game->getUserOpponent()->isAi()) ? 0 : $game->getChatroom()->getId(),
						'latest_event_id' => $event_id,
						'current_turn' => $game->getTurnNumber(),
						'current_phase' => $game->getCurrentPhase(),
						'current_player_id' => $game->getCurrentPlayerId(),
						'movable' => ($game->canUserMove($user->getId())) ? 'true' : 'false',
						'actions' => ($game->getCurrentPlayerId() == $user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? 'true' : 'false',
						'music_enabled' => ($user->isGameMusicEnabled()) ? 'true' : 'false',
						'actions_remaining' => ($game->getCurrentPlayerId() == $user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0
					);
					break;
			}

			return $this->renderJSON(compact('interface_content', 'options'));
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
					case 'game_interface':
						return $this->_processGameInterface($request);
						break;
					case 'game_topmenu':
						return $this->_processGameTopMenu($request);
						break;
					case 'opponent_avatar':
						return $this->_processOpponentAvatar($request);
						break;
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
					case 'training':
						return $this->_processTraining($request);
						break;
					case 'leave':
						return $this->_processLeaveGame($request);
						break;
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
					case 'invite_user':
						return $this->_processInviteUser($request);
						break;
					case 'train_skill':
						return $this->_processTrainSkill($request);
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