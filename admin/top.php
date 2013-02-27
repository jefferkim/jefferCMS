<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<script src="<?echo $SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.ui.js"></script>
</head>

<body>

<?
		$newsList=$SysConfig['maindb']->Execute("select * from t_news where IsCommend=1 limit 0,5");
        $i=0;
		while(!$newsList->EOF)
		{
		$newsObj = $newsList->FetchObject();	
			$newsList->MoveNext();
			$i++;
		}
		?>

<table width="100%" height="76" border="0" cellspacing="0" cellpadding="0" style="background:url(images/top_bj.jpg) repeat-x left top;">
  <tr>
    <td valign="top"><img src="images/logo.jpg" width="486" height="75" /></td>
    <td align="right" style=" padding-right:20px;"><span style="color:#7CBBF1;">日期：<em  id="webjx"><SCRIPT>
setInterval("document.getElementById('webjx').innerHTML=new Date().toLocaleString()+''.charAt(new Date().getDay());",1000);
              </SCRIPT></em></span> <a href="right.php" class="sx" target="main">刷新</a> <a href="member/sys_user.php" class="ren" target="main">通讯录</a> <a href="admin_news/sys_news.php" class="mail" target="main">（<?=$i?>）</a></td>
  </tr>
</table>
<table width="100%" height="27" border="0" cellspacing="0" cellpadding="0" style="background:url(images/user_info_bj.jpg) repeat-x left top;">
  <tr>
    <td align="right" style="padding-right:20px;"><a href="javascript:changlocal.exit();""  class="sys">退出</a><a href="sys_config.php" target="main" class="sys">系统设置</a><span class="info">您好，<?=$_SESSION['SWEBADMIN_USERNAME']?>(<?=$_SESSION['SWEBADMIN_USERCALLED']?>) &nbsp; | &nbsp; 上次登陆：<? if($_SESSION['SWEBADMIN_LOGINTIME']){echo date("Y-m-d H:i",strtotime($_SESSION['SWEBADMIN_LOGINTIME']));}else{echo date("Y-m-d H:i");}?></span></td>
  </tr>
</table>
</body>
</html>

