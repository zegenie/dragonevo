<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * User->adventures table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="user_adventures")
	 * @Entity(class="\application\entities\UserAdventure")
	 */
	class UserAdventures extends \b2db\Table
	{

		public function getAdventuresByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_adventures.user_id', $user_id);
			$crit->addOrderBy('user_adventures.winning', Criteria::SORT_ASC);

			$adventures = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$adventures[$row->get('user_adventures.adventure_id')] = $row->get('user_adventures.winning');
				}
			}

			return $adventures;
		}

		public function getAttemptsByAdventureIdAndUserId($adventure_id, $user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_adventures.adventure_id', $adventure_id);
			$crit->addWhere('user_adventures.user_id', $user_id);

			$attempts = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$attempts[$row->get('user_adventures.id')] = array('date' => $row->get('user_adventures.date'), 'winning' => $row->get('user_adventures.winning'));
				}
			}

			return $attempts;
		}

	}
