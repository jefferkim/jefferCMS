<?
//newstype dao
//zjb
//080717

include_once("newsdao.class.php");

//新闻分类dao
class NewsTypeDao extends BaseDao
{
	var $logger;

	function NewsTypeDao($db)
	{
		$this->db = $db;
		$this->table = 't_newtype';
		
		$this->logger = new Logger($db);
	}

	//添加新闻分类
	function Add($called,$lan,$customerFieldArr)
	{
		$record['Called'] = stripslashes($called);
		$record['Language'] = $lan;

		$id = $this->Insert($record+$customerFieldArr);

		$this->logger->add(GetIPAddr(),"添加新闻分类，ID:".$id.",分类名称:".$called);
		return $id;
	}

	//修改新闻分类
	function Edit($id,$called,$lan,$customerFieldArr)
	{
		$record['Called'] = stripslashes($called);
		$record['Language'] = $lan;

		$ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改新闻分类，ID:".$id.",分类名称:".$called);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}

	//删除新闻分类并删除分类下的所有新闻
	function Delete($id,$cascade=false)
	{
		$ok = $this->Remove("id=".$id);

		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除新闻分类,ID:".$id);
			if ($cascade)
			{
				$newsDao = NewsDao($this->db);
				$newsDao->DeleteByType($id);
			}

			return $this->SUCCESS;
		}

		return $this->FAILED;
	}
}
?>