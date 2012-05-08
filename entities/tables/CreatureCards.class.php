<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="creature_cards")
	 * @Entity(class="\application\entities\CreatureCard")
	 * @Entities(identifier="card_state")
	 * @SubClasses(template="\application\entities\CreatureCard", owned="\application\entities\UserCreatureCard")
	 */
	class CreatureCards extends \b2db\Table
	{
		
		public function getAll()
		{
			return $this->selectAll();
		}
		
		public function getNumberOfCards()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->count($crit);
		}

		public function getByFaction($faction)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.faction', $faction);
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_TEMPLATE);
			return $this->select($crit);
		}

		public function getByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('creature_cards.user_id', $user_id);
			$crit->addWhere('creature_cards.card_state', \application\entities\Card::STATE_OWNED);
			return $this->select($crit);
		}

	}