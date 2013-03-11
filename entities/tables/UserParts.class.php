<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * User->parts table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="user_parts")
	 * @Entity(class="\application\entities\UserPart")
	 */
	class UserParts extends \b2db\Table
	{

		public function getPartsByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_parts.user_id', $user_id);
			$crit->addOrderBy('user_parts.winning', Criteria::SORT_ASC);

			$parts = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$parts[$row->get('user_parts.part_id')] = $row->get('user_parts.winning');
				}
			}

			return $parts;
		}

		public function getAttemptsByPartIdAndUserId($part_id, $user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_parts.part_id', $part_id);
			$crit->addWhere('user_parts.user_id', $user_id);

			$attempts = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$attempts[$row->get('user_parts.id')] = array('date' => $row->get('user_parts.date'), 'winning' => $row->get('user_parts.winning'));
				}
			}

			return $attempts;
		}

	}
