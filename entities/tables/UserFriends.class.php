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
	 * @Table(name="user_friends")
	 * @Entity(class="\application\entities\UserFriend")
	 */
	class UserFriends extends \b2db\Table
	{

		public function getFriendsByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('user_friends.user_id', $user_id);
			$crit->addOr('user_friends.friend_user_id', $user_id);

			return $this->select($crit);
		}

	}
