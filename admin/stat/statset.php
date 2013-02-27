<?
include_once("../../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('P0',$userRole))
{
	echo '没有权限访问';
	exit();
}


$action = $_REQUEST['action'];
$result = false;

switch($action)
{
	case "del":
		$result = del($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
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

	for ($i=0; $i<$len; $i++)
	{
		$db->Execute("DELETE FROM t_flow WHERE id=?",array($idArr[$i]));
	}

	return true;
}
?>