<?
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('J5',$userRole))
{
	exit();
}

$sql = "SELECT * FROM t_memberfield ORDER BY id";
$rs = $SysConfig['customerdb']->Execute($sql);
$data = array();
while (!$rs->EOF)
{
	$obj = $rs->FetchObject();
	$data[] = $obj;
	
	$rs->MoveNext();
}

echo json_encode($data);
?>