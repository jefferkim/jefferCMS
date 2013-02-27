<?
//content dao
//zjb
//080717

//内容模块DAO
class SeoDao extends BaseDao
{
	var $logger;

	function SeoDao($db)
	{
		$this->db = $db;
		$this->table = 't_seo';
		$this->logger = new Logger($db);
	}

	//添加
	function Add($title,$lan,$keywords,$description,$url,$customerFieldArr)
	{
		$record['Title'] = stripslashes($title);
		$record['Language'] = $lan;
		$record['Keywords'] = stripslashes($keywords);
		$record['Description'] = stripslashes($description);
		$record['Url'] = stripslashes($url);
		

        $id = $this->Insert($record+$customerFieldArr);
		
		$this->logger->add(GetIPAddr(),"添加网站seo，ID:".$id.",名称:".$title);

		return $id;
	}

	//修改
	function Edit($id,$title,$lan,$keywords,$description,$url,$customerFieldArr)
	{
		$record['Title'] = stripslashes($title);
		$record['Language'] = $lan;
		$record['Keywords'] = stripslashes($keywords);
		$record['Description'] = stripslashes($description);
		$record['Url'] = stripslashes($url);

        $ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"添加网站seo，ID:".$id.",名称:".$title);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}
}
?>