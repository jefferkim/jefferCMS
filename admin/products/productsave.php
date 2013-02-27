<?
include_once("../config.php");
include_once("../dao/productsdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('F1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('F2',$userRole))
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
	$called = trim($_POST['called']);
	$pid = $_POST['pid'];
	$language = explode(",",$_POST['language']);
	$isshow = $_POST['isshow'];
	$iscommend = $_POST['iscommend'];
	$orderBy = $_POST['orderby'];
	$memo = FckReplace($_POST['memo'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);
	$content = FckReplace($_POST['content'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);
	$smallpic = $_POST['oldpic'];
	$webtitle = $_REQUEST['webtitle'];
	$webkey = $_REQUEST['webkey'];
	$webdesc = $_REQUEST['webdesc'];

	if ($called == "")
	{
		return "没有填写名称";
	}
	if ($pid == "")
	{
		return "没有选择分类";
	}

	/*$uploadResult = SavePicture('smallpic',$_SESSION['SWEBADMIN_USERNAME']."/upload/");
	if ($uploadResult[0])
	{
		$smallpic = $uploadResult[1];
	}
	else
	{
		return array("productadd.php",$uploadResult[1]);
	}*/

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_products' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = stripcslashes($_REQUEST[$fieldObj->FIELDNAME]);
		$fieldRs->MoveNext();
	}

	$dao = new ProductsDao($db);
	$lanLen = count($language);
	for ($i=0; $i<$lanLen; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$content,$memo,$smallpic,$isshow,$iscommend,$orderBy,$pid,$language[$i],$webtitle,$webkey,$webdesc,$customerFieldArr);
	}

	return "添加成功";
}

function edit($db,$uploaddir)
{
	$id = $_POST['id'];
	$called = trim($_POST['called']);
	$pid = $_POST['pid'];
	$language = $_POST['language'];
	$isshow = $_POST['isshow'];
	$iscommend = $_POST['iscommend'];
	$orderBy = $_POST['orderby'];
	$memo = FckReplace($_POST['memo'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);
	$content = FckReplace($_POST['content'],$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);
	$smallpic = $_POST['oldpic'];
	$webtitle = $_REQUEST['webtitle'];
	$webkey = $_REQUEST['webkey'];
	$webdesc = $_REQUEST['webdesc'];

	if ($called == "")
	{
		return "没有填写名称";
	}
	if ($pid == "")
	{
		return "没有选择分类";
	}

	/*$uploadResult = SavePicture('smallpic',$_SESSION['SWEBADMIN_USERNAME']."/upload/");
	if ($uploadResult[0])
	{
		$smallpic = $uploadResult[1];
	}
	else
	{
		$smallpic = $_POST['oldpic'];
	}*/

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_products' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = stripcslashes($_REQUEST[$fieldObj->FIELDNAME]);
		$fieldRs->MoveNext();
	}

	$dao = new ProductsDao($db);
	$dao->Edit($id,$called,$content,$memo,$smallpic,$isshow,$iscommend,$orderBy,$pid,$language,$webtitle,$webkey,$webdesc,$customerFieldArr);
	
	return "修改成功";
}
?>