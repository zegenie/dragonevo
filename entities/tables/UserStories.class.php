<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * User->stories table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="user_stories")
	 * @Entity(class="\application\entities\UserStory")
	 */
	class UserStories extends \b2db\Table
	{

		public function getStoriesByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_stories.user_id', $user_id);
			$crit->addOrderBy('user_stories.winning', Criteria::SORT_ASC);

			$stories = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$stories[$row->get('user_stories.story_id')] = $row->get('user_stories.winning');
				}
			}

			return $stories;
		}

		public function getAttemptsByStoryIdAndUserId($story_id, $user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_stories.story_id', $story_id);
			$crit->addWhere('user_stories.user_id', $user_id);

			$attempts = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$attempts[$row->get('user_stories.id')] = array('date' => $row->get('user_stories.date'), 'winning' => $row->get('user_stories.winning'));
				}
			}

			return $attempts;
		}

	}
