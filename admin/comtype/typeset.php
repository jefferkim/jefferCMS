<?
include_once("../../config.php");
include_once("../dao/comtypedao.class.php");

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
	case "del":
		if (!UserIsInRole('CT4',$userRole))
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

function movePrev($db,$id)
{
	$dao = new ComTypeDao($db);
	$dao->MovePrev($id);

	return true;
}

function moveNext($db,$id)
{
	$dao = new ComTypeDao($db);
	$dao->MoveNext($id);

	return true;
}

function moveFirst($db,$id)
{
	$dao = new ComTypeDao($db);
	$dao->MoveFirst($id);

	return true;
}

function moveLast($db,$id)
{
	$dao = new ComTypeDao($db);
	$dao->MoveLast($id);

	return true;
}

function del($db,$id,$cascade)
{
	$dao = new ComTypeDao($db);
	$idArr = explode(",",$id);
	for($i=0; $i<count($idArr); $i++)
	{
		$dao->Delete($idArr[$i],$cascade);
	}

	return true;
}
?>