<?
include_once("../../config.php");
include_once("../dao/combuydao.class.php");

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
		break;
	case "del":
		if (!UserIsInRole('CB2',$userRole))
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
	$dao = new ComBuyDao($db);
	$dao->MovePrev($id);

	return true;
}

function moveNext($db,$id)
{
	$dao = new ComBuyDao($db);
	$dao->MoveNext($id);

	return true;
}

function moveFirst($db,$id)
{
	$dao = new ComBuyDao($db);
	$dao->MoveFirst($id);

	return true;
}

function moveLast($db,$id)
{
	$dao = new ComBuyDao($db);
	$dao->MoveLast($id);

	return true;
}


function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComBuyDao($db);

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
		$dao = new ComBuyDao($db);

		for ($i=0; $i<$len; $i++)
		{
			$dao->setOrder($idArr[$i],$orderArr[$i]);
		}
	}

	return true;
}
?>