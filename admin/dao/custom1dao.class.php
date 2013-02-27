<?
//content dao
//zjb
//080717

//内容模块DAO
class Custom1Dao extends BaseDao
{
	var $logger;

	function Custom1Dao($db)
	{
		$this->db = $db;
		$this->table = 't_custom1';
		$this->logger = new Logger($db);
	}

	//添加
	function Add($called,$content,$lan,$customerFieldArr)
	{
		$record['Called'] = stripslashes($called);
		$record['Content'] = stripslashes($content);
		$record['Language'] = $lan;
		$record['NoteTime'] = date("Y-m-d H:i:s");

        $id = $this->Insert($record+$customerFieldArr);
		
		$this->logger->add(GetIPAddr(),"添加网站内容，ID:".$id.",名称:".$called);

		return $id;
	}

	//修改
	function Edit($id,$called,$content,$lan,$customerFieldArr)
	{
		$record['Called'] = stripslashes($called);
		$record['Content'] = stripslashes($content);
		$record['Language'] = $lan;
		$record['NoteTime'] = date("Y-m-d H:i:s");

        $ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改网站内容，ID:".$id.",名称:".$called);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}

	//删除
	function Delete($id)
	{
		$ok = $this->Remove("id=".$id);

		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除网站内容，ID:".$id);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}
}
?>