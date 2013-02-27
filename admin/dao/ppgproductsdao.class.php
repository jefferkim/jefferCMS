<?
//ppgproducts dao class
//zjb
//080919

class PpgProductsDao extends BaseDao
{
	var $logger;

	function PpgProductsDao($db)
	{
		$this->db = $db;
		$this->table = "t_ppgproducts";

		$this->logger = new Logger($db);
	}

	//添加产品
	function Add($name,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$color,$img,$spic,$mpic,$bpic,$customerField)
	{
		$record = $this->GetRecord($name,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$customerField);

		$id = $this->Insert($record);
		
		//add color
		$colorArr = explode(",",$color);
		$imgArr = explode(",",$img);
		$spicArr = explode(",",$spic);
		$mpicArr = explode(",",$mpic);
		$bpicArr = explode(",",$bpic);

		$len = count($colorArr);
		for ($i=0; $i<$len; $i++)
		{
			if ($colorArr[$i] != "" && $imgArr[$i] != "")
			{
				$colorRecord = array(
					'ProductId' => $id,
					'Name' => $colorArr[$i],
					'Picture' => $imgArr[$i]
				);

				$this->db->AutoExecute('t_ppgcolors',$colorRecord,'INSERT');
				$colorId = $this->db->Insert_ID();

				//add picture
				$s = explode("|",$spicArr[$i]);
				$m = explode("|",$mpicArr[$i]);
				$b = explode("|",$bpicArr[$i]);

				$len1 = count($s);
				for ($j=0; $j<$len1; $j++)
				{
					if ($s[$j]!="" && $m[$j]!="" && $b[$j]!="")
					{
						$picRecord = array(
							'ProductId' => $id,
							'ColorId' => $colorId,
							'SmallPic' => $s[$j],
							'MiddlePic' => $m[$j],
							'BigPic' => $b[$j]
						);
						$this->db->AutoExecute('t_ppgpictures',$picRecord,'INSERT');
					}
				}
			}
		}

		$this->logger->add(GetIPAddr(),"添加新产品,ID:".$id.",名称:".$name);
	}

	//修改产品
	function Edit($id,$name,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$color,$img,$spic,$mpic,$bpic,$customerField)
	{
		$record = $this->GetRecord($name,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$customerField);

		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			//delete old colors
			$this->db->Execute("DELETE FROM t_ppgcolors WHERE ProductId=?",array($id));
			$this->db->Execute("DELETE FROM t_ppgpictures WHERE ProductId=?",array($id));
			
			//add new colors
			$colorArr = explode(",",$color);
			$imgArr = explode(",",$img);
			$spicArr = explode(",",$spic);
			$mpicArr = explode(",",$mpic);
			$bpicArr = explode(",",$bpic);

			$len = count($colorArr);
			for ($i=0; $i<$len; $i++)
			{
				if ($colorArr[$i]!="" && $imgArr[$i]!="")
				{
					$colorRecord = array(
						'ProductId' => $id,
						'Name' => $colorArr[$i],
						'Picture' => $imgArr[$i]
					);

					$this->db->AutoExecute('t_ppgcolors',$colorRecord,'INSERT');
					$colorId = $this->db->Insert_ID();

					//add picture
					$s = explode("|",$spicArr[$i]);
					$m = explode("|",$mpicArr[$i]);
					$b = explode("|",$bpicArr[$i]);

					$len1 = count($s);
					for ($j=0; $j<$len1; $j++)
					{
						if ($s[$j]!="" && $m[$j]!="" && $b[$j]!="")
						{
							$picRecord = array(
								'ProductId' => $id,
								'ColorId' => $colorId,
								'SmallPic' => $s[$j],
								'MiddlePic' => $m[$j],
								'BigPic' => $b[$j]
							);
							$this->db->AutoExecute('t_ppgpictures',$picRecord,'INSERT');
						}
					}
				}
			}

			$this->logger->add(GetIPAddr(),"修改产品，ID:".$id.",名称:".$name);
		}
	}

	function UpdateProName($id,$name)
	{
		$record['ProName'] = $name;

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
		$this->db->Execute("DELETE FROM t_ppgcolors WHERE ProductId=?",array($id));
		$this->db->Execute("DELETE FROM t_ppgpictures WHERE ProductId=?",array($id));
		$this->logger->add(GetIPAddr(),"删除产品,ID:".$id);
	}

	function GetRecord($name,$memo,$smallPic,$isShow,$isCommend,$orderBy,$typeId,$language,$customerField)
	{
		$record['ProName'] = stripslashes($name);
		$record['Memo'] = stripslashes($memo);
		$record['NoteTime'] = date("Y-m-d H:i:s");
		$record['SmallPic'] = $smallPic;
		$record['IsShow'] = $isShow;
		$record['IsCommend'] = $isCommend;
		$record['OrderBy'] = $orderBy;
		$record['TypeID'] = $typeId;
		$record['Hits'] = 0;
		$record['Language'] = $language;

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
		$rs = $this->db->Execute("SELECT * FROM ".$this->table." WHERE TypeID=? ORDER BY id",array($typeId));
		while(!$rs->EOF)
		{
			$this->db->Execute("DELETE FROM t_ppgcolors WHERE ProductId=?",array($rs->fields['id']));
			$this->db->Execute("DELETE FROM t_ppgpictures WHERE ProductId=?",array($rs->fields['id']));
			$rs->MoveNext();
		}
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