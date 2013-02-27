<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$maindb = $SysConfig['maindb'];

$timeRs = $maindb->Execute("SELECT * FROM t_timeline WHERE CustomerID=? ORDER BY id",array($_SESSION['SWEBADMIN_USERID']));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<style type="text/css">
<!--
@import url("css.css");
-->
</style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form method="post" name="form" action="">
<tr align="center" valign="middle">
  <td width="23" height="50">&nbsp;</td>
  <td width="32"><img src="images/icon_arow_list.gif" width="7" height="7"></td>
  <td width="507" align="left" valign="middle" class="le"> 网站进度表</td>
  <td width="215" align="left">&nbsp;</td>
</tr>
<tr align="center" valign="middle">
  <td colspan="4"><table width="600" border="0" cellspacing="0" cellpadding="0" class="MainTable">
	<tr align="left" valign="top" class="cn">
	  <td colspan="5"><table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td>
		  <table cellspacing="1" cellpadding="4" class="styletable" width="98%">
			<thead>
				<td>状态</td>
				<td>预定开始时间</td>
				<td>实际开始时间</td>
			</thead>
		  <?
		  while (!$timeRs->EOF)
		  {
			  $time = $timeRs->FetchObject();
		  ?>
			<tr>
				<td><?=$SysConfig['status'][$time->STATUS]?></td>
				<td><?=$time->YSTARTDATE?></td>
				<td><?=$time->SSTARTDATE?></td>
			</tr>
		  <?
			$timeRs->MoveNext();
		  }
		  ?>
		  </table>
		  </td>
		</tr>
	  </table></td>
	</tr>
  </table></td>
</tr>
</form>
</table>
</body>
</html>