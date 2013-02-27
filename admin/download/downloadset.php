<?
include_once("../config.php");
include_once("../dao/downloaddao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "操作成功";

switch($action)
{
	case "show":
		show($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "hide":
		hide($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "commend":
		commend($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "uncommend":
		uncommend($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "del":
		del($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "moveprev":
		movePrev($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "movefirst":
		moveFirst($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "movenext":
		moveNext($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "movelast":
		moveLast($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
}

echo json_encode(array('result'=>$msg));

function show($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetShow($idArr[$i]);
	}
}

function hide($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetHide($idArr[$i]);
	}
}

function commend($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetCommend($idArr[$i]);
	}
}

function uncommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetUnCommend($idArr[$i]);
	}
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}
}

function movePrev($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->MovePrev($idArr[$i]);
	}
}

function moveFirst($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->MoveFirst($idArr[$i]);
	}
}

function moveNext($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->MoveNext($idArr[$i]);
	}
}

function moveLast($db,$idArr)
{
	$len = count($idArr);
	$dao = new DownloadDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->MoveLast($idArr[$i]);
	}
}
?>