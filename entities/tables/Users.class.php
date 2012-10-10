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
			$crit->addWhere('users.username', $username);
			$crit->addWhere('users.password', $password);
			return $this->selectOne($crit);
		}
		
		public function getByUsername($username)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('users.username', $username);
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
			$crit->addOrderBy('users.isadmin', \b2db\Criteria::SORT_DESC);
			$crit->addOrderBy('users.username', \b2db\Criteria::SORT_ASC);
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
			return $this->select($crit);
		}

	}