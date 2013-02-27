<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
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
</head>
<body>
<table width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle" background="images/451115_33.jpg" class="menu"><?=$SysConfig['copyright']?></td>
  </tr>
</table>
</body>
</html>
