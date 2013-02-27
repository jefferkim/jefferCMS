<?
include_once("../config.php");
include_once("../dao/productsdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$result = false;

switch($action)
{
	case "moveprev":
		$result = movePrev($SysConfig['customerdb'],$_POST['id']);
		break;
	case "movenext":
		$result = moveNext($SysConfig['customerdb'],$_POST['id']);
		break;
	case "movefirst":
		$result = moveFirst($SysConfig['customerdb'],$_POST['id']);
		break;
	case "movelast":
		$result = moveLast($SysConfig['customerdb'],$_POST['id']);
		break;
	case "order":
		$result = order($SysConfig['customerdb'],explode(",",$_POST['id']),explode(",",$_POST['order']));
		$result = updateProName($SysConfig['customerdb'],explode(",",$_POST['id']),explode("|",$_POST['pname']));
		break;
	case "show":
		if (!UserIsInRole('F4',$userRole))
		{
			$result = false;
			break;
		}
		$result = show($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "hide":
		if (!UserIsInRole('F4',$userRole))
		{
			$result = false;
			break;
		}
		$result = hide($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "commend":
		if (!UserIsInRole('F5',$userRole))
		{
			$result = false;
			break;
		}
		$result = commend($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "uncommend":
		if (!UserIsInRole('F5',$userRole))
		{
			$result = false;
			break;
		}
		$result = unCommend($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "del":
		if (!UserIsInRole('F3',$userRole))
		{
			$result = false;
			break;
		}
		$result = del($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
}

if ($result)
	$msg = "成功";
else
	$msg = "数据出错";

echo json_encode(array('result'=>$msg));

function movePrev($db,$id)
{
	$dao = new ProductsDao($db);
	$dao->MovePrev($id);

	return true;
}

function moveNext($db,$id)
{
	$dao = new ProductsDao($db);
	$dao->MoveNext($id);

	return true;
}

function moveFirst($db,$id)
{
	$dao = new ProductsDao($db);
	$dao->MoveFirst($id);

	return true;
}

function moveLast($db,$id)
{
	$dao = new ProductsDao($db);
	$dao->MoveLast($id);

	return true;
}

function show($db,$idArr)
{
	$len = count($idArr);
	$dao = new ProductsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setShow($idArr[$i]);
	}

	return true;
}

function hide($db,$idArr)
{
	$len = count($idArr);
	$dao = new ProductsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setHide($idArr[$i]);
	}

	return true;
}

function commend($db,$idArr)
{
	$len = count($idArr);
	$dao = new ProductsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setCommend($idArr[$i]);
	}

	return true;
}

function unCommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new ProductsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setUnCommend($idArr[$i]);
	}

	return true;
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new ProductsDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}

	return true;
}

function order($db,$idArr,$orderArr)
{
	$len = count($idArr);

	if ($len == count($orderArr))
	{
		$dao = new ProductsDao($db);

		for ($i=0; $i<$len; $i++)
		{
			$dao->setOrder($idArr[$i],$orderArr[$i]);
		}
	}

	return true;
}

function updateProName($db,$idArr,$pnameArr)
{
	$len = count($idArr);
	if ($len == count($pnameArr))
	{
		$dao = new ProductsDao($db);

		for ($i=0; $i<$len; $i++)
		{
			$dao->UpdateProName($idArr[$i],$pnameArr[$i]);
		}
	}

	return true;
}
?>