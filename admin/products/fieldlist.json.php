<?
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('F11',$userRole))
{
	exit();
}

$sql = "SELECT * FROM t_fields WHERE TypeName='t_products' ORDER BY id";
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