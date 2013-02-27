<?
include_once("../config.php");
include_once("../dao/producttypedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('F7',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('F8',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
}

echo json_encode(array('result'=>$msg));

function add($db,$uploaddir)
{
	$called = trim($_POST['called']);
	$pid = $_POST['pid'];
	$language = explode(',',$_POST['language']);
	$isShow = $_POST['isshow'];
	$orderBy = $_POST['orderby'];
	$picurl = $_POST['oldpic'];
	$memo = FckReplace($_POST['memo'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);

	if ($called == "")
	{
		return "请填写名称";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_protype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new ProductTypeDao($db);
	$lanLen = count($language);
	for ($i=0; $i<$lanLen; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$pid,$language[$i],$isShow,$orderBy,$memo,$picurl,$customerFieldArr);
	}

	return "添加成功";
}

function edit($db,$uploaddir)
{
	$id = $_POST['id'];
	$called = trim($_POST['called']);
	$pid = $_POST['pid'];
	$language = $_POST['language'];
	$isShow = $_POST['isshow'];
	$orderBy = $_POST['orderby'];
	$picurl = $_POST['oldpic'];
	$memo = FckReplace($_POST['memo'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);

	if ($called == "")
	{
		return "请填写名称";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_protype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new ProductTypeDao($db);
	$dao->Edit($id,$called,$pid,$language,$isShow,$orderBy,$memo,$picurl,$customerFieldArr);

	return "修改成功";
}
?>