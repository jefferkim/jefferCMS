<?php
include_once("../config.php");
include_once("../dao/downloaddao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "无效操作";
//$SysConfig['customerdb']->debug = true;
switch($action)
{
	case "add":
		if (!UserIsInRole('H1',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":
		if (!UserIsInRole('H2',$userRole))
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
	$isShow = $_REQUEST['isshow'];
	$language = explode(",",$_REQUEST['language']);
	$memo = $_REQUEST['memo'];
	$fileurl = $_REQUEST['fileurl'];
	$size = getFileSize($fileurl);
	if($size===null){
		$size = 1;
	}else{
		$size = round($size/1024,2);
	}

	$isCommend = 0;
	if ($called == "")
	{
		return "请填写下载名称";
	}
	if ($fileurl == "")
	{
		return "请选择上传文件";
	}
	/*if ($size <= 0)
	{
		$f = explode("/",$fileurl);
		$f = $f[count($f)-1];
		$size = filesize("/web/video/".$_SESSION['SWEBADMIN_USERNAME']."/".$f);
		$size = round($size/1024,2);
		if ($size <= 0)
		{
			return "文件大小为空";
		}
	}*/

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_download' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new DownloadDao($db);
	$len = count($language);
	for ($i=0; $i<$len; $i++)
	{
		if ($language[$i] != "")
			$dao->Add($called,$fileurl,$memo,$isShow,$isCommend,$type,$size,$language[$i],$customerFieldArr);
	}

	return "添加成功";
}

function edit($db)
{
	$id = $_POST['id'];
	$called = trim($_POST['called']);
	$type = $_POST['type'];
	$isShow = $_POST['isshow'];
	$language = $_POST['language'];
	$memo = $_POST['memo'];
	$fileurl = $_POST['fileurl'];
	$size = getFileSize($fileurl);
	if($size===null){
		$size = 1;
	}else{
		$size = round($size/1024,2);
	}
	
	$isCommend = 0;
	if ($called == "")
	{
		return "请填写下载名称";
	}
	if ($fileurl == "")
	{
		return "请选择上传文件";
	}
	/*if ($size <= 0)
	{
		return "文件大小为空";
	}*/
	$record = $db->Execute("SELECT IsCommend FROM t_download WHERE id=?",array($id));
	$isCommend = $record->fields['IsCommend'];
	
	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_download' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	$dao = new DownloadDao($db);
	$dao->Edit($id,$called,$fileurl,$memo,$isShow,$isCommend,$type,$size,$language,$customerFieldArr);

	return "修改成功";
}

//读取网络路径文件大小
function getFileSize($url){
	$url = parse_url($url);
	if($fp = fsockopen($url['host'],empty($url['port'])?80:$url['port'],$error)){
		fputs($fp,"GET ".(empty($url['path'])?'/':$url['path'])." HTTP/1.1\r\n");
		fputs($fp,"Host:$url[host]\r\n\r\n");
		while(!feof($fp)){
			$tmp = fgets($fp);
			if(trim($tmp) == '') {
				break;
			}elseif(preg_match('/Content-Length:(.*)/si',$tmp,$arr)) {
				return trim($arr[1]);
			}
		}
		return null;
	}else{
		return null;
	}
}
?>