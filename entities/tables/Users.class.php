<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="users")
	 * @Entity(class="\application\entities\User")
	 */
	class Users extends \b2db\Table
	{

		public function loginCheck($username, $password)
		{
			if (!$username || !$password) {
				return null;
			}
			$crit = $this->getCriteria();
			$crit->addWhere('users.username', strtolower($username), \b2db\Criteria::DB_EQUALS, '', '', \b2db\Criteria::DB_LOWER);
			$crit->addWhere('users.password', $password);
			return $this->selectOne($crit);
		}
		
		public function getByUsername($username)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.username', $username);
			return $this->selectOne($crit);
		}
		
		public function getByEmail($email)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.email', $email);
			return $this->selectOne($crit);
		}

		public function validateCode($code)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.password', "%{$code}", \b2db\Criteria::DB_LIKE);
			return (bool) $this->count($crit);
		}

		public function validateUsername($username)
		{
			if (!trim($username)) return false;
			$crit = $this->getCriteria();
			$crit->addWhere('users.username', $username);
			return !(bool) $this->count($crit);
		}

		public function getLoggedInUsers()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.lastseen', time() - 900, \b2db\Criteria::DB_GREATER_THAN_EQUAL);
			return $this->select($crit);
		}

		public function getNumberOfRegisteredUsers()
		{
			$crit = $this->getCriteria();
			return $this->doCount($crit);
		}
		
		public function getNumberOfRegisteredUsersLastWeek()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.created_at', time() - 604800, \b2db\Criteria::DB_GREATER_THAN_EQUAL);
			return $this->doCount($crit);
		}

		public function getNumberOfRegisteredUsersLast24Hours()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.created_at', time() - 86400, \b2db\Criteria::DB_GREATER_THAN_EQUAL);
			return $this->doCount($crit);
		}

		public function getNumberOfLoggedInUsersLastWeek()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.lastseen', time() - 604800, \b2db\Criteria::DB_GREATER_THAN_EQUAL);
			return $this->doCount($crit);
		}

		public function getNumberOfLoggedInUsers()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.lastseen', time() - 900, \b2db\Criteria::DB_GREATER_THAN_EQUAL);
			return $this->doCount($crit);
		}

		public function getNumberOfLoggedInUsersLast24Hours()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.lastseen', time() - 86400, \b2db\Criteria::DB_GREATER_THAN_EQUAL);
			return $this->doCount($crit);
		}
		
		public function getAll()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.ai_level', \application\entities\User::AI_HUMAN);
			$crit->addOrderBy('users.isadmin', \b2db\Criteria::SORT_DESC);
			$crit->addOrderBy('users.created_at', \b2db\Criteria::SORT_ASC);
			return $this->select($crit);
		}

		public function findByInfo($userinfo)
		{
			$crit = $this->getCriteria();
			if (filter_var($userinfo, FILTER_VALIDATE_EMAIL) == $userinfo) {
				$crit->addWhere('users.email', $userinfo);
			} else {
				$crit->addWhere('users.username', $userinfo);
			}
			$crit->addWhere('users.email', '', \b2db\Criteria::DB_NOT_EQUALS);
			return $this->select($crit);
		}
		
		public function getByRanking($mode)
		{
			$crit = $this->getCriteria();
			$crit->addSelectionColumn('users.id', 'id');
			$crit->addSelectionColumn('users.charactername', 'character_name');
			$crit->addSelectionColumn('users.username', 'username');
			$crit->addSelectionColumn('users.ranking_'.$mode, 'rank');
			$crit->addSelectionColumn('users.ranking_points_'.$mode, 'points');
			$crit->addOrderBy('users.ranking_'.$mode, \b2db\Criteria::SORT_ASC);
			
			$return_array = array();
			$res = $this->doSelect($crit);
			if ($res) {
				while ($row = $res->getNextRow()) {
					$return_array[] = array('rank' => $row['rank'], 'points' => $row['points'], 'name' => ($row['character_name']) ? $row['character_name'] : $row['username']);
				}
			}
			
			return $return_array;
		}

		public function updateRanking()
		{
			$return_array = array();
			foreach (array('sp', 'mp') as $item) {
				$var = "{$item}_users";
				$return_array[$var] = array();
				$crit = $this->getCriteria();
				$crit->addSelectionColumn('users.id', 'id');
				$crit->addSelectionColumn('users.username', 'username');
				$crit->addOrderBy("users.ranking_points_{$item}", 'desc');
				$res = $this->doSelect($crit);

				$cc = 1;
				if ($res) {
					while ($row = $res->getNextRow()) {
						$c = $this->getCriteria();
						$c->addUpdate("users.ranking_{$item}", $cc);
						$this->doUpdateById($c, $row['id']);

						$return_array[$var][$row['username']] = $cc;
						$cc++;
					}
				}
			}

			return $return_array;
		}

	}