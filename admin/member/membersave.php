<?php
include_once("../config.php");
include_once("../dao/memberdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('J1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('J2',$userRole))
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
	$userName = trim($_POST['username']);
	$password = trim($_POST['password']);
	$called = trim($_POST['called']);
	$tel = trim($_POST['tel']);
	$mobile = trim($_POST['mobile']);
	$mail = trim($_POST['mail']);
	$company = trim($_POST['company']);
	$isLock = $_POST['islock'];
	$language = $_POST['language'];

	if ($userName == "")
	{
		return "用户名不能为空";
	}
	if ($password == "")
	{
		return "密码不能为空";
	}

	$rs = $db->Execute("SELECT * FROM t_user WHERE UserName=?",array($userName));
	if ($rs->RecordCount() > 0)
	{
		return "用户名已存在";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new MemberDao($db);
	$dao->Add($userName,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$customerFieldArr);

	return "添加成功";
}

function edit($db)
{
	$id = $_POST['id'];
	$userName = trim($_POST['username']);
	$password = trim($_POST['password']);
	$called = trim($_POST['called']);
	$tel = trim($_POST['tel']);
	$mobile = trim($_POST['mobile']);
	$mail = trim($_POST['mail']);
	$company = trim($_POST['company']);
	$isLock = $_POST['islock'];
	$language = $_POST['language'];

	if ($userName == "")
	{
		return "用户名不能为空";
	}
	if ($password == "")
	{
		return "密码不能为空";
	}

	$rs = $db->Execute("SELECT * FROM t_user WHERE UserName=? AND id<>?",array($userName,$id));
	if ($rs->RecordCount() > 0)
	{
		return "用户名已存在";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new MemberDao($db);
	$dao->Edit($id,$userName,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$customerFieldArr);

	return "修改成功";
}
?>