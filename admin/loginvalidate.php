<?
include_once("config.php");
$redirect = 'login.php';
$errormsg = '用户名或密码错误';
$username = trim($_POST['username']);
$password = trim($_POST['password']);


$SysConfig['customerdb'] = ADONewConnection("mysql");
$SysConfig['customerdb']->NConnect($SysConfig['dbhost'],$SysConfig['dbuser'],$SysConfig['dbpass'],$SysConfig['dbuser']);
$SysConfig['customerdb']->charSet = 'UTF8';
$SysConfig['customerdb']->Execute("set names 'UTF8'");
$sql = $SysConfig['customerdb']->Prepare("select * from t_admin where UserName=? and PassWord=? and IsLock=0 and UserType=2");




$rs = $SysConfig['customerdb']->Execute($sql,array($username,$password));


$count = $rs->RecordCount();
 

if ($count > 0)
{
	$obj = $rs->FetchObject();

		$_SESSION['SWEBADMIN_USERID'] = $obj->ID;
		$_SESSION['SWEBADMIN_USERNAME'] = $username;
		$_SESSION['SWEBADMIN_USERREALNAME'] = $obj->USERCALLED;
		$_SESSION['SWEBADMIN_USERROLECALLED'] = $obj->USERROLECALLED;	//角色
		$_SESSION['SWEBADMIN_USERCALLED'] = $obj->USERCALLED;	//公司名称
		$_SESSION['SWEBADMIN_USERROLE'] = $obj->USERROLE;
		$_SESSION['SWEBADMIN_DBNAME'] = $obj->DBNAME;
		$_SESSION['SWEBADMIN_LOGINTIME'] = $obj->LOGINTIME;
		$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$username."/upload/";
		$record = array(
		'LoginTime' => date("Y-m-d H:i:s"),
        );
	   $SysConfig['customerdb']->AutoExecute("t_admin",$record,"UPDATE","id=".$obj->ID);


	
		$redirect = 'main.php';
		$errormsg = '';
		
		
	
}else{ 

$db = $SysConfig['maindb'];
$sql = $db->Prepare("select * from t_admin where UserName=? and PassWord=? and IsLock=0 and UserType=2");
$rs = $db->Execute($sql,array($username,$password));

$count = $rs->RecordCount();
if ($count > 0)
{
	$obj = $rs->FetchObject();

		$_SESSION['SWEBADMIN_USERID'] = $obj->ID;
		$_SESSION['SWEBADMIN_USERNAME'] = $username;
		$_SESSION['SWEBADMIN_USERREALNAME'] = $obj->USERCALLED;
		$_SESSION['SWEBADMIN_USERROLECALLED'] = $obj->USERROLECALLED;	//角色
		$_SESSION['SWEBADMIN_USERCALLED'] = $obj->USERCALLED;	//公司名称
		$_SESSION['SWEBADMIN_USERROLE'] = $obj->USERROLE;
		$_SESSION['SWEBADMIN_DBNAME'] = $obj->DBNAME;
		$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$username."/upload/";
		$redirect = 'main.php';
		$errormsg = '';
	
}

	
}
?>

<HTML>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<TITLE><?=$SysConfig['title']?></TITLE>
		<meta http-equiv='refresh' content='0;url=<?=$redirect?>'>
		<script>
		<?
		if ($errormsg != '')
		{
			echo 'alert("'.$errormsg.'");';
		}
		?>
		</script>
	</HEAD>
</HTML>