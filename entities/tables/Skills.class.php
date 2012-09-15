<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="skills")
	 * @Entity(class="\application\entities\Skill")
	 */
	class Skills extends \b2db\Table
	{

		public function getSkillsByRace($race, $parent_skill_id = null)
		{
			$crit = $this->getCriteria();
			switch ($race) {
				case \application\entities\User::RACE_HUMAN:
					$crit->addWhere('skills.race_human', true);
					$crit->addWhere('skills.race_lizard', false);
					$crit->addWhere('skills.race_beast', false);
					$crit->addWhere('skills.race_elf', false);
					break;
				case \application\entities\User::RACE_LIZARD:
					$crit->addWhere('skills.race_human', false);
					$crit->addWhere('skills.race_lizard', true);
					$crit->addWhere('skills.race_beast', false);
					$crit->addWhere('skills.race_elf', false);
					break;
				case \application\entities\User::RACE_BEAST:
					$crit->addWhere('skills.race_human', false);
					$crit->addWhere('skills.race_lizard', false);
					$crit->addWhere('skills.race_beast', true);
					$crit->addWhere('skills.race_elf', false);
					break;
				case \application\entities\User::RACE_ELF:
					$crit->addWhere('skills.race_human', false);
					$crit->addWhere('skills.race_lizard', false);
					$crit->addWhere('skills.race_beast', false);
					$crit->addWhere('skills.race_elf', true);
					break;
			}
			if ($parent_skill_id !== null) {
				$crit->addWhere('skills.parent_skill_id', $parent_skill_id);
			} else {
				$crit->addWhere('skills.parent_skill_id', 0);
			}

			return $this->select($crit);
		}

		public function countSubSkills($parent_skill_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('skills.parent_skill_id', $parent_skill_id);

			return $this->count($crit);
		}

		public function getSubSkills($parent_skill_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('skills.parent_skill_id', $parent_skill_id);

			return $this->select($crit);
		}

		public function getAll()
		{
			return $this->selectAll();
		}

	}