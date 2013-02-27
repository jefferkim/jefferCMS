<?
include_once("../../config.php");
include_once("../dao/ppgproducttypedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('N7',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('N8',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb']);
		break;
}

echo json_encode(array('result'=>$msg));

function add($db)
{
	$called = trim($_POST['called']);
	$pid = $_POST['pid'];
	$language = explode(',',$_POST['language']);
	$isShow = $_POST['isshow'];
	$orderBy = $_POST['orderby'];
	$memo = trim($_POST['memo']);

	if ($called == "")
	{
		return "请填写名称";
	}

	$dao = new PpgProductTypeDao($db);
	$lanLen = count($language);
	for ($i=0; $i<$lanLen; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$pid,$language[$i],$isShow,$orderBy,$memo);
	}

	return "添加成功";
}

function edit($db)
{
	$id = $_POST['id'];
	$called = trim($_POST['called']);
	$pid = $_POST['pid'];
	$language = $_POST['language'];
	$isShow = $_POST['isshow'];
	$orderBy = $_POST['orderby'];
	$memo = trim($_POST['memo']);

	if ($called == "")
	{
		return "请填写名称";
	}

	$dao = new PpgProductTypeDao($db);
	$dao->Edit($id,$called,$pid,$language,$isShow,$orderBy,$memo);

	return "修改成功";
}
?>