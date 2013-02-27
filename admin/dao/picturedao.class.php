<?php
//picture dao
//zjb
//080801

class PictureDao extends BaseDao
{
	var $logger;

	function PictureDao($db)
	{
		$this->db = $db;
		$this->table = 't_pic';

		$this->logger = new Logger($db);
	}

	function Add($picName,$picUrl,$bigUrl,$isShow,$IsCommend,$typeId,$language,$customerField)
	{
		$orderBy = 1;
		$rs = $this->db->Execute("SELECT * FROM t_pic ORDER BY OrderBy DESC LIMIT 0,1");
		if ($rs->RecordCount() > 0)
		{
			$orderBy = $rs->fields['OrderBy'] +1;
		}
		$record = $this->GetRecord($picName,$picUrl,$bigUrl,date("Y-m-d H:i:s"),$isShow,$IsCommend,$typeId,$language,$customerField,$orderBy);
		$id = $this->Insert($record);
		$this->logger->add(GetIPAddr(),"添加新图片,ID:".$id.",名称:".$picName);
	}

	function Edit($id,$picName,$picUrl,$bigUrl,$isShow,$IsCommend,$typeId,$language,$customerField)
	{
		$record = $this->GetRecord($picName,$picUrl,$bigUrl,date("Y-m-d H:i:s"),$isShow,$IsCommend,$typeId,$language,$customerField);
		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改图片,ID:".$id.",名称:".$picName);
		}
	}

	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除图片,ID:".$id);
	}

	function DeleteByType($typeId)
	{
		$this->Remove("TypeID=".$typeId);
		$this->logger->add(GetIPAddr(),"删除分类图片，分类ID:".$typeId);
	}

	function GetRecord($picName,$picUrl,$bigUrl,$noteTime,$isShow,$IsCommend,$typeId,$language,$customerField,$orderBy=0)
	{
		$record['PicName'] = stripslashes($picName);
		$record['PicUrl'] = $picUrl;
		$record['BigUrl'] = $bigUrl;
		$record['NoteTime'] = $noteTime;
		$record['IsShow'] = $isShow;
		$record['IsCommend'] = $IsCommend;
		$record['TypeID'] = $typeId;
		$record['Language'] = $language;
		if ($orderBy > 0)
			$record['OrderBy'] = $orderBy;

		return $record + $customerField;
	}

	function setShow($id)
	{
		$record['IsShow'] = 1;
		$this->Update($record,"id=".$id);

		$this->logger->add(GetIPAddr(),"图片显示,ID:".$id);
	}

	function setHide($id)
	{
		$record['IsShow'] = 0;
		$this->Update($record,"id=".$id);

		$this->logger->add(GetIPAddr(),"图片隐藏,ID:".$id);
	}

	function setCommend($id)
	{
		$record['IsCommend'] = 1;
		$this->Update($record,"id=".$id);
	}

	function setUnCommend($id)
	{
		$record['IsCommend'] = 0;
		$this->Update($record,"id=".$id);
	}
}
?>