<?include_once("../config.php")?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">

</head>

<body>

<div id="main">

<? require_once('header.php');?>


<div id="center">


<div class="ny_cont">

<div class="ny_left">
 
 <div class="title"><img src="images/ny_left_a.jpg" width="239" height="121" /></div>
 
 <ul>
 <li><a href="about.php?gid=0">公司简介</a></li>
 <li><a href="about.php?gid=1">荣誉资质</a></li>
 <li><a href="about.php?gid=2">联系我们</a></li>
 </ul>
</div>


  <?
 $linkurl = $_SERVER["PHP_SELF"]."?";
 $typename="";
 $typeID=$_REQUEST['gid']?$_REQUEST['gid']:0;
 
switch($typeID){
 case 0:
	  $typename="公司简介";
	  break;
 case 1:
	  $typename="荣誉资质";
  break;
 case 2:
	  $typename="联系我们";
  break;
}
 ?>  

<div class="ny_right">
 
 <div class="title"><img src="images/pic.jpg" width="706" height="113" /></div>
 
 <div class="cont">
  
 <?
$where = "WHERE Language='cn' AND Called='"."$typename"."'";
$contentRs = $maindb->Execute("SELECT * FROM t_content ".$where);
if ($contentRs->RecordCount() > 0)
{
	$contentObj = $contentRs->FetchObject();
	echo $contentObj->CONTENT;
}?>

 
 </div>


</div>

</div>



</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>