<?
include_once("../config.php");
include_once("../dao/newsdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "错误选择";
$idArr = explode(",",$_REQUEST['id']);
$result = true;

switch($action)
{
	case "del":
		if (!UserIsInRole('E7',$userRole))
		{
			$msg = "没有权限操作";
			break;
		}
		$result = del($SysConfig['customerdb'],$idArr);
		break;
	case "show":
		if (!UserIsInRole('E9',$userRole))
		{
			$msg = "没有权限操作";
			break;
		}
		$result = setShow($SysConfig['customerdb'],$idArr);
		break;
	case "unshow":
		if (!UserIsInRole('E9',$userRole))
		{
			$msg = "没有权限操作";
			break;
		}
		$result = setUnShow($SysConfig['customerdb'],$idArr);
		break;
	case "commend":
		if (!UserIsInRole('E10',$userRole))
		{
			$msg = "没有权限操作";
			break;
		}
		$result = setCommend($SysConfig['customerdb'],$idArr);
		break;
	case "uncommend":
		if (!UserIsInRole('E10',$userRole))
		{
			$msg = "没有权限操作";
			break;
		}
		$result = setUnCommend($SysConfig['customerdb'],$idArr);
		break;
	case "order":
		$result = setOrder($SysConfig['customerdb'],$idArr,explode(',',$_REQUEST['order']));
		break;
	case "moveprev":
		$result = movePrev($SysConfig['customerdb']);
		break;
	case "movefirst":
		$result = moveFirst($SysConfig['customerdb']);
		break;
	case "movenext":
		$result = moveNext($SysConfig['customerdb']);
		break;
	case "movelast":
		$result = moveLast($SysConfig['customerdb']);
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
	$dao = new NewsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}

	return true;
}

function setShow($db,$idArr)
{
	$len = count($idArr);
	$dao = new NewsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->SetShow($idArr[$i]);
	}

	return true;
}

function setUnShow($db,$idArr)
{
	$len = count($idArr);
	$dao = new NewsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->SetUnShow($idArr[$i]);
	}

	return true;
}

function setCommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new NewsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->SetCommend($idArr[$i]);
	}

	return true;
}

function setUnCommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new NewsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->SetUnCommend($idArr[$i]);
	}

	return true;
}

function setOrder($db,$idArr,$orderArr)
{
	$len = count($idArr);

	$dao = new NewsDao($db);

	for($i=0; $i<$len; $i++)
	{
		$dao->SetOrder($idArr[$i],$orderArr[$i]);
	}

	return true;
}

function movePrev($db)
{
	$id = $_REQUEST['id'];
	$dao = new NewsDao($db);

	$dao->MovePrev($id);
	return true;
}

function moveFirst($db)
{
	$id = $_REQUEST['id'];
	$dao = new NewsDao($db);

	$dao->MoveFirst($id);
	return true;
}

function moveNext($db)
{
	$id = $_REQUEST['id'];
	$dao = new NewsDao($db);

	$dao->MoveNext($id);
	return true;
}

function moveLast($db)
{
	$id = $_REQUEST['id'];
	$dao = new NewsDao($db);

	$dao->MoveLast($id);
	return true;
}
?>