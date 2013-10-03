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
		
		protected function _generateRandomDefenceMultiplier()
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
		
		protected function _generateRandomBaseHealth()
		{
			$base_hp = $this->getBaseHP();
			$diff = ($base_hp / 100) * $this->getBaseHealthRandomness();
			if (rand(0, 100) > 50) {
				$this->setBaseHealth(ceil($base_hp + $diff));
			} else {
				$this->setBaseHealth(floor($base_hp - $diff));
			}
		}

		public function generateUniqueDetails()
		{
			$this->_generateRandomDefenceMultiplier();
			$this->_generateRandomBaseHealth();
			$attacks = $this->getOriginalCard()->getAttacks();
            $attack = $attacks[array_rand($attacks)];
            $cattack = clone $attack;
            $cattack->setCard($this);
            $cattack->setOriginalAttack($attack);
            $cattack->save();
		}
		
	}
