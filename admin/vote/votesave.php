<?php
include_once("../config.php");
include_once("../dao/votedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('T5',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('T6',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "del":
		if (!UserIsInRole('T7',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = del($SysConfig['customerdb'],$_REQUEST['cascade'],explode(",",$_REQUEST['id']));
		break;
}

echo json_encode(array('result'=>$msg));


//添加内容
function add($db,$uploaddir)
{
	$subject = trim($_POST['subject']);
	$lan = $_POST['lan'];

	if ($subject == "")
	{
		return '请填写投票标题';
	}


    $customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_vote' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}
	$dao = new VoteDao($db);
	
	$id = $dao->Add($subject,$lan,$customerFieldArr);
	
	return "添加成功！";
}

//修改内容
function edit($db,$uploaddir)
{
	$id = $_POST['id'];
	$subject = trim($_POST['subject']);
	$lan = $_POST['lan'];

	if ($subject == "")
	{
		return "未填写投票标题";
	}
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_vote' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new VoteDao($db);
	$result = $dao->Edit($id,$subject,$lan,$customerFieldArr);
	if ($result == $dao->SUCCESS)
		return "修改成功";
	else
		return "修改失败";
}

//删除内容
function del($db,$cascade,$idArr)
{
	$len = count($idArr);
	$dao = new VoteDao($db);
	for ($i=0; $i<$len;$i++)
	{
		$dao->Delete($idArr[$i],$cascade);
	}
	
	return "删除成功";
}
?>