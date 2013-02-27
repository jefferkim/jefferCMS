<?include_once("../config.php")?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?
if (isset($_POST['username']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$msg = "登录失败，用户名密码错误或用户被锁定";
	$returl = "index.php";
	$rs = $maindb->Execute("SELECT * FROM t_user WHERE UserName=? AND Password=? AND IsLock=0",array($username,$password));
	if ($rs->RecordCount() > 0)
	{
		if ($rs->fields['UserName'] == $username)
		{
			session_start("S_SITE_USERID");
			session_start("S_SITE_USERNAME");
			$_SESSION['S_SITE_USERID'] = $rs->fields['id'];
			$_SESSION['S_SITE_USERNAME'] = $username;
			$msg = "登录成功";
			$returl = "index.php";
			if (isset($_REQUEST['returl']) && $_REQUEST['returl']!="")
			{
				$returl = $_REQUEST['returl'];
			}
		}
	}
	echo '<script>';
	echo 'window.location.href="'.$returl.'";';
	echo 'window.alert("'.$msg.'");';
	echo '</script>';
 }
 else if (isset($_REQUEST['logout']))
 {
	$_SESSION['S_SITE_USERID'] = "";
	$_SESSION['S_SITE_USERNAME'] = "";
	session_destroy("S_SITE_USERID");
	session_destroy("S_SITE_USERNAME");
	echo '<script>';
	echo 'window.location.href="index.php";';
	echo '</script>';
 }
 ?>



</body>
</html><?include_once("bottom.php")?>