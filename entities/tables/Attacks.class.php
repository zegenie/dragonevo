<?php

	namespace application\entities\tables;

	use b2db\Table,
		b2db\Criteria;

	/**
	 * @Table(name="attacks")
	 * @Entity(class="\application\entities\Attack")
	 */
	class Attacks extends \b2db\Table
	{
		
		public function removeByCardId($card_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('attacks.card_id', $card_id);
			$this->doDelete($crit);
		}

	}