<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo generic card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\Tellables")
	 */
	abstract class Tellable extends \b2db\Saveable
	{

		const TYPE_STORY = 'story';
		const TYPE_CHAPTER = 'chapter';
		const TYPE_PART = 'part';
		const TYPE_ADVENTURE = 'adventure';

		/**
		 * Unique identifier
		 *
		 * @Id
		 * @Column(type="integer", auto_increment=true, length=10)
		 * @var integer
		 */
		protected $_id;

		/**
		 * Tellable type
		 *
		 * @Column(type="string", length=300)
		 * @var string
		 */
		protected $_tellable_type;

		/**
		 * Tellable name
		 * 
		 * @Column(type="text")
		 * 
		 * @var string
		 */
		protected $_name;

		/**
		 * Tellable excerpt, or "introduction"
		 *
		 * @Column(type="text")
		 *
		 * @var string
		 */
		protected $_excerpt;

		/**
		 * Tellable full story
		 *
		 * @Column(type="text")
		 *
		 * @var string
		 */
		protected $_fullstory;

		/**
		 * The area on the map this tellable item applies to
		 * Coordinates: top,left
		 *
		 * @Column(type="serializable", length=100)
		 *
		 * @var array
		 */
		protected $_coordinates = array('x' => 0, 'y' => 0);

		/**
		 * Gold reward
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_reward_gold;

		/**
		 * Required level
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_required_level;

		/**
		 * XP reward
		 *
		 * @Column(type="integer", length=10)
		 * @var integer
		 */
		protected $_reward_xp;

		/**
		 * Whether this tellable is available to neutrals
		 *
		 * @Column(type="integer", length=1)
		 * @var boolean
		 */
		protected $_applies_neutrals;

		/**
		 * Whether this tellable is available to rutai
		 *
		 * @Column(type="integer", length=1)
		 * @var boolean
		 */
		protected $_applies_rutai;

		/**
		 * Whether this tellable is available to resistance
		 *
		 * @Column(type="integer", length=1)
		 * @var boolean
		 */
		protected $_applies_resistance;

		public static function getTypes()
		{
			return array(
				self::TYPE_ADVENTURE => 'Adventure',
				self::TYPE_CHAPTER => 'Chapter',
				self::TYPE_PART => 'Part',
				self::TYPE_STORY => 'Story'
			);
		}

		public function getId()
		{
			return $this->_id;
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

		public function getTellableType()
		{
			return $this->_tellable_type;
		}

		public function setTellableType($tellable_type)
		{
			$this->_tellable_type = $tellable_type;
		}

		public function getExcerpt()
		{
			return $this->_excerpt;
		}

		public function setExcerpt($excerpt)
		{
			$this->_excerpt = $excerpt;
		}

		public function getFullstory()
		{
			return $this->_fullstory;
		}

		public function setFullstory($fullstory)
		{
			$this->_fullstory = $fullstory;
		}

		public function getCoordinates()
		{
			return $this->_coordinates;
		}

		public function getCoordinateX()
		{
			$coord = $this->getCoordinates();
			return (is_array($coord) && array_key_exists('x', $coord)) ? $coord['x'] : 0;
		}

		public function getCoordinateY()
		{
			$coord = $this->getCoordinates();
			return (is_array($coord) && array_key_exists('y', $coord)) ? $coord['y'] : 0;
		}

		public function setCoordinates($top, $left)
		{
			$this->_coordinates = array('x' => $top, 'y' => $left);
		}

		public function setAppliesResistance($val = true)
		{
			$this->_applies_resistance = $val;
		}

		public function getAppliesResistance()
		{
			return (bool) $this->_applies_resistance;
		}

		public function doesApplyToResistance()
		{
			return $this->getAppliesResistance();
		}

		public function setAppliesRutai($val = true)
		{
			$this->_applies_rutai = $val;
		}

		public function getAppliesRutai()
		{
			return (bool) $this->_applies_rutai;
		}

		public function doesApplyToRutai()
		{
			return $this->getAppliesRutai();
		}

		public function setAppliesNeutrals($val = true)
		{
			$this->_applies_neutrals = $val;
		}

		public function getAppliesNeutrals()
		{
			return (bool) $this->_applies_neutrals;
		}

		public function doesApplyToNeutrals()
		{
			return $this->getAppliesNeutrals();
		}

		public function getCardRewards()
		{
			return $this->_b2dbLazyload('_card_rewards');
		}

		public function hasCardRewards()
		{
			if (is_array($this->_card_rewards)) {
				return (bool) count($this->_card_rewards);
			}

			return (bool) $this->_b2dbLazycount('_card_rewards');
		}

		public function getCardOpponents()
		{
			return $this->_b2dbLazyload('_card_opponents');
		}

		public function hasCardOpponents()
		{
			if (is_array($this->_card_opponents)) {
				return (bool) count($this->_card_opponents);
			}

			return (bool) $this->_b2dbLazycount('_card_opponents');
		}

		public function getRequiredLevel()
		{
			return $this->_required_level;
		}

		public function setRequiredLevel($required_level)
		{
			$this->_required_level = $required_level;
		}

		public function getRewardGold()
		{
			return (int) $this->_reward_gold;
		}

		public function setRewardGold($reward_gold)
		{
			$this->_reward_gold = $reward_gold;
		}

		public function getRewardXp()
		{
			return (int) $this->_reward_xp;
		}

		public function setRewardXp($reward_xp)
		{
			$this->_reward_xp = $reward_xp;
		}

		public function isVisibleForUser(User $user)
		{
			$visible = false;
			if ($this->_applies_neutrals && $user->hasCardsInFaction(Card::FACTION_NEUTRALS)) $visible = true;
			if ($this->_applies_resistance && $user->hasCardsInFaction(Card::FACTION_RESISTANCE)) $visible = true;
			if ($this->_applies_rutai && $user->hasCardsInFaction(Card::FACTION_RUTAI)) $visible = true;

			return $visible;
		}

		public function isAvailableForUser($data)
		{
			switch ($this->getTellableType()) {
				case self::TYPE_STORY:
					return true;
				case self::TYPE_CHAPTER:
					return true;
				case self::TYPE_PART:
					if ($this->getPreviousPartId() == 0) return true;
					return (bool) (array_key_exists($this->getPreviousPartId(), $data['part']) && $data['part'][$this->getPreviousPartId()]);
			}
		}

		public function isCompletedForUser($data)
		{
			return (bool) (array_key_exists($this->getId(), $data[$this->getTellableType()]) && $data[$this->getTellableType()][$this->getId()] == true);
		}

		public function getPercentCompleted($data)
		{
			$cc = 0;
			$ccc = 0;
			foreach ($this->getChapters() as $chapter) {
				if (array_key_exists($chapter->getId(), $data['chapter']) && $data['chapter'][$chapter->getId()]) $ccc++;
				foreach ($chapter->getParts() as $part) {
					$cc++;
					if (array_key_exists($part->getId(), $data['part']) && $data['part'][$part->getId()]) $ccc++;
				}
			}
			if ($cc > 0 && $ccc > 0) {
				if ($cc == $ccc) return 100;
				
				return floor(($ccc / $cc) * 100);
			} else {
				return 0;
			}
		}

		public function mergeFormData(\caspar\core\Request $form_data)
		{
			foreach (array('name', 'excerpt', 'fullstory') as $field) {
				$property_name = "_{$field}";
				$this->$property_name = (string) stripslashes($form_data[$field]);
			}
			foreach (array('reward_gold', 'reward_xp', 'required_level') as $field) {
				$property_name = "_{$field}";
				$this->$property_name = (integer) $form_data[$field];
			}
			foreach (array('neutrals', 'rutai', 'resistance') as $field) {
				$property_name = "_applies_{$field}";
				$this->$property_name = $form_data->hasParameter('applies_'.$field);
			}
			$coordinates = explode(',', $form_data['coordinates']);
			$this->setCoordinates($coordinates[0], $coordinates[1]);
		}

	}
