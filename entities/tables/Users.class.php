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
			$crit = $this->getCriteria();
			$crit->addWhere('users.username', $username);
			$crit->addWhere('users.password', $password);
			return $this->selectOne($crit);
		}
		
	}