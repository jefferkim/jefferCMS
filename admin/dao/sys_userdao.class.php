<?
//admin dao
//tgr
//080717

//系统管理模块DAO
class AdminDao extends BaseDao
{
	var $logger;

	function AdminDao($db)
	{
		$this->db = $db;
		$this->table = 't_admin';
		$this->logger = new Logger($db);
	}

	function Edit($id,$username,$password,$role)
	{
		$record['UserName'] = stripslashes($username);
		$record['PassWord'] = stripslashes($password);
		$record['UserRole'] = $role;

        $ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改系统管理，ID:".$id.",用户名:".$username);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}


	
	function Lock($id)
	{
		$record['IsLock'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"锁定系统管理,ID:".$id);
	}

	function UnLock($id)
	{
		$record['IsLock'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"解锁系统管理员,ID:".$id);
	}
	//删除
	function Delete($id)
	{
		$ok = $this->Remove("id=".$id);

		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除系统管理，ID:".$id);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}
}
?>