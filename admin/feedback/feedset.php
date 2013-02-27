<?php
include_once("../config.php");
include_once("../dao/guestbookdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];
$result = false;

switch($action)
{
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_POST['id']));
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

	for ($i=0; $i<$len; $i++)
	{
		$db->Execute("DELETE FROM t_feedback WHERE id=?",array($idArr[$i]));
	}

	return true;
}
?>