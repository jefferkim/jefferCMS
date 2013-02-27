<?
//member dao
//zjb
//080729

class ComMemberDao extends BaseDao
{
	var $logger;

	function ComMemberDao($db)
	{
		$this->db = $db;
		$this->table = "t_comuser";

		$this->logger = new Logger($db);
	}

	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除行业会员，ID:".$id);

		$rs = $this->db->Execute("SHOW TABLES LIKE 't_supply'");
		if ($rs->RecordCount() == 1)
		{
			$this->db->Execute("DELETE FROM t_supply WHERE MemberId=?",array($id));
		}
		$rs = $this->db->Execute("SHOW TABLES LIKE 't_buy'");
		if ($rs->RecordCount() == 1)
		{
			$this->db->Execute("DELETE FROM t_buy WHERE MemberId=?",array($id));
		}
	}

	function Lock($id)
	{
		$record['IsLock'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"锁定行业会员,ID:".$id);
	}

	function UnLock($id)
	{
		$record['IsLock'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"解锁行业会员,ID:".$id);
	}

	function Commend($id)
	{
		$record['IsCommend'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置为推荐行业会员,ID:".$id);
	}

	function UnCommend($id)
	{
		$record['IsCommend'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"取消推荐行业会员,ID:".$id);
	}

	function Excellent($id)
	{
		$record['IsExcellent'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置为优秀行业会员,ID:".$id);
	}

	function UnExcellent($id)
	{
		$record['IsExcellent'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"取消优秀行业会员,ID:".$id);
	}
}
?>