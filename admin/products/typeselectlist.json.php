<?
include_once("../config.php");
include("products.function.php");

$customerdb = $SysConfig['customerdb'];

$language = "cn";
$currentId = "";

if (isset($_REQUEST['language']))
{
	$language = $_REQUEST['language'];
}
if (isset($_REQUEST['currentid']))
{
	$currentId = $_REQUEST['currentid'];
}


$resultData = GetSubTypeObject($SysConfig['customerdb'],0,$currentId,$language,$customerLanArr);

$result = array('data' => $resultData);

echo json_encode($result);
?>