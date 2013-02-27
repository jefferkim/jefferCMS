<?php
//dwonload dao
//zjb
//080804

class DownloadDao extends BaseDao
{
	var $logger;

	function DownloadDao($db)
	{
		$this->db = $db;
		$this->table = "t_download";

		$this->logger = new Logger($db);
	}

	function Add($called,$fileUrl,$memo,$isShow,$isCommend,$typeId,$fileSize,$language,$customerFieldArr)
	{
		$orderBy = 1;
		$rs = $this->db->Execute("SELECT * FROM t_download ORDER BY OrderBy DESC LIMIT 0,1");
		if ($rs->RecordCount() > 0)
		{
			$orderBy = $rs->fields['OrderBy'] + 1;
		}
		$fileSize=round(filesize("../../upload/".$fileUrl)/1024,2);
		
		$record = $this->GetRecord($called,$fileUrl,$memo,$isShow,$isCommend,$orderBy,$typeId,$fileSize,$language,date("Y-m-d H:i:s"));
		$id = $this->Insert($record+$customerFieldArr);

		$this->logger->add(GetIPAddr(),"添加下载,ID:".$id.",名称:".$called);
	}

	function Edit($id,$called,$fileUrl,$memo,$isShow,$isCommend,$typeId,$fileSize,$language,$customerFieldArr)
	{
		$orderBy = 1;
		$rs = $this->db->Execute("SELECT * FROM t_download WHERE id=?",array($id));
		if ($rs->RecordCount() > 0)
		{
			$orderBy = $rs->fields['OrderBy'];
		}
		$fileSize=round(filesize("../../upload/".$fileUrl)/1024,2);
		
		$record = $this->GetRecord($called,$fileUrl,$memo,$isShow,$isCommend,$orderBy,$typeId,$fileSize,$language,date("Y-m-d H:i:s"));
		$ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改下载内容,ID:".$id.",名称:".$called);
		}
	}

	function Delete($id)
	{
		$ok = $this->Remove("id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除下载内容,ID:".$id);
		}
	}

	function DeleteByType($typeId)
	{
		$ok = $this->Remove("TypeID=".$typeId);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除分类下所有下载内容,分类ID:".$typeId);
		}
	}

	function SetShow($id)
	{
		$record['IsShow'] = 1;
		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"将下载内容设置为显示,ID:".$id);
		}
	}

	function SetHide($id)
	{
		$record['IsShow'] = 0;
		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"将下载内容设置为隐藏,ID:".$id);
		}
	}

	function SetCommend($id)
	{
		$record['IsCommend'] = 1;
		$ok = $this->Update($record,"id=".$id);
	}

	function SetUnCommend($id)
	{
		$record['IsCommend'] = 0;
		$ok = $this->Update($record,"id=".$id);
	}

	function GetRecord($called,$fileUrl,$memo,$isShow,$isCommend,$orderBy,$typeId,$fileSize,$language,$noteTime)
	{
		$record['Called'] = stripslashes($called);
		$record['FileURL'] = $fileUrl;
		$record['Memo'] = stripslashes($memo);
		$record['IsShow'] = $isShow;
		$record['OrderBy'] = $orderBy;
		$record['TypeID'] = $typeId;
		$record['FileSize'] = $fileSize;
		$record['Language'] = $language;
		$record['NoteTime'] = $noteTime;
		$record['IsCommend'] = $isCommend;

		return $record;
	}
}
?>