<?php
include_once("../config.php");
include_once("../dao/sys_userdao.class.php");
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";
$url="";
$adminid = $_SESSION['SWEBADMIN_USERID'];
$lanRs = $SysConfig['maindb']->Execute("SELECT * FROM t_language WHERE UserId=? ORDER BY id" ,array($adminid));

$adminRs = $SysConfig['maindb']->Execute("SELECT * FROM t_admin WHERE id=?",array($adminid));
$adminObj = $adminRs->FetchObject();

$IsLock=$adminObj->ISLOCK;
$UserCalled=$adminObj->USERCALLED;
$UserRoleCalled=$adminObj->USERROLECALLED;
$UserId=$adminObj->USERID;
$Space=$adminObj->SPACE;
$DataBase=$adminObj->DATABASE;
$ServiceStart=$adminObj->SERVICESTART;
$ServiceEnd=$adminObj->SERVICEEND;
$IsPointing=$adminObj->ISPOINTING;
$Industry=$adminObj->INDUSTRY;
$Key=$adminObj->KEY;
$IsCase=$adminObj->ISCASE;
$Amount=$adminObj->AMOUNT;
$UserType=$adminObj->USERTYPE;
$DbName=$adminObj->DBNAME;
$RedirectUrl=$adminObj->REDIRECTURL;
$Status=$adminObj->STATUS;
$SiteType=$adminObj->SITETYPE;
$DesignContact=$adminObj->DESIGNCONTACT;
$area=$adminObj->AREA;
$coder=$adminObj->CODER;
$designer=$adminObj->DESIGNER;
$infoer=$adminObj->INFOER;
$PointDate=$adminObj->POINTDATE;
$SalesMan=$adminObj->SALESMAN;
$LoginTime=$adminObj->LOGINTIME;
$ServerName=$adminObj->SERVERNAME;
$ServerTel=$adminObj->SERVERTEL;
$ServerQQ=$adminObj->SERVERQQ;


switch($action)
{
	case "add":
		$msg = add($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR'],$IsLock,$UserCalled,$UserRoleCalled,$UserId,$Space,$DataBase,$ServiceStart,$ServiceEnd,$IsPointing,$Industry,$Key,$IsCase,$Amount,$UserType,$DbName,$RedirectUrl,$Status,$SiteType,$DesignContact,$area,$coder,$designer,$infoer,$PointDate,$SalesMan,$LoginTime,$ServerName,$ServerTel,$ServerQQ);
		break;
	case "edit":
		$msg = edit($SysConfig['customerdb'],$SysConfig['PHPUPLOADDIR']);
		break;
	case "del":
		$msg = del($SysConfig['customerdb']);
		break;
	case "addlen":
	 $msg = addlen($SysConfig['customerdb'],$lanRs);	
	 break;
}







//添加内容
function add($db,$uploaddir,$IsLock,$UserCalled,$UserRoleCalled,$UserId,$Space,$DataBase,$ServiceStart,$ServiceEnd,$IsPointing,$Industry,$Key,$IsCase,$Amount,$UserType,$DbName,$RedirectUrl,$Status,$SiteType,$DesignContact,$area,$coder,$designer,$infoer,$PointDate,$SalesMan,$LoginTime,$ServerName,$ServerTel,$ServerQQ)
{
	
    $username = trim($_POST['UserName']);

	$sys_userRs = $db->Execute("SELECT * FROM t_admin WHERE UserName=?",array($username));
	if ($sys_userRs->RecordCount() >0)
	 {
		return "用户名已存在";
	 }
	
	$password = $_POST['PassWord'];
	$roleArray = $_POST['power'];
    $role = implode(":",$roleArray);
	$record = array(
		'UserName' => $username,
		'PassWord' => $password,
		'IsLock' => $IsLock,
		'UserCalled' => $UserCalled,
		'UserRole' => $role,
		'UserRoleCalled' => $UserRoleCalled,
		'UserId' => $UserId,
		'Space' => $Space,
		'ServiceStart' => $ServiceStart,
		'ServiceEnd' => $ServiceEnd,
		'IsPointing' => $IsPointing,
		'Industry' => $Industry,
		'IsCase' => $IsCase,
		'Amount' => $Amount,
		'UserType' => $UserType,
		'DbName' => $DbName,
		'RedirectUrl' => $RedirectUrl,
		'Status' => $Status,
		'SiteType' => $SiteType,
		'DesignContact' => $DesignContact,
		'area' => $area,
		'coder' => $coder,
		'designer' => $designer,
		'infoer' => $infoer,
		'PointDate' => $PointDate,
		'SalesMan' => $SalesMan,
		'LoginTime' => $LoginTime,
		'ServerName' => $ServerName,
		'ServerTel' => $ServerTel,
		'ServerQQ' => $ServerQQ

	);
	$db->AutoExecute("t_admin",$record,"INSERT");

	return "添加成功";
}

//添加语言模板

function addlen($db,$lanRs){
	
	$id = $_REQUEST['id'];
	
	while (!$lanRs->EOF)
	{
		$lan = $lanRs->FetchObject();
		$Called=$lan->CALLED;
		$ModelId=$lan->MODELID;
		$SelModel=$lan->SELMODEL; 
		$Html=$lan->HTML;
		echo $id;
		$record = array(
		'Called' => $Called,
		'SelModel' => $SelModel,
		'UserId' => $id
	);
	$db->AutoExecute("t_language",$record,"INSERT");
	
	
	$lanRs->MoveNext();
	}
	
	return "导入成功";
	
	
}



//修改内容
function edit($db,$uploaddir)
{
	$id = $_REQUEST['id'];
	echo $id;
    $username = trim($_POST['UserName']);
	$password = $_POST['PassWord'];
	$roleArray = $_POST['power'];
    $role = implode(":",$roleArray);
	
	if ($username == "")
	{
		return "未填写用户名";
	}
	

	$dao = new AdminDao($db);
	$result = $dao->Edit($id,$username,$password,$role);
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


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>

</head>
<script>
<?
if ($msg != "")
{
	echo "alert('".$msg."');";
	echo "javascript :history.back(-1);";
}
?>
</script>
</html>
