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
	$rs = $db->Execute("SELECT * FROM t_pictype ".$where);
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		$record = array(
			'Called' => $obj->CALLED,
			'Memo' => $obj->MEMO,
			'NoteTime' => date("Y-m-d H:i:s"),
			'Language' => $importLan
		);
		$db->AutoExecute('t_pictype',$record,'INSERT');
		$rs->MoveNext();
	}

	return '导入成功';
}
?>