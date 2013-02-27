<?
include_once("../../config.php");
include_once("../dao/memberdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];
$result = false;

switch($action)
{
	case "lock":
		if (!UserIsInRole('J4',$userRole))
		{
			$result = false;
		}
		$result = lock($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "unlock":
		if (!UserIsInRole('J4',$userRole))
		{
			$result = false;
		}
		$result = unlock($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
}

if ($result)
	$msg = "操作成功";
else
	$msg = "操作失败";

echo json_encode(array('result'=>$msg));

function lock($db,$idArr)
{
	$len = count($idArr);
	$dao = new MemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Lock($idArr[$i]);
	}

	return true;
}

function unlock($db,$idArr)
{
	$len = count($idArr);
	$dao = new MemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->UnLock($idArr[$i]);
	}

	return true;
}

function del($db,$idArr)
{
	$len = count($idArr);
	

	for ($i=0; $i<$len; $i++)
	{
		$db->Execute("DELETE FROM t_kg WHERE id=?",array($idArr[$i]));
	}

	return true;
}
?>