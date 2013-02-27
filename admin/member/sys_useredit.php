<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

$maindb = $SysConfig['maindb'];

$id = $_REQUEST['id'];
$sys_userRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_admin WHERE id=?",array($id));
$sys_userObj = $sys_userRs->FetchObject();
$adminid=$sys_userObj->ID;
$userName=$sys_userObj->USERNAME;
$password=$sys_userObj->PASSWORD;
$adminrole=$sys_userObj->USERROLE;


//加载通用模块
$commonRoleList = array();
$commonRs = $maindb->Execute("SELECT * FROM t_plugin WHERE Type=".$SysConfig['CommonRole']." AND IsShow=1 ORDER BY OrderBy");
while (!$commonRs->EOF)
{
	$common = $commonRs->FetchObject();

	$item = array();
	$name = $common->CALLED;
	$desc = $common->DESCRIPTION;
	$power = $common->POWER;
	$powerDesc = $common->POWERDESCRIPTION;
	$item[0] = $name;
	$item[1] = $desc;
	$item[2] = GetEditPowerArray($power,$powerDesc,$adminrole);
	$commonRoleList[] = $item;

	$commonRs->MoveNext();
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script type="text/javascript">
$(document).ready(function()         
         {
var h=$(window).height()-40; //浏览器当前窗口可视区域高度

$("#box").css("height",h+"px");

}
         )

</script>

<script>
function check(){

    var username = $("input[name=UserName]").val();
	var password = $("input[name=PassWord]").val();
	if (username == "")
	{
		alert("请填写用户名");
		return false;
	}
	
	if (password == "")
	{
		alert("请填写密码");
		return false;
	}	
	
}



</script>





</head>

<body style="background:#FFF;">

<?
if (!UserIsInRole('A2',$userRole))
{
    echo '<script>';
	echo 'alert("您没有权限访问！");';
	echo '</script>';
	exit();
}

?>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>系统管理员管理 — 系统管理员添加
   </div>

  <div id="box" style="overflow-y:auto; vertical-align:top">
  <form name="form" method="post" action="sys_usersave.php" onsubmit="return check()">
     <input type="hidden" name="action" value="edit"> 
     <input type="hidden" name="id" value="<?=$adminid?>">
          <?include_once("sys_usereditview.php")?>
          </form>
 </div>

    </td>
    
  </tr>
  
</table>


</body>

</html>


