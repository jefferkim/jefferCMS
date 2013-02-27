<?
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('K5',$userRole))
{
	exit();
}

$action = $_POST['action'];
$result = false;

switch($action)
{
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_POST['id']));
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
	$logger = new Logger($db);
	for ($i=0; $i<$len; $i++)
	{
		$db->Execute("DELETE FROM t_career WHERE id=?",array($idArr[$i]));
		$logger->add(GetIPAddr(),"删除简历,ID:".$idArr[$i]);
	}

	return true;
}
?>