<?
include_once("../../config.php");
include_once("../dao/ppgproductsdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('N1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('N2',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = edit($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
}

echo json_encode(array('result'=>$msg));

function add($db,$uploaddir)
{
	$called = trim($_REQUEST['called']);
	$pid = $_REQUEST['pid'];
	$language = explode(",",$_REQUEST['language']);
	$isshow = $_REQUEST['isshow'];
	$iscommend = $_REQUEST['iscommend'];
	$orderBy = $_REQUEST['orderby'];
	$memo = $_REQUEST['memo'];
	$smallpic = "";

	if ($called == "")
	{
		return "没有填写名称";
	}
	if ($pid == "")
	{
		return "没有选择分类";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_ppgproductfield ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$color = $_REQUEST['color'];
	$img = $_REQUEST['img'];
	$spic = $_REQUEST['spic'];
	$mpic = $_REQUEST['mpic'];
	$bpic = $_REQUEST['bpic'];

	$dao = new PpgProductsDao($db);
	$lanLen = count($language);
	for ($i=0; $i<$lanLen; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$memo,$smallpic,$isshow,$iscommend,$orderBy,$pid,$language[$i],$color,$img,$spic,$mpic,$bpic,$customerFieldArr);
	}

	return "添加成功";
}

function edit($db,$uploaddir)
{
	$id = $_REQUEST['id'];
	$called = trim($_REQUEST['called']);
	$pid = $_REQUEST['pid'];
	$language = $_REQUEST['language'];
	$isshow = $_REQUEST['isshow'];
	$iscommend = $_REQUEST['iscommend'];
	$orderBy = $_REQUEST['orderby'];
	$memo = $_REQUEST['memo'];
	$smallpic = "";

	if ($called == "")
	{
		return "没有填写名称";
	}
	if ($pid == "")
	{
		return "没有选择分类";
	}

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_ppgproductfield ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$color = $_REQUEST['color'];
	$img = $_REQUEST['img'];
	$spic = $_REQUEST['spic'];
	$mpic = $_REQUEST['mpic'];
	$bpic = $_REQUEST['bpic'];

	$dao = new PpgProductsDao($db);
	$dao->Edit($id,$called,$memo,$smallpic,$isshow,$iscommend,$orderBy,$pid,$language,$color,$img,$spic,$mpic,$bpic,$customerFieldArr);

	return "修改成功";
}
?>