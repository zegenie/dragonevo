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
	class Actions extends \application\lib\Actions
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
				if ($request['version'] != str_replace('.', '_', $this->getResponse()->getVersion())) {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('upgrade' => true));
				}
			} catch (\Exception $e) { }
		}

		protected function _processGameInvites(Request $request)
		{
			$invites = array();
			$removed_invites = array();
			if ($this->getUser()->isAuthenticated()) {
				$game_invites = GameInvites::getTable()->getInvitesByUserId($this->getUser()->getId());
				foreach ($game_invites as $invite_id => $invite) {
					$invites[$invite_id] = array('player_name' => $invite->getFromPlayer()->getCharactername(), 'game_id' => $invite->getGameId(), 'invite_id' => $invite->getId());
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
						$users[$user->getId()] = array('username' => $user->getUsername(), 'mp_ranking' => $user->getRankingMP(), 'sp_ranking' => $user->getRankingSP(), 'avatar' => $user->getAvatar(), 'charactername' => $user->getCharactername(), 'race' => $user->getRaceName(), 'user_id' => $user->getId(), 'is_admin' => $user->isAdmin(), 'level' => $user->getLevel(), 'friends' => $this->getUser()->isFriends($user));
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

		protected function _processProfileInfo(Request $request)
		{
			try {
				$user = \application\entities\tables\Users::getTable()->selectById((int) $request['user_id']);
				if (!$user instanceof \application\entities\User) {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('add_friend' => 'failed', 'error' => 'This user does not exist'));
				}
				return $this->renderJSON(array('profile_info' => $this->getTemplateHTML('main/profileinfo', compact('user'))));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured. Please try again in a little while.'));
			}
		}

		protected function _processAddFriend(Request $request)
		{
			try {
				$user = \application\entities\tables\Users::getTable()->selectById((int) $request['user_id']);
				if ($user instanceof \application\entities\User) {
					if ($this->getUser()->isAcceptedFriends($user)) {
						$this->getResponse()->setHttpStatus(400);
						return $this->renderJSON(array('add_friend' => 'failed', 'error' => 'This user is already your friend'));
					} else {
						$val = $this->getUser()->addFriend($user);
					}
				} else {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('add_friend' => 'failed', 'error' => 'This user does not exist'));
				}
				$message = ($val === false) ? 'You are now friends' : 'Friend request sent successfully';
				return $this->renderJSON(array('add_friend' => 'ok', 'message' => $message));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured. Please try again in a little while.'));
			}
		}

		protected function _processRemoveFriend(Request $request)
		{
			try {
				$userfriend = null;
				if ($request->hasParameter('user_id')) {
					$userfriends = $this->getUser()->getUserFriends();
					foreach ($userfriends as $uf) {
						if (in_array($this->getUser()->getId(), array($uf->getUserId(), $uf->getFriendUserId()))) {
							$userfriend = $uf;
							break;
						}
					}
				} else {
					$userfriend = \application\entities\tables\UserFriends::getTable()->selectById((int) $request['userfriend_id']);
				}
				if ($userfriend instanceof \application\entities\UserFriend) {
					if (in_array($this->getUser()->getId(), array($userfriend->getUserId(), $userfriend->getFriendUserId()))) {
						$user_id = $userfriend->getFriend()->getId();
						$userfriend->delete();
					} else {
						$this->getResponse()->setHttpStatus(400);
						return $this->renderJSON(array('remove_friend' => 'failed', 'error' => 'This user is not your friend'));
					}
				} else {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('remove_friend' => 'failed', 'error' => 'This user does not exist'));
				}
				return $this->renderJSON(array('remove_friend' => 'ok', 'user_id' => $user_id, 'message' => 'You are no longer friends'));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured. Please try again in a little while.'));
			}
		}

		protected function _processInviteUser(Request $request)
		{
			try {
				$email_address = $request['invite_email'];
				if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
					$invite_code = substr($this->getUser()->getPassword(), -10);
					$user = \application\entities\tables\Users::getTable()->getByEmail($email_address);
					if ($user instanceof \application\entities\User) {
						$this->_createGameInvite($user);
					} else {
						$this->_sendEmailGameInvite($this->getUser(), $email_address, $invite_code);
					}
					return $this->renderJSON(array('invite' => 'ok', 'message' => 'Invite sent successfully!'));
				} else {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('invite' => 'failed', 'error' => 'Not a valid email address!'));
				}
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('invite' => 'failed', 'error' => 'An error occured. Please try again in a little while.'));
			}
		}

		protected function _findQuickmatch(Request $request)
		{
			$user = $this->getUser();
			$qm_game = \application\entities\tables\Games::getTable()->getQuickmatchGameForUser($user->getId());
			if ($qm_game instanceof \application\entities\Game) {
				if ($qm_game->getCreatedAt() <= time() - 10) {
					$this->_setupTraining($qm_game, rand(1, 3));
					return $qm_game;
				} elseif ($qm_game->getOpponent() instanceof \application\entities\User) {
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
				return $this->renderJSON(array('options' => $game->getOptions($this->getUser())));
			} else {
				return $this->renderJSON(array('game' => 'not found'));
			}
		}

		protected function _processSetVersion(Request $request)
		{
			$this->getUser()->setLastVersion($this->getResponse()->getVersion());
			$this->getUser()->save();

			return $this->renderJSON(array('version' => $this->getResponse()->getVersion()));
		}

		protected function _createGameInvite(\application\entities\User $opponent)
		{
			$game = new \application\entities\Game();
			$game->setPlayer($this->getUser());
			$game->save();
			$invite = $game->invite($opponent);
			$game->save();
			$invited = false;
			if (true || $opponent->getLastSeen() < time() - 180) {
				$this->_sendGameInvite($invite, $opponent, $this->getUser());
				$invited = true;
			}
			return array($invited, $game);
		}

		protected function _processInvite(Request $request)
		{
			$user_id = $request['user_id'];
			$user = \application\entities\tables\Users::getTable()->selectById($user_id);
			list($invited, $game) = $this->_createGameInvite($user);
			return $this->renderJSON(array('sent_invite' => $invited, 'game' => $this->getTemplateHTML('lobby/game', compact('game'))));
		}

		protected function _processGameList(Request $request)
		{
			$games = array();
			foreach ($this->getUser()->getGames() as $game) {
				$games[$game->getId()] = array('invitation_confirmed' => $game->isInvitationConfirmed(), 'invitation_rejected' => $game->isInvitationRejected(), 'turn' => array('opponent' => $game->isOpponentTurn(), 'player' => $game->isPlayerTurn(), 'number' => $game->getTurnNumber(), 'phase' => $game->getCurrentPhase()));
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
			$game = $invite->getGame();
			$invite->delete();
			return $this->renderJSON(array('options' => $game->getOptions($this->getUser())));
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

		protected function _processGetOnlineFriends(Request $request)
		{
			$online_friends = array();
			$userfriends = $this->getUser()->getUserFriends();
			$online_userids = \application\entities\tables\ChatPings::getTable()->getUserIdsByRoomId(1);
			foreach ($userfriends as $userfriend) {
				if ($userfriend->isAccepted() && in_array($userfriend->getFriend()->getId(), $online_userids)) {
					$online_friends[$userfriend->getId()] = array('user_id' => $userfriend->getFriend()->getId(), 'username' => $userfriend->getFriend()->getUsername(), 'charactername' => $userfriend->getFriend()->getCharactername());
				}
			}
			$friend_requests = $this->getTemplateHTML('main/friendrequests', compact('userfriends'));
			return $this->renderJSON(compact('online_friends', 'friend_requests'));
		}

		protected function _processSaveProfile(Request $request)
		{
			if (strlen(trim($request->getParameter('charactername'))) == 0) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'You need to pick a character name'));
			}
			$this->getUser()->mergeFormData($request);
			$this->getUser()->save();
			return $this->renderJSON(array('message' => 'Profile updated!'));
		}

		protected function _processGetCard(Request $request)
		{
			try {
				$card = $this->game->getCard($request['card_id']);
				if (!$card instanceof \application\entities\Card) {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('error' => 'The game is requesting a card not in play.', 'desync' => true));
				}
				$class = ($card->getUserId() == $this->getUser()->getId()) ? '' : 'flipped';

				return $this->renderJSON(array('card' => $this->getTemplateHTML('game/card', array('card' => $card, 'ingame' => true, 'mode' => $class))));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured while trying to retrieve a card. Try reloading the page.'));
			}
		}

		protected function _processGetLevelledUpCard(Request $request)
		{
			try {
				$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
				$card->levelUp('both');
				$card->setId($card->getId().'_levelup');
				$xp = $this->getUser()->getXp();
				list($xp_card, $xp_attacks) = $card->getLevelUpCost();
				return $this->renderJSON(array('user_xp' => $xp, 'xp_card' => $xp_card, 'xp_attacks' => $xp_attacks, 'card' => $this->getTemplateHTML('game/card', array('card' => $card, 'ingame' => false, 'mode' => 'levelledup'))));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured while trying to retrieve a card. Try reloading the page.'));
			}
		}

		protected function _processGetMarketBuyCards($card)
		{
			return $this->renderJSON(array('buycards' => $this->getComponentHTML('market/buycards')));
		}

		protected function _processGetCardPrice(Request $request)
		{
			try {
				$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
				$cost = $card->getSellValue();
				return $this->renderJSON(array('cost' => $cost));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured while trying to retrieve a card. Try reloading the page.'));
			}
		}

		protected function _processSellCard(Request $request)
		{
			try {
				$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
				$card->delete();
				$cost = $card->getSellValue();
				$old_gold = $this->getUser()->getGold();
				$this->getUser()->setGold($old_gold + $cost);
				$this->getUser()->save();
				return $this->renderJSON(array('cost' => array('from' => $old_gold, 'to' => $this->getUser()->getGold(), 'diff' => $cost)));
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => 'An error occured while trying to retrieve a card. Try reloading the page.'));
			}
		}

		protected function _processLevelUpCard(Request $request)
		{
			try {
				$card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
				list($xp_card, $xp_attacks) = $card->getLevelUpCost();
				$xp = $this->getUser()->getXp();
				switch ($request['mode']) {
					case 'both':
						$cost = $xp_attacks + $xp_card;
						break;
					case 'card':
						$cost = $xp_card;
						break;
					case 'attacks':
						$cost = $xp_attacks;
						break;
				}
				$can_upgrade = (bool) $xp >= $cost;
				if (!$can_upgrade) {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('error' => 'You do not have enough XP to level up this card'));
				}
				$card->levelUp($request['mode']);
				$card->save();
				foreach ($card->getAttacks() as $attack) {
					$attack->save();
				}
				$clonecard = clone $card;
				$clonecard->setId($card->getId().'_clone');
				$this->getUser()->setXp($xp - $cost);
				$this->getUser()->save();
				return $this->renderJSON(array('levelup' => 'ok', 'level' => $this->getUser()->getLevel(), 'xp' => $this->getUser()->getXp(), 'card_clone' => $this->getTemplateHTML('game/card', array('card' => $clonecard, 'ingame' => false, 'mode' => 'levellingup')), 'card' => $this->getTemplateHTML('game/card', array('card' => $card, 'ingame' => false, 'mode' => 'medium selected'))));
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
					if (!is_array($slots) || !$slots) {
						$this->getResponse()->setHttpStatus(400);
						return $this->renderJSON(array('error' => 'An error occured while trying to end the movement phase.', 'desync' => true));
					}
					foreach ($slots as $slot_no => $slot) {
						$has_slot_card = false;
						$slot_card = $this->game->getUserPlayerCardSlot($slot_no);
						if (!$slot_card || ($slot_card instanceof Card && $slot_card->getUniqueId() != $slot['card_id'])) {
							if ($slot_card instanceof Card) {
								$this->game->setUserPlayerCardSlot(0, $slot_card);
								$cards_to_save[$slot_card->getUniqueId()] = $slot_card;
							}
							if ($slot['card_id']) {
								$card = $this->game->getCard($slot['card_id']);
								if ($card !== null) {
									$this->game->setUserPlayerCardSlot($slot_no, $card);
									$cards_to_save[$card->getUniqueId()] = $card;
									$has_slot_card = true;
								}
							}
						}
						$p1_slot_card = $this->game->getUserPlayerCardSlotPowerupCard1($slot_no);
						if (!$p1_slot_card || ($p1_slot_card instanceof Card && $p1_slot_card->getUniqueId() != $slot['powerupcard1_id'])) {
							if ($p1_slot_card instanceof Card) {
								$this->game->setUserPlayerCardSlotPowerupCard1(0, $p1_slot_card);
								$cards_to_save[$p1_slot_card->getUniqueId()] = $p1_slot_card;
							}
							if ($slot['powerupcard1_id'] && $has_slot_card) {
								$card = $this->game->getCard($slot['powerupcard1_id']);
								if ($card !== null) {
									$this->game->setUserPlayerCardSlotPowerupCard1($slot_no, $card);
									$cards_to_save[$card->getUniqueId()] = $card;
								}
							}
						}
						$p2_slot_card = $this->game->getUserPlayerCardSlotPowerupCard2($slot_no);
						if (!$p2_slot_card || ($p2_slot_card instanceof Card && $p2_slot_card->getUniqueId() != $slot['powerupcard2_id'])) {
							if ($p2_slot_card instanceof Card) {
								$this->game->setUserPlayerCardSlotPowerupCard2(0, $p2_slot_card);
								$cards_to_save[$p2_slot_card->getUniqueId()] = $p2_slot_card;
							}
							if ($slot['powerupcard2_id'] && $has_slot_card) {
								$card = $this->game->getCard($slot['powerupcard2_id']);
								if ($card !== null) {
									$this->game->setUserPlayerCardSlotPowerupCard2($slot_no, $card);
									$cards_to_save[$card->getUniqueId()] = $card;
								}
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
				if ($this->game->getCurrentPhase() == Game::PHASE_REPLENISH) {
					$this->game->endPhase();
					if (!$this->game->getUserOpponent()->isAI() && $this->game->getUserOpponent()->getLastSeen() < time() - 180) {
						$this->_sendGameTurnEmail($this->game, $this->game->getUserOpponent(), $this->getUser());
					}
				}
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
			$player_card = $this->game->getCard($request['card_id']);
			$attack = null;
			foreach ($player_card->getAttacks() as $a) {
				if ($request['attack_id'] == $a->getId()) $attack = $a;
			}
			$requires_card = true;
			if ($request['attacked_card_id']) {
				$card = $this->game->getCard($request['attacked_card_id']);
			}
			
			if (!(!$attack->isForageAttack() && !$attack->isStealAttack())) {
				$requires_card = false;
			}

			$error = null;
			$actions_remaining = $this->game->getCurrentPlayerActions();

			if ($this->game->getCurrentPlayerId() != $this->getUser()->getId()) {
				$error = "It's not your turn";
			}

			if ($this->game->getCurrentPhase() != \application\entities\Game::PHASE_ACTION) {
				$error = "You cannot attack during this phase";
			}

			if ($actions_remaining <= 0) {
				$error = "You don't have any attacks left";
			}

			if ($requires_card && !$card->isInPlay()) {
				$error = "That card is no longer in play";
			}

			if ($attack->getCard()->hasEffect(\application\entities\ModifierEffect::TYPE_STUN)) {
				$error = "This card is stunned, and cannot attack";
			}

			if (!$attack->canAfford()) {
				$error = "This attack is not available";
			}

			if (isset($error)) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(compact('error', 'actions_remaining'));
			}

			if ($requires_card) {
				$attack->perform($card);
			} else {
				$attack->perform();
			}
			$this->game->save();
			$this->game->saveAffectedCards();
			return $this->renderJSON(array('attack' => 'ok', 'actions_remaining' => $actions_remaining));
		}

		protected function _processPotion(Request $request)
		{
//			$potion_card = $this->game->getCard($request['card_id']);
			$potion_card = \application\entities\tables\Cards::getTable()->getCardByUniqueId($request['card_id']);
			$card = $this->game->getCard($request['attacked_card_id']);
			
			if (!$potion_card instanceof \application\entities\PotionItemCard) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "That is not a valid potion card", 'desync' => true));
			}

			if ($card instanceof \application\entities\Card && $card->isInPlay() && $card->getHP() > 0) {
				$potion_card->cast($this->game, $card);
				$deleted = false;
				if ($potion_card->getNumberOfUses() == 0) {
					$deleted = true;
					$potion_card->delete();
				}
				$this->game->save();
				$this->game->saveAffectedCards();
				if ($potion_card->isOneTimePotion() && $potion_card->getNumberOfUses() == 0) {
					$deleted = true;
					$potion_card->delete();
				}
				return $this->renderJSON(array('potion' => 'ok', 'deleted' => true));
			} else {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "That card is no longer in play", 'in_game' => $this->game->hasCard($card), 'in_play' => $card->isInPlay(), 'hp' => $card->getHP()));
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
			$this->getUser()->setDragDropEnabled($request['drag_drop_enabled']);
			$this->getUser()->setLowGraphicsEnabled($request['low_graphics_enabled']);
			return $this->renderJSON(array('message' => 'Settings saved!'));
		}

		protected function _processOpponentAvatar(Request $request)
		{
			$avatar_url = '/images/avatars/'.$this->game->getUserOpponent()->getAvatar();
			return $this->renderJSON(array('avatar_url' => $avatar_url, 'opponent_id' => $this->game->getUserOpponentId()));
		}

		protected function _processGameTopMenu(Request $request)
		{
			return $this->renderJSON(array('menu' => $this->getComponentHTML('game/gametopmenu', array('game' => $this->game))));
		}

		protected function _processLevelUpProfile(Request $request)
		{
			$cost = $this->getUser()->getNextLevelXp();
			if ($this->getUser()->getXp() >= $cost) {
				$this->getUser()->levelUp();
				$this->getUser()->save();
			} else {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "You do not have enough XP to level up"));
			}
			return $this->renderJSON(array('message' => 'Levelled up!', 'level' => $this->getUser()->getLevel(), 'xp' => $this->getUser()->getXp(), 'next_level_xp' => $this->getUser()->getNextLevelXp()));
		}

		protected function _processTrainSkill(Request $request)
		{
			$skill_id = $request['selected_skill'];
			$skill = \application\entities\tables\Skills::getTable()->selectById((int) $skill_id);
			if ($this->getUser()->hasTrainedSkill($skill) || !$skill->isTrainable()) {
				return $this->renderJSON(array('message' => 'This skill is not available for training', 'level' => $this->getUser()->getLevel(), 'xp' => $this->getUser()->getXp()));
			}

			if ($this->getUser()->getXp() <= $skill->getXpCost() || $skill->getRequiredLevel() > $this->getUser()->getLevel()) {
				return $this->renderJSON(array('message' => 'This skill is not available for training', 'level' => $this->getUser()->getLevel(), 'xp' => $this->getUser()->getXp()));
			}

			$this->getUser()->trainSkill($skill);
			$this->getUser()->setXp($this->getUser()->getXp() - $skill->getXpCost());
			$this->getUser()->save();
			return $this->renderJSON(array('message' => 'Skill training completed!', 'skill_trained' => (int) $skill_id, 'level' => $this->getUser()->getLevel(), 'xp' => $this->getUser()->getXp()));
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
					$this->game->resetCards();
				}
			}

			return $this->renderJSON(array('leave_game' => 'ok', 'is_adventure' => $this->game->isScenario(), 'part_id' => $this->game->getPartId()));
		}

		protected function _setupTraining(Game $game, $level)
		{
			switch ($level) {
				case \application\entities\User::AI_EASY:
					$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_easy');
					break;
				case \application\entities\User::AI_NORMAL:
					$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_normal');
					break;
				case \application\entities\User::AI_HARD:
				default:
					$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_hard');
			}
			$game->setPlayer($this->getUser());
			$game->setOpponent($ai_player);
			$game->completeQuickmatch();
			$game->setCurrentPlayer($this->getUser());
			$game->save();

			$factions = array('resistance', 'neutrals', 'rutai');
			$faction = $factions[array_rand($factions)];
			$creature_cards = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			$c_cards = \application\entities\tables\Cards::pickCards($creature_cards, $ai_player, rand(3, 7));
			foreach ($c_cards as $card_id => $card) {
				$game->addCard($card, $ai_player);
			}
			$equippable_item_cards = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$e_cards = \application\entities\tables\Cards::pickCards($equippable_item_cards, $ai_player, rand(5, 10));
			foreach ($e_cards as $card_id => $card) {
				$game->addCard($card, $ai_player);
			}

			return $game;
		}

		protected function _processTraining(Request $request)
		{
			$game = new Game();
			$this->_setupTraining($game, $request['level']);
			return $this->renderJSON(array('options' => $game->getOptions($this->getUser())));
		}

		protected function _processDisableTutorial(Request $request)
		{
			$this->getUser()->disableTutorial($request['key']);
			return $this->renderJSON(array('disable_tutorial' => array($request['key'] => 'ok')));
		}

		protected function _processEnableTutorial(Request $request)
		{
			$this->getUser()->enableTutorial($request['key']);
			return $this->renderJSON(array('enable_tutorial' => array($request['key'] => 'ok')));
		}

		protected function _processRemoveCardReward(Request $request)
		{
			$reward = \application\entities\tables\TellableCardRewards::getTable()->selectById($request['reward_id']);
			$reward->delete();
			return $this->renderJSON(array('remove_card_reward' => 'ok'));
		}

		protected function _processAddCardReward(Request $request)
		{
			$reward = new \application\entities\TellableCardReward();
			$reward->setCardUniqueId($request['card_id']);
			switch ($request['tellable_type']) {
				case \application\entities\Tellable::TYPE_ADVENTURE:
					$reward->setAdventureId($request['tellable_id']);
					break;
				case \application\entities\Tellable::TYPE_STORY:
					$reward->setStoryId($request['tellable_id']);
					break;
				case \application\entities\Tellable::TYPE_CHAPTER:
					$reward->setChapterId($request['tellable_id']);
					break;
				case \application\entities\Tellable::TYPE_PART:
					$reward->setPartId($request['tellable_id']);
					break;
			}
			$reward->save();
			return $this->renderJSON(array('reward' => $this->getTemplateHTML('admin/cardreward', array('reward' => $reward))));
		}

		protected function _processRemoveCardOpponent(Request $request)
		{
			$opponent = \application\entities\tables\TellableCardOpponents::getTable()->selectById($request['opponent_id']);
			$opponent->delete();
			return $this->renderJSON(array('remove_card_opponent' => 'ok'));
		}

		protected function _processAddCardOpponent(Request $request)
		{
			$opponent = new \application\entities\TellableCardOpponent();
			$opponent->setCardUniqueId($request['card_id']);
			$opponent->setCardLevel($request['card_level']);
			switch ($request['tellable_type']) {
				case \application\entities\Tellable::TYPE_ADVENTURE:
					$opponent->setAdventureId($request['tellable_id']);
					break;
				case \application\entities\Tellable::TYPE_STORY:
					$opponent->setStoryId($request['tellable_id']);
					break;
				case \application\entities\Tellable::TYPE_CHAPTER:
					$opponent->setChapterId($request['tellable_id']);
					break;
				case \application\entities\Tellable::TYPE_PART:
					$opponent->setPartId($request['tellable_id']);
					break;
			}
			$opponent->save();
			return $this->renderJSON(array('opponent' => $this->getTemplateHTML('admin/cardopponent', array('opponent' => $opponent))));
		}

		protected function _processStartPart(Request $request)
		{
			try {
				/**
				 * @var \application\entities\Part
				 */
				$part = \application\entities\tables\Parts::getTable()->selectById($request['part_id']);
				switch ($request['difficulty']) {
					case \application\entities\User::AI_EASY:
						$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_easy');
						break;
					case \application\entities\User::AI_NORMAL:
						$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_normal');
						break;
					case \application\entities\User::AI_HARD:
					default:
						$ai_player = \application\entities\tables\Users::getTable()->getByUsername('ai_hard');
				}
				$game = new Game();
				$game->setPlayer($this->getUser());
				$game->setPart($part);
				$game->setOpponent($ai_player);
				$game->completeQuickmatch();
				$game->setCurrentPlayer($this->getUser());
				$game->save();
				return $this->renderJSON(array('options' => $game->getOptions($this->getUser())));
			} catch (Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "This is not a valid quest"));
			}

		}

		protected function _processGetTellableAttempts(Request $request)
		{
			$results = array();
			switch ($request['tellable_type']) {
				case 'story':
					$results = \application\entities\tables\UserStories::getTable()->getAttemptsByStoryIdAndUserId($request['tellable_id'], $this->getUser()->getId());
					break;
				case 'adventure':
					$results = \application\entities\tables\UserAdventures::getTable()->getAttemptsByAdventureIdAndUserId($request['tellable_id'], $this->getUser()->getId());
					break;
				case 'chapter':
					$results = \application\entities\tables\UserChapters::getTable()->getAttemptsByChapterIdAndUserId($request['tellable_id'], $this->getUser()->getId());
					break;
				case 'part':
					$results = \application\entities\tables\UserParts::getTable()->getAttemptsByPartIdAndUserId($request['tellable_id'], $this->getUser()->getId());
					$current_attempt = Games::getTable()->getCurrentPartAttemptForUser($this->getUser()->getId(), $request['tellable_id']);
					$current_attempt = ($current_attempt instanceof Game) ? $current_attempt->getId() : 0;
					break;
			}
			$attempts = array();
			foreach ($results as $attempt) {
				$attempts[] = array('time' => date('d-m-Y H:i', $attempt['date']), 'winning' => (bool) $attempt['winning']);
			}
			return $this->renderJSON(compact('attempts', 'current_attempt'));
		}

		protected function _processGetTellableCardRewards(Request $request)
		{
			$tellable = null;
			switch ($request['tellable_type']) {
				case 'story':
					$tellable = \application\entities\tables\Stories::getTable()->selectById($request['tellable_id']);
					break;
				case 'adventure':
					$tellable = \application\entities\tables\Adventures::getTable()->selectById($request['tellable_id']);
					break;
				case 'chapter':
					$tellable = \application\entities\tables\Chapters::getTable()->selectById($request['tellable_id']);
					break;
				case 'part':
					$tellable = \application\entities\tables\Parts::getTable()->selectById($request['tellable_id']);
					break;
			}
			if (!$tellable instanceof \application\entities\Tellable) {
				return $this->renderJSON(array('message' => 'This is not a valid quest'));
			}
			$cards = array();
			foreach ($tellable->getCardRewards() as $reward) {
				$cards[] = $this->getTemplateHTML('game/card', array('card' => $reward->getCard(), 'ingame' => false, 'mode' => 'medium'));
			}
			if (count($cards)) {
				return $this->renderJSON(compact('cards'));
			} else {
				return $this->renderJSON(array('tellable_card_rewards' => 'none'));
			}
		}

		protected function _processGetTellableCardOpponents(Request $request)
		{
			$tellable = null;
			switch ($request['tellable_type']) {
				case 'part':
					$tellable = \application\entities\tables\Parts::getTable()->selectById($request['tellable_id']);
					break;
			}
			if (!$tellable instanceof \application\entities\Part) {
				return $this->renderJSON(array('message' => 'This is not a valid quest'));
			}
			$cards = array();
			foreach ($tellable->getCardOpponents() as $opponent) {
				$card = $opponent->getCard();
				if (!$card instanceof \application\entities\CreatureCard) continue;
				$cards[] = $this->getTemplateHTML('game/card', array('card' => $card, 'ingame' => false, 'mode' => 'tiny'));
			}
			if (count($cards)) {
				return $this->renderJSON(compact('cards'));
			} else {
				return $this->renderJSON(array('tellable_card_opponents' => 'none'));
			}
		}

		protected function _processBuyCard(Request $request)
		{
			$card = Cards::getTable()->getCardByUniqueId($request['card_id']);
			$user = $this->getUser();
			$cost = $card->getCost();
			$user_gold = $user->getGold();
			if ($user_gold < $cost) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => "You cannot afford this card"));
			}
			$user_card = $user->giveCard($card);
			$user->setGold($user_gold - $cost);
			$user->save();
			return $this->renderJSON(array('cost' => array('diff' => $cost, 'to' => $user->getGold()), 'card_id' => $user_card->getUniqueId()));
		}

		protected function _processGameInterface(Request $request)
		{
			$interface_part = $request['part'];
			$interface_content = '';
			switch ($interface_part) {
				case 'lobby':
					$interface_content = $this->getComponentHTML('lobby/lobbycontent');
					break;
				case 'adventure':
					$interface_content = $this->getComponentHTML('adventure/adventurecontent');
					break;
				case 'market':
					$interface_content = $this->getComponentHTML('market/marketcontent');
					break;
				case 'market_buy':
					$interface_content = $this->getComponentHTML('market/buycontent');
					break;
				case 'market_sell':
					$interface_content = $this->getComponentHTML('market/sellcontent');
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
					if ($this->game->isGameOver() || $this->game->hasCards()) {
						return $this->renderJSON(array('is_started' => 1));
					} else {
						$interface_content = $this->getComponentHTML('game/pickcardscontent', array('game' => $this->game));
					}
					break;
				case 'board':
					if (!$this->game instanceof Game) {
						return $this->renderJSON(array('game' => 'none'));
					}
					if (in_array($this->getUser()->getId(), array($this->game->getPlayer()->getId(), $this->game->getOpponent()->getId()))) {
						if (!$this->game->isGameOver() && !$this->game->hasCards()) {
							return $this->renderJSON(array('state' => 'no_cards', 'options' => $this->game->getOptions($this->getUser())));
						}
					}
					$interface_content = $this->getComponentHTML('game/boardcontent', array('game' => $this->game));
					$options = $this->game->getOptions($this->getUser());
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
					case 'profile_info':
						return $this->_processProfileInfo($request);
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
					case 'online_friends':
						return $this->_processGetOnlineFriends($request);
						break;
					case 'levelledup_card':
						return $this->_processGetLevelledUpCard($request);
						break;
					case 'card_price':
						return $this->_processGetCardPrice($request);
						break;
					case 'buy_cards':
						return $this->_processGetMarketBuyCards($request);
						break;
					case 'tellable_card_rewards':
						return $this->_processGetTellableCardRewards($request);
						break;
					case 'tellable_card_opponents':
						return $this->_processGetTellableCardOpponents($request);
						break;
					case 'tellable_attempts':
						return $this->_processGetTellableAttempts($request);
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
					case 'buy_card':
						return $this->_processBuyCard($request);
						break;
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
					case 'levelup_card':
						return $this->_processLevelUpCard($request);
						break;
					case 'set_version':
						return $this->_processSetVersion($request);
						break;
					case 'levelup_profile':
						return $this->_processLevelUpProfile($request);
						break;
					case 'disable_tutorial':
						return $this->_processDisableTutorial($request);
						break;
					case 'enable_tutorial':
						return $this->_processEnableTutorial($request);
						break;
					case 'remove_card_reward':
						return $this->_processRemoveCardReward($request);
						break;
					case 'add_card_reward':
						return $this->_processAddCardReward($request);
						break;
					case 'remove_card_opponent':
						return $this->_processRemoveCardOpponent($request);
						break;
					case 'add_card_opponent':
						return $this->_processAddCardOpponent($request);
						break;
					case 'start_part':
						return $this->_processStartPart($request);
						break;
					case 'add_friend':
						return $this->_processAddFriend($request);
						break;
					case 'remove_userfriend':
						return $this->_processRemoveFriend($request);
						break;
					case 'saveprofile':
						return $this->_processSaveProfile($request);
						break;
					case 'sell_card':
						return $this->_processSellCard($request);
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