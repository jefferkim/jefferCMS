<?
include_once("../config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>

div{ overflow:visible}

body{ font-size:12px}

</style>
</head>

<body>

<? 
$nid = $_REQUEST['nid'];
$newsRs = $SysConfig['maindb']->Execute("SELECT * FROM t_news WHERE id='".$nid."'");
$newsObj = $newsRs->FetchObject();

echo $newsObj->CONTENT;

?>

</body>
</html>