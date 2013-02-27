<?
//news dao
//zjb
//080717

//News dao
class NewsDao extends BaseDao
{
	var $logger;

	function NewsDao($db)
	{
		$this->db = $db;
		$this->table = 't_news';

		$this->logger = new Logger($db);
	}

	//添加新闻
	function add($title,$content,$userName,$isShow,$isCommend,$orderBy,$newsType,$language,$parent,$webtitle,$showtime,$webkey,$webdesc,$smallPic,$customerFieldArr)
	{
		$record['Title'] = stripslashes($title);
		$record['Content'] = stripslashes($content);
		$record['UserName'] = stripslashes($userName);
		$record['IsShow'] = $isShow;
		$record['IsCommend'] = $isCommend;
		$record['OrderBy'] = $orderBy;
		$record['NewType'] = $newsType;
		$record['Language'] = $language;
		$record['Parent'] = $parent;
		$record['WebTitle'] = $webtitle;
		$record['WebKey'] = $webkey;
		$record['WebDesc'] = $webdesc;
		$record['ShowTime'] = $showtime;
		$record['SmallPic'] = $smallPic;
		$record['NoteTime'] = date("Y-m-d H:i:s");
		$record['Hits'] = 0;

		$id = $this->Insert($record+$customerFieldArr);

		$this->logger->add(GetIPAddr(),"添加新闻，ID:".$id.",标题:".$title);

		return $id;
	}

	//修改新闻
	function Edit($id,$title,$content,$userName,$isShow,$isCommend,$orderBy,$newsType,$language,$parent,$webtitle,$showtime,$webkey,$webdesc,$smallPic,$customerFieldArr)
	{
		$record['Title'] = stripslashes($title);
		$record['Content'] = stripslashes($content);
		$record['UserName'] = stripslashes($userName);
		$record['IsShow'] = $isShow;
		$record['IsCommend'] = $isCommend;
		$record['OrderBy'] = $orderBy;
		$record['NewType'] = $newsType;
		$record['Language'] = $language;
		$record['Parent'] = $parent;
		$record['WebTitle'] = $webtitle;
		$record['WebKey'] = $webkey;
		$record['WebDesc'] = $webdesc;
		$record['ShowTime'] = $showtime;
		$record['SmallPic'] = $smallPic;
		$record['NoteTime'] = date("Y-m-d H:i:s");

		$ok = $this->Update($record+$customerFieldArr,"id=".$id);

		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改新闻，ID:".$id.",新闻标题：".$title);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}

	//删除新闻
	function Delete($id)
	{
		$ok = $this->Remove("id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除新闻，ID:".$id);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}

	//根据分类ID删除新闻
	function DeleteByType($typeid)
	{
		$ok = $this->Remove("NewType=".$typeid);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除分类下的新闻，分类ID:".$typeid);
			return $this->SUCCESS;
		}
		
		return $this->FAILED;
	}

	//显示
	function SetShow($id)
	{
		$record['IsShow'] = 1;

		$this->Update($record,"id=".$id);

		$this->logger->add(GetIPAddr(),"设置新闻显示,ID:".$id);
	}

	//隐藏
	function SetUnShow($id)
	{
		$record['IsShow'] = 0;
		$this->Update($record,"id=".$id);

		$this->logger->add(GetIPAddr(),"设置新闻隐藏,ID:".$id);
	}

	//推荐
	function SetCommend($id)
	{
		$record['IsCommend'] = 1;
		$this->Update($record,"id=".$id);

		$this->logger->add(GetIPAddr(),"设置新闻推荐,ID:".$id);
	}

	//取消推荐
	function SetUnCommend($id)
	{
		$record['IsCommend'] = 0;
		$this->Update($record,"id=".$id);

		$this->logger->add(GetIPAddr(),"设置新闻推荐取消,ID:".$id);
	}

	function SetOrder($id,$order)
	{
		$record['OrderBy'] = $order;
		$this->Update($record,'id='.$id);

		$this->logger->add(GetIPAddr(),"设置新闻排序,ID:".$id);
	}
}
?>