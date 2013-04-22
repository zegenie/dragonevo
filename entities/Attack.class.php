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
		 * Effect percentage (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_effect_percentage_min;

		/**
		 * Effect percentage (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_effect_percentage_max;

		/**
		 * Effect duration (min)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_effect_duration_min;

		/**
		 * Effect duration (max)
		 *
		 * @Column(type="integer", length=5)
		 * @var integer
		 */
		protected $_effect_duration_max;

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
		 * @Column(type="integer", length=5, default=0)
		 * @var integer
		 */
		protected $_level = 0;

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
		 * If cloned, the original attack
		 *
		 * @Column(type="integer", length=10)
		 * @Relates(class="\application\entities\Attack")
		 *
		 * @var \application\entities\Attack
		 */
		protected $_original_attack_id;

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

		public function hasPenaltyRoundsRange()
		{
			return ($this->_penalty_rounds_min != $this->_penalty_rounds_max);
		}

		public function hasAttackPointsRange()
		{
			return ($this->_attack_points_min != $this->_attack_points_max);
		}

		public function hasAttackPoints()
		{
			return ($this->_attack_points_max > 0);
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

		/**
		 * Return the original attack
		 * 
		 * @return Attack
		 */
		public function getOriginalAttack()
		{
			return $this->_b2dbLazyload('_original_attack_id');
		}

		public function getOriginalAttackId()
		{
			return ($this->_original_attack_id instanceof Attack) ? $this->_original_attack_id->getId() : $this->_original_attack_id;
		}

		public function setOriginalAttackId($original_attack_id)
		{
			$this->_original_attack_id = $original_attack_id;
		}

		public function setOriginalAttack(Attack $original_attack_id)
		{
			$this->_original_attack_id = $original_attack_id;
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

		public function hasEffectPercentageRange()
		{
			return ($this->_effect_percentage_min != $this->_effect_percentage_max);
		}

		public function getEffectPercentageMin()
		{
			return (int) $this->_effect_percentage_min;
		}

		public function getEffectPercentageMax()
		{
			return (int) $this->_effect_percentage_max;
		}

		public function isRepeatable()
		{
			return ($this->_repeat_rounds_max > 0);
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

		public function setEffectPercentageMin($effect_percentage_min)
		{
			$this->_effect_percentage_min = $effect_percentage_min;
		}

		public function setEffectPercentageMax($effect_percentage_max)
		{
			$this->_effect_percentage_max = $effect_percentage_max;
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

		public function hasEffectDurationRange()
		{
			return (bool) ($this->_effect_duration_min != $this->_effect_duration_max);
		}

		public function getEffectDurationMin()
		{
			return (int) $this->_effect_duration_min;
		}

		public function setEffectDurationMin($effect_duration_min)
		{
			$this->_effect_duration_min = $effect_duration_min;
		}

		public function getEffectDurationMax()
		{
			return (int) $this->_effect_duration_max;
		}

		public function setEffectDurationMax($effect_duration_max)
		{
			$this->_effect_duration_max = $effect_duration_max;
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
		
		public function canAfford()
		{
			if ($this->getCard()->getInGameEP() < $this->getCostMagic()) return false;
			if ($this->getCard()->getGame()->getUserPlayerGold() < $this->getCostGold()) return false;
			if ($this->getCard()->getUserCardLevel() < $this->getRequiresLevel()) return false;
			
			return true;
		}

		public function canStealGold()
		{
			return (bool) ($this->_steal_gold_chance > 0);
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
			return (bool) ($this->_steal_magic_chance > 0);
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

		public function hasEffect()
		{
			return ($this->getEffectPercentageMin() > 0);
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
			$this->_attack_all = $request['attack_all'];
			$this->_attack_points_restored = $request['hp_restored'];
			$this->_attack_points_min = $request['hp_min'];
			$this->_attack_points_max = $request['hp_max'];
			$this->_repeat_rounds_min = $request['rep_min'];
			$this->_repeat_rounds_max = $request['rep_max'];
			$this->_repeat_attack_points_min = $request['rep_hp_min'];
			$this->_repeat_attack_points_max = $request['rep_hp_max'];
			$this->_unblockable = $request['unblockable'];
			$this->_mandatory = $request['mandatory'];
			$this->_critical_hit_percentage = $request['critical_hit_percentage'];
			$this->_effect_percentage_min = $request['effect_percentage_min'];
			$this->_effect_percentage_max = $request['effect_percentage_max'];
			$this->_effect_duration_min = $request['effect_duration_min'];
			$this->_effect_duration_max = $request['effect_duration_max'];
			$this->_penalty_rounds_min = $request['penalty_rounds_min'];
			$this->_penalty_rounds_max = $request['penalty_rounds_max'];
			$this->_penalty_dmg = $request['penalty_dmg'];
			$this->_steal_gold_chance = $request['steal_gold_chance'];
			$this->_steal_gold_amount = $request['steal_gold_amount'];
			$this->_steal_magic_chance = $request['steal_magic_chance'];
			$this->_steal_magic_amount = $request['steal_magic_amount'];
			$this->_requires_level = $request['requires_level'];
			$this->_requires_item_card_type_1 = $request['requires_item_card_type_1'];
			$this->_requires_item_card_type_2 = $request['requires_item_card_type_2'];
			$this->_requires_item_both = (bool) $request['requires_item_both'];
			$this->_generate_gold_amount = $request['generate_gold_amount'];
			$this->_generate_magic_amount = $request['generate_magic_amount'];
			$this->_generate_hp_amount = $request['generate_hp_amount'];
		}

		public function isBonusAttack()
		{
			return (bool) ($this->_generate_hp_amount || $this->_generate_magic_amount);
		}

		public function isForageAttack()
		{
			return (bool) ($this->_generate_gold_amount && !$this->_attack_points_min);
		}

		public function isStealAttack()
		{
			return (bool) ($this->_steal_gold_amount);
		}

		public function doesRegenerateHP()
		{
			return ($this->_generate_hp_amount > 0);
		}

		public function doesRegenerateEP()
		{
			return ($this->_generate_magic_amount > 0);
		}

		public function doesGenerateGold()
		{
			return ($this->_generate_gold_amount > 0);
		}

		public function hasOwnPenaltyRounds()
		{
			return ($this->_penalty_rounds_max > 0);
		}

		protected function _generateGold(Game $game)
		{
			$amount = $this->getGenerateGoldAmount();
			$player_gold = $game->getUserPlayerGold();
			$game->setUserPlayerGold($player_gold + $amount);
			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_GENERATE_GOLD);
			$event->setEventData(array(
									'player_id' => $game->getCurrentPlayerId(),
									'attacking_card_id' => $this->getCard()->getUniqueId(),
									'attacking_card_name' => $this->getCard()->getName(),
									'attack_name' => $this->getName(),
									'amount' => array('from' => $player_gold, 'diff' => $amount, 'to' => $game->getUserPlayerGold())
									));
			$game->addEvent($event);
		}

		protected function _generateAttack(CreatureCard $card, $this_powerup_cards, $opponent_powerup_cards, $type = 'regular', $percentage = 0, $recursive_count = 0)
		{
			if ($type == 'regular') {
				$dmg = rand($this->getAttackPointsMin(), $this->getAttackPointsMax());
			} elseif ($type == 'effect') {
				$dmg = ceil(($card->getBaseHP() / 100) * $percentage);
			} else {
				$dmg = rand($this->getRepeatAttackPointsMin(), $this->getRepeatAttackPointsMax());
			}

			if ($recursive_count) {
				$dmg = ceil($dmg / rand(1, 5));
			}

			$bonus_cards = array();
			$defence_bonus_cards = array();
			$effects = $this->getCard()->getModifierEffects();
			$effects += $this->getCard()->getUser()->getAttackSkills();

			if (count($effects)) {
				switch ($this->getAttackType()) {
					case self::TYPE_AIR:
						foreach($effects as $effect) {
							if ($effect->getDecreasesAirAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesAirAttackDamagePercentage()));
							} elseif ($effect->getIncreasesAirAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesAirAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_DARK:
						foreach($effects as $effect) {
							if ($effect->getDecreasesDarkAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesDarkAttackDamagePercentage()));
							} elseif ($effect->getIncreasesDarkAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesDarkAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_EARTH:
						foreach($effects as $effect) {
							if ($effect->getDecreasesEarthAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesEarthAttackDamagePercentage()));
							} elseif ($effect->getIncreasesEarthAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesEarthAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_FIRE:
						foreach($effects as $effect) {
							if ($effect->getDecreasesFireAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesFireAttackDamagePercentage()));
							} elseif ($effect->getIncreasesFireAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesFireAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_FREEZE:
						foreach($effects as $effect) {
							if ($effect->getDecreasesFreezeAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesFreezeAttackDamagePercentage()));
							} elseif ($effect->getIncreasesFreezeAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesFreezeAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_MELEE:
						foreach($effects as $effect) {
							if ($effect->getDecreasesMeleeAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesMeleeAttackDamagePercentage()));
							} elseif ($effect->getIncreasesMeleeAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesMeleeAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_POISON:
						foreach($effects as $effect) {
							if ($effect->getDecreasesPoisonAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesPoisonAttackDamagePercentage()));
							} elseif ($effect->getIncreasesPoisonAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesPoisonAttackDamagePercentage()));
							}
						}
						break;
					case self::TYPE_RANGED:
						foreach($effects as $effect) {
							if ($effect->getDecreasesRangedAttackDamagePercentage()) {
								$dmg -= floor(($dmg / 100) * rand(0, $effect->getDecreasesRangedAttackDamagePercentage()));
							} elseif ($effect->getIncreasesRangedAttackDamagePercentage()) {
								$dmg += ceil(($dmg / 100) * rand(0, $effect->getIncreasesRangedAttackDamagePercentage()));
							}
						}
						break;
				}
			}
			
			if (count($this_powerup_cards)) {
				switch ($this->getAttackType()) {
					case self::TYPE_AIR:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getAirAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getAirAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_DARK:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getDarkAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getDarkAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_EARTH:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getEarthAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getEarthAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_FIRE:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFireAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getFireAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_FREEZE:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFreezeAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getFreezeAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_MELEE:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getMeleeAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getMeleeAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_POISON:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getPoisonAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getPoisonAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_RANGED:
						foreach($this_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getRangedAttackDamagePercentageModifier()) {
								$dmg += floor(($dmg / 100) * $pc->getRangedAttackDamagePercentageModifier());
								$bonus_cards[] = $pc->getUniqueId();
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
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_DARK:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getDarkAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getDarkAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_EARTH:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getEarthAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getEarthAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_FIRE:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFireAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getFireAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_FREEZE:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getFreezeAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getFreezeAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_MELEE:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getMeleeAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getMeleeAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_POISON:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getPoisonAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getPoisonAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
					case self::TYPE_RANGED:
						foreach($opponent_powerup_cards as $pc) {
							if ($pc instanceof EquippableItemCard && $pc->isInPlay() && $pc->getRangedAttackDmpPercentageModifier()) {
								$dmg -= floor(($dmg / 100) * rand(0, $pc->getRangedAttackDmpPercentageModifier()));
								$defence_bonus_cards[] = $pc->getUniqueId();
							}
						}
						break;
				}
			}

			if ($dmg > 0) {

				$defence_bonus_cards = array_unique($defence_bonus_cards);
				$bonus_cards = array_unique($bonus_cards);

				$attacked_from_hp = $card->getInGameHP();
				$card->removeHP($dmg);
				$this->getCard()->getGame()->addAffectedCard($card);

				$event = new GameEvent();
				$event->setEventType(GameEvent::TYPE_DAMAGE);
				$event->setEventData(array(
										'player_id' => $this->getCard()->getGame()->getCurrentPlayerId(),
										'attacking_card_id' => $this->getCard()->getUniqueId(),
										'attacking_card_name' => $this->getCard()->getName(),
										'attacked_card_id' => $card->getUniqueId(),
										'attacked_card_name' => $card->getName(),
										'attack_name' => $this->getName(),
										'damage_type' => $type,
										'hp' => array('from' => $attacked_from_hp, 'to' => $card->getInGameHP(), 'diff' => $dmg),
										'bonus_cards' => $bonus_cards,
										'defence_bonus_cards' => $defence_bonus_cards
										));
				$this->getCard()->getGame()->addEvent($event);
				if ($type == 'regular' && $this->_attack_points_restored > 0) {
					$old_hp = $this->getCard()->getHP();
					$hp = +ceil(($dmg / 100) * $this->_attack_points_restored);
					$this->getCard()->setInGameHP($old_hp + $hp);
					$this->getCard()->getGame()->addAffectedCard($this->getCard());

					$event = new GameEvent();
					$event->setEventType(GameEvent::TYPE_RESTORE_HEALTH);
					$event->setEventData(array(
											'player_id' => $this->getCard()->getUser()->getId(),
											'attacking_card_id' => $this->getCard()->getUniqueId(),
											'attacking_card_name' => $this->getCard()->getName(),
											'attacked_card_id' => $this->getCard()->getUniqueId(),
											'attacked_card_name' => $this->getCard()->getName(),
											'attack_name' => $this->getName(),
											'hp' => array('from' => $old_hp, 'to' => $this->getCard()->getInGameHP(), 'diff' => $hp)
											));
					$this->getCard()->getGame()->addEvent($event);
				}

			}
		}

		protected function _applyEffect(CreatureCard $card, Game $game, $type, $duration, $percentage = 0, $applies_to_self = false)
		{
			$duration = floor($duration);
			$percentage = floor($percentage);
			$effect = new ModifierEffect();
			$effect->setEffectType($type);
			$effect->setCard($card);
			$effect->setGame($game);
			$effect->apply($duration, $percentage, $applies_to_self);
			$effect->save();

			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_APPLY_EFFECT);
			$event->setEventData(array(
									'player_id' => $game->getCurrentPlayerId(),
									'attacking_card_id' => $this->getCard()->getUniqueId(),
									'attacking_card_name' => $this->getCard()->getName(),
									'attacked_card_id' => $card->getUniqueId(),
									'attacked_card_name' => $card->getName(),
									'effect' => $type,
									'duration' => $duration
									));
			$game->addEvent($event);
		}

		protected function _generateAirEffect(CreatureCard $card, Game $game, $p_min = null, $p_max = null)
		{
			if ($card->hasAnyEffect(array(ModifierEffect::TYPE_AIR, ModifierEffect::TYPE_DARK, ModifierEffect::TYPE_FIRE, ModifierEffect::TYPE_FREEZE, ModifierEffect::TYPE_POISON))) return false;
			$duration = ($p_min === null) ? null : rand(1, 2);
			$p_min = ($p_min === null) ? $this->getEffectPercentageMin() : $p_min;
			$p_max = ($p_max === null) ? $this->getEffectPercentageMax() : $p_max;

			if ($duration === null) {
				$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($card->getSlot());
				$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($card->getSlot());
				if ($upcard_1) {
					$p_max += $upcard_1->getIncreasesAirAttackDamagePercentage();
				}
				if ($upcard_2 && ($this->getRequiresItemBoth() || ($upcard_1->isDefensive() || $upcard_2->isDefensive()))) {
					$p_max += $upcard_2->getIncreasesAirAttackDamagePercentage();
				}
			}
			$p_max = ($p_max > 100) ? 100 : $p_max;
			$p_max = ($p_max < 0) ? 0 : $p_max;

			$percentage = rand($p_min, $p_max);
			$effect = false;
			if ($percentage < rand(0, 100)) {
				$duration = ($duration !== null) ? $duration : rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_AIR, $duration, $percentage);
				$effect = true;
			}

			if (rand(0, 100) <= 10) {
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_STUN, 1);
				$effect = true;
			}

			$pcard_1 = $game->getUserOpponentCardSlotPowerupCard1Id($card->getSlot());
			$pcard_2 = $game->getUserOpponentCardSlotPowerupCard2Id($card->getSlot());
				
			if (($pcard_1 || $pcard_2) && rand(0, 100) <= rand(0, 20)) {
				if ($pcard_1) $game->setUserPlayerCardSlotPowerupCard1($card->getSlot(), 0);
				if ($pcard_2) $game->setUserPlayerCardSlotPowerupCard2($card->getSlot(), 0);
			}

			return $effect;
		}

		protected function _generateAttackEffect(CreatureCard $card, Game $game)
		{
			if (rand(1, 100) < rand($this->getEffectPercentageMin(), $this->getEffectPercentageMax())) {
				$duration = rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_STUN, $duration);
				return true;
			}

			return false;
		}

		protected function _generateDarkEffect(CreatureCard $card, Game $game, $p_min = null, $p_max = null)
		{
			if ($card->hasAnyEffect(array(ModifierEffect::TYPE_AIR, ModifierEffect::TYPE_DARK, ModifierEffect::TYPE_FIRE, ModifierEffect::TYPE_FREEZE, ModifierEffect::TYPE_POISON))) return false;
			$duration = ($p_min === null) ? null : rand(1, 2);
			$p_min = ($p_min === null) ? $this->getEffectPercentageMin() : $p_min;
			$p_max = ($p_max === null) ? $this->getEffectPercentageMax() : $p_max;

			if ($duration === null) {
				$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($card->getSlot());
				$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($card->getSlot());
				if ($upcard_1) {
					$p_max += $upcard_1->getIncreasesDarkAttackDamagePercentage();
				}
				if ($upcard_2 && ($this->getRequiresItemBoth() || ($upcard_1->isDefensive() || $upcard_2->isDefensive()))) {
					$p_max += $upcard_2->getIncreasesDarkAttackDamagePercentage();
				}
			}
			$p_max = ($p_max > 100) ? 100 : $p_max;
			$p_max = ($p_max < 0) ? 0 : $p_max;

			$percentage = rand($p_min, $p_max);
			if ($percentage < rand(0, 100)) {
				$duration = ($duration !== null) ? $duration : rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_DARK, $duration, $percentage);
				return true;
			}

			return false;
		}

		protected function _generateEarthEffect(CreatureCard $card, Game $game, $p_min = null, $p_max = null)
		{
			$p_min = ($p_min === null) ? $this->getEffectPercentageMin() : $p_min;
			$p_max = ($p_max === null) ? $this->getEffectPercentageMax() : $p_max;
			$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($card->getSlot());
			$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($card->getSlot());

			if ($upcard_1) {
				$p_max += $upcard_1->getIncreasesEarthAttackDamagePercentage();
			}
			if ($upcard_2 && ($this->getRequiresItemBoth() || ($upcard_1->isDefensive() || $upcard_2->isDefensive()))) {
				$p_max += $upcard_2->getIncreasesEarthAttackDamagePercentage();
			}
			$p_max = ($p_max > 100) ? 100 : $p_max;
			$p_max = ($p_max < 0) ? 0 : $p_max;

			$percentage = rand($p_min, $p_max);
			$cards = array($card->getSlot());
			switch ($card->getSlot()) {
				case 1:
				case 5:
					if (rand(0, 25) <= rand(0, 50)) {
						$cards[] = ($card->getSlot() == 1) ? 2 : 4;
						if (rand(0, 50) <= rand(0, 50)) {
							$cards[] = 3;
						}
					}
					break;
				case 2:
				case 4:
					if (rand(0, 25) <= rand(0, 50)) {
						$cards[] = ($card->getSlot() == 2) ? 1 : 5;
						if (rand(0, 50) <= rand(0, 50)) {
							$cards[] = 3;
						}
					}
					break;
				case 3:
					if (rand(0, 25) <= rand(0, 50)) {
						$cards[] = 2;
						if (rand(0, 50) <= rand(0, 50)) {
							$cards[] = 4;
						}
					}
					break;
			}
			$effect = false;
			if (rand(0, 60) <= rand(0, 50)) {
				$powerup_cards = $this->getCard()->getPowerupCards();
				foreach ($cards as $slot) {
					$c = $game->getUserOpponentCardSlot($slot);
					$this->_generateAttack($c, $powerup_cards, $c->getPowerupCards(), 'effect', ceil($percentage));
					if ($slot == $card->getSlot()) $percentage /= 2;
					$effect = true;
				}
			} else {
				$duration = rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				foreach ($cards as $slot) {
					$c = $game->getUserOpponentCardSlot($slot);
					$this->_applyEffect($card, $game, ModifierEffect::TYPE_STUN, ceil($duration));
					if ($slot == $card->getSlot()) $duration /= 2;
					$effect = true;
				}
			}

			return $effect;
		}

		protected function _generateFireEffect(CreatureCard $card, Game $game, $p_min = null, $p_max = null)
		{
			if ($card->hasAnyEffect(array(ModifierEffect::TYPE_AIR, ModifierEffect::TYPE_DARK, ModifierEffect::TYPE_FIRE, ModifierEffect::TYPE_FREEZE, ModifierEffect::TYPE_POISON))) return false;
			$duration = ($p_min === null) ? null : rand(1, 2);
			$p_min = ($p_min === null) ? $this->getEffectPercentageMin() : $p_min;
			$p_max = ($p_max === null) ? $this->getEffectPercentageMax() : $p_max;

			if ($duration === null) {
				$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($card->getSlot());
				$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($card->getSlot());
				if ($upcard_1) {
					$p_max += $upcard_1->getIncreasesFireAttackDamagePercentage();
				}
				if ($upcard_2 && ($this->getRequiresItemBoth() || ($upcard_1->isDefensive() || $upcard_2->isDefensive()))) {
					$p_max += $upcard_2->getIncreasesFireAttackDamagePercentage();
				}
			}
			$p_max = ($p_max > 100) ? 100 : $p_max;
			$p_max = ($p_max < 0) ? 0 : $p_max;

			$percentage = rand($p_min, $p_max);
			if ($percentage < rand(0, 100)) {
				$duration = ($duration !== null) ? $duration : rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_FIRE, $duration, $percentage);
				return true;
			}

			return false;
		}

		protected function _generateFreezeEffect(CreatureCard $card, Game $game, $p_min = null, $p_max = null)
		{
			if ($card->hasAnyEffect(array(ModifierEffect::TYPE_AIR, ModifierEffect::TYPE_DARK, ModifierEffect::TYPE_FIRE, ModifierEffect::TYPE_FREEZE, ModifierEffect::TYPE_POISON))) return false;
			$freeze_duration = ($p_min === null) ? null : rand(1, 2);
			$p_min = ($p_min === null) ? $this->getEffectPercentageMin() : $p_min;
			$p_max = ($p_max === null) ? $this->getEffectPercentageMax() : $p_max;

			if ($freeze_duration === null) {
				$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($card->getSlot());
				$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($card->getSlot());
				if ($upcard_1) {
					$p_max += $upcard_1->getIncreasesFreezeAttackDamagePercentage();
				}
				if ($upcard_2 && ($this->getRequiresItemBoth() || ($upcard_1->isDefensive() || $upcard_2->isDefensive()))) {
					$p_max += $upcard_2->getIncreasesFreezeAttackDamagePercentage();
				}
			}
			$p_max = ($p_max > 100) ? 100 : $p_max;
			$p_max = ($p_max < 0) ? 0 : $p_max;

			$percentage = rand($p_min, $p_max);
			$effect = false;
			if ($percentage < rand(0, 100)) {
				if (!isset($freeze_duration)) {
					if (rand($p_min, $p_max) > rand(0, 100)) {
						$stun_duration = rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
						$this->_applyEffect($card, $game, ModifierEffect::TYPE_STUN, $stun_duration);
						$effect = true;
					}
				}
				$freeze_duration = ($freeze_duration !== null) ? $freeze_duration : rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_FREEZE, $freeze_duration, $percentage);
				$effect = true;
			}

			return $effect;
		}

		protected function _generatePoisonEffect(CreatureCard $card, Game $game, $p_min = null, $p_max = null)
		{
			if ($card->hasAnyEffect(array(ModifierEffect::TYPE_AIR, ModifierEffect::TYPE_DARK, ModifierEffect::TYPE_FIRE, ModifierEffect::TYPE_FREEZE, ModifierEffect::TYPE_POISON))) return false;
			$duration = ($p_min === null) ? null : rand(1, 2);
			$p_min = ($p_min === null) ? $this->getEffectPercentageMin() : $p_min;
			$p_max = ($p_max === null) ? $this->getEffectPercentageMax() : $p_max;

			if ($duration === null) {
				$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($card->getSlot());
				$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($card->getSlot());
				if ($upcard_1) {
					$p_max += $upcard_1->getIncreasesPoisonAttackDamagePercentage();
				}
				if ($upcard_2 && ($this->getRequiresItemBoth() || ($upcard_1->isDefensive() || $upcard_2->isDefensive()))) {
					$p_max += $upcard_2->getIncreasesPoisonAttackDamagePercentage();
				}
			}
			$p_max = ($p_max > 100) ? 100 : $p_max;
			$p_max = ($p_max < 0) ? 0 : $p_max;

			$percentage = rand($p_min, $p_max);
			if ($percentage < rand(0, 100)) {
				$duration = ($duration !== null) ? $duration : rand($this->getEffectDurationMin(), $this->getEffectDurationMax());
				$this->_applyEffect($card, $game, ModifierEffect::TYPE_POISON, $duration, $percentage);
				return true;
			}

			return false;
		}

		protected function _stealGold(Game $game)
		{
			$event = new GameEvent();
			if (rand(0, 100) <= $this->getStealGoldChance()) {
				$gold = $game->getUserOpponentGold();
				$player_gold = $game->getUserPlayerGold();
				$amount = ceil(($gold / 100) * rand(1, $this->getStealGoldAmount()));
				$game->setUserOpponentGold($gold - $amount);
				$game->setUserPlayerGold($player_gold + $amount);
				$event->setEventType(GameEvent::TYPE_STEAL_GOLD);
				$event->setEventData(array(
										'player_id' => $game->getCurrentPlayerId(),
										'attacking_card_id' => $this->getCard()->getUniqueId(),
										'attacking_card_name' => $this->getCard()->getName(),
										'amount' => array('from' => $player_gold, 'diff' => $amount, 'to' => $game->getUserPlayerGold())
										));
			} else {
				$event->setEventType(GameEvent::TYPE_STEAL_GOLD_FAILED);
				$event->setEventData(array(
										'player_id' => $game->getCurrentPlayerId(),
										'attacking_card_id' => $this->getCard()->getUniqueId(),
										'attacking_card_name' => $this->getCard()->getName()
										));
			}
			$game->addEvent($event);
		}
		
		protected function _stealMagic(CreatureCard $card)
		{
			if (rand(0, 100) <= $this->getStealMagicChance()) {
				$ep = $card->getEP();
				$player_ep = $this->getCard()->getEP();
				$amount = ceil(($ep / 100) * rand(1, $this->getStealMagicAmount()));
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

		protected function _generateOwnPenaltyRounds(Game $game)
		{
			$duration = rand($this->getPenaltyRoundsMin(), $this->getPenaltyRoundsMax());
			if ($duration > 0) {
				$this->_applyEffect($this->getCard(), $game, ModifierEffect::TYPE_STUN, $duration, 0, true);
			}
		}

		protected function _createInitialAttackEvent($card, $recursive, $attacking_from_gold, $attacking_from_ep, $attacking_from_hp)
		{
			$game = $this->getCard()->getGame();
			$card_uid = ($card instanceof CreatureCard) ? $card->getUniqueId() : 0;
			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_ATTACK);
			$event->setEventData(array(
									'player_id' => $game->getCurrentPlayerId(),
									'remaining_actions' => $game->getCurrentPlayerActions(),
									'attacking_card_id' => $this->getCard()->getUniqueId(),
									'attacking_card_name' => $this->getCard()->getName(),
									'attacked_card_id' => $card_uid,
									'attack_type' => $this->getAttackType(),
									'recursive' => (int) $recursive,
									'attacked_card_name' => ($card_uid) ? $card->getName() : '',
									'cost' => array(
												'gold' => array('from' => $attacking_from_gold, 'to' => (($recursive) ? $attacking_from_gold : $game->getUserPlayerGold()), 'diff' => (($recursive) ? 0 : $this->getCostGold())),
												'ep' => array('from' => $attacking_from_ep, 'to' => (($recursive) ? $attacking_from_ep : $this->getCard()->getEP()), 'diff' => (($recursive) ? 0 : $this->getCostMagic())),
												'hp' => array('from' => $attacking_from_hp, 'to' => (($recursive) ? $attacking_from_hp : $this->getCard()->getHP()), 'diff' => (($recursive) ? 0 : $attacking_from_hp - $this->getCard()->getHP()))
												)
									));
			$game->addEvent($event);
		}

		public function perform(CreatureCard $card = null, $recursive = false, $recursive_count = 0)
		{
			$game = $this->getCard()->getGame();
			$card_uid = ($card instanceof CreatureCard) ? $card->getUniqueId() : 0;

			$attacking_from_gold = $game->getUserPlayerGold();
			$attacking_from_ep = $this->getCard()->getInGameEP();
			$attacking_from_hp = $this->getCard()->getInGameHP();
			if (!$recursive) {
				$game->setUserPlayerGold($attacking_from_gold - $this->getCostGold());
				$this->getCard()->setInGameEP($attacking_from_ep - $this->getCostMagic());
				$this->getCard()->setInGameHP($attacking_from_hp - floor(($attacking_from_hp / 100) * $this->getPenaltyDmg()));
				$game->useAction();
			}

			$this->_createInitialAttackEvent($card_uid, $recursive, $attacking_from_gold, $attacking_from_ep, $attacking_from_hp);
			$this_powerup_cards = $this->getCard()->getPowerupCards();
			$opponent_powerup_cards = ($card_uid) ? $card->getPowerupCards() : array();
			
			if ($card_uid && $this->hasAttackPoints()) {
				$this->_generateAttack($card, $this_powerup_cards, $opponent_powerup_cards, 'regular', 0, $recursive_count);
			
				if ($card->getHP() > 0 && $this->isRepeatable()) {
					$repeat_rounds = rand($this->getRepeatRoundsMin(), $this->getRepeatRoundsMax());
					for ($cc = 1; $cc <= $repeat_rounds; $cc++) {
						$this->_generateAttack($card, $this_powerup_cards, $opponent_powerup_cards, 'repeat');
						if ($card->getHP() == 0) break;
					}
				}
			}

			if (!$recursive) {
				if ($card_uid) {
					if ($this->canStealMagic()) {
						$this->_stealMagic($card);
					}

					if ($card->getHP() > 0) {
						$effect = false;
						if ($this->hasEffect()) {
							switch ($this->getAttackType()) {
								case self::TYPE_AIR:
									$effect = $this->_generateAirEffect($card, $game);
									break;
								case self::TYPE_DARK:
									$effect = $this->_generateDarkEffect($card, $game);
									break;
								case self::TYPE_EARTH:
									$effect = $this->_generateEarthEffect($card, $game);
									break;
								case self::TYPE_FIRE:
									$effect = $this->_generateFireEffect($card, $game);
									break;
								case self::TYPE_FREEZE:
									$effect = $this->_generateFreezeEffect($card, $game);
									break;
								case self::TYPE_POISON:
									$effect = $this->_generatePoisonEffect($card, $game);
									break;
								default:
									$effect = $this->_generateAttackEffect($card, $game);
							}
						} else {
							$upcard_1 = $game->getUserPlayerCardSlotPowerupCard1($this->getCard()->getSlot());
							$upcard_2 = $game->getUserPlayerCardSlotPowerupCard2($this->getCard()->getSlot());

							if (!$effect && $upcard_1) {
								if ($upcard_1->getIncreasesAirAttackDamagePercentage()) { 
									$effect = $this->_generateAirEffect($card, $game, 0, $upcard_1->getIncreasesAirAttackDamagePercentage());
								} elseif ($upcard_1->getIncreasesDarkAttackDamagePercentage()) {
									$effect = $this->_generateDarkEffect($card, $game, 0, $upcard_1->getIncreasesDarkAttackDamagePercentage());
								} elseif ($upcard_1->getIncreasesEarthAttackDamagePercentage()) {
									$effect = $this->_generateEarthEffect($card, $game, 0, $upcard_1->getIncreasesEarthAttackDamagePercentage());
								} elseif ($upcard_1->getIncreasesFireAttackDamagePercentage()) {
									$effect = $this->_generateFireEffect($card, $game, 0, $upcard_1->getIncreasesFireAttackDamagePercentage());
								} elseif ($upcard_1->getIncreasesFreezeAttackDamagePercentage()) {
									$effect = $this->_generateFreezeEffect($card, $game, 0, $upcard_1->getIncreasesFreezeAttackDamagePercentage());
								} elseif ($upcard_1->getIncreasesPoisonAttackDamagePercentage()) {
									$effect = $this->_generatePoisonEffect($card, $game, 0, $upcard_1->getIncreasesPoisonAttackDamagePercentage());
								}
							}
							if (!$effect && $upcard_2 && $this->getRequiresItemBoth()) {
								if ($upcard_2->getIncreasesAirAttackDamagePercentage()) {
									$this->_generateAirEffect($card, $game, 0, $upcard_2->getIncreasesAirAttackDamagePercentage());
								} elseif ($upcard_2->getIncreasesDarkAttackDamagePercentage()) {
									$this->_generateDarkEffect($card, $game, 0, $upcard_2->getIncreasesDarkAttackDamagePercentage());
								} elseif ($upcard_2->getIncreasesEarthAttackDamagePercentage()) {
									$this->_generateEarthEffect($card, $game, 0, $upcard_2->getIncreasesEarthAttackDamagePercentage());
								} elseif ($upcard_2->getIncreasesFireAttackDamagePercentage()) {
									$this->_generateFireEffect($card, $game, 0, $upcard_2->getIncreasesFireAttackDamagePercentage());
								} elseif ($upcard_2->getIncreasesFreezeAttackDamagePercentage()) {
									$this->_generateFreezeEffect($card, $game, 0, $upcard_2->getIncreasesFreezeAttackDamagePercentage());
								} elseif ($upcard_2->getIncreasesPoisonAttackDamagePercentage()) {
									$this->_generatePoisonEffect($card, $game, 0, $upcard_2->getIncreasesPoisonAttackDamagePercentage());
								}
							}
						}
					}

					if ($this->doesAttackAll()) {
						$range = range(1, 5);
						shuffle($range);
						foreach ($range as $cc) {
							if ($cc == $card->getSlot()) continue;
							if ($c = $game->getUserOpponentCardSlot($cc)) {
								$this->perform($c, true, $cc);
							}
						}
					}
				}

				if ($this->hasOwnPenaltyRounds()) {
					$this->_generateOwnPenaltyRounds($game);
				}

				if ($this->canStealGold()) {
					$this->_stealGold($game);
				}

				if ($this->doesGenerateGold()) {
					$this->_generateGold($game);
				}
			}
			
			if ($card_uid && $card->getHP() <= 0) {
				$game->removeCard($card);
			}
			
			$game->addAffectedCard($this->getCard());

			$event = new GameEvent();
			$event->setEventType(GameEvent::TYPE_END_ATTACK);
			$event->setEventData(array(
									'player_id' => $game->getCurrentPlayerId(),
									'remaining_actions' => $game->getCurrentPlayerActions(),
									'attacking_card_id' => $this->getCard()->getUniqueId(),
									'attacking_card_name' => $this->getCard()->getName(),
									'attacked_card_id' => $card_uid,
									'recursive' => (int) $recursive,
									'attacked_card_name' => ($card_uid) ? $card->getName() : '',
									));
			$game->addEvent($event);

		}

		public function levelUp($factor, $randomizer)
		{
			$this->_level++;
			$level = $this->_level;
			$oc = $this->getOriginalAttack();
			$increase_ap = false;
			$increase_repeat_ap = false;

			switch (true) {
				case ($randomizer > 90):
					$increase_ap = true;
					break;
				case ($randomizer > 50):
					$increase_repeat_ap = true;
					$increase_ap = true;
					break;
				case ($randomizer > 30):
					$increase_ap = true;
					break;
			}

			if ($increase_ap) {
				if ($this->_attack_points_min > 0) $this->_attack_points_min = round($oc->getAttackPointsMin() + ((($oc->getAttackPointsMin() / 75) * $factor) * $level));
				if ($this->_attack_points_max > 0) $this->_attack_points_max = round($oc->getAttackPointsMax() + ((($oc->getAttackPointsMax() / 75) * $factor) * $level));
				if ($this->_attack_points_restored > 0) $this->_attack_points_restored = round($oc->getAttackPointsRestored() + ((($oc->getAttackPointsRestored() / 75) * $factor) * $level));
				if ($this->_generate_gold_amount > 0) $this->_generate_gold_amount = round($oc->getGenerateGoldAmount() + ((($oc->getGenerateGoldAmount() / 75) * $factor) * $level));
				if ($this->_steal_gold_amount > 0) $this->_steal_gold_amount = round($oc->getStealGoldAmount() + ((($oc->getStealGoldAmount() / 75) * $factor) * $level));
				if ($this->_steal_magic_amount > 0) $this->_steal_magic_amount = round($oc->getStealMagicAmount() + ((($oc->getStealMagicAmount() / 75) * $factor) * $level));
			}
			if ($increase_repeat_ap) {
				if ($this->_repeat_attack_points_min > 0) $this->_repeat_attack_points_min = round($oc->getRepeatAttackPointsMin() + ((($oc->getRepeatAttackPointsMin() / 75) * $factor) * $level));
				if ($this->_repeat_attack_points_max > 0) $this->_repeat_attack_points_max = round($oc->getRepeatAttackPointsMax() + ((($oc->getRepeatAttackPointsMax() / 75) * $factor) * $level));
				if ($this->_steal_gold_chance > 0) $this->_steal_gold_chance = round($oc->getStealGoldChance() + ((($oc->getStealGoldChance() / 75) * $factor) * $level));
				if ($this->_steal_gold_chance > 100) $this->_steal_gold_chance = 100;
				if ($this->_steal_magic_chance > 0) $this->_steal_magic_chance = round($oc->getStealMagicChance() + ((($oc->getStealMagicChance() / 75) * $factor) * $level));
				if ($this->_steal_magic_chance > 100) $this->_steal_magic_chance = 100;
			}

			if ($this->_cost_gold > 0) $this->_cost_gold = floor($oc->getCostGold() + ((($oc->getCostGold() / 90) * $factor) * $level));
			if ($this->_cost_magic > 0) $this->_cost_magic = floor($oc->getCostMagic() + ((($oc->getCostMagic() / 90) * $factor) * $level));
		}

		public function getLevelUpCost()
		{
			return 300 + ($this->getLevel() * 35);
		}

	}