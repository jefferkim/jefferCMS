<?php
include_once("../config.php");
include_once("../dao/orderdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('L1',$userRole))
{
	exit();
}

$action = $_REQUEST['action'];
$result = false;

switch($action)
{
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
}

if ($result)
	$msg = "操作成功";
else
	$msg = "操作失败";

echo json_encode(array('result'=>$msg));

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new OrderDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}

	return true;
}
?>