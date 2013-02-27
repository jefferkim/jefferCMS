<?php
include_once("../config.php");
include_once("../dao/sys_userdao.class.php");
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];
$msg = "";
$url="";
switch($action)
{
	case "edit":
		$msg = edit($SysConfig['customerdb']);
		break;
}

//修改内容
function edit($db)
{
	$id = $_POST['id'];
	$custom1 = trim($_POST['custom1']);
	$custom2 = trim($_POST['custom2']);
    $record = array(
		'custom1' => $custom1,
		'custom2' => $custom2
		);


	$result=$db->AutoExecute('t_custom',$record,'UPDATE',"id=".$id);

		return "修改成功";

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
