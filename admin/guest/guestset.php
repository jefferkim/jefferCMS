<?php
include_once("../config.php");
include_once("../dao/guestbookdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];
$result = false;

switch($action)
{
	case "show":
		$result = show($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "hide":
		$result = hide($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "reply":
		$result = reply($SysConfig['customerdb'],$_POST['id'],trim($_POST['reply']));
		break;
}

if ($result)
	$msg = "操作成功";
else
	$msg = "操作失败";

echo json_encode(array('result'=>$msg));

function show($db,$idArr)
{
	$len = count($idArr);
	$dao = new GuestBookDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setShow($idArr[$i]);
	}

	return true;
}

function hide($db,$idArr)
{
	$len = count($idArr);
	$dao = new GuestBookDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setHide($idArr[$i]);
	}

	return true;
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new GuestBookDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}

	return true;
}

function reply($db,$id,$reply)
{
	$dao = new GuestBookDao($db);
	$dao->Reply($id,$reply);

	return true;
}
?>