<?
include_once("../config.php");
include_once("../dao/newsdao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('E5',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "edit":
		if (!UserIsInRole('E6',$userRole))
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
	$title = trim($_REQUEST['title']);
	$parent = $_REQUEST['parent'];
	$lan = explode(",",$_REQUEST['language']);
	$type = $_REQUEST['type'];
	$isShow = $_REQUEST['isshow'];
	$isCommend = $_REQUEST['iscommend'];
	$userName = $_REQUEST['username'];
	$orderBy = $_REQUEST['orderby'];
	$content = FckReplace(stripslashes($_REQUEST['content']),$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);
	$webtitle = $_REQUEST['webtitle'];
	$showtime = $_REQUEST['showtime'];
	$webkey = $_REQUEST['webkey'];
	$webdesc = $_REQUEST['webdesc'];
	$smallpic = $_REQUEST['smallpic'];
	
	if ($title == "")
	{
		return '请填写新闻标题';
	}
	if ($type == "")
	{
		return "请选择新闻分类";
	}
	if ($orderBy == "")
	{
		$orderBy = 1;
	}

	/*$smallpic = "";
	$uploadResult = SavePicture('smallpic',$_SESSION['SWEBADMIN_USERNAME']."/upload/");
	if ($uploadResult[0])
	{
		$smallpic = $uploadResult[1];
	}*/
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_news' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new NewsDao($db);
	$len = count($lan);
	for ($i=0; $i<$len; $i++)
	{
		if (trim($lan[$i]) != "")
		{
			$id = $dao->Add($title,$content,$userName,$isShow,$isCommend,$orderBy,$type,$lan[$i],$parent,$webtitle,$showtime,$webkey,$webdesc,$smallpic,$customerFieldArr);
		}
	}

	return '添加成功';
}

function edit($db,$uploaddir)
{
	$id = $_REQUEST['newsid'];
	$title = trim($_REQUEST['title']);
	$parent = $_REQUEST['parent'];
	$lan = $_REQUEST['language'];
	$type = $_REQUEST['type'];
	$isShow = $_REQUEST['isshow'];
	$isCommend = $_REQUEST['iscommend'];
	$userName = $_REQUEST['username'];
	$orderBy = $_REQUEST['orderby'];
	$content = FckReplace(stripslashes($_REQUEST['content']),$uploaddir.$_SESSION['SWEBADMIN_USERNAME']."/",true);
	$webtitle = $_REQUEST['webtitle'];
	$showtime = $_REQUEST['showtime'];
	$webkey = $_REQUEST['webkey'];
	$webdesc = $_REQUEST['webdesc'];
	$smallpic = $_REQUEST['smallpic'];

	if ($title == "")
	{
		return '请填写新闻标题';
	}
	if ($type == "")
	{
		return "请选择新闻分类";
	}
	if ($orderBy == "")
	{
		$orderBy = 1;
	}

	/*$uploadResult = SavePicture('smallpic',$_SESSION['SWEBADMIN_USERNAME']."/upload/");
	if ($uploadResult[0])
	{
		$smallpic = $uploadResult[1];
	}*/

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_news' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new NewsDao($db);
	$result = $dao->Edit($id,$title,$content,$userName,$isShow,$isCommend,$orderBy,$type,$lan,$parent,$webtitle,$showtime,$webkey,$webdesc,$smallpic,$customerFieldArr);
	
	if ($result == $dao->SUCCESS)
		return "修改成功";
	else
		return "修改失败";
}
?>