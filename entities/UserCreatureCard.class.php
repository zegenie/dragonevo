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
		
		protected $_user_card_level = 1;
		
		protected $_user_dmp;
		
		public function generateRandomDefenceMultiplier() {
			$level = rand(1, 100);
			switch (true) {
				case $level == 100:
					$this->setUserDMP(8);
					break;
				case $level > 98:
					$this->setUserDMP(7);
					break;
				case $level > 95:
					$this->setUserDMP(6);
					break;
				case $level > 91:
					$this->setUserDMP(5);
					break;
				case $level > 86:
					$this->setUserDMP(4);
					break;
				case $level > 80:
					$this->setUserDMP(3);
					break;
				case $level > 73:
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
		}
		
		public function setUserDMP($multiplier)
		{
			$multiplier = ($multiplier > $this->_base_dmp) ? $this->_base_dmp : $multiplier;
			$this->_user_dmp = $multiplier;
		}
		
	}
