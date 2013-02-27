<?
include_once("../../config.php");

$outputLan = $_REQUEST['outputLan'];
$importLan = $_REQUEST['importLan'];

$typefieldList = array();
$rs = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM t_ppgprotype");
while(!$rs->EOF)
{
	if ($rs->fields['Field'] == "id")
	{
		$rs->MoveNext();
		continue;
	}
	$typefieldList[] = $rs->fields['Field'];
	$rs->MoveNext();
}
$pfieldList = array();
$rs = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM t_ppgproducts");
while(!$rs->EOF)
{
	if ($rs->fields['Field'] == "id")
	{
		$rs->MoveNext();
		continue;
	}
	$pfieldList[] = $rs->fields['Field'];
	$rs->MoveNext();
}
$colorfieldList = array();
$rs = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM t_ppgcolors");
while(!$rs->EOF)
{
	if ($rs->fields['Field'] == "id")
	{
		$rs->MoveNext();
		continue;
	}
	$colorfieldList[] = $rs->fields['Field'];
	$rs->MoveNext();
}
$picfieldList = array();
$rs = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM t_ppgpictures");
while(!$rs->EOF)
{
	if ($rs->fields['Field'] == "id")
	{
		$rs->MoveNext();
		continue;
	}
	$picfieldList[] = $rs->fields['Field'];
	$rs->MoveNext();
}

$msg = Import($SysConfig['customerdb'],$outputLan,$importLan);

echo json_encode(array('result'=>$msg));

function Import($db,$outputLan,$importLan)
{
	if ($outputLan == $importLan)
	{
		return '不能在相同语言内导接产品';
	}
	/*if ($importType == "")
	{
		return '不能导入到一个空的产品分类下';
	}

	$rs = $db->Execute("SELECT * FROM t_ppgprotype WHERE Language='".$importLan."' AND id=".$importType);
	if ($rs->RecordCount() <= 0)
	{
		return '要导入的产品分类不存在';
	}

	$where = "WHERE Language='".$outputLan."'";
	if ($outputType != "")
		$where .= " AND TypeID=".$outputType;
	$rs = $db->Execute("SELECT * FROM t_ppgproducts ".$where);
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		$record = array(
			'ProName' => $obj->PRONAME,
			'Content' => $obj->CONTENT,
			'NoteTime' => date("Y-m-d H:i:s"),
			'SmallPic' => $obj->SMALLPIC,
			'IsShow' => $obj->ISSHOW,
			'IsCommend' => $obj->ISCOMMEND,
			'OrderBy' => $obj->ORDERBY,
			'TypeID' => $importType,
			'Hits' => 0,
			'Language' => $importLan
		);
		$db->AutoExecute('t_ppgproducts',$record,'INSERT');
		$rs->MoveNext();
	}*/

	ProductImport($db,0,0,$outputLan,$importLan);

	return '导入成功';
}

function ProductImport($db,$outpid,$inpid,$outLan,$inLan)
{
	global $typefieldList,$pfieldList,$colorfieldList,$picfieldList;

	$rs = $db->Execute("SELECT * FROM t_ppgprotype WHERE Language=? AND PID=? ORDER BY id",array($outLan,$outpid));
	while(!$rs->EOF)
	{
		$typeObj = $rs->FetchObject();
		foreach($typefieldList as $field)
		{
			$typeRecord[$field] = $rs->fields[$field];
		}
		$typeRecord['NoteTime'] = date("Y-m-d H:i:s");
		$typeRecord['Language'] = $inLan;
		$typeRecord['PID'] = $inpid;
		if ($inpid > 0)
		{
			$tmpRs = $db->Execute("SELECT * FROM t_ppgprotype WHERE id=?",array($inpid));
			if ($tmpRs->RecordCount() == 1)
			{
				if ($tmpRs->fields['ParentPath'] != "")
					$typeRecord['ParentPath'] = $tmpRs->fields['ParentPath'].'-'.$inpid;
				else
					$typeRecord['ParentPath'] = $inpid;
			}
		}
		$db->AutoExecute('t_ppgprotype',$typeRecord,'INSERT');
		$typeId = $db->Insert_ID();

		$prd = $db->Execute("SELECT * FROM t_ppgproducts WHERE Language=? AND TypeID=? ORDER BY id",array($outLan,$typeObj->ID));
		while(!$prd->EOF)
		{
			$pObj = $prd->FetchObject();
			foreach($pfieldList as $field)
			{
				$record[$field] = $prd->fields[$field];
			}
			$record['TypeID'] = $typeId;
			$record['NoteTime'] = date("Y-m-d H:i:s");
			$record['Hits'] = 0;
			$record['Language'] = $inLan;
			$db->AutoExecute('t_ppgproducts',$record,'INSERT');
			$proId = $db->Insert_ID();

			$crd = $db->Execute("SELECT * FROM t_ppgcolors WHERE ProductId=? ORDER BY id",array($pObj->ID));
			while(!$crd->EOF)
			{
				foreach($colorfieldList as $field)
				{
					$crecord[$field] = $crd->fields[$field];
				}
				$crecord['ProductId'] = $proId;
				$db->AutoExecute('t_ppgcolors',$crecord,'INSERT');
				$colorId = $db->Insert_ID();

				$picrd = $db->Execute("SELECT * FROM t_ppgpictures WHERE ColorId=? ORDER BY id",array($crd->fields['id']));
				while(!$picrd->EOF)
				{
					foreach($picfieldList as $field)
					{
						$precord[$field] = $picrd->fields[$field];
					}
					$precord['ProductId'] = $proId;
					$precord['ColorId'] = $colorId;
					$db->AutoExecute('t_ppgpictures',$precord,'INSERT');

					$picrd->MoveNext();
				}

				$crd->MoveNext();
			}

			$prd->MoveNext();
		}

		ProductImport($db,$typeObj->ID,$typeId,$outLan,$inLan);

		$rs->MoveNext();
	}
}
?>