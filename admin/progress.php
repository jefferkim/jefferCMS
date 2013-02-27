<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$maindb = $SysConfig['maindb'];
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
  <td width="507" align="left" valign="middle" class="le"> 网站进度信息</td>
  <td width="215" align="left">&nbsp;</td>
</tr>
<tr align="center" valign="middle">
  <td colspan="4"><table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr align="left" valign="top" class="cn">
	  <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td>
		  <div class="titlelist">
		  <?
		  $len = count($SysConfig['status']);
		  for ($i=1;$i<$len;$i++)
		  {
		  ?>
		  <h1><?=$SysConfig['status'][$i]?></h1>
		  <ul>
			<?
			  $iIndex = 1;
			  $rs = $maindb->Execute("SELECT * FROM t_progress WHERE CustomerID=? AND StatusID=?",array($_SESSION['SWEBADMIN_USERID'],$i));
		      while (!$rs->EOF)
			  {
				$pObj = $rs->FetchObject();
				?>
				<li><?=$iIndex?>.<a href="javascript:;" onclick="window.open('progressdetail.php?id=<?=$pObj->ID?>','','width=550,height=550,scrollbars=yes')"><?=$pObj->TITLE?></a><span>[<?=$pObj->ENTERDATE?>]</span></li>
				<?
				$iIndex++;
				$rs->MoveNext();
			  }
		    ?>
		  </ul>
		  <?
		  }
		  ?>
		  </div>
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