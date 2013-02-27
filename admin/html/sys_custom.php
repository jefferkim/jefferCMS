<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";


$custom1 = "";
$custom2 = "";
$customRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_custom WHERE id=1");
$custom = $customRs->FetchObject();
$custom1 = $custom->CUSTOM1;
$custom2 = $custom->CUSTOM2;

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
</head>

<body style="background:#FFF;">

<?
if (!UserIsInRole('D0',$userRole))
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
    <span style="font-weight:bold">位置：</span>自定义功能设置
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
       
       <form action="sys_customsave.php" method="post">
       
       <input type="hidden" name="action" value="edit">
       <input type="hidden" name="id" value="1">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">自定义功能设置</td>
    </tr>
    <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
   
  <tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">自定义功能一：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="custom1" value="<?=$custom1?>" class="sys_input"></td>
    <td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">自定义功能二：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="custom2" value="<?=$custom2?>" class="sys_input"></td>
</tr>



 <tr>
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
  
  </table>
  </td>
  </tr>
  
</table>


</form>
       
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>

</html>