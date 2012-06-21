<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\PotionItemCards")
	 */
	class PotionItemCard extends ItemCard
	{

		/**
		 * Card type
		 *
		 * @Column(type="string", length=20)
		 */
		protected $_card_type = Card::TYPE_POTION_ITEM;

		/**
		 * Turn duration
		 *
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_turn_duration = 1;

		/**
		 * @Column(type="integer", length=10, default=1)
		 * @var integer
		 */
		protected $_number_of_uses = 1;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_one_time_potion = true;

		/**
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_is_used = true;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_restores_health_percentage = 0;

		/**
		 * @Column(type="integer", length=10, default=0)
		 * @var integer
		 */
		protected $_restores_energy_percentage = 0;

		/**
		 * Item class
		 *
		 * @Column(type="integer", length=10, not_null=true, default=10)
		 * @var integer
		 */
		protected $_item_class = ItemCard::CLASS_POTION_HEALTH;

		public static function getPotionTypes()
		{
			return array(
				self::CLASS_POTION_HEALTH => 'Health potion',
				self::CLASS_POTION_ALTERATION => 'Boost potion'
			);
		}

		public function getTurnDuration()
		{
			return $this->_turn_duration;
		}

		public function setTurnDuration($turn_duration)
		{
			$this->_turn_duration = $turn_duration;
		}

		public function getNumberOfUses()
		{
			return $this->_number_of_uses;
		}

		public function setNumberOfUses($number_of_uses)
		{
			$this->_number_of_uses = $number_of_uses;
		}

		public function getIsOneTimePotion()
		{
			return $this->_is_one_time_potion;
		}

		public function isOneTimePotion()
		{
			return $this->getIsOneTimePotion();
		}

		public function setIsOneTimePotion($is_one_time_potion)
		{
			$this->_is_one_time_potion = $is_one_time_potion;
		}

		public function getRestoresHealthPercentage()
		{
			return $this->_restores_health_percentage;
		}

		public function setRestoresHealthPercentage($restores_health_percentage)
		{
			$this->_restores_health_percentage = $restores_health_percentage;
		}

		public function getRestoresEnergyPercentage()
		{
			return $this->_restores_energy_percentage;
		}

		public function setRestoresEnergyPercentage($restores_energy_percentage)
		{
			$this->_restores_energy_percentage = $restores_energy_percentage;
		}

		public function getPotionType()
		{
			return $this->getItemClass();
		}

		public function setPotionType($potion_type)
		{
			$this->setItemClass($potion_type);
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			parent::mergeFormData($form_data);
			$this->setPotionType($form_data['item_class']);
			$this->_is_one_time_potion = (bool) $form_data['is_one_time_potion'];
			$this->_number_of_uses = (bool) $form_data['number_of_uses'];
			if ($this->getPotionType() == ItemCard::CLASS_POTION_ALTERATION) {
				$this->_turn_duration = $form_data['turn_duration'];
			}
			elseif ($this->getPotionType() == ItemCard::CLASS_POTION_HEALTH) {
				$this->_restores_health_percentage = $form_data['restores_health_percentage'];
				$this->_restores_energy_percentage = $form_data['restores_energy_percentage'];
			}
		}

		public function cast(Game $game, CreatureCard $card)
		{
			if ($this->getNumberOfUses()) {
				$this->_number_of_uses--;
				$game->useAction();
				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_ATTACK);
				$event->setEventData(array(
										'player_id' => $game->getCurrentPlayerId(),
										'remaining_actions' => $game->getCurrentPlayerActions(),
										'attacking_card_id' => $this->getUniqueId(),
										'attacking_card_name' => $this->getName(),
										'attacked_card_id' => $card->getUniqueId(),
										'attacked_card_name' => $card->getName()
										));
				$game->addEvent($event);

				if ($this->getRestoresHealthPercentage()) {
					$old_hp = $card->getInGameHP();
					$hp = $old_hp + ceil(($card->getBaseHP() / 100) * $this->getRestoresHealthPercentage());
					if ($hp > $card->getBaseHP()) $hp = $card->getBaseHP();
					$card->setInGameHP($hp);

					$event = new GameEvent();
					$event->setEventType(GameEvent::TYPE_RESTORE_HEALTH);
					$event->setEventData(array(
											'player_id' => $game->getCurrentPlayerId(),
											'attacking_card_id' => $this->getUniqueId(),
											'attacking_card_name' => $this->getName(),
											'attacked_card_id' => $card->getUniqueId(),
											'attacked_card_name' => $card->getName(),
											'attack_name' => $this->getName(),
											'hp' => array('from' => $old_hp, 'to' => $card->getInGameHP(), 'diff' => $card->getInGameHP() - $old_hp)
											));
					$game->addEvent($event);
				}

				if ($this->getRestoresEnergyPercentage()) {
					$old_ep = $card->getInGameEP();
					$ep = $old_ep + ceil(($card->getBaseEP() / 100) * $this->getRestoresEnergyPercentage());
					if ($ep > $card->getBaseEP()) $ep = $card->getBaseEP();
					$card->setInGameEP($ep);

					$event = new GameEvent();
					$event->setEventType(GameEvent::TYPE_RESTORE_ENERGY);
					$event->setEventData(array(
											'player_id' => $game->getCurrentPlayerId(),
											'attacking_card_id' => $this->getUniqueId(),
											'attacking_card_name' => $this->getName(),
											'attacked_card_id' => $card->getUniqueId(),
											'attacked_card_name' => $card->getName(),
											'attack_name' => $this->getName(),
											'ep' => array('from' => $old_ep, 'to' => $card->getInGameEP(), 'diff' => $card->getInGameEP() - $old_ep)
											));
					$game->addEvent($event);
				}
			}
		}

	}
