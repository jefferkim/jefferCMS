<?
include_once("../config.php");
include_once("../dao/picturedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "完成";

switch($action)
{
	case "show":
		if (!UserIsInRole('G4',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		show($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "hide":
		if (!UserIsInRole('G4',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		hide($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "order":
		order($SysConfig['customerdb']);
		break;
	case "commend":
		commend($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "uncommend":
		uncommend($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
	case "moveprev":
		movePrev($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "movefirst":
		moveFirst($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "movenext":
		moveNext($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "movelast":
		moveLast($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "del":
		if (!UserIsInRole('G3',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		del($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
}

echo json_encode(array('result'=>$msg));

function show($db,$idArr)
{
	$len = count($idArr);
	$dao = new PictureDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->setShow($idArr[$i]);
	}
}

function hide($db,$idArr)
{
	$len = count($idArr);
	$dao = new PictureDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->setHide($idArr[$i]);
	}
}

function commend($db,$idArr)
{
	$len = count($idArr);
	$dao = new PictureDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->setCommend($idArr[$i]);
	}
}

function uncommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new PictureDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->setUnCommend($idArr[$i]);
	}
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new PictureDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}
}

function movePrev($db,$id)
{
	$dao = new PictureDao($db);
	$dao->MovePrev($id);
}

function moveFirst($db,$id)
{
	$dao = new PictureDao($db);
	$dao->MoveFirst($id);
}

function moveNext($db,$id)
{
	$dao = new PictureDao($db);
	$dao->MoveNext($id);
}

function moveLast($db,$id)
{
	$dao = new PictureDao($db);
	$dao->MoveLast($id);
}

function order($db)
{
	$id_array = explode(",",$_POST['id']);
	$order_array = explode(",",$_POST['order']);
    $pname_array = explode(",",$_POST['panme']);
	$len = count($id_array);
	for ($i=0; $i<$len; $i++)
	{
		if ($order_array[$i] > 0)
		{
			$db->Execute("UPDATE t_pic SET OrderBy=?, PicName=? WHERE id=?",array($order_array[$i],$pname_array[$i],$id_array[$i]));
		}
	}
	
}

?>