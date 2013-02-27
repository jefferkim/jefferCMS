<?php
include_once("../config.php");
include_once("../dao/newstypedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('E1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('E2',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb']);
		break;
	case "del":
		if (!UserIsInRole('E3',$userRole))
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
	$lan = explode(",",$_POST['language']);

	if ($called == "")
	{
		return "请填写分类名称";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_newtype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new NewsTypeDao($db);
	$len = count($lan);
	for ($i=0; $i<$len; $i++)
	{
		if (trim($lan[$i]) != "")
		{
			$dao->Add($called,$lan[$i],$customerFieldArr);
		}
	}

	return "添加成功";
}

function edit($db)
{
	$called = trim($_POST['called']);
	$lan = $_POST['language'];
	$typeid = $_POST['typeid'];

	if ($typeid == "")
	{
		return "请选择要修改的分类";
	}
	if ($called == "")
	{
		return "请填写分类名称";
	}
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_newtype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new NewsTypeDao($db);
	$result = $dao->Edit($typeid,$called,$lan,$customerFieldArr);

	if ($result == $dao->SUCCESS)
		return "修改成功";
	else
		return "修改失败";
}

function del($db)
{
	$id = explode(",",$_REQUEST['id']);
	$len = count($id);
	
	$dao = new NewsTypeDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($id[$i]);
	}

	return "删除成功";
}
?>