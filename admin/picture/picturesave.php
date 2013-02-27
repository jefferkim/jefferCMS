<?php
include_once("../config.php");
include_once("../dao/picturedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('G1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('G2',$userRole))
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
	$called = trim($_REQUEST['called']);
	$type = $_REQUEST['type'];
	$language = explode(",",$_REQUEST['language']);
	$isshow = $_REQUEST['isshow'];
	$spic = $_REQUEST['spic'];
	$bpic = $_REQUEST['bpic'];
	
	if ($called == "")
	{
		return "没有填写名称";
	}
	if ($type == "")
	{
		return "请选择分类";
	}
	if ($spic == "")
	{
		return "没有上传小图片";
	}
	if ($bpic == "")
	{
		return "没有上传大图片";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_pic' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new PictureDao($db);
	$len = count($language);
	for ($i=0; $i<$len; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$spic,$bpic,$isshow,0,$type,$language[$i],$customerFieldArr);
	}

	return "添加成功";
}

function edit($db)
{
	$id = $_REQUEST['id'];
	$called = trim($_REQUEST['called']);
	$type = $_REQUEST['type'];
	$language = $_REQUEST['language'];
	$isshow = $_REQUEST['isshow'];
	$spic = $_REQUEST['spic'];
	$bpic = $_REQUEST['bpic'];

	if ($called == "")
	{
		return "没有填写名称";
	}
	if ($type == "")
	{
		return "请选择分类";
	}
	if ($spic == "")
	{
		return "没有上传小图片";
	}
	if ($bpic == "")
	{
		return "没有上传大图片";
	}
	
	$IsCommend = $db->Execute("SELECT IsCommend from t_pic WHERE id=?",array($id));
	$cid = $IsCommend->fields['IsCommend'];
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_pic' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}
	
	$dao = new PictureDao($db);
	$dao->Edit($id,$called,$spic,$bpic,$isshow,$cid,$type,$language,$customerFieldArr);

	return "修改成功";
}
?>