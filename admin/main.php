<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",false);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<style>

</style>
<script src="js/jquery.js" type="text/javascript"></script>
<title><?=$SysConfig['title']?></title>
</head>

<frameset rows="107,*" cols="*" framespacing="0" frameborder="no" border="0">
  <frame src="top.php" name="top" scrolling="No" noresize="noresize" id="top" title="top" />
  <frame src="center.php" name="top" scrolling="No" noresize="noresize" id="midel" title="midel" />
<body>
</body>
</html>

