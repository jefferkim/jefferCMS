<?
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
	$rs = $db->Execute("SELECT * FROM t_downloadtype ".$where);
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		$record = array(
			'Called' => $obj->CALLED,
			'NoteTime' => $obj->NOTETIME,
			'Memo' => $obj->MEMO,
			'Language' => $importLan
		);
		$db->AutoExecute('t_downloadtype',$record,'INSERT');
		$rs->MoveNext();
	}

	return '导入成功';
}
?>