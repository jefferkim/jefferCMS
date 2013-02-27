<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$tableName = $_REQUEST['table'];

$sql = "SELECT * FROM t_fields WHERE TypeName='".$tableName."' ORDER BY id";
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