<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo creature card attack class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Attacks")
	 */
	class Attack extends \b2db\Saveable
	{

		const TYPE_AIR = 10;
		const TYPE_DARK = 11;
		const TYPE_EARTH = 12;
		const TYPE_FIRE = 13;
		const TYPE_FREEZE = 14;
		const TYPE_MELEE = 15;
		const TYPE_POISON = 16;
		const TYPE_RANGED = 17;

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Attack name
		 *
		 * @Column(type="string", length=250)
		 * @var string
		 */
		protected $_name;

		/**
		 * Attack description
		 *
		 * @Column(type="text")
		 * @var string
		 */
		protected $_description;

		/**
		 * Attack type
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_type;

		/**
		 * Cost (gold)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_cost_gold;

		/**
		 * Cost (magic)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_cost_magic;

		/**
		 * Attack HP restored
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_points_restored;

		/**
		 * Attack HP damage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_points_min;

		/**
		 * Attack HP damage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_attack_points_max;

		/**
		 * Repeat attack HP damage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_attack_points_min;

		/**
		 * Repeat attack HP damage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_attack_points_max;

		/**
		 * Repeat rounds (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_rounds_min;

		/**
		 * Repeat rounds (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_repeat_rounds_max;

		/**
		 * Unblockable or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_unblockable;

		/**
		 * Mandatory or not
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_mandatory;

		/**
		 * Stun percentage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_percentage_min;

		/**
		 * Stun percentage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_percentage_max;

		/**
		 * Stun duration (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_duration_min;

		/**
		 * Stun duration (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_stun_duration_max;

		/**
		 * Belonging card
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\CreatureCard")
		 * 
		 * @var \application\entities\CreatureCard
		 */
		protected $_card_id;

		/**
		 * Attack level
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_level;

		/**
		 * Penalty rounds (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_penalty_rounds_min;

		/**
		 * Penalty rounds (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_penalty_rounds_max;

		/**
		 * Penalty damage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_penalty_dmg;

		/**
		 * Critical hit percentage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_critical_hit_percentage;

		/**
		 * Steal gold chance percentage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_gold_chance;

		/**
		 * Steal gold amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_gold_amount;

		/**
		 * Steal magic chance percentage
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_magic_chance;

		/**
		 * Steal magic amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_steal_magic_amount;
		
		/**
		 * Generate gold amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_generate_gold_amount;

		/**
		 * Generate magic amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_generate_magic_amount;

		/**
		 * Generate hp amount
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_generate_hp_amount;

		/**
		 * Whether the attack targets single card or all cards
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_attack_all = false;

		/**
		 * Introduction (minimum) level
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_requires_level;
		
		/**
		 * Powerup item card requirement 1
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_requires_item_card_type_1;

		/**
		 * Powerup item card requirement 2
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_requires_item_card_type_2;

		/**
		 * Whether the attack targets single card or all cards
		 *
		 * @Column(type="boolean", default=false)
		 * @var boolean
		 */
		protected $_requires_item_both;

		public static function getTypes()
		{
			$types = array(
				self::TYPE_AIR => 'Air',
				self::TYPE_DARK => 'Dark',
				self::TYPE_EARTH => 'Earth',
				self::TYPE_FIRE => 'Fire',
				self::TYPE_FREEZE => 'Freeze',
				self::TYPE_MELEE => 'Melee',
				self::TYPE_POISON => 'Poison',
				self::TYPE_RANGED => 'Ranged'
				);
			
			return $types;
		}
		
		public function getId()
		{
			return $this->_id;
		}

		public function getName()
		{
			return $this->_name;
		}

		public function getDescription()
		{
			return $this->_description;
		}

		public function getAttackType()
		{
			return $this->_attack_type;
		}

		public function setAttackType($attack_type)
		{
			$this->_attack_type = $attack_type;
		}

		public function hasCostGold()
		{
			return ($this->_cost_gold > 0);
		}

		public function getCostGold()
		{
			return (int) $this->_cost_gold;
		}

		public function hasCostMagic()
		{
			return ($this->_cost_magic > 0);
		}

		public function getCostMagic()
		{
			return (int) $this->_cost_magic;
		}

		public function hasAttackPointsRange()
		{
			return ($this->_attack_points_min != $this->_attack_points_max);
		}

		public function getAttackPointsRestored()
		{
			return (int) $this->_attack_points_restored;
		}

		public function getAttackPointsMin()
		{
			return (int) $this->_attack_points_min;
		}

		public function getAttackPointsMax()
		{
			return (int) $this->_attack_points_max;
		}

		public function hasRepeatAttackPointsRange()
		{
			return ($this->_repeat_attack_points_min != $this->_repeat_attack_points_max);
		}

		public function getRepeatAttackPointsMin()
		{
			return (int) $this->_repeat_attack_points_min;
		}

		public function getRepeatAttackPointsMax()
		{
			return (int) $this->_repeat_attack_points_max;
		}

		public function isAvailable()
		{
			return true;
		}

		public function isMandatory()
		{
			return $this->_mandatory;
		}

		public function isUnblockable()
		{
			return $this->_unblockable;
		}

		public function isBlockable()
		{
			return !$this->isUnblockable();
		}

		public function hasStunPercentageRange()
		{
			return ($this->_stun_percentage_min != $this->_stun_percentage_max);
		}

		public function getStunPercentageMin()
		{
			return (int) $this->_stun_percentage_min;
		}

		public function getStunPercentageMax()
		{
			return (int) $this->_stun_percentage_max;
		}

		public function isRepeatable()
		{
			return ($this->_repeat_rounds_min > 0);
		}
		
		public function hasRepeatRoundsRange()
		{
			return ($this->_repeat_rounds_min != $this->_repeat_rounds_max);
		}

		public function getRepeatRoundsMin()
		{
			return (int) $this->_repeat_rounds_min;
		}

		public function getRepeatRoundsMax()
		{
			return (int) $this->_repeat_rounds_max;
		}

		public function setName($name)
		{
			$this->_name = $name;
		}

		public function setDescription($description)
		{
			$this->_description = $description;
		}

		public function setCostGold($cost_gold)
		{
			$this->_cost_gold = $cost_gold;
		}

		public function setCostMagic($cost_magic)
		{
			$this->_cost_magic = $cost_magic;
		}

		public function setAttackPointsRestored($attack_points_restored)
		{
			$this->_attack_points_restored = $attack_points_restored;
		}

		public function setAttackPointsMin($attack_points_min)
		{
			$this->_attack_points_min = $attack_points_min;
		}

		public function setAttackPointsMax($attack_points_max)
		{
			$this->_attack_points_max = $attack_points_max;
		}

		public function setRepeatAttackPointsMin($repeat_attack_points_min)
		{
			$this->_repeat_attack_points_min = $repeat_attack_points_min;
		}

		public function setRepeatAttackPointsMax($repeat_attack_points_max)
		{
			$this->_repeat_attack_points_max = $repeat_attack_points_max;
		}

		public function setMandatory($mandatory)
		{
			$this->_mandatory = $mandatory;
		}

		public function setUnblockable($unblockable)
		{
			$this->_unblockable = $unblockable;
		}

		public function setStunPercentageMin($stun_percentage_min)
		{
			$this->_stun_percentage_min = $stun_percentage_min;
		}

		public function setStunPercentageMax($stun_percentage_max)
		{
			$this->_stun_percentage_max = $stun_percentage_max;
		}

		public function setRepeatRoundsMin($repeat_rounds_min)
		{
			$this->_repeat_rounds_min = $repeat_rounds_min;
		}

		public function setRepeatRoundsMax($repeat_rounds_max)
		{
			$this->_repeat_rounds_max = $repeat_rounds_max;
		}

		public function setIntroductionLevel($introduction_level)
		{
			$this->_introduction_level = $introduction_level;
		}

		/**
		 * Return this attack's card
		 *
		 * @return CreatureCard
		 */
		public function getCard()
		{
			$this->_b2dbLazyload('_card_id');
			return $this->_card_id;
		}

		public function getCardId()
		{
			return ($this->_card_id instanceof CreatureCard) ? $this->_card_id->getId() : $this->_card_id;
		}

		public function setCard(CreatureCard $card)
		{
			$this->_card_id = $card;
		}

		public function setCardId($card_id)
		{
			$this->_card_id = $card_id;
		}

		public function hasStunDurationRange()
		{
			return (bool) $this->_stun_duration_min != $this->_stun_duration_max;
		}

		public function getStunDurationMin()
		{
			return (int) $this->_stun_duration_min;
		}

		public function setStunDurationMin($stun_duration_min)
		{
			$this->_stun_duration_min = $stun_duration_min;
		}

		public function getStunDurationMax()
		{
			return (int) $this->_stun_duration_max;
		}

		public function setStunDurationMax($stun_duration_max)
		{
			$this->_stun_duration_max = $stun_duration_max;
		}

		public function getPenaltyRoundsMin()
		{
			return (int) $this->_penalty_rounds_min;
		}

		public function setPenaltyRoundsMin($penalty_rounds_min)
		{
			$this->_penalty_rounds_min = $penalty_rounds_min;
		}

		public function getPenaltyRoundsMax()
		{
			return (int) $this->_penalty_rounds_max;
		}

		public function setPenaltyRoundsMax($penalty_rounds_max)
		{
			$this->_penalty_rounds_max = $penalty_rounds_max;
		}

		public function getPenaltyDmg()
		{
			return (int) $this->_penalty_dmg;
		}

		public function setPenaltyDmg($penalty_dmg)
		{
			$this->_penalty_dmg = $penalty_dmg;
		}

		public function getCriticalHitPercentage()
		{
			return (int) $this->_critical_hit_percentage;
		}

		public function setCriticalHitPercentage($critical_hit_percentage)
		{
			$this->_critical_hit_percentage = $critical_hit_percentage;
		}

		public function canStealGold()
		{
			return (bool) $this->_steal_gold_chance > 0;
		}

		public function getStealGoldChance()
		{
			return (int) $this->_steal_gold_chance;
		}

		public function setStealGoldChance($steal_gold_chance)
		{
			$this->_steal_gold_chance = $steal_gold_chance;
		}

		public function getStealGoldAmount()
		{
			return (int) $this->_steal_gold_amount;
		}

		public function setStealGoldAmount($steal_gold_amount)
		{
			$this->_steal_gold_amount = $steal_gold_amount;
		}

		public function canStealMagic()
		{
			return (bool) $this->_steal_magic_chance > 0;
		}

		public function getStealMagicChance()
		{
			return (int) $this->_steal_magic_chance;
		}

		public function setStealMagicChance($steal_magic_chance)
		{
			$this->_steal_magic_chance = $steal_magic_chance;
		}

		public function getStealMagicAmount()
		{
			return (int) $this->_steal_magic_amount;
		}

		public function setStealMagicAmount($steal_magic_amount)
		{
			$this->_steal_magic_amount = $steal_magic_amount;
		}

		public function canStun()
		{
			return ($this->getStunPercentageMin() > 0);
		}

		public function getLevel()
		{
			return $this->_level;
		}

		public function setLevel($level)
		{
			$this->_level = $level;
		}
		
		public function getRequiresLevel()
		{
			return (int) $this->_requires_level;
		}

		public function setRequiresLevel($requires_level)
		{
			$this->_requires_level = $requires_level;
		}

		public function doesRequireBothItems()
		{
			return (bool) $this->getRequiresItemBoth();
		}

		public function getRequiresItemBoth()
		{
			return (bool) $this->_requires_item_both;
		}

		public function setRequiresItemBoth($requires_item_both)
		{
			$this->_requires_item_both = $requires_item_both;
		}

		public function getRequiresItemCardType1()
		{
			return $this->_requires_item_card_type_1;
		}

		public function setRequiresItemCardType1($requires_item_card_type)
		{
			$this->_requires_item_card_type_1 = $requires_item_card_type;
		}

		public function getRequiresItemCardType2()
		{
			return $this->_requires_item_card_type_2;
		}

		public function setRequiresItemCardType2($requires_item_card_type)
		{
			$this->_requires_item_card_type_2 = $requires_item_card_type;
		}

		public function getGenerateGoldAmount()
		{
			return (int) $this->_generate_gold_amount;
		}

		public function setGenerateGoldAmount($generate_gold_amount)
		{
			$this->_generate_gold_amount = $generate_gold_amount;
		}

		public function getGenerateMagicAmount()
		{
			return (int) $this->_generate_magic_amount;
		}

		public function setGenerateMagicAmount($generate_magic_amount)
		{
			$this->_generate_magic_amount = $generate_magic_amount;
		}

		public function getGenerateHpAmount()
		{
			return (int) $this->_generate_hp_amount;
		}

		public function setGenerateHpAmount($generate_hp_amount)
		{
			$this->_generate_hp_amount = $generate_hp_amount;
		}

		public function doesAttackAll()
		{
			return $this->getAttackAll();
		}

		public function getAttackAll()
		{
			return (bool) $this->_attack_all;
		}

		public function setAttackAll($attack_all)
		{
			$this->_attack_all = $attack_all;
		}

		public function mergeFormData(\caspar\core\Request $request)
		{
			$this->_name = $request['name'];
			$this->_description = $request['description'];
			$this->_card_id = $request['card_id'];
			$this->_attack_type = $request['attack_type'];
			$this->_cost_gold = $request['cost_gold'];
			$this->_cost_magic = $request['cost_magic'];
			$this->_attack_points_min = $request['hp_min'];
			$this->_attack_points_max = $request['hp_max'];
			$this->_repeat_rounds_min = $request['rep_min'];
			$this->_repeat_rounds_max = $request['rep_max'];
			$this->_repeat_attack_points_min = $request['rep_hp_min'];
			$this->_repeat_attack_points_max = $request['rep_hp_max'];
			$this->_unblockable = $request['unblockable'];
			$this->_mandatory = $request['mandatory'];
			$this->_critical_hit_percentage = $request['critical_hit_percentage'];
			$this->_stun_percentage_min = $request['stun_percentage_min'];
			$this->_stun_percentage_max = $request['stun_percentage_max'];
			$this->_stun_duration_min = $request['stun_duration_min'];
			$this->_stun_duration_max = $request['stun_duration_max'];
			$this->_penalty_rounds_min = $request['penalty_rounds_min'];
			$this->_penalty_rounds_max = $request['penalty_rounds_max'];
			$this->_penalty_dmg = $request['penalty_dmg'];
			$this->_steal_gold_chance = $request['steal_gold_chance'];
			$this->_steal_gold_amount = $request['steal_gold_amount'];
			$this->_steal_magic_chance = $request['steal_magic_chance'];
			$this->_steal_magic_amount = $request['steal_magic_amount'];
			$this->_requires_level = $request['requires_level'];
			$this->_requires_item_card_type = $request['requires_item_card_type'];
		}

		protected function _generateAttack(CreatureCard $card, $this_powerup_cards, $opponent_powerup_cards, $type = 'regular')
		{
			if ($type == 'regular') {
				$dmg = rand($this->getAttackPointsMin(), $this->getAttackPointsMax());
			} else {
				$dmg = rand($this->getRepeatAttackPointsMin(), $this->getRepeatAttackPointsMax());
			}

			if (count($this_powerup_cards)) {
				switch ($this->getAttackType()) {
					case self::TYPE_AIR:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getAirAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getAirAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_DARK:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getDarkAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getDarkAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_EARTH:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getEarthAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getEarthAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_FIRE:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFireAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getFireAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_FREEZE:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFreezeAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getFreezeAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_MELEE:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getMeleeAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getMeleeAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_POISON:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getPoisonAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getPoisonAttackDamagePercentageModifier());
							}
						}
						break;
					case self::TYPE_RANGED:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getRangedAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getRangedAttackDamagePercentageModifier());
							}
						}
						break;
				}
			}

			// Reduce dmg by user dmp value
			if (!$this->isUnblockable()) $dmg -= floor(($dmg / 100) * rand(0, $card->getUserDMP() * 10));
			if (count($opponent_powerup_cards)) {
				switch ($this->getAttackType()) {
					case self::TYPE_AIR:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getAirAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getAirAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_DARK:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getDarkAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getDarkAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_EARTH:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getEarthAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getEarthAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_FIRE:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFireAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getFireAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_FREEZE:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFreezeAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getFreezeAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_MELEE:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getMeleeAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getMeleeAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_POISON:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getPoisonAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getPoisonAttackDmpPercentageModifier()));
							}
						}
						break;
					case self::TYPE_RANGED:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getRangedAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getRangedAttackDmpPercentageModifier()));
							}
						}
						break;
				}
			}

			$attacked_from_hp = $card->getInGameHP();
			$card->removeHP($dmg);

			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_DAMAGE);
			$event->setEventData(array(
									'player_id' => $this->getCard()->getGame()->getCurrentPlayerId(),
									'attacking_card_id' => $this->getCard()->getUniqueId(),
									'attacking_card_name' => $this->getCard()->getName(),
									'attacked_card_id' => $card->getUniqueId(),
									'attacked_card_name' => $card->getName(),
									'attack_name' => $this->getName(),
									'hp' => array('from' => $attacked_from_hp, 'to' => $card->getInGameHP(), 'diff' => $dmg)
									));
			$this->getCard()->getGame()->addEvent($event);
		}

		protected function _stun(CreatureCard $card, Game $game)
		{
			if (rand(0, 100) >= rand($this->getStunPercentageMin(), $this->getStunPercentageMax())) {
				$stun_duration = rand($this->getStunDurationMin(), $this->getStunDurationMax());
				$card->stun($stun_duration);
				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_STUN);
				$event->setEventData(array(
										'player_id' => $game->getCurrentPlayerId(),
										'attacked_card_id' => $card->getUniqueId(),
										'attacked_card_name' => $card->getName()
										));
				$game->addEvent($event);
			}
		}

		protected function _stealGold(Game $game)
		{
			if (rand(0, 100) > rand(0, $this->getStealGoldChance())) {
				$gold = $game->getUserOpponentGold();
				$player_gold = $game->getUserPlayerGold();
				$amount = ceil(($gold / 100) * rand(0, $this->getStealGoldAmount()));
				$game->setUserOpponentGold($gold - $amount);
				$game->setUserPlayerGold($player_gold + $amount);
				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_STEAL_GOLD);
				$event->setEventData(array(
										'player_id' => $game->getCurrentPlayerId(),
										'amount' => array('from' => $gold, 'diff' => $amount, 'to' => $game->getUserOpponentGold())
										));
				$game->addEvent($event);
			}
		}
		
		protected function _stealMagic(CreatureCard $card)
		{
			if (rand(0, 100) > rand(0, $this->getStealMagicChance())) {
				$ep = $card->getEP();
				$player_ep = $this->getCard()->getEP();
				$amount = ceil(($ep / 100) * rand(0, $this->getStealMagicAmount()));
				$card->setInGameEP($ep - $amount);
				$this->getCard()->setInGameEP($player_ep + $amount);
				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_STEAL_MAGIC);
				$event->setEventData(array(
										'player_id' => $card->getCurrentPlayerId(),
										'attacking_card_id' => $this->getCard()->getUniqueId(),
										'attacking_card_name' => $this->getCard()->getName(),
										'attacked_card_id' => $card->getUniqueId(),
										'attacked_card_name' => $card->getName(),
										'amount' => array('from' => $ep, 'diff' => $amount, 'to' => $this->getCard()->getInGameEP())
										));
				$card->addEvent($event);
			}
		}

		public function perform(CreatureCard $card)
		{
			$game = $this->getCard()->getGame();

			// Apply costs
			$attacking_from_gold = $game->getUserPlayerGold();
			$game->setUserPlayerGold($attacking_from_gold - $this->getCostGold());
			$attacking_from_ep = $this->getCard()->getInGameEP();
			$this->getCard()->setInGameEP($attacking_from_ep - $this->getCostMagic());
			$game->useAction();

			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_ATTACK);
			$event->setEventData(array(
									'player_id' => $game->getCurrentPlayerId(),
									'remaining_actions' => $game->getCurrentPlayerActions(),
									'attacking_card_id' => $this->getCard()->getUniqueId(),
									'attacking_card_name' => $this->getCard()->getName(),
									'attacked_card_id' => $card->getUniqueId(),
									'attacked_card_name' => $card->getName(),
									'cost' => array(
												'gold' => array('from' => $attacking_from_gold, 'to' => $game->getUserPlayerGold(), 'diff' => $this->getCostGold()),
												'ep' => array('from' => $attacking_from_ep, 'to' => $this->getCard()->getEP(), 'diff' => $this->getCostMagic())
												)
									));
			$game->addEvent($event);

			$this_powerup_cards = $this->getCard()->getPowerupCards();
			$opponent_powerup_cards = $card->getPowerupCards();
			$this->_generateAttack($card, $this_powerup_cards, $opponent_powerup_cards);
			
			if ($card->getInGameHP() > 0 && $this->isRepeatable()) {
				$repeat_rounds = rand($this->getRepeatRoundsMin(), $this->getRepeatRoundsMax());
				for ($cc = 1; $cc <= $repeat_rounds; $cc++) {
					$this->_generateAttack($card, $this_powerup_cards, $opponent_powerup_cards, 'repeat');
					if ($card->getInGameHP() == 0) break;
				}
			}

			if ($this->canStealGold()) {
				$this->_stealGold($game);
			}

			if ($this->canStealMagic()) {
				$this->_stealMagic($game);
			}

			if ($card->getHP() == 0) {
				$game->removeCard($card);
			} else {
				if ($this->canStun()) {
					$this->_stun($card, $game);
				}
			}

			return array($game, $this->getCard());
		}

	}