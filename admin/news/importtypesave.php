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

	$where = "WHERE Language='".$outputLan."'";
	$rs = $db->Execute("SELECT * FROM t_newtype ".$where);
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		$record = array(
			'Called' => $obj->CALLED,
			'Language' => $importLan
		);
		$db->AutoExecute('t_newtype',$record,'INSERT');
		$rs->MoveNext();
	}

	return '导入成功';
}
?>