<?
include_once("../config.php");
include_once("../dao/picturetypedao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('G6',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('G7',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb']);
		break;
	case "del":
		if (!UserIsInRole('G8',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = del($SysConfig['customerdb'],$_REQUEST['cascade'],explode(",",$_REQUEST['id']));
		break;
}

echo json_encode(array('result'=>$msg));

function add($db)
{
	$called = trim($_REQUEST['called']);
	$language = explode(",",$_REQUEST['language']);
	$memo = $_REQUEST['memo'];

	if ($called == "")
	{
		return "名称不能为空";
	}
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_pictype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new PictureTypeDao($db);
	$len = count($language);
	for ($i=0; $i<$len; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$memo,$language[$i],$customerFieldArr);
	}

	return "添加成功";
}

function edit($db)
{
	$id = $_REQUEST['id'];
	$called = trim($_REQUEST['called']);
	$language = $_REQUEST['language'];
	$memo = $_REQUEST['memo'];

	if ($called == "")
	{
		return "名称不能为空";
	}
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_pictype' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new PictureTypeDao($db);
	$dao->Edit($id,$called,$memo,$language,$customerFieldArr);

	return "修改成功";
}

function del($db,$cascade,$idArr)
{
	$len = count($idArr);
	$dao = new PictureTypeDao($db);
	for ($i=0; $i<$len;$i++)
	{
		$dao->Delete($idArr[$i],$cascade);
	}
	
	return "删除成功";
}
?>