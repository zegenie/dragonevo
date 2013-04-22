<?php 

	namespace application\modules\admin;

	use application\entities\EventCard,
		application\entities\table\EventCards,
		application\entities\tables\Users;

	use caspar\core\Request;

	/**
	 * Actions for the market module
	 */
	class Actions extends \caspar\core\Actions
	{

		public function preExecute(Request $request, $action)
		{
			$this->forward403Unless($this->getUser()->isAdmin());
			$this->getResponse()->setFullscreen(false);
		}

		/**
		 * Index page
		 *  
		 * @param Request $request
		 */
		public function runIndex(Request $request)
		{
			$this->registered_users = array('total' => Users::getTable()->getNumberOfRegisteredUsers(),
											'last_week' => Users::getTable()->getNumberOfRegisteredUsersLastWeek(),
											'last_24' => Users::getTable()->getNumberOfRegisteredUsersLast24Hours());
			$this->loggedin_users = array('total' => Users::getTable()->getNumberOfLoggedInUsers(),
										'last_week' => Users::getTable()->getNumberOfLoggedInUsersLastWeek(),
										'last_24' => Users::getTable()->getNumberOfLoggedInUsersLast24Hours());
			
			$this->itemcards = \application\entities\tables\EquippableItemCards::getTable()->getNumberOfUserCards();
			$this->eventcards = \application\entities\tables\EventCards::getTable()->getNumberOfUserCards();
			$this->creaturecards = \application\entities\tables\CreatureCards::getTable()->getNumberOfUserCards();
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
				case 'equippable_item':
					$this->getResponse()->setTemplate('admin/equippableitemcards');
					$this->redirect('editEquippableItemCards');
					break;
				case 'potion_item':
					$this->getResponse()->setTemplate('admin/potionitemcards');
					$this->redirect('editPotionItemCards');
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
				case 'equippable_item':
					$this->getResponse()->setTemplate('admin/equippableitemcard');
					$this->redirect('editEquippableItemCard');
					break;
				case 'potion_item':
					$this->getResponse()->setTemplate('admin/potionitemcard');
					$this->redirect('editPotionItemCard');
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

		public function runEditEquippableItemCards(Request $request)
		{
			$this->cards = \application\entities\tables\EquippableItemCards::getTable()->getAll();
		}

		public function runEditPotionItemCards(Request $request)
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
						foreach (\application\entities\tables\EventCards::getTable()->getDescendantCards($this->card->getId()) as $card) {
							$card->mergeFormData($request);
							$card->save();
						}
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
						foreach (\application\entities\tables\CreatureCards::getTable()->getDescendantCards($this->card->getId()) as $card) {
							$card->mergeFormData($request);
							$card->save();
						}
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'creature')));
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runEditEquippableItemCard(Request $request)
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
						foreach (\application\entities\tables\EquippableItemCards::getTable()->getDescendantCards($this->card->getId()) as $card) {
							$card->mergeFormData($request);
							$card->save();
						}
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'equippable_item')));
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runEditPotionItemCard(Request $request)
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
						foreach (\application\entities\tables\PotionItemCards::getTable()->getDescendantCards($this->card->getId()) as $card) {
							$card->mergeFormData($request);
							$card->save();
						}
						$this->forward($this->getRouting()->generate('edit_card', array('card_id' => $this->card->getB2DBID(), 'card_type' => 'potion_item')));
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
			$equippable_item = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$event = \application\entities\tables\EventCards::getTable()->getAll();
			$creature = array();
			foreach (\application\entities\Card::getFactions() as $faction => $description) {
				$creature[$faction] = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			}
			$this->cards = compact('equippable_item', 'potion_item', 'event', 'creature');
		}

		public function runSkills(Request $request)
		{
			$this->skills_human = \application\entities\tables\Skills::getTable()->getSkillsByRace(\application\entities\User::RACE_HUMAN);
			$this->skills_lizard = \application\entities\tables\Skills::getTable()->getSkillsByRace(\application\entities\User::RACE_LIZARD);
			$this->skills_beast = \application\entities\tables\Skills::getTable()->getSkillsByRace(\application\entities\User::RACE_BEAST);
			$this->skills_elf = \application\entities\tables\Skills::getTable()->getSkillsByRace(\application\entities\User::RACE_ELF);
		}

		public function runEditSkill(Request $request)
		{
			$skill_id = $request['skill_id'];

			try {
				if ($skill_id) {
					$this->skill = new \application\entities\Skill($skill_id);
				} else {
					$this->skill = new \application\entities\Skill();
					if ($request['race']) {
						switch ($request['race']) {
							case \application\entities\User::RACE_HUMAN:
								$this->skill->setRaceHuman();
								break;
							case \application\entities\User::RACE_LIZARD:
								$this->skill->setRaceLizard();
								break;
							case \application\entities\User::RACE_BEAST:
								$this->skill->setRaceBeast();
								break;
							case \application\entities\User::RACE_ELF:
								$this->skill->setRaceElf();
								break;
						}
					}
					if ($request['parent_skill_id']) {
						$this->skill->setParentSkill($request['parent_skill_id']);
						if ($this->skill->getParentSkill()->getRaceHuman()) $this->skill->setRaceHuman(true);
						if ($this->skill->getParentSkill()->getRaceLizard()) $this->skill->setRaceLizard(true);
						if ($this->skill->getParentSkill()->getRaceBeast()) $this->skill->setRaceBeast(true);
						if ($this->skill->getParentSkill()->getRaceElf()) $this->skill->setRaceElf(true);
					}
				}
			} catch (\Exception $e) {
				return $this->return404('This is not a valid skill');
			}

			try {
				if (!$this->skill instanceof \application\entities\Skill) {
					return $this->return404('This is not a valid skill');
				} else {
					if ($request->isPost()) {
						$this->skill->mergeFormData($request);
						$this->skill->save();
						$this->forward($this->getRouting()->generate('edit_skill', array('skill_id' => $this->skill->getB2DBID())));
					} else {
						$this->subskills = \application\entities\tables\Skills::getTable()->getSubSkills($this->skill->getB2DBID());
					}
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}

		public function runTellables(Request $request)
		{
			$this->tellable_type = $request['tellable_type'];
			switch ($this->tellable_type) {
				case 'adventure':
					$this->tellables = \application\entities\tables\Adventures::getTable()->getAll();
					break;
				default:
					$this->tellables = \application\entities\tables\Stories::getTable()->getAll();
			}
		}

		public function runEditTellable(Request $request)
		{
			switch ($request['tellable_type']) {
				case 'story':
					$this->tellable = new \application\entities\Story($request['tellable_id']);
					break;
				case 'chapter':
					$this->tellable = new \application\entities\Chapter($request['tellable_id']);
					if (!$this->tellable->getB2DBID()) {
						$this->tellable->setStoryId($request['parent_id']);
						$this->tellable->setAppliesNeutrals($this->tellable->getStory()->getAppliesNeutrals());
						$this->tellable->setAppliesRutai($this->tellable->getStory()->getAppliesRutai());
						$this->tellable->setAppliesResistance($this->tellable->getStory()->getAppliesResistance());
					}
					break;
				case 'part':
					$this->tellable = new \application\entities\Part($request['tellable_id']);
					if (!$this->tellable->getB2DBID() && !$request->isPost()) {
						if ($request['parent_type'] == 'chapter') {
							$this->tellable->setChapterId($request['parent_id']);
							$parent = $this->tellable->getChapter();
						} else {
							$this->tellable->setAdventureId($request['parent_id']);
							$parent = $this->tellable->getAdventure();
						}
						$this->tellable->setAppliesNeutrals($parent->getAppliesNeutrals());
						$this->tellable->setAppliesRutai($parent->getAppliesRutai());
						$this->tellable->setAppliesResistance($parent->getAppliesResistance());
					}
					break;
				case 'adventure':
					$this->tellable = new \application\entities\Adventure($request['tellable_id']);
					break;
			}
			if ($request->isPost()) {
				$this->tellable->mergeFormData($request);
				$this->tellable->save();
				$this->forward($this->getRouting()->generate('edit_tellable', array('tellable_type' => $this->tellable->getTellableType(), 'tellable_id' => $this->tellable->getB2DBID())));
			}
		}

		public function runDeleteTellable(Request $request)
		{
			$params = array();
			switch ($request['tellable_type']) {
				case 'story':
					$this->tellable = new \application\entities\Story($request['tellable_id']);
					$route = 'admin_tellables';
					$params = array('tellable_type' => 'story');
					break;
				case 'chapter':
					$this->tellable = new \application\entities\Chapter($request['tellable_id']);
					$route = 'edit_tellable';
					$params = array('tellable_type' => $this->tellable->getParentType(), 'tellable_id' => $this->tellable->getParentId());
					break;
				case 'part':
					$this->tellable = new \application\entities\Part($request['tellable_id']);
					$route = 'edit_tellable';
					$params = array('tellable_type' => $this->tellable->getParentType(), 'tellable_id' => $this->tellable->getParentId());
					break;
				case 'adventure':
					$this->tellable = new \application\entities\Adventure($request['tellable_id']);
					$route = 'admin_tellables';
					$params = array('tellable_type' => 'adventure');
					break;
			}
			if ($request->isPost()) {
				$this->tellable->delete();
				$this->forward($this->getRouting()->generate($route, $params));
			}
		}

		public function runNews(Request $request)
		{
			$this->all_news = \application\entities\tables\News::getTable()->getAll();
		}

		public function runEditNews(Request $request)
		{
			$news = new \application\entities\News($request['id']);
			if ($request->isPost()) {
				$news->setTitle($request['title']);
				$news->setContent(stripslashes($request->getRawParameter('content')));
				$news->setUrl($request['news_url']);
				$news->setCreatedAt(mktime($request['hour'], $request['minute'], $request['second'], $request['month'], $request['day'], $request['year']));
				$news->save();
				$this->forward($this->getRouting()->generate('edit_news', array('id' => $news->getId())));
			}
			$this->news = $news;
		}
		
		public function runEditAttack(Request $request)
		{
			try {
				$attack = new \application\entities\Attack($request['attack_id']);
				$attack->mergeFormData($request);
				foreach (\application\entities\tables\Attacks::getTable()->getDescendantAttacks($attack->getId()) as $att) {
					$card_id = $att->getCardID();
					$att->mergeFormData($request);
					$att->setCardId($card_id);
					$att->save();
				}
				$attack->save();
			} catch (\Exception $e) {
				$this->getResponse()->setHttpStatus(400);
				return $this->renderJSON(array('error' => $e->getMessage()));
			}
			return $this->renderJSON(array('message' => $this->getI18n()->__('Attack saved'), 'content' => Actions::returnTemplateHTML('admin/cardattack', compact('attack'))));
		}

		public function runResetUserCards(Request $request)
		{
			\application\entities\tables\EventCards::getTable()->removeUserCards();
			\application\entities\tables\CreatureCards::getTable()->removeUserCards();
			\application\entities\tables\PotionItemCards::getTable()->removeUserCards();
			\application\entities\tables\EquippableItemCards::getTable()->removeUserCards();
			$this->forward($this->getRouting()->generate('admin'));
		}

		public function runResetGames(Request $request)
		{
			\application\entities\tables\Games::getTable()->create();
			\application\entities\tables\GameInvites::getTable()->create();
			\application\entities\tables\GameEvents::getTable()->create();
			\application\entities\tables\ChatRooms::getTable()->resetChatRooms();
			\application\entities\tables\ChatLines::getTable()->resetChatLines();
			\application\entities\tables\EventCards::getTable()->resetUserCards();
			\application\entities\tables\CreatureCards::getTable()->resetUserCards();
			\application\entities\tables\PotionItemCards::getTable()->resetUserCards();
			\application\entities\tables\EquippableItemCards::getTable()->resetUserCards();
			\application\entities\tables\ModifierEffects::getTable()->removeEffects();
			
			$this->forward($this->getRouting()->generate('admin'));
		}

		public function runGames(Request $request)
		{
			$this->games = \application\entities\tables\Games::getTable()->getAllByState($request['mode'], $request['type']);
			$this->mode = $request['mode'];
			$this->type = $request['type'];
		}

		public function runUsers(Request $request)
		{
			$this->users = \application\entities\tables\Users::getTable()->getAll();
		}

		public function runListUsers(Request $request)
		{
			$users = \application\entities\tables\Users::getTable()->getAll();
			$emails = array();
			foreach ($users as $user) {
				if (filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) $emails[] = $user->getEmail();
			}

			$this->emails = $emails;
		}

		protected function _processResetUserCards(Request $request)
		{
			if ($request['user_id'] && (int) $request['user_id'] > 0) {
				$user_id = (int) $request['user_id'];
				\application\entities\tables\EventCards::getTable()->resetUserCards(null, $user_id);
				\application\entities\tables\CreatureCards::getTable()->resetUserCards(null, $user_id);
				\application\entities\tables\PotionItemCards::getTable()->resetUserCards(null, $user_id);
				\application\entities\tables\EquippableItemCards::getTable()->resetUserCards(null, $user_id);
				return $this->renderJSON(array('reset_cards' => 'ok', 'message' => 'User cards has been reset'));
			} else {
				return $this->renderJSON(array('reset_cards' => 'failed', 'error' => 'That is not a valid user id'));
			}
		}
		
		protected function _processRemoveUserCards(Request $request)
		{
			if ($request['user_id'] && (int) $request['user_id'] > 0) {
				$user_id = (int) $request['user_id'];
				\application\entities\tables\EventCards::getTable()->removeUserCards($user_id);
				\application\entities\tables\CreatureCards::getTable()->removeUserCards($user_id);
				\application\entities\tables\PotionItemCards::getTable()->removeUserCards($user_id);
				\application\entities\tables\EquippableItemCards::getTable()->removeUserCards($user_id);
				return $this->renderJSON(array('reset_cards' => 'ok', 'message' => 'User cards has been removed'));
			} else {
				return $this->renderJSON(array('reset_cards' => 'failed', 'error' => 'That is not a valid user id'));
			}
		}

		protected function _processResetUserCharacter(Request $request)
		{
			if ($request['user_id'] && (int) $request['user_id'] > 0) {
				$user_id = (int) $request['user_id'];
				$user = new \application\entities\User($user_id);
				$user->setLevel(1);
				$user->setRace(0);
				$user->setCharactername('');
				$user->setAvatar('default.png');
				$user->save();
				\application\entities\tables\Skills::getTable()->removeSkillsByUserId($user_id);
				return $this->renderJSON(array('reset_cards' => 'ok', 'message' => 'User skills and level has been reset'));
			} else {
				return $this->renderJSON(array('reset_cards' => 'failed', 'error' => 'That is not a valid user id'));
			}
		}

		protected function _processUserNewStarterPack(Request $request)
		{
			if ($request['user_id'] && (int) $request['user_id'] > 0) {
				$user_id = (int) $request['user_id'];
				$user = new \application\entities\User($user_id);
				$user->generateStarterPack($request['faction']);
				return $this->renderJSON(array('reset_cards' => 'ok', 'message' => "User has got new starter pack"));
			} else {
				return $this->renderJSON(array('reset_cards' => 'failed', 'error' => 'That is not a valid user id'));
			}
		}
		
		protected function _processUserNewPotionPack(Request $request)
		{
			if ($request['user_id'] && (int) $request['user_id'] > 0) {
				$user_id = (int) $request['user_id'];
				$user = new \application\entities\User($user_id);
				$user->generatePotionCards(5);
				return $this->renderJSON(array('reset_cards' => 'ok', 'message' => "User has got 5 new potions"));
			} else {
				return $this->renderJSON(array('reset_cards' => 'failed', 'error' => 'That is not a valid user id'));
			}
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
					case 'reset_user_cards':
						return $this->_processResetUserCards($request);
						break;
					case 'reset_user_character':
						return $this->_processResetUserCharacter($request);
						break;
					case 'remove_user_cards':
						return $this->_processRemoveUserCards($request);
						break;
					case 'user_new_starter_pack':
						return $this->_processUserNewStarterPack($request);
						break;
					case 'user_new_potion_pack':
						return $this->_processUserNewPotionPack($request);
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