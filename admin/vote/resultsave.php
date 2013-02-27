<?php
include_once("../config.php");
include_once("../dao/resultdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('T1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('T2',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "del":
		if (!UserIsInRole('T3',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		del($SysConfig['customerdb'],explode(",",$_REQUEST['id']));
		break;
}

echo json_encode(array('result'=>$msg));


//添加内容
function add($db,$uploaddir)
{
	$result = trim($_POST['result']);
	$vote = $_POST['vote'];
	$lan = $_POST['lan'];

	if ($result == "")
	{
		return '请填写投票答案';
	}


    $customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_result' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}
	$dao = new ResultDao($db);
	
	$id = $dao->Add($result,$vote,$lan,$customerFieldArr);
	
	return "添加成功！";
}

//修改内容
function edit($db,$uploaddir)
{
	$id = $_POST['id'];
	$result = trim($_POST['result']);
	$vote = $_POST['vote'];
	$lan = $_POST['lan'];

	if ($result == "")
	{
		return "未填写投票标题";
	}
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_result' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new ResultDao($db);
	$result = $dao->Edit($id,$result,$vote,$lan,$customerFieldArr);
	if ($result == $dao->SUCCESS)
		return "修改成功";
	else
		return "修改失败";
}

function del($db,$idArr)
{
	$len = count($idArr);
	$dao = new ResultDao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($idArr[$i]);
	}
}

?>