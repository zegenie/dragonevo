<?php 

	namespace application\modules\admin;

	/**
	 * market action components
	 */
	class Components extends \caspar\core\Components
	{
		
		public function componentAttack()
		{
			
		}
		
		public function componentCardAttack()
		{
			
		}

		public function componentTellable()
		{
			switch (true) {
				case ($this->tellable instanceof \application\entities\Story):
					$this->children = $this->tellable->getChapters();
					break;
				case ($this->tellable instanceof \application\entities\Chapter || $this->tellable instanceof \application\entities\Adventure):
					$this->children = $this->tellable->getParts();
					break;
			}
		}

		public function componentTellableCoordinates()
		{
			$stories = array();
			$adventures = array();
			if (!$this->tellable_id) $this->tellable_id = null;
			switch ($this->tellable_type) {
				case 'story':
					$this->tellable = new \application\entities\Story($this->tellable_id);
					$stories = array($this->tellable);
					break;
				case 'chapter':
					$this->tellable = new \application\entities\Chapter($this->tellable_id);
					$stories = array(new \application\entities\Story($this->parent_id));
					break;
				case 'part':
					$this->tellable = new \application\entities\Part($this->tellable_id);
					if ($this->parent_type == 'chapter') {
						$this->parent = new \application\entities\Chapter($this->parent_id);
						$stories = array($this->parent->getStory());
					} else {
						$this->parent = new \application\entities\Adventure($this->parent_id);
						$adventures = array($this->parent);
					}
					break;
				case 'adventure':
					$this->tellable = new \application\entities\Adventure($this->tellable_id);
					$adventures = array($this->tellable);
					break;
			}
			$this->adventures = $adventures;
			$this->stories = $stories;
		}

		public function componentAddCardReward()
		{
			$equippable_item = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$potion_item = \application\entities\tables\PotionItemCards::getTable()->getAll();
			$event = \application\entities\tables\EventCards::getTable()->getAll();
			$creature = array();
			foreach (\application\entities\Card::getFactions() as $faction => $description) {
				$creature[$faction] = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			}
			$this->cards = compact('equippable_item', 'potion_item', 'event', 'creature');
		}

		public function componentAddCardOpponent()
		{
			$equippable_item = \application\entities\tables\EquippableItemCards::getTable()->getAll();
			$potion_item = \application\entities\tables\PotionItemCards::getTable()->getAll();
			$creature = array();
			foreach (\application\entities\Card::getFactions() as $faction => $description) {
				$creature[$faction] = \application\entities\tables\CreatureCards::getTable()->getByFaction($faction);
			}
			$this->cards = compact('equippable_item', 'potion_item', 'creature');
		}

		public function componentSkill()
		{
			$this->subskills = \application\entities\tables\Skills::getTable()->getSkillsByRace($this->race, $this->skill->getId());
		}
		
	}
