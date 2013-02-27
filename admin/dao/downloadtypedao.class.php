<?
//download type dao
//zjb
//080804

include_once("downloaddao.class.php");

class DownloadTypeDao extends BaseDao
{
	var $logger;

	function DownloadTypeDao($db)
	{
		$this->db = $db;
		$this->table = "t_downloadtype";

		$this->logger = new Logger($db);
	}

	function Add($called,$memo,$language,$customerFieldArr)
	{
		$record = $this->GetRecord($called,$memo,$language,date("Y-m-d H:i:s"));

		$id = $this->Insert($record+$customerFieldArr);
		$this->logger->add(GetIPAddr(),"添加下载分类,ID:".$id.",名称:".$called);
	}

	function Edit($id,$called,$memo,$language,$customerFieldArr)
	{
		$record = $this->GetRecord($called,$memo,$language,date("Y-m-d H:i:s"));
		$ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改下载分类,ID:".$id.",名称:".$called);
		}
	}

	function Delete($id,$cascade=false)
	{
		$ok = $this->Remove("id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除下载分类,ID:".$id);

			if ($cascade)
			{
				$downloadDao = new DownloadDao($this->db);
				$downloadDao->DeleteByType($id);
			}
		}
	}

	function GetRecord($called,$memo,$language,$noteTime)
	{
		$record['Called'] = stripslashes($called);
		$record['Memo'] = stripslashes($memo);
		$record['Language'] = $language;
		$record['NoteTime'] = $noteTime;

		return $record;
	}
}
?>