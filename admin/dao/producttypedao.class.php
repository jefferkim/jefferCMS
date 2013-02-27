<?
//product type dao
//zjb
//080722

include_once("productsdao.class.php");

class ProductTypeDao extends BaseDao
{
	var $logger;

	function ProductTypeDao($db)
	{
		$this->db = $db;
		$this->table = 't_protype';

		$this->logger = new Logger($db);
	}

	//添加一个产品分类
	function Add($called,$pid,$language,$isShow,$orderBy,$memo,$picurl,$customerField)
	{
		$typeLevel = 0;
		$parentPath = "";
		
		$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE id=?",array($pid));
		if ($typeRs->RecordCount() > 0)
		{
			$typeObj = $typeRs->FetchObject();
			$typeLevel = $typeObj->TYPELEVEL + 1;
			$parentPath = $typeObj->PARENTPATH;
			if ($parentPath == "")
				$parentPath = $typeObj->ID;
			else
				$parentPath = $parentPath."-".$typeObj->ID;
		}

		$record = $this->GetRecord($called,$pid,$language,$isShow,$orderBy,$memo,$picurl,$customerField);
		$record['TypeLevel'] = $typeLevel;
		$record['ParentPath'] = $parentPath;

		$id = $this->Insert($record);

		$this->logger->add(GetIPAddr(),"添加新产品分类,ID:".$id.",名称:".$called);

		return $this->SUCCESS;
	}

	//修改产品分类
	function Edit($id,$called,$pid,$language,$isShow,$orderBy,$memo,$picurl,$customerField)
	{
		$record = $this->GetRecord($called,$pid,$language,$isShow,$orderBy,$memo,$picurl,$customerField);

		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->UpdateTypeLevel($id,$pid);
			$this->logger->add(GetIPAddr(),"修改产品分类,ID:".$id.",名称:".$called);
			return $this->SUCCESS;
		}
		
		return $this->FAILED;
	}

	//删除产品分类，如果$cascade设置为true,则删除所有子分类及子分类的产品
	function Delete($id,$cascade=false)
	{
		if (!$cascade)
		{
			$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE id=?",array($id));
			if ($typeRs->RecordCount() == 1)
			{
				$typeObj = $typeRs->FetchObject();
				$pid = $typeObj->PID;

				$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE PID=?",array($id));
				while (!$typeRs->EOF)
				{
					$typeObj = $typeRs->FetchObject();
					$record['PID'] = $pid;
					$this->Update($record,"id=".$typeObj->ID);
					$this->UpdateTypeLevel($typeObj->ID,$pid);

					$typeRs->MoveNext();
				}
			}
		}

		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除产品分类,ID:".$id);

		if ($cascade)
		{
			$productDao = new ProductsDao($this->db);
			$productDao->DeleteByType($id);
			$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE PID=?",array($id));
			while (!$typeRs->EOF)
			{
				$typeObj = $typeRs->FetchObject();
				$this->Delete($typeObj->ID,$cascade);
				$typeRs->MoveNext();
			}
		}
	}

	//更新子分类的分类级别
	function UpdateTypeLevel($id,$pid)
	{
		$typeLevel = 0;
		$parentPath = "";
		$parentId = 0;

		$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE id=?",array($pid));
		if ($typeRs->RecordCount() >0)
		{
			$typeObj = $typeRs->FetchObject();
			$typeLevel = $typeObj->TYPELEVEL + 1;
			$parentPath = $typeObj->PARENTPATH;
			if ($parentPath == "")
				$parentPath = $typeObj->ID;
			else
				$parentPath = $parentPath."-".$typeObj->ID;
			$parentId = $typeObj->ID;
		}

		$record['TypeLevel'] = $typeLevel;
		$record['ParentPath'] = $parentPath;
		$record['PID'] = $parentId;

		$this->Update($record,"id=".$id);

		$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE PID=?",array($id));
		while (!$typeRs->EOF)
		{
			$typeObj = $typeRs->FetchObject();
			$this->UpdateTypeLevel($typeObj->ID,$typeObj->PID);
			$typeRs->MoveNext();
		}
	}

	//将分类设为显示
	function setShow($id,$cascade=false)
	{
		$record['IsShow'] = 1;

		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置分类显示,ID:".$id);

		if ($cascade)
		{
			$productDao = new ProductsDao($this->db);
			$productDao->setShowByType($id);
			$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE PID=?",array($id));
			while (!$typeRs->EOF)
			{
				$typeObj = $typeRs->FetchObject();
				$this->setShow($typeObj->ID,$cascade);
				$typeRs->MoveNext();
			}
		}
	}

	//将分类设为隐藏
	function setHide($id,$cascade=false)
	{
		$record['IsShow'] = 0;

		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置分类隐藏,ID:".$id);

		if ($cascade)
		{
			$productDao = new ProductsDao($this->db);
			$productDao->setHideByType($id);
			$typeRs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE PID=?",array($id));
			while (!$typeRs->EOF)
			{
				$typeObj = $typeRs->FetchObject();
				$this->setHide($typeObj->ID,$cascade);
				$typeRs->MoveNext();
			}
		}
	}

	function GetRecord($called,$pid,$language,$isShow,$orderBy,$memo,$picurl,$customerField)
	{
		$record['Called'] = stripslashes($called);
		$record['OrderBy'] = $orderBy;
		$record['IsShow'] = $isShow;
		$record['Memo'] = stripslashes($memo);
		$record['PID'] = $pid;
		$record['Language'] = $language;
		$record['NoteTime'] = date("Y-m-d H:i:s");
		$record['PicUrl'] = $picurl;

		return $record + $customerField;
	}
}
?>