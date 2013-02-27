<?
//content dao
//zjb
//080717

//内容模块DAO
class ContentDao extends BaseDao
{
	var $logger;

	function ContentDao($db)
	{
		$this->db = $db;
		$this->table = 't_global';
		$this->logger = new Logger($db);
	}

	//添加
	function Add($webname,$title,$web,$upload,$beian,$keywords,$description,$lan)
	{
		$record['Webname'] = stripslashes($webname);
		$record['Title'] = stripslashes($title);
		$record['Web'] = stripslashes($web);
		$record['Upload'] = stripslashes($upload);
		$record['Beian'] = stripslashes($beian);
		$record['Keywords'] = stripslashes($keywords);
		$record['Description'] = stripslashes($description);
		$record['Language'] = $lan;

		$id = $this->Insert($record);

		$this->logger->add(GetIPAddr(),"添加网站内容，ID:".$id.",名称:".$webname);

		return $id;
	}

	//修改
	function Edit($id,$webname,$title,$web,$upload,$beian,$keywords,$description,$lan)
	{
		$record['Webname'] = stripslashes($webname);
		$record['Title'] = stripslashes($title);
		$record['Web'] = stripslashes($web);
		$record['Upload'] = stripslashes($upload);
		$record['Beian'] = stripslashes($beian);
		$record['Keywords'] = stripslashes($keywords);
		$record['Description'] = stripslashes($description);
		$record['Language'] = $lan;

		$ok = $this->Update($record,"id=".$id);

		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改网站内容，ID:".$id.",名称:".$webname);
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