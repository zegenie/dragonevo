<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * User->chapters table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="user_chapters")
	 * @Entity(class="\application\entities\UserChapter")
	 */
	class UserChapters extends \b2db\Table
	{

		public function getChaptersByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_chapters.user_id', $user_id);
			$crit->addOrderBy('user_chapters.winning', Criteria::SORT_ASC);

			$chapters = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$chapters[$row->get('user_chapters.chapter_id')] = $row->get('user_chapters.winning');
				}
			}

			return $chapters;
		}

		public function getAttemptsByChapterIdAndUserId($chapter_id, $user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_chapters.chapter_id', $chapter_id);
			$crit->addWhere('user_chapters.user_id', $user_id);

			$attempts = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$attempts[$row->get('user_chapters.id')] = array('date' => $row->get('user_chapters.date'), 'winning' => $row->get('user_chapters.winning'));
				}
			}

			return $attempts;
		}

	}
