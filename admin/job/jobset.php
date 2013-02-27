<?
include_once("../config.php");
include_once("../dao/jobdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];
$msg = "";

switch($action)
{
	case "moveprev":
		$result = movePrev($SysConfig['customerdb'],$_POST['id']);
		break;
	case "movefirst":
		$result = moveFirst($SysConfig['customerdb'],$_POST['id']);
		break;
	case "movenext":
		$result = moveNext($SysConfig['customerdb'],$_POST['id']);
		break;
	case "movelast":
		$result = moveLast($SysConfig['customerdb'],$_POST['id']);
		break;
	case "show":
		$result = show($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "hide":
		$result = hide($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "commend":
		$result = commend($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "uncommend":
		$result = uncommend($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
}

if ($result)
	$msg = "操作成功";
else
	$msg = "操作失败";
echo json_encode(array('result'=>$msg));

function movePrev($db,$id)
{
	$dao = new JobDao($db);
	$dao->MovePrev($id);

	return true;
}

function moveFirst($db,$id)
{
	$dao = new JobDao($db);
	$dao->MoveFirst($id);

	return true;
}

function moveNext($db,$id)
{
	$dao = new JobDao($db);
	$dao->MoveNext($id);
	
	return true;
}

function moveLast($db,$id)
{
	$dao = new JobDao($db);
	$dao->MoveLast($id);

	return true;
}

function show($db,$idArr)
{
	$len = count($idArr);
	$dao = new JobDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetShow($idArr[$i]);
	}

	return true;
}

function hide($db,$idArr)
{
	$len = count($idArr);
	$dao = new JobDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetHide($idArr[$i]);
	}

	return true;
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new JobDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}

	return true;
}

function commend($db,$idArr)
{
	$len = count($idArr);
	$dao = new JobDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetCommend($idArr[$i]);
	}

	return true;
}

function uncommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new JobDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->SetUnCommend($idArr[$i]);
	}

	return true;
}
?>