<?php
include_once("../config.php");
include_once("../dao/custom2dao.class.php");

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
	$called = trim($_POST['called']);
	$lan = $_POST['lan'];
	$content = FckReplace($_POST['content'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);

	if ($called == "")
	{
		return '请填写名称';
	}


    $customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_custom2' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}
	$dao = new Custom2Dao($db);
	
	$id = $dao->Add($called,$content,$lan,$customerFieldArr);
	
	return "添加成功！";
}

//修改内容
function edit($db,$uploaddir)
{
	$id = $_POST['id'];
	$called = trim($_POST['called']);
	$lan = $_POST['lan'];
	$content = FckReplace($_POST['content'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);

	if ($called == "")
	{
		return "未填写名称";
	}
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_custom2' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new Custom2Dao($db);
	$result = $dao->Edit($id,$called,$content,$lan,$customerFieldArr);
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

	$dao = new Custom2Dao($db);
	for ($i=0; $i<$len; $i++)
	{
		$dao->Delete($id[$i]);
	}

	return "删除成功";
}
?>