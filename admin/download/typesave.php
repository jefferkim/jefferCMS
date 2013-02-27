<?
include_once("../config.php");
include_once("../dao/downloadtypedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "无效操作";

switch($action)
{
	case "add":
		if (!UserIsInRole('H6',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('H7',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb']);
		break;
	case "del":
		if (!UserIsInRole('H8',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = del($SysConfig['customerdb']);
		break;
}

echo json_encode(array('result'=>$msg));

function add($db)
{
	$called = trim($_POST['called']);
	$language = explode(",",$_POST['language']);
	$memo = $_POST['memo'];

	if ($called == "")
	{
		return "分类名称不能为空";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_downloadtype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new DownloadTypeDao($db);
	$len = count($language);
	for ($i=0; $i<$len; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$memo,$language[$i],$customerFieldArr);
	}

	return "添加成功";
}

function edit($db)
{
	$id = $_POST['id'];
	$called = trim($_POST['called']);
	$language = $_POST['language'];
	$memo = $_POST['memo'];

	if ($called == "")
	{
		return "分类名称不能为空";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_downloadtype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new DownloadTypeDao($db);
	$dao->Edit($id,$called,$memo,$language,$customerFieldArr);

	return "修改成功";
}

function del($db)
{
	$idArr = explode(",",$_REQUEST['id']);
	$cascade = $_REQUEST['cascade'];
	$len = count($idArr);

	$dao = new DownloadTypeDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i],$cascade);
	}

	return "删除成功";
}
?>