<?
//products dao class
//zjb
//080723

class ProductsDao extends BaseDao
{
	var $logger;

	function ProductsDao($db)
	{
		$this->db = $db;
		$this->table = "t_products";

		$this->logger = new Logger($db);
	}

	//添加产品
	function Add($name,$content,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$webtitle,$webkey,$webdesc,$customerField)
	{
		$record = $this->GetRecord($name,$content,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$webtitle,$webkey,$webdesc,$customerField);

		$id = $this->Insert($record);
		$this->logger->add(GetIPAddr(),"添加新产品,ID:".$id.",名称:".$name);
	}

	//修改产品
	function Edit($id,$name,$content,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$webtitle,$webkey,$webdesc,$customerField)
	{
		$record = $this->GetRecord($name,$content,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$webtitle,$webkey,$webdesc,$customerField);

		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改产品，ID:".$id.",名称:".$name);
		}
	}

	function UpdateProName($id,$name)
	{
		$record['ProName'] = stripcslashes($name);

		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改产品名称,ID:".$id.",名称：".$name);
		}
	}

	//删除产品
	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除产品,ID:".$id);
	}

	function GetRecord($name,$content,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$webtitle,$webkey,$webdesc,$customerField)
	{
		$record['ProName'] = stripcslashes($name);
		$record['Content'] = stripslashes($content);
		$record['Memo'] = stripslashes($memo);
		$record['NoteTime'] = date("Y-m-d H:i:s");
		$record['SmallPic'] = $smallPic;
		$record['IsShow'] = $isShow;
		$record['IsCommend'] = $isCommend;
		$record['OrderBy'] = $orderBy;
		$record['TypeID'] = $typeId;
		$record['Hits'] = 0;
		$record['Language'] = $language;
		$record['WebTitle'] = $webtitle;
		$record['WebKey'] = $webkey;
		$record['WebDesc'] = $webdesc;

		return $record + $customerField;
	}

	//显示
	function setShow($id)
	{
		$record['IsShow'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置产品显示，ID:".$id);
	}

	//隐藏
	function setHide($id)
	{
		$record['IsShow'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置产品隐藏,ID:".$id);
	}

	//推荐
	function setCommend($id)
	{
		$record['IsCommend'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置产品推荐,ID:".$id);
	}

	//取消推荐
	function setUnCommend($id)
	{
		$record['IsCommend'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置产品取消推荐,ID:".$id);
	}

	//根据产品分类删除产品
	function DeleteByType($typeId)
	{
		$this->Remove("TypeID=".$typeId);
		$this->logger->add(GetIPAddr(),"将分类ID=".$typeId."的产品删除");
	}

	//根据产品分类显示产品
	function setShowByType($typeId)
	{
		$record['IsShow'] = 1;

		$this->Update($record,"TypeID=".$typeId);
		$this->logger->add(GetIPAddr(),"将分类ID=".$typeId."的产品设置为显示");
	}

	//根据产品分类隐藏产品
	function setHideByType($typeId)
	{
		$record['IsShow'] = 0;

		$this->Update($record,"TypeID=".$typeId);
		$this->logger->add(GetIPAddr(),"将分类ID=".$typeId."的产品设置为隐藏");
	}

	//设置排序位置
	function setOrder($id,$order)
	{
		$record['OrderBy'] = $order;
		$this->Update($record,"id=".$id);
		//$this->logger->add(GetIPAddr(),"设置产品排序，ID:".$id.",位置:".$order);
	}
}
?>