<?php
include_once("../config.php");

$outputLan = $_REQUEST['outputLan'];
$importLan = $_REQUEST['importLan'];

$msg = Import($SysConfig['customerdb'],$outputLan,$importLan);

echo json_encode(array('result'=>$msg));

function Import($db,$outputLan,$importLan)
{
	if ($outputLan == $importLan)
	{
		return '不能在相同语言内导接';
	}

	$typefieldList = array();
	$rs = $db->Execute("SHOW FIELDS FROM t_newtype");
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
	$rs = $db->Execute("SHOW FIELDS FROM t_news");
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


	$where = "WHERE Language='".$outputLan."'";
	$rs = $db->Execute("SELECT * FROM t_newtype ".$where." ORDER BY id");
	while (!$rs->EOF)
	{
		$typeObj = $rs->FetchObject();
		foreach($typefieldList as $field)
		{
			$typeRecord[$field] = $rs->fields[$field];
		}
		$typeRecord['Language'] = $importLan;
		$db->AutoExecute('t_newtype',$typeRecord,"INSERT");
		$typeId = $db->Insert_ID();

		$prs = $db->Execute("SELECT * FROM t_news WHERE Language=? AND NewType=? ORDER BY OrderBy,id",array($outputLan,$typeObj->ID));
		while(!$prs->EOF)
		{
			$obj = $prs->FetchObject();
			foreach($pfieldList as $field)
			{
				$record[$field] = $prs->fields[$field];
			}
			$record['Language'] = $importLan;
			$record['NewType'] = $typeId;
			$record['Hits'] = 0;
			$db->AutoExecute('t_news',$record,'INSERT');
			$prs->MoveNext();
		}
		$rs->MoveNext();
	}

	return '导入成功';
}
?>