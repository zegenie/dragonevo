<?php

	namespace application\entities;

	use \caspar\core\Caspar;

	/**
	 * Dragon Evo "placable" (item / creature) card class
	 *
	 * @package dragonevo
	 * @subpackage core
	 *
	 * @Table(name="\application\entities\tables\CreatureCards")
	 */
	class UserCreatureCard extends CreatureCard
	{
		
		public function generateRandomDefenceMultiplier()
		{
			$level = rand(1, 100);
			switch (true) {
				case $level == 100:
					$this->setUserDMP(8);
					break;
				case $level > 99:
					$this->setUserDMP(7);
					break;
				case $level > 97:
					$this->setUserDMP(6);
					break;
				case $level > 94:
					$this->setUserDMP(5);
					break;
				case $level > 90:
					$this->setUserDMP(4);
					break;
				case $level > 85:
					$this->setUserDMP(3);
					break;
				case $level > 75:
					$this->setUserDMP(2);
					break;
				default:
					$this->setUserDMP(1);
					break;
			}
		}
		
		public function generateUniqueDetails()
		{
			$this->generateRandomDefenceMultiplier();
			$attacks = 0;
			foreach ($this->getOriginalCard()->getAttacks() as $attack) {
				if (!$attack->isMandatory()) {
					if (rand(0, 10) > rand(0, 10)) continue;
				}
				$cattack = clone $attack;
				$cattack->setCard($this);
				$cattack->save();
				$attacks++;
				if ($attacks == 3) break;
			}
		}
		
	}
