<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",true);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<script>
function switchSysBar(){ 
var locate=location.href.replace('center.php','');
var ssrc=document.getElementById("img").src.replace(locate,'');
if (ssrc=="images/block.jpg")
{ 
document.all("img").src="images/none.jpg";
document.getElementById("frmTitle").style.display="none" 
} 
else
{ 
document.all("img").src="images/block.jpg";
document.getElementById("frmTitle").style.display="" 
} 
} 
</script>

</head>

<body style=" position:relative;">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="179" name="fmTitle" id="frmTitle">
    <iframe name="I1" height="100%" width="179" src="left.php" border="0" frameborder="0" scrolling="no"> 浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe>
    
    </td>
    <td onClick="switchSysBar()" width="5"><span class="navPoint" 
id="switchPoint" title="关闭/打开左栏"><img src="images/block.jpg" width="5" id="img" name="img" height="45" style="cursor:pointer"></span></td>
    <td valign="top" height="100%">
    
     <iframe name="main" height="100%" width="100%" src="right.php" border="0" frameborder="0" scrolling="no"> 浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe>
    
    </td>
  </tr>
</table>

</body>
</html>
