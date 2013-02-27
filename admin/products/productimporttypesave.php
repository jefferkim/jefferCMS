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
		return '不能在相同语言内导接产品分类';
	}

	$where = "WHERE Language='".$outputLan."'";
	$rs = $db->Execute("SELECT * FROM t_protype ".$where);
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		$record = array(
			'Called' => $obj->CALLED,
			'OrderBy' => $obj->ORDERBY,
			'Memo' => $obj->MEMO,
			'NoteTime' => date("Y-m-d H:i:s"),
			'IsShow' => $obj->ISSHOW,
			'PID' => $obj->PID,
			'TypeLevel' => $obj->TYPELEVEL,
			'Language' => $importLan,
			'ParentPath' => $obj->PARENTPATH
		);
		$db->AutoExecute('t_protype',$record,'INSERT');
		$rs->MoveNext();
	}

	return '导入成功';
}
?>