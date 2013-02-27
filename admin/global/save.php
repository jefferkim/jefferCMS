<?php
include_once("../config.php");
include_once("../dao/global.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('D1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('D2',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "del":
		if (!UserIsInRole('D3',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = del($SysConfig['customerdb']);
		break;
}

echo json_encode(array('result'=>$msg));


//添加内容
function add($db,$uploaddir)
{
	$webname = trim($_POST['webname']);
	$title = trim($_POST['title']);
	$web = trim($_POST['web']);
	$upload = trim($_POST['upload']);
	$beian = trim($_POST['beian']);
	$keywords = trim($_POST['keywords']);
	$description = trim($_POST['description']);
	$lan = $_POST['lan'];
	

	if ($webname == "")
	{
		return '请填写站点名称';
	}

	$dao = new ContentDao($db);
	$result = $dao->Add($webname,$title,$web,$upload,$beian,$keywords,$description,$lan);

	return "添加成功！";
}

//修改内容
function edit($db,$uploaddir)
{
	$id = $_POST['id'];	
	$webname = trim($_POST['webname']);
	$title = trim($_POST['title']);
	$web = trim($_POST['web']);
	$upload = trim($_POST['upload']);
	$beian = trim($_POST['beian']);
	$keywords = trim($_POST['keywords']);
	$description = trim($_POST['description']);
	$lan = $_POST['lan'];
	
	if ($webname == "")
	{
		return "未填写站点名称";
	}

	$dao = new ContentDao($db);
	$result = $dao->Edit($id,$webname,$title,$web,$upload,$beian,$keywords,$description,$lan);

	if ($result == $dao->SUCCESS)
		return "修改成功";
	else
		return "修改失败";
}

//删除内容
function del($db)
{
	$id = explode(",",$_REQUEST['id']);
	$len = count($id);

	$dao = new ContentDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($id[$i]);
	}

	return "删除成功";
}
?>