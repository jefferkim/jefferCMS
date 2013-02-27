<?
include_once("../config.php");

$outputLan = $_REQUEST['outputLan'];
$importLan = $_REQUEST['importLan'];

$typefieldList = array();
$rs = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM t_protype");
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
$rs = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM t_products");
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

$msg = Import($SysConfig['customerdb'],$outputLan,$importLan);

echo json_encode(array('result'=>$msg));

function Import($db,$outputLan,$importLan)
{
	if ($outputLan == $importLan)
	{
		return '不能在相同语言内导接产品';
	}

	/*$where = "WHERE Language='".$outputLan."'";
	$typefieldList = array();
	$rs = $db->Execute("SHOW FIELDS FROM t_protype");
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
	$rs = $db->Execute("SHOW FIELDS FROM t_products");
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
	$rs = $db->Execute("SELECT * FROM t_protype ".$where." ORDER BY OrderBy,id");
	while (!$rs->EOF)
	{
		$typeObj = $rs->FetchObject();
		foreach($typefieldList as $field)
		{
			$typeRecord[$field] = $rs->fields[$field];
		}
		$typeRecord['NoteTime'] = date("Y-m-d H:i:s");
		$typeRecord['Language'] = $importLan;
		$db->AutoExecute("t_protype",$typeRecord,'INSERT');
		$typeId = $db->Insert_ID();

		$prs = $db->Execute("SELECT * FROM t_products WHERE Language=? AND TypeID=? ORDER BY OrderBy,id",array($outputLan,$typeObj->ID));
		while(!$prs->EOF)
		{
			$obj = $prs->FetchObject();
			foreach($pfieldList as $field)
			{
				$record[$field] = $prs->fields[$field];
			}
			$record['TypeID'] = $typeId;
			$record['NoteTime'] = date("Y-m-d H:i:s");
			$record['Hits'] = 0;
			$record['Language'] = $importLan;
			$db->AutoExecute('t_products',$record,'INSERT');
			$prs->MoveNext();
		}
		$rs->MoveNext();
	}*/

	ProductImport($db,0,0,$outputLan,$importLan);

	return '导入成功';
}

function ProductImport($db,$outpid,$inpid,$outLan,$inLan)
{
	global $typefieldList,$pfieldList;

	$rs = $db->Execute("SELECT * FROM t_protype WHERE Language=? AND PID=? ORDER BY id",array($outLan,$outpid));
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
			$tmpRs = $db->Execute("SELECT * FROM t_protype WHERE id=?",array($inpid));
			if ($tmpRs->RecordCount() == 1)
			{
				if ($tmpRs->fields['ParentPath'] != "")
					$typeRecord['ParentPath'] = $tmpRs->fields['ParentPath'].'-'.$inpid;
				else
					$typeRecord['ParentPath'] = $inpid;
			}
		}
		$db->AutoExecute('t_protype',$typeRecord,'INSERT');
		$typeId = $db->Insert_ID();

		$prd = $db->Execute("SELECT * FROM t_products WHERE Language=? AND TypeID=? ORDER BY id",array($outLan,$typeObj->ID));
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
			$db->AutoExecute('t_products',$record,'INSERT');

			$prd->MoveNext();
		}

		ProductImport($db,$typeObj->ID,$typeId,$outLan,$inLan);

		$rs->MoveNext();
	}
}
?>