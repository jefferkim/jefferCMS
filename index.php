<?
include_once("../config.php");

$file = $_SERVER['SCRIPT_FILENAME'];
$arr = explode("/",$file);
$userName = $arr[count($arr)-2];

$rs = $SysConfig['maindb']->Execute("SELECT * FROM t_admin WHERE UserName=?",array($userName));
$obj = $rs->FetchObject();

$title = $obj->USERCALLED;
if ($obj->ISLOCK == 0)
{
	header("Location:".$obj->REDIRECTURL);
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$title?></title>
</head>
<body>
网站建设中......
</body>
</html>