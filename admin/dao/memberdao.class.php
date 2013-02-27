<?
//member dao
//zjb
//080729

class MemberDao extends BaseDao
{
	var $logger;

	function MemberDao($db)
	{
		$this->db = $db;
		$this->table = "t_user";

		$this->logger = new Logger($db);
	}

	function Add($username,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$customerField)
	{
		$record = $this->GetRecord($username,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,date("Y-m-d H:i:s"),$customerField);

		$id = $this->Insert($record);
		$this->logger->add(GetIPAddr(),"添加新会员，ID:".$id.",用户名：".$username);
	}

	function Edit($id,$username,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$customerField)
	{
		$record = $this->GetRecord($username,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,"",$customerField);

		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改会员,ID:".$id.",用户名：".$username);
		}
	}

	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除会员，ID:".$id);
	}

	function Lock($id)
	{
		$record['IsLock'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"锁定会员,ID:".$id);
	}

	function UnLock($id)
	{
		$record['IsLock'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"解锁会员,ID:".$id);
	}

	function GetRecord($username,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$noteTime,$customerField)
	{
		$record['UserName'] = $username;
		$record['Password'] = $password;
		$record['Called'] = stripslashes($called);
		$record['Tel'] = $tel;
		$record['Mobile'] = $mobile;
		$record['Mail'] = $mail;
		$record['Company'] = $company;
		$record['IsLock'] = $isLock;
		$record['Language'] = $language;
		if ($noteTime != "")
			$record['NoteTime'] = $noteTime;

		return $record + $customerField;
	}
}
?>