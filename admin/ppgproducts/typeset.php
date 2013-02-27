<?
include_once("../../config.php");
include_once("../dao/ppgproducttypedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$result = false;

switch($action)
{
	case "moveprev":
		$result = movePrev($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "movenext":
		$result = moveNext($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "movefirst":
		$result = moveFirst($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "movelast":
		$result = moveLast($SysConfig['customerdb'],$_REQUEST['id']);
		break;
	case "show":
		if (!UserIsInRole('N10',$userRole))
		{
			$result = false;
		}
		$result = show($SysConfig['customerdb'],explode(",",$_REQUEST['id']),getCascade());
		break;
	case "unshow":
		if (!UserIsInRole('N10',$userRole))
		{
			$result = false;
		}
		$result = hide($SysConfig['customerdb'],explode(",",$_REQUEST['id']),getCascade());
		break;
	case "del":
		if (!UserIsInRole('N9',$userRole))
		{
			$result = false;
		}
		$result = del($SysConfig['customerdb'],$_REQUEST['id'],getCascade());
		break;
}

if ($result)
	$msg = "操作成功";
else
	$msg = "操作失败";

echo json_encode(array('result'=>$msg));

function getCascade()
{
	$cascade = false;
	if (isset($_POST['cascade']))
		$cascade = $_POST['cascade'];

	return $cascade;
}

function show($db,$idArr,$cascade)
{
	$dao = new PpgProductTypeDao($db);
	$len = count($idArr);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setShow($idArr[$i],$cascade);
	}

	return true;
}

function hide($db,$idArr,$cascade)
{
	$dao = new PpgProductTypeDao($db);
	$len = count($idArr);

	for ($i=0; $i<$len; $i++)
	{
		$dao->setHide($idArr[$i],$cascade);
	}

	return true;
}

function movePrev($db,$id)
{
	$dao = new PpgProductTypeDao($db);
	$dao->MovePrev($id);

	return true;
}

function moveNext($db,$id)
{
	$dao = new PpgProductTypeDao($db);
	$dao->MoveNext($id);

	return true;
}

function moveFirst($db,$id)
{
	$dao = new PpgProductTypeDao($db);
	$dao->MoveFirst($id);

	return true;
}

function moveLast($db,$id)
{
	$dao = new PpgProductTypeDao($db);
	$dao->MoveLast($id);

	return true;
}

function del($db,$id,$cascade)
{
	$dao = new PpgProductTypeDao($db);
	$dao->Delete($id,$cascade);

	return true;
}
?>