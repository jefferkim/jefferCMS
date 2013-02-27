<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$maindb = $SysConfig['maindb'];

$id = $_REQUEST['id'];
$rs = $maindb->Execute("SELECT * FROM t_progress WHERE id=?",array($id));
$pObj = $rs->FetchObject();
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
<tr align="center" valign="middle">
  <td colspan="4"><table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr align="left" valign="top" class="cn">
	  <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td>
		  <?=$pObj->CONTENT?>
		  </td>
		</tr>
	  </table></td>
	</tr>
  </table></td>
</tr>
</table>
</body>
</html>