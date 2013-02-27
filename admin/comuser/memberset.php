<?
include_once("../../config.php");
include_once("../dao/commemberdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];
$result = false;

switch($action)
{
	case "lock":
		if (!UserIsInRole('CU3',$userRole))
		{
			$result = false;
		}
		$result = lock($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "unlock":
		if (!UserIsInRole('CU3',$userRole))
		{
			$result = false;
		}
		$result = unlock($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "commend":
		if (!UserIsInRole('CU4',$userRole))
		{
			$result = false;
		}
		$result = commend($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "uncommend":
		if (!UserIsInRole('CU4',$userRole))
		{
			$result = false;
		}
		$result = uncommend($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "excellent":
		if (!UserIsInRole('CU5',$userRole))
		{
			$result = false;
		}
		$result = excellent($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "unexcellent":
		if (!UserIsInRole('CU5',$userRole))
		{
			$result = false;
		}
		$result = unexcellent($SysConfig['customerdb'],explode(",",$_POST['id']));
		break;
	case "del":
		if (!UserIsInRole('CU2',$userRole))
		{
			$result = false;
		}
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
	$dao = new ComMemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Lock($idArr[$i]);
	}

	return true;
}

function unlock($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComMemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->UnLock($idArr[$i]);
	}

	return true;
}

function commend($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComMemberDao($db);

	for($i=0; $i<$len; $i++)
	{
		$dao->Commend($idArr[$i]);
	}
}

function uncommend($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComMemberDao($db);

	for($i=0; $i<$len; $i++)
	{
		$dao->UnCommend($idArr[$i]);
	}
}

function excellent($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComMemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Excellent($idArr[$i]);
	}
}

function unexcellent($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComMemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->UnExcellent($idArr[$i]);
	}
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new ComMemberDao($db);

	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}

	return true;
}
?>