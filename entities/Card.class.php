<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo generic card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Cards")
	 */
	abstract class Card extends \b2db\Saveable
	{

		const TYPE_EVENT = 'event';
		const TYPE_CREATURE = 'creature';
		const TYPE_EQUIPPABLE_ITEM = 'equippable_item';
		const TYPE_POTION_ITEM = 'potion_item';

		const FACTION_NEUTRALS = 'neutrals';
		const FACTION_RUTAI = 'rutai';
		const FACTION_RESISTANCE = 'resistance';
		const FACTION_WORLD = 'world';

		const STATE_TEMPLATE = 'template';
		const STATE_OWNED = 'owned';

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Card state
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_card_state = Card::STATE_TEMPLATE;
		
		/** 
		 * If owned, the user_id who owns this card
		 * 
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\User")
		 * 
		 * @var \application\entities\User
		 */
		protected $_user_id;

		/**
		 * If in a game, the game_card of the game
		 *
		 * @var \application\entities\GameCard
		 */
		protected $_game_card;

		/**
		 * If owned, the original card id
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\CreatureCard")
		 *
		 * @var \application\entities\CreatureCard
		 */
		protected $_original_card_id;

		/**
		 * If in a game, the slot the card is on
		 *
		 * @var integer
		 */
		protected $_slot;

		/**
		 * Whether the card is a in play or not
		 *
		 * @var boolean
		 */
		protected $_is_in_play = false;

		/**
		 * Whether this card is using powerup slot 1
		 *
		 * @var boolean
		 */
		protected $_powerup_slot_1 = false;

		/**
		 * Whether this card is using powerup slot 2
		 *
		 * @var boolean
		 */
		protected $_powerup_slot_2 = false;

		/**
		 * Current in-game health
		 *
		 * @var integer
		 */
		protected $_in_game_health = 1;

		/**
		 * Current in-game health
		 *
		 * @var integer
		 */
		protected $_in_game_ep = 1;

		/**
		 * Card name
		 *
		 * @Column(type="string", length=200)
		 * @var string
		 */
		protected $_name = '';

		/**
		 * Brief card description
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_brief_description = '';

		/**
		 * Card description
		 *
		 * @Column(type="text")
		 * @var string
		 */
		protected $_long_description = '';

		/**
		 * What the card costs to buy
		 *
		 * @Column(type="integer", default=50)
		 * @var integer
		 */
		protected $_cost = 50;

		/**
		 * Number of cards in the entire deck
		 *
		 * @Column(type="integer", default=50)
		 * @var integer
		 */
		protected $_likelihood = 50;

		/**
		 * Whether the card is a special card or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_special_card = false;

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = null;

		/**
		 * Gold per turn increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_increase_player = 0;

		/**
		 * Gold per turn decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_decrease_player = 0;

		/**
		 * Gold per turn increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_increase_opponent = 0;

		/**
		 * Gold per turn decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_gpt_decrease_opponent = 0;

		/**
		 * GPT randomness factor
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_gpt_randomness = 0;

		/**
		 * Magic per turn increase (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_increase_player = 0;

		/**
		 * Magic per turn decrease (player)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_decrease_player = 0;

		/**
		 * Magic per turn increase (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_increase_opponent = 0;

		/**
		 * Magic per turn decrease (opponent)
		 *
		 * @Column(type="integer", length=10, default=0)
		 */
		protected $_mpt_decrease_opponent = 0;

		/**
		 * MPT randomness factor
		 *
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_mpt_randomness = 0;

		public static function getFactions()
		{
			return array(
				self::FACTION_NEUTRALS => 'Highwinds',
				self::FACTION_RESISTANCE => 'Hologev',
				self::FACTION_RUTAI => 'Rutai',
				self::FACTION_WORLD => 'World'
			);
		}

		protected function _postSave($is_new)
		{
			if ($this->_game_card instanceof GameCard) {
				$this->_game_card->setSlot($this->_slot);
				$this->_game_card->setInGameEP($this->_in_game_ep);
				$this->_game_card->setInGameHP($this->_in_game_health);
				$this->_game_card->setIsInPlay($this->_is_in_play);
				$this->_game_card->setPowerupSlot1($this->_powerup_slot_1);
				$this->_game_card->setPowerupSlot2($this->_powerup_slot_2);
				$this->_game_card->save();
			}
		}

		public function getId()
		{
			return $this->_id;
		}

		public function getUniqueId()
		{
			return $this->getCardType() . '_' . $this->getId();
		}

		public function setId($id)
		{
			$this->_id = $id;
		}

		public function getName()
		{
			return $this->_name;
		}

		public function setName($name)
		{
			$this->_name = $name;
		}

		public function getCost()
		{
			return $this->_cost;
		}

		public function setCost($cost)
		{
			$this->_cost = $cost;
		}

		public function getLikelihood()
		{
			return $this->_likelihood;
		}

		public function setLikelihood($likelihood)
		{
			$this->_likelihood = $likelihood;
		}

		public function getBriefDescription()
		{
			return $this->_brief_description;
		}

		public function setBriefDescription($brief_description)
		{
			$this->_brief_description = $brief_description;
		}

		public function getLongDescription()
		{
			return $this->_long_description;
		}

		public function setLongDescription($long_description)
		{
			$this->_long_description = $long_description;
		}

		public function getCardType()
		{
			return $this->_card_type;
		}

		public function setCardType($card_type)
		{
			$this->_card_type = $card_type;
		}

		public function getIsSpecialCard()
		{
			return (bool) $this->_is_special_card;
		}

		public function isSpecialCard()
		{
			return $this->getIsSpecialCard();
		}

		public function setIsSpecialCard($is_special_card = true)
		{
			$this->_is_special_card = (bool) $is_special_card;
		}

		public function resolve()
		{
			
		}

		public function getGPTIncreasePlayer()
		{
			return $this->_gpt_increase_player;
		}

		public function setGPTIncreasePlayer($gpt_increase_player)
		{
			$this->_gpt_increase_player = $gpt_increase_player;
		}

		public function getGPTDecreasePlayer()
		{
			return $this->_gpt_decrease_player;
		}

		public function setGPTDecreasePlayer($gpt_decrease_player)
		{
			$this->_gpt_decrease_player = $gpt_decrease_player;
		}

		public function getGPTIncreaseOpponent()
		{
			return $this->_gpt_increase_opponent;
		}

		public function setGPTIncreaseOpponent($gpt_increase_opponent)
		{
			$this->_gpt_increase_opponent = $gpt_increase_opponent;
		}

		public function getGPTDecreaseOpponent()
		{
			return $this->_gpt_decrease_opponent;
		}

		public function setGPTDecreaseOpponent($gpt_decrease_opponent)
		{
			$this->_gpt_decrease_opponent = $gpt_decrease_opponent;
		}

		public function getGPTPlayerModifier()
		{
			return $this->getGPTDecreasePlayer() + $this->getGPTIncreasePlayer();
		}

		public function getGPTOpponentModifier()
		{
			return $this->getGPTDecreaseOpponent() + $this->getGPTIncreaseOpponent();
		}
		
		public function getGPTRandomness()
		{
			return $this->_gpt_randomness;
		}

		public function setGPTRandomness($gpt_randomness)
		{
			$this->_gpt_randomness = $gpt_randomness;
		}

		public function getMPTIncreasePlayer()
		{
			return $this->_mpt_increase_player;
		}

		public function setMPTIncreasePlayer($mpt_increase_player)
		{
			$this->_mpt_increase_player = $mpt_increase_player;
		}

		public function getMPTDecreasePlayer()
		{
			return $this->_mpt_decrease_player;
		}

		public function setMPTDecreasePlayer($mpt_decrease_player)
		{
			$this->_mpt_decrease_player = $mpt_decrease_player;
		}

		public function getMPTIncreaseOpponent()
		{
			return $this->_mpt_increase_opponent;
		}

		public function setMPTIncreaseOpponent($mpt_increase_opponent)
		{
			$this->_mpt_increase_opponent = $mpt_increase_opponent;
		}

		public function getMPTDecreaseOpponent()
		{
			return $this->_mpt_decrease_opponent;
		}

		public function setMPTDecreaseOpponent($mpt_decrease_opponent)
		{
			$this->_mpt_decrease_opponent = $mpt_decrease_opponent;
		}

		public function getMPTPlayerModifier()
		{
			return $this->getMPTDecreasePlayer() + $this->getMPTIncreasePlayer();
		}

		public function getMPTOpponentModifier()
		{
			return $this->getMPTDecreaseOpponent() + $this->getMPTIncreaseOpponent();
		}

		public function getMPTRandomness()
		{
			return $this->_mpt_randomness;
		}

		public function setMPTRandomness($mpt_randomness)
		{
			$this->_mpt_randomness = $mpt_randomness;
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			foreach (array('name', 'brief_description', 'long_description') as $field) {
				$property_name = "_{$field}";
				$this->$property_name = (string) stripslashes($form_data[$field]);
			}
			$this->_is_special_card = (bool) $form_data['is_special_card'];
			foreach (array('cost', 'likelihood') as $field) {
				$property_name = "_{$field}";
				$this->$property_name = (integer) $form_data[$field];
			}
			$this->_gpt_increase_opponent = 0;
			$this->_gpt_decrease_opponent = 0;
			$this->_gpt_increase_player = 0;
			$this->_gpt_decrease_player = 0;
			foreach (array('gpt') as $resource) {
				foreach (array('player', 'opponent') as $pl) {
					$property_name = "_{$resource}_".$form_data["{$resource}_{$pl}"]."_{$pl}";
					$this->$property_name = (int) $form_data["{$resource}_{$pl}_modifier"];
				}
				$randomness_property_name = "_{$resource}_randomness";
				$this->$randomness_property_name = $form_data[$randomness_property_name];
			}
			if ($form_data->hasFileUploads()) {
				$form_data->handleUpload('card_image', $this->getKey() . '.png', DEVO_CARD_UPLOAD_PATH);
			}
		}

		public function getKey()
		{
			return strtolower(str_replace(' ', '', $this->_name));
		}
		
		public function setCardState($state)
		{
			$this->_card_state = $state;
		}
		
		public function getCardState()
		{
			return $this->_card_state;
		}
		
		public function isOwned()
		{
			return ($this->_card_state == self::STATE_OWNED);
		}
		
		public function setUserId($user_id)
		{
			$this->_user_id = $user_id;
		}
		
		public function setUser($user)
		{
			$this->_user_id = $user;
		}

		/**
		 * Return the user associated with this card
		 *
		 * @return User
		 */
		public function getUser()
		{
			return $this->_b2dbLazyload('_user_id');
		}

		public function getUserId()
		{
			return ($this->_user_id instanceof User) ? $this->_user_id->getId() : (int) $this->_user_id;
		}

		/**
		 * Returns the currently assigned game
		 *
		 * @return Game
		 */
		public function getGame()
		{
			return $this->getGameCard()->getGame();
		}
		
		public function getGameId()
		{
			return ($this->_game_card instanceof GameCard) ? $this->_game_card->getGame()->getId() : 0;
		}

		public function getOriginalCard()
		{
			return $this->_b2dbLazyload('_original_card_id');
		}

		public function getOriginalCardId()
		{
			return ($this->_original_card_id instanceof Card) ? $this->_original_card_id->getId() : $this->_original_card_id;
		}

		public function setOriginalCardId($original_card_id)
		{
			$this->_original_card_id = $original_card_id;
		}

		public function setOriginalCard(Card $original_card_id)
		{
			$this->_original_card_id = $original_card_id;
		}

		public function giveTo($user)
		{
			$this->_card_state = self::STATE_OWNED;
			$this->_user_id = $user;
		}

		/**
		 * The connected game card
		 *
		 * @return GameCard
		 */
		public function getGameCard()
		{
			return $this->_game_card;
		}

		public function setGameCard(GameCard $game_card)
		{
			$this->_game_card = $game_card;
		}

		public function removeGameCard()
		{
			$this->_game_card = null;
		}

		public function getPowerupSlot1()
		{
			return $this->_powerup_slot_1;
		}

		public function isPowerupSlot1()
		{
			return $this->getPowerupSlot1();
		}

		public function setPowerupSlot1($powerup_slot_1 = true)
		{
			$this->_powerup_slot_1 = $powerup_slot_1;
		}

		public function getPowerupSlot2()
		{
			return $this->_powerup_slot_2;
		}

		public function isPowerupSlot2()
		{
			return $this->getPowerupSlot2();
		}

		public function setPowerupSlot2($powerup_slot_2 = true)
		{
			$this->_powerup_slot_2 = $powerup_slot_2;
		}

		public function isInGame()
		{
			return ($this->_game_card instanceof GameCard);
		}

		public function getIsInPlay()
		{
			return (bool) $this->_is_in_play;
		}

		public function isInPlay()
		{
			return $this->getIsInPlay();
		}

		public function setIsInPlay($is_in_play = true)
		{
			$this->_is_in_play = (bool) $is_in_play;
		}

		public function setSlot($slot)
		{
			$this->_slot = $slot;
		}

		public function getSlot()
		{
			return $this->_slot;
		}

		public function getInGameHealth()
		{
			return (int) $this->_in_game_health;
		}

		public function getInGameHP()
		{
			return $this->getInGameHealth();
		}

		public function setInGameHealth($in_game_health)
		{
			$this->_in_game_health = (int) $in_game_health;
		}

		public function setInGameHP($hp)
		{
			$this->setInGameHealth($hp);
		}

		public function removeHP($dmg)
		{
			$this->_in_game_health -= $dmg;
			if ($this->_in_game_health < 0) $this->_in_game_health = 0;
		}

		public function getInGameEP()
		{
			return (int) $this->_in_game_ep;
		}

		public function setInGameEP($in_game_ep)
		{
			$this->_in_game_ep = (int) $in_game_ep;
		}

		public function removeEP($dmg)
		{
			$this->_in_game_ep -= $dmg;
			if ($this->_in_game_ep < 0) $this->_in_game_ep = 0;
		}

	}
