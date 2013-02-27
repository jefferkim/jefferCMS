<?include_once("../config.php")?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<title><?=GetGlobalTitle("cn");?></title>
<meta name="keywords" content="<?=GetGlobalKeywords("cn");?>" />
<meta name="description" content="<?=GetGlobalDescription("cn");?>" />
</head>

<body style=" background:url(images/bj.jpg) repeat-x left top #f2e9da;">

<div id="main">

<div id="header">

<div class="notice"><img src="images/sytop.jpg" width="948" height="23" /></div>
<div class="top">

<div class="logo"><img src="images/logo.jpg" width="385" height="131" /></div>

<div class="menu">
<ul>
<li><a href="index.php"><img src="images/menu1.jpg" width="81" height="74" /></a></li>
<li><a href="products.php"><img src="images/menu2.jpg" width="72" height="74" /></a></li>
<li><a href="case.php"><img src="images/menu3.jpg" width="93" height="74" /></a></li>
<li><a href="cuxiao.php"><img src="images/menu4.jpg" width="63" height="74" /></a></li>
<li><a href="member.php"><img src="images/menu5.jpg" width="90" height="74" /></a></li>
<li><a href="news.php"><img src="images/menu6.jpg" width="65" height="74" /></a></li>
<li><a href="about.php"><img src="images/menu7.jpg" width="99" height="74" /></a></li>
</ul>
</div>
</div>

</div>


<div id="center">

<div class="syflash">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="940" height="411">
  <param name="movie" value="mail.swf" />
  <param name="quality" value="high" />
  <embed src="mail.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="940" height="411"></embed>
</object>
</div>

<br class=" clear_cs" />

<div class="home_two">

<ul class="sy_dh">

<li><a href="#">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="205" height="140">
    <param name="movie" value="11.swf" />
    <param name="quality" value="high" />
    <embed src="11.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="205" height="140"></embed>
  </object>
</a></li>
<li><a href="#">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="198" height="140">
    <param name="movie" value="22.swf" />
    <param name="quality" value="high" />
    <embed src="22.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="198" height="140"></embed>
  </object>
</a></li>
<li><a href="#">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="207" height="140">
    <param name="movie" value="33.swf" />
    <param name="quality" value="high" />
    <embed src="33.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="207" height="140"></embed>
  </object>
</a></li>
</ul>

<div class="sy_member">
<form action="login.php" method="post">
<input type="hidden" name="returl" value="<?if (isset($_REQUEST['returl'])){echo $_REQUEST['returl'];}?>" />
<table width="100%" border="0">
  <tr>
    <td width="60" height="30" align="center">用户名：</td>
    <td height="30"> <input type="text" name="username" class="s_input" /></td>
  </tr>
  <tr>
    <td height="30" align="center">密&nbsp;&nbsp;&nbsp;码：</td>
    <td height="30"> <input type="password" name="password" class="s_input" /></td>
  </tr>
  <tr>
    <td height="30"></td>
    <td height="30"> <input type="submit" value="" class="login_btn" /> <a href="#" class="reg_btn" style="display:inline-block"></a></td>
  </tr>
</table>

</form>
</div>

</div>

</div>

<? require_once('footer.php');?>



</div>



</body>
</html>
<?include_once("bottom.php")?>