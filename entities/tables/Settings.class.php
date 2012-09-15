<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * Settings table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="settings")
	 */
	class Settings extends \b2db\Table
	{

		protected function _initialize()
		{
			parent::_setup('settings', 'settings.id');
			parent::_addVarchar('settings.name', 45);
			parent::_addVarchar('settings.value', 200);
			parent::_addInteger('settings.user_id', 10);
		}
		
		public function getSettings($uid = 0)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('settings.user_id', $uid);
			$res = $this->doSelect($crit);
			return $res;
		}

		public function saveSetting($name, $value, $uid)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('settings.name', $name);
			$crit->addWhere('settings.user_id', $uid);
			$res = $this->doSelectOne($crit);

			if ($res instanceof \b2db\Row)
			{
				$theID = $res->get('settings.id');
				$crit2 = new Criteria();
				$crit2->addWhere('settings.name', $name);
				$crit2->addWhere('settings.user_id', $uid);
				$crit2->addWhere('settings.id', $theID, Criteria::DB_NOT_EQUALS);
				$res2 = $this->doDelete($crit2);
				
				$crit = $this->getCriteria();
				$crit->addUpdate('settings.name', $name);
				$crit->addUpdate('settings.user_id', $uid);
				$crit->addUpdate('settings.value', $value);
				$this->doUpdateById($crit, $theID);
			}
			else
			{
				$crit = $this->getCriteria();
				$crit->addInsert('settings.name', $name);
				$crit->addInsert('settings.value', $value);
				$crit->addInsert('settings.user_id', $uid);
				$this->doInsert($crit);
			}
		}

		public function deleteSetting($name, $uid)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('settings.name', $name);
			$crit->addWhere('settings.user_id', $uid);
			$this->doDelete($crit);
		}

	}
