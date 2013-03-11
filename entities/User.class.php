<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo user class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Users")
	 */
	class User extends \b2db\Saveable
	{

		const SETTING_GAME_MUSIC = 'game_music';
		const SETTING_DRAG_DROP = 'drag_drop';
		const SETTING_LOW_GRAPHICS = 'low_graphics';
		const SETTING_SYSTEM_CHAT_MESSAGES = 'system_chat_messages';
		
		const AI_HUMAN = 0;
		const AI_EASY = 1;
		const AI_NORMAL = 2;
		const AI_HARD = 3;

		const RACE_HUMAN = 1;
		const RACE_LIZARD = 2;
		const RACE_BEAST = 3;
		const RACE_ELF = 4;

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Timestamp of when the user was created
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_created_at;

		/**
		 * Unique username (login name)
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_username = '';

		/**
		 * Whether or not the user has authenticated
		 * 
		 * @var boolean
		 */
		protected $authenticated = false;

		/**
		 * Hashed password
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_password = '';

		/**
		 * User real name
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_realname = '';

		/**
		 * User email
		 *
		 * @Column(type="string", length=250)
		 * @var string
		 */
		protected $_email = '';

		/**
		 * Users language
		 *
		 * @var string
		 */
		protected $_language = '';

		/**
		 * The users group
		 *
		 * @Column(type="integer", length=10)
		 */
		protected $_group_id = null;

		/**
		 * Timestamp of when the user was last seen
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_lastseen = 0;

		/**
		 * Recent version this user played
		 *
		 * @Column(type="string", length=10)
		 * @var string
		 */
		protected $_lastversion = '';

		/**
		 * The timezone this user is in
		 *
		 * @var integer
		 */
		protected $_timezone = null;

		/**
		 * Whether the user is enabled
		 * 
		 * @Column(type="boolean", deafult=true)
		 * @var boolean
		 */
		protected $_enabled = false;

		/**
		 * Whether the user is an admin
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_isadmin = false;

		/**
		 * Whether the user is activated
		 *
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_activated = false;

		/**
		 * Whether the user is deleted
		 * 
		 * @Column(type="boolean", deafult=false)
		 * @var boolean
		 */
		protected $_deleted = false;

		/**
		 * The XP this user has
		 *
		 * @var integer
		 * @Column(type="integer", default=0, length=10)
		 */
		protected $_xp = 0;
		
		/**
		 * This users level
		 *
		 * @var integer
		 * @Column(type="integer", default=0, length=10)
		 */
		protected $_level = 1;

		/**
		 * This users gold
		 *
		 * @var integer
		 * @Column(type="integer", default=0, length=10)
		 */
		protected $_gold = 0;

		/**
		 * This users character name
		 *
		 * @var string
		 * @Column(type="string", default=null, length=250)
		 */
		protected $_charactername;
		
		/**
		 * This users avatar image
		 *
		 * @var string
		 * @Column(type="string", default="default.png", length=250)
		 */
		protected $_avatar;

		/**
		 * This users character race
		 *
		 * @var integer
		 * @Column(type="integer", default=0, length=5)
		 */
		protected $_race;

		/**
		 * This user's ai level
		 * 
		 * @Column(type="integer", default=0, length=10)
		 * @var integer
		 */
		protected $_ai_level = self::AI_HUMAN;
		
		/**
		 * This user's cards
		 * 
		 * @var array
		 */
		protected $_cards;
		
		/**
		 * This user's number of invites
		 * 
		 * @Column(type="integer", default=0, length=10)
		 * @var integer
		 */
		protected $_invites = 0;

		/**
		 * Games user is invited to
		 *
		 * @Relates(class="\application\entities\GameInvite", collection=true, foreign_column="to_player_id")
		 * @var array|\application\entities\GameInvite
		 */
		protected $_game_invites;

		/**
		 * Skills trained
		 *
		 * @Relates(class="\application\entities\Skill", collection=true, foreign_column="user_id")
		 * @var array|\application\entities\Skill
		 */
		protected $_skills;

		/**
		 * Games the user is playing
		 *
		 * @var array|\application\entities\Game
		 */
		protected $_games;

		/**
		 * This users password restore key
		 *
		 * @var string
		 * @Column(type="string", default=null, length=20)
		 */
		protected $_password_key;

		protected $_has_cards_in_faction = array();

		/**
		 * Take a raw password and convert it to the hashed format
		 * 
		 * @param string $password
		 * 
		 * @return hashed password
		 */
		public static function hashPassword($password, $salt = null)
		{
			$salt = ($salt !== null) ? $salt : Caspar::getSalt();
			return crypt($password, '$2a$07$' . $salt . '$');
		}

		public static function loginCheck($username, $password, $rehash = true)
		{
			$password = trim($password);
			$username = trim($username);
			if ($rehash && $password) {
				$password = self::hashPassword($password);
			}
			$user = self::getB2DBTable()->loginCheck($username, $password);
			if ($user instanceof User) {
				$user->updateLastSeen();
				$user->save();
			} else {
				$user = new User();
			}
			return $user;
		}

		/**
		 * Create and return a temporary password
		 *
		 * @return string
		 */
		public static function createPassword($len = 8)
		{
			$pass = '';
			$lchar = 0;
			$char = 0;
			for ($i = 0; $i < $len; $i++) {
				while ($char == $lchar) {
					$char = mt_rand(48, 109);
					if ($char > 57)
						$char += 7;
					if ($char > 90)
						$char += 6;
				}
				$pass .= chr($char);
				$lchar = $char;
			}
			return $pass;
		}

		public static function getRaceNameByRace($race)
		{
			static $races = array(
				self::RACE_HUMAN => 'Human',
				self::RACE_LIZARD => 'Lacerta',
				self::RACE_BEAST => 'Faewryn',
				self::RACE_ELF => 'Skurn'
			);

			return isset($races[$race]) ? $races[$race] : '';
		}

		/**
		 * Retrieve the users real name
		 *
		 * @return string
		 */
		public function getName()
		{
			return ($this->_realname) ? $this->_realname : $this->_username;
		}

		/**
		 * Retrieve the users id
		 *
		 * @return integer
		 */
		public function getID()
		{
			return $this->_id;
		}

		/**
		 * Retrieve this users realname and username combined
		 *
		 * @return string "Real Name (username)"
		 */
		public function getNameWithUsername()
		{
			return ($this->_realname) ? $this->_realname . ' (' . $this->_username . ')' : $this->_username;
		}

		public function __toString()
		{
			return $this->getNameWithUsername();
		}

		protected function _preSave($is_new = false)
		{
			if ($is_new) {
				$this->_created_at = time();
			}
		}

		/**
		 * Whether this user is authenticated or just an authenticated guest
		 *
		 * @return boolean
		 */
		public function isAuthenticated()
		{
			return (bool) $this->getID();
		}

		/**
		 * Set users "last seen" property to NOW
		 */
		public function updateLastSeen()
		{
			$this->_lastseen = NOW;
		}

		/**
		 * Return timestamp for when this user was last online
		 *
		 * @return integer
		 */
		public function getLastSeen()
		{
			return $this->_lastseen;
		}

		public function getCreatedAt()
		{
			return $this->_created_at;
		}

		public function setCreatedAt($created_at)
		{
			$this->_created_at = $created_at;
		}

		/**
		 * Checks whether or not the user is logged in
		 *
		 * @return boolean
		 */
		public function isLoggedIn()
		{
			return (bool) $this->_id;
		}

		/**
		 * Change the password to a new password
		 *
		 * @param string $newpassword
		 */
		public function changePassword($newpassword)
		{
			$this->_password = self::hashPassword($newpassword);
			$this->_password_key = '';
		}

		/**
		 * Alias for changePassword
		 *
		 * @param string $newpassword
		 *
		 * @see self::changePassword
		 */
		public function setPassword($newpassword)
		{
			return $this->changePassword($newpassword);
		}

		/**
		 * Whether this user is currently active on the site
		 *
		 * @return boolean
		 */
		public function isActive()
		{
			return (bool) ($this->_lastseen > (NOW - (60 * 10)));
		}

		/**
		 * Whether this user is currently inactive (but not logged out) on the site
		 *
		 * @return boolean
		 */
		public function isAway()
		{
			return (bool) (($this->_lastseen < (NOW - (60 * 10))) && ($this->_lastseen > (NOW - (60 * 30))));
		}

		/**
		 * Whether this user is currently offline (timed out or explicitly logged out)
		 *
		 * @return boolean
		 */
		public function isOffline()
		{
			return (bool) ($this->_lastseen < (NOW - (60 * 30)));
		}

		/**
		 * Whether this user is enabled or not
		 *
		 * @return boolean
		 */
		public function isEnabled()
		{
			return $this->_enabled;
		}

		/**
		 * Set whether this user is activated or not
		 *
		 * @param boolean $val[optional]
		 */
		public function setActivated($val = true)
		{
			$this->_activated = (boolean) $val;
		}

		/**
		 * Whether this user is activated or not
		 *
		 * @return boolean
		 */
		public function isActivated()
		{
			return $this->_activated;
		}

		/**
		 * Whether this user is deleted or not
		 *
		 * @return boolean
		 */
		public function isDeleted()
		{
			return $this->_deleted;
		}

		public function markAsDeleted()
		{
			$this->_deleted = true;
		}

		/**
		 * Set the username
		 *
		 * @param string $username
		 */
		public function setUsername($username)
		{
			$this->_username = $username;
		}

		/**
		 * Return this users' username
		 *
		 * @return string
		 */
		public function getUsername()
		{
			return $this->_username;
		}

		/**
		 * Returns a hash of the user password
		 *
		 * @return string
		 */
		public function getHashPassword()
		{
			return $this->_password;
		}

		/**
		 * Returns a hash of the user password
		 *
		 * @see TBGUser::getHashPassword
		 * @return string
		 */
		public function getPassword()
		{
			return $this->getHashPassword();
		}

		/**
		 * Return whether or not the users password is this
		 *
		 * @param string $password Unhashed password
		 *
		 * @return boolean
		 */
		public function hasPassword($password)
		{
			return $this->hasPasswordHash(self::hashPassword($password));
		}

		/**
		 * Return whether or not the users password is this
		 *
		 * @param string $password Hashed password
		 *
		 * @return boolean
		 */
		public function hasPasswordHash($password)
		{
			return (bool) ($password == $this->getHashPassword());
		}

		/**
		 * Returns the real name (full name) of the user
		 *
		 * @return string
		 */
		public function getRealname()
		{
			return $this->_realname;
		}

		/**
		 * Returns the email of the user
		 *
		 * @return string
		 */
		public function getEmail()
		{
			return $this->_email;
		}

		/**
		 * Set the users email address
		 *
		 * @param string $email A valid email address
		 */
		public function setEmail($email)
		{
			$this->_email = $email;
		}

		/**
		 * Set the users realname
		 *
		 * @param string $realname
		 */
		public function setRealname($realname)
		{
			$this->_realname = $realname;
		}

		/**
		 * Set whether this user is enabled or not
		 *
		 * @param boolean $val[optional]
		 */
		public function setEnabled($val = true)
		{
			$this->_enabled = $val;
		}

		/**
		 * Set whether this user is validated or not
		 *
		 * @param boolean $val[optional]
		 */
		public function setValidated($val = true)
		{
			$this->_activated = $val;
		}

		/**
		 * Get this users timezone
		 *
		 * @return mixed
		 */
		public function getTimezone()
		{
			return $this->_timezone;
		}

		/**
		 * Set this users timezone
		 *
		 * @param integer $timezone
		 */
		public function setTimezone($timezone)
		{
			$this->_timezone = $timezone;
		}

		public function setLanguage($language)
		{
			$this->_language = $language;
		}

		public function getLanguage()
		{
			return ($this->_language != '') ? $this->_language : TBGSettings::getLanguage();
		}

		public function getXp()
		{
			return $this->_xp;
		}

		public function setXp($xp)
		{
			$this->_xp = $xp;
		}

		public function addXp($amount)
		{
			$this->_xp += $amount;
		}

		public function getLevel()
		{
			return $this->_level;
		}

		public function setLevel($level)
		{
			$this->_level = $level;
		}

		public function getRace()
		{
			return $this->_race;
		}

		public function getRaceName()
		{
			return self::getRaceNameByRace($this->_race);
		}

		public function setRace($race)
		{
			$this->_race = $race;
		}

		public function getCharactername()
		{
			return $this->_charactername;
		}

		public function setCharactername($charactername)
		{
			$this->_charactername = $charactername;
		}

		public function hasCharacter()
		{
			return (bool) ($this->_charactername && $this->_race);
		}

		public function setIsAdmin($isadmin = true)
		{
			$this->_isadmin = $isadmin;
		}

		public function isAdmin()
		{
			return (bool) $this->_isadmin;
		}

		protected function _populateCards()
		{
			if ($this->_cards === null) {
				$this->_cards = array();
				$cards = array();
				foreach (array('Creature', 'EquippableItem', 'PotionItem', 'Event') as $card_type) {
					$class_name = "\application\entities\\tables\\" . $card_type . "Cards";
					$cards += $class_name::getTable()->getByUserId($this->getID());
				}
				$this->_cards = $cards;
			}
		}
		
		public function hasCards()
		{
			$this->_populateCards();
			return (bool) count($this->_cards);
		}

		/**
		 * Return all user cards
		 *
		 * @return array|Card
		 */
		public function getCards()
		{
			$this->_populateCards();
			return $this->_cards;
		}

		public function giveCard(Card $card)
		{
			$picked_card = clone $card;
			$picked_card->giveTo($this->getId());
			$picked_card = $picked_card->morph();
			$picked_card->save();
			$picked_card->setOriginalCard($card);
			$picked_card->generateUniqueDetails();
			$picked_card->save();

			return $picked_card;
		}

		protected function _pickCards($cards, $num = 5)
		{
			\application\entities\tables\Cards::pickCards($cards, $this, $num);
		}
		
		public function generateCreatureCards($faction, $num = 8)
		{
			$creature_cards = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			$this->_pickCards($creature_cards, $num);
		}
		
		public function generatePotionCards($num = 4)
		{
			$potion_item_cards = \application\entities\tables\PotionItemCards::getTable()->getAll();
			$this->_pickCards($potion_item_cards, $num);
		}

		public function generateItemCards($num = 10)
		{
			$equippable_item_cards = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$this->_pickCards($equippable_item_cards, $num);
		}

		public function generateStarterPack($faction)
		{
			$this->generateCreatureCards($faction);
			$this->generatePotionCards();
			$this->generateItemCards();
			
			$this->_populateCards();
			return $this->_cards;
		}

		public function getNextLevelXp() 
		{
			return (($this->getLevel()) * 1500) + (350 * ($this->getLevel() - 1));
		}

		public function canLevelUp()
		{
			return ($this->getXp() >= $this->getNextLevelXp());
		}

		public function levelUp()
		{
			$this->_xp -= $this->getNextLevelXp();
			$this->_level++;
		}
		
		public function getInvites()
		{
			return $this->_invites;
		}

		public function setInvites($invites)
		{
			$this->_invites = $invites;
		}

		public function getGameInvites()
		{
			return $this->_b2dbLazyload('_game_invites');
		}

		public function setAvatar($avatar)
		{
			$this->_avatar = $avatar;
		}

		public function getAvatar()
		{
			return $this->_avatar;
		}

		protected function _populateGames()
		{
			if ($this->_games === null) {
				$this->_games = \application\entities\tables\Games::getTable()->getGamesByUserId($this->getId());
			}
		}

		public function getGames()
		{
			$this->_populateGames();
			return $this->_games;
		}

		public function logout()
		{
			\application\entities\tables\ChatPings::getTable()->cleanUserPings($this->getId());
		}

		protected function _getSetting($key)
		{
			return Settings::get($key, $this->getId());
		}

		protected function _setSetting($key, $value)
		{
			return Settings::saveSetting($key, $value, $this->getId());
		}

		protected function _unsetSetting($key)
		{
			return Settings::deleteSetting($key, $this->getId());
		}

		public function isGameMusicEnabled()
		{
			return (bool) $this->_getSetting(self::SETTING_GAME_MUSIC);
		}

		public function setGameMusicEnabled($value)
		{
			$this->_setSetting(self::SETTING_GAME_MUSIC, (int) $value);
		}

		public function disableTutorial($key)
		{
			$this->_setSetting('disable_tutorial_'.$key, true);
		}

		public function enableTutorial($key)
		{
			$this->_unsetSetting('disable_tutorial_'.$key);
		}

		public function isLowGraphicsEnabled()
		{
			return (bool) $this->_getSetting(self::SETTING_LOW_GRAPHICS);
		}

		public function setLowGraphicsEnabled($value)
		{
			$this->_setSetting(self::SETTING_LOW_GRAPHICS, (int) $value);
		}

		public function isDragDropEnabled()
		{
			return (bool) $this->_getSetting(self::SETTING_DRAG_DROP);
		}

		public function setDragDropEnabled($value)
		{
			$this->_setSetting(self::SETTING_DRAG_DROP, (int) $value);
		}

		public function isSystemChatMessagesEnabled()
		{
			return (bool) $this->_getSetting(self::SETTING_SYSTEM_CHAT_MESSAGES);
		}

		public function setSystemChatMessagesEnabled($value)
		{
			$this->_setSetting(self::SETTING_SYSTEM_CHAT_MESSAGES, (int) $value);
		}

		public function getGold()
		{
			return $this->_gold;
		}

		public function setGold($gold)
		{
			$this->_gold = $gold;
		}

		public function addGold($amount)
		{
			$this->_gold += $amount;
		}
		
		protected function _aiHasUnplacedCards(Game $game, $type)
		{
			foreach ($game->getUserPlayerCards() as $card_type => $cards) {
				if ($card_type == $type) {
					foreach ($cards as $card) {
						if (!$card->getSlot()) return true;
					}
				}
			}
			
			return false;
		}
		
		protected function _aiHasPlacedCards(Game $game, $type)
		{
			foreach ($game->getUserPlayerCards() as $card_type => $cards) {
				if ($card_type == $type) {
					foreach ($cards as $card) {
						if ($card->getSlot()) return true;
					}
				}
			}
			
			return false;
		}
		
		public function _aiSortCardsNormal($card_1, $card_2)
		{
			if (!$card_1 instanceof Card) return -1;
			if (!$card_2 instanceof Card) return 1;
			$c1_val = 0;
			$c2_val = 0;
			if ($card_1->getHP() > $card_2->getHP()) {
				$c1_val += 2;
			} elseif ($card_1->getHP() < $card_2->getHP()) {
				$c2_val += 2;
			}
			if ($card_1->getEP() > $card_2->getEP()) {
				$c1_val++;
			} elseif ($card_1->getEP() < $card_2->getEP()) {
				$c2_val++;
			}
			if ($c1_val == $c2_val) return 0;
			return ($c1_val < $c2_val) ? -1 : 1;
		}
		
		public function _aiSortCardsHard($card_1, $card_2)
		{
			if (!$card_1 instanceof Card) return -1;
			if (!$card_2 instanceof Card) return 1;
			$c1_val = 0;
			$c2_val = 0;
			foreach ($card_1->getAttacks() as $attack) {
				$val = 0;
				$val += $attack->getAttackPointsMax();
				$val += $attack->getRepeatAttackPointsMax() * $attack->getRepeatRoundsMax();
				if ($val > $c1_val) $val = $c1_val;
			}
			foreach ($card_2->getAttacks() as $attack) {
				$val = 0;
				$val += $attack->getAttackPointsMax();
				$val += $attack->getRepeatAttackPointsMax() * $attack->getRepeatRoundsMax();
				if ($val > $c2_val) $val = $c2_val;
			}
			if ($c1_val == $c2_val) return 0;
			return ($c1_val < $c2_val) ? -1 : 1;
		}
		
		protected function _aiPlaceCards(Game $game)
		{
			if ($game->hasUserPlayerCards()) {
				if ($this->_aiHasUnplacedCards($game, 'creature')) {
					
					$cards = $game->getUserPlayerCards();
					$creature_cards = $cards['creature'];
					if ($this->_ai_level > self::AI_EASY) {
						foreach ($creature_cards as $card) {
							$card->getAttacks();
						}
						if ($this->_ai_level == self::AI_NORMAL) {
							usort($creature_cards, array($this, '_aiSortCardsNormal'));
						} else {
							usort($creature_cards, array($this, '_aiSortCardsNormal'));
						}
					}
					foreach (array(3, 2, 4, 1, 5) as $slot) {
						if ($game->getUserPlayerCardSlot($slot)) continue;
						if (!$this->_aiHasUnplacedCards($game, 'creature')) continue;
						
						if ($this->_ai_level == self::AI_EASY) {
							do {
								$card = $creature_cards[array_rand($cards['creature'])];
							} while ($card->getSlot());
						} else {
							do {
								if (!count($creature_cards)) break;
								$card = array_shift($creature_cards);
							} while ($card->getSlot());
						}
						
						if (rand(1, 10) > 5) $game->aiThinking($this->_ai_level);

						if ($card->isInGame()) {
							$game->setPlayerCardSlot($slot, $card);
							$card->setInGameHP($card->getBaseHP());
							$card->setInGameEP($card->getBaseEP());
							$game->addAffectedCard($card);

							if ($this->_aiHasUnplacedCards($game, 'equippable_item')) {
								$slot_1 = false;
								foreach ($cards['equippable_item'] as $i_card) {
									if ($i_card->getSlot()) continue;
									if (!$i_card->isEquippableByCard($card)) continue;

									if (!$slot_1) {
										$game->setPlayerCardSlotPowerup1($slot, $i_card);
									} else {
										$game->setPlayerCardSlotPowerup2($slot, $i_card);
										break;
									}
									$game->addAffectedCard($i_card);
								}
							}
						}
					}
				}
			}
		}
		
		protected function _aiAttack(Game $game)
		{
			$cards = $game->getCards();
			$creature_cards = $cards['creature'];
			if ($this->_ai_level == self::AI_EASY) {
				shuffle($creature_cards);
			} else {
				foreach ($creature_cards as $card) {
					$card->getAttacks();
				}
				if ($this->_ai_level == self::AI_NORMAL) {
					usort($creature_cards, array($this, '_aiSortCardsNormal'));
				} else {
					usort($creature_cards, array($this, '_aiSortCardsNormal'));
				}
			}
			for ($cc = 1; $cc <= 2; $cc++) {
				if (!$game->getCurrentPlayerActions()) break;
				foreach ($creature_cards as $card) {
					if (!$game->getCurrentPlayerActions()) break;
					if (!$card->isInPlay()) continue;
					if (!$card->getSlot()) continue;
					if ($card->hasEffect(ModifierEffect::TYPE_STUN)) continue;

					if (rand(1, 10) > 5) $game->aiThinking($this->_ai_level);

					$attacks = $card->getAttacks();
					if ($this->_ai_level == self::AI_EASY) {
						shuffle($attacks);
					} else {
						$sortable_function = function($attack_1, $attack_2) {
							if (!$attack_1 instanceof Attack) return -1;
							if (!$attack_2 instanceof Attack) return 1;
							$c1_val = 0;
							$c2_val = 0;
							$c1_val += $attack_1->getAttackPointsMax();
							$c1_val += $attack_1->getRepeatAttackPointsMax() * $attack_1->getRepeatRoundsMax();
							$c2_val += $attack_2->getAttackPointsMax();
							$c2_val += $attack_2->getRepeatAttackPointsMax() * $attack_2->getRepeatRoundsMax();
							if ($c1_val == $c2_val) return 0;
							return ($c1_val < $c2_val) ? -1 : 1;
						};
						usort($attacks, $sortable_function);
					}
					foreach ($attacks as $attack) {
						if (!$game->getCurrentPlayerActions()) break;
						if ($attack->canAfford()) {
							if (rand(1, 10) > 5) $game->aiThinking($this->_ai_level);
							$slots = range(1, 5);
							if ($this->_ai_level == self::AI_EASY) {
								shuffle($slots);
								foreach ($slots as $slot) {
									$p_card = $game->getPlayerCardSlot($slot);
									if ($p_card instanceof CreatureCard) {
										$attack->perform($p_card);
										$game->addAffectedCard($p_card);
										$game->addAffectedCard($card);
										break;
									}
								}
							} else {
								$cards = array();
								foreach ($slots as $slot) {
									$p_card = $game->getPlayerCardSlot($slot);
									if ($p_card instanceof CreatureCard) {
										$cards[] = $p_card;
									}
								}
								if (!count($cards)) break;
								$opp_sortable_function = function($card_1, $card_2) {
									$c1_val = 0;
									$c2_val = 0;
									if ($card_1->getHP() > $card_2->getHP()) {
										$c1_val += 2;
									} elseif ($card_1->getHP() < $card_2->getHP()) {
										$c2_val += 2;
									}
									if ($card_1->getEP() > $card_2->getEP()) {
										$c1_val++;
									} elseif ($card_1->getEP() < $card_2->getEP()) {
										$c2_val++;
									}
								};
								uasort($cards, $opp_sortable_function);
								if ($p_card instanceof CreatureCard) {
									$attack->perform($p_card);
									$game->addAffectedCard($p_card);
									$game->addAffectedCard($card);
								}
								break;
							}
							break;
						}
					}

					if (!$game->getCurrentPlayerActions()) break;
				}
			}
		}

		public function aiPerformTurn(Game $game)
		{
			// End replenishment
			$game->endPhase();

			// Move
			$this->_aiPlaceCards($game);
			$game->endPhase();
			
			// Actions
			if ($game->getTurnNumber() > 2) {
				$this->_aiAttack($game);
			}
			$game->endPhase();

			// End turn
			$game->endPhase();
		}
		
		public function setAiLevel($level)
		{
			$this->_ai_level = $level;
		}
		
		public function isAI()
		{
			return ($this->_ai_level > 0);
		}

        /**
         * @return array|Skill
         */
        public function getSkills()
		{
			return $this->_b2dbLazyload('_skills');
		}

        public function getAttackSkills()
        {
            $skills = $this->getSkills();
            foreach ($skills as $skill) {
                if (!$skill->hasParentSkill()) continue;
				$p_id = $skill->getParentSkillId();
                if (array_key_exists($p_id, $skills)) unset($skills[$p_id]);
            }

			return $skills;
        }

		public function hasTrainedSkill(Skill $skill)
		{
			foreach ($this->getSkills() as $trained_skill) {
				if ($trained_skill->getOriginalSkillId() == $skill->getId()) return true;
			}

			return false;
		}

		public function getTrainedSkill(Skill $skill)
		{
			foreach ($this->getSkills() as $trained_skill) {
				if ($trained_skill->getOriginalSkillId() == $skill->getId()) return $trained_skill;
			}

			return null;
		}

		public function trainSkill(Skill $skill)
		{
			$trained_skill = clone $skill;
			$trained_skill->setUser($this);
			$trained_skill->setOriginalSkill($skill);
			if ($trained_skill->hasParentSkill()) {
				$trained_skill->setParentSkill($this->getTrainedSkill($trained_skill->getParentSkill()));
			}
			$trained_skill->save();
			$this->_skills = null;
		}

		public function getOrGeneratePasswordRestoreKey()
		{
			if ($this->_password_key == '') {
				$this->_password_key = uniqid();
			}
			return $this->_password_key;
		}

		public function getLastVersion()
		{
			return $this->_lastversion;
		}

		public function setLastVersion($lastversion)
		{
			$this->_lastversion = $lastversion;
		}

		protected function _isTutorialDisabled($key)
		{
			return (bool) $this->_getSetting('disable_tutorial_'.$key);
		}

		public function isLobbyTutorialEnabled()
		{
			return !$this->_isTutorialDisabled('lobby');
		}

		public function isPickCardsTutorialEnabled()
		{
			return !$this->_isTutorialDisabled('pickcards');
		}

		public function isBoardTutorialEnabled()
		{
			return !$this->_isTutorialDisabled('board');
		}

		public function isAdventureTutorialEnabled()
		{
			return !$this->_isTutorialDisabled('adventure');
		}

		public function hasCardsInFaction($faction)
		{
			if (!array_key_exists($faction, $this->_has_cards_in_faction)) {
				$this->_has_cards_in_faction[$faction] = false;
				foreach($this->getCards() as $card) {
					if ($card instanceof CreatureCard && $card->getFaction() == $faction) {
						$this->_has_cards_in_faction[$faction] = true;
					}
				}
			}

			return $this->_has_cards_in_faction[$faction];
		}

	}
