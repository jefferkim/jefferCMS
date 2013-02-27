<?
include_once("../../config.php");
include_once("products.function.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$customerdb = $SysConfig['customerdb'];

$language = "";
if (isset($_REQUEST['language']))
{
	$language = $_REQUEST['language'];
}

$typeArr = GetSubType($SysConfig['customerdb'],0,"",$language);

$arr = array();
while(list($key,$val)=each($typeArr))
{
	$arr[] = array(
		'ID' => $key,
		'CALLED' => $val
	);
}

echo json_encode($arr);
?>