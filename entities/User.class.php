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
		 * Games the user is playing
		 *
		 * @var array|\application\entities\Game
		 */
		protected $_games;

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
			return (bool) $this->_charactername;
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

		public function getCards()
		{
			$this->_populateCards();
			return $this->_cards;
		}

		protected function _pickCards($cards, $num = 5)
		{
			if (!count($cards)) return array();
			$pickablecards = array();
			foreach ($cards as $card) {
				if ($card->getLikelihood() == 0) continue;
				for($cc = 1;$cc <= $card->getLikelihood();$cc++) {
					$pickablecards[] = $card->getId();
				}
			}

			$return_cards = array();
			$cc = 1;
			while ($cc <= $num) {
				if (empty($pickablecards)) break;

				$id = array_rand($pickablecards);
				$card_id = $pickablecards[$id];
				if (array_key_exists($card_id, $cards)) {
					$card = $cards[$card_id];
					$picked_card = clone $card;
					$picked_card->giveTo($this);
					$picked_card = $picked_card->morph();
					$picked_card->save();
					$picked_card->setOriginalCard($card);
					$picked_card->generateUniqueDetails();
					$picked_card->save();
					$return_cards[$picked_card->getId()] = $picked_card;
					unset($pickablecards[$id]);
					$cc++;
				}
			}

			return $return_cards;
		}

		public function generateStarterPack($faction)
		{
			$creature_cards = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			$this->_pickCards($creature_cards, 8);

			$potion_item_cards = \application\entities\tables\PotionItemCards::getTable()->getAll();
			$this->_pickCards($potion_item_cards, 4);

			$equippable_item_cards = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$this->_pickCards($equippable_item_cards, 10);

//			$event_cards = \application\entities\tables\EventCards::getTable()->getAll();
//			$this->_pickCards($event_cards, 1);
			
			$this->_populateCards();
			return $this->_cards;
		}

		public function getNextLevelXp() 
		{
			return ($this->getLevel() + 1) * 100;
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

		public function getAvatar()
		{
			return 'default.png';
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

		public function isGameMusicEnabled()
		{
			return (bool) $this->_getSetting(self::SETTING_GAME_MUSIC);
		}

		public function setGameMusicEnabled($value)
		{
			$this->_setSetting(self::SETTING_GAME_MUSIC, (int) $value);
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

	}
