<?php
include_once("../config.php");
include_once("../dao/jobdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('K1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('K2',$userRole))
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
	$position = trim($_REQUEST['position']);
	$specialty = trim($_REQUEST['specialty']);
	$age = trim($_REQUEST['age']);
	$sex = $_REQUEST['sex'];
	$num = trim($_REQUEST['nums']);
	$educational = trim($_REQUEST['educational']);
	$experience = trim($_REQUEST['experience']);
	$salary = trim($_REQUEST['salary']);
	$endtime = trim($_REQUEST['endtime']);
	$isShow = $_REQUEST['isshow'];
	$orderBy = $_REQUEST['orderby'];
	$language = explode(",",$_REQUEST['language']);
	$memo = trim($_REQUEST['memo']);
	$isCommend = 0;

	if ($position == "")
	{
		return "招聘职位不能为空";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new JobDao($db);
	$len = count($language);
	for ($i=0; $i<$len; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isShow,$isCommend,$orderBy,$language[$i],$memo,$customerFieldArr);
	}

	return "添加成功";
}

function edit($db)
{
	$id = $_REQUEST['id'];
	$position = trim($_REQUEST['position']);
	$specialty = trim($_REQUEST['specialty']);
	$age = trim($_REQUEST['age']);
	$sex = $_REQUEST['sex'];
	$num = trim($_REQUEST['nums']);
	$educational = trim($_REQUEST['educational']);
	$experience = trim($_REQUEST['experience']);
	$salary = trim($_REQUEST['salary']);
	$endtime = trim($_REQUEST['endtime']);
	$isShow = $_REQUEST['isshow'];
	$orderBy = $_REQUEST['orderby'];
	$language = $_REQUEST['language'];
	$memo = trim($_REQUEST['memo']);
	$isCommend = 0;

	if ($position == "")
	{
		return "招聘职位不能为空";
	}
	$record = $db->Execute("SELECT IsCommend FROM t_job WHERE id=?",array($id));
	$isCommend = $record->fields['IsCommend'];
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new JobDao($db);
	$dao->Edit($id,$position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isShow,$isCommend,$orderBy,$language,$memo,$customerFieldArr);

	return "修改成功";
}
?>