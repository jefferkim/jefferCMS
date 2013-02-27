<?
//picture type dao
//zjb
//080801
include_once("picturedao.class.php");

class PictureTypeDao extends BaseDao
{
	var $logger;

	function PictureTypeDao($db)
	{
		$this->db = $db;
		$this->table = 't_pictype';

		$this->logger = new Logger($db);
	}

	function Add($called,$memo,$language,$customerFieldArr)
	{
		$record = $this->GetRecord($called,$memo,$language,date("Y-m-d H:i:s"));

		$id = $this->Insert($record+$customerFieldArr);
		$this->logger->add(GetIPAddr(),"添加图片分类,ID:".$id.",名称:".$called);
	}

	function Edit($id,$called,$memo,$language,$customerFieldArr)
	{
		$record = $this->GetRecord($called,$memo,$language,date("Y-m-d H:i:s"));

		$ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改图片分类,ID:".$id."，名称:".$called);
		}
	}

	function Delete($id,$cascade=false)
	{
		$this->Remove("id=".$id);

		if ($cascade)
		{
			$dao = new PictureDao($this->db);
			$dao->DeleteByType($id);
		}

		$this->logger->add(GetIPAddr(),"删除图片分类,ID:".$id);
	}

	function GetRecord($called,$memo,$language,$noteTime)
	{
		$record['Called'] = stripslashes($called);
		$record['Memo'] = stripslashes($memo);
		$record['Language'] = $language;
		if ($noteTime != "")
			$record['NoteTime'] = $noteTime;

		return $record;
	}
}
?>