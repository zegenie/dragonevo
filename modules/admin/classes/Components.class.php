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

		public function componentSkill()
		{
			$this->subskills = \application\entities\tables\Skills::getTable()->getSkillsByRace($this->race, $this->skill->getId());
		}
		
	}
