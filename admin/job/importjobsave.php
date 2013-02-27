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

	$pfieldList = array();
	$rs = $db->Execute("SHOW FIELDS FROM t_job");
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
	$rs = $db->Execute("SELECT * FROM t_job ".$where);
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		foreach($pfieldList as $field)
		{
			$record[$field] = $rs->fields[$field];
		}
		$record['Language'] = $importLan;
		$db->AutoExecute('t_job',$record,'INSERT');
		$rs->MoveNext();
	}

	return '导入成功';
}
?>