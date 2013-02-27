<?php
include_once("../config.php");
include_once("../dao/seodao.class.php");

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
}

echo json_encode(array('result'=>$msg));


//添加seo
function add($db,$uploaddir)
{
	$title = trim($_POST['title']);
	$lan = $_POST['lan'];
    $keywords = trim($_POST['keywords']);
	$description = trim($_POST['description']);
	$url = trim($_POST['url']);


	if ($title == "")
	{
		return '请填写网站标题';
	}


    $customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_seo' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}
	$dao = new SeoDao($db);
	
	$id = $dao->Add($title,$lan,$keywords,$description,$url,$customerFieldArr);
	
	return "添加成功！";
}

//修改seo
function edit($db,$uploaddir)
{
	$id = $_POST['id'];
	$title = trim($_POST['title']);
	$lan = $_POST['lan'];
    $keywords = trim($_POST['keywords']);
	$description = trim($_POST['description']);
	$url = trim($_POST['url']);

	if ($title == "")
	{
		return "请填写网站标题";
	}
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_seo' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new SeoDao($db);
	$result = $dao->Edit($id,$title,$lan,$keywords,$description,$url,$customerFieldArr);
	if ($result == $dao->SUCCESS)
		return "修改成功";
	else
		return "修改失败";
}

?>