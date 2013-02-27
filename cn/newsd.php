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
 
 <div class="title"><img src="images/ny_left_n.jpg" width="239" height="121" /></div>
 
 <ul>
 <li><a href="news.php?gid=0">公司新闻</a></li>
 <li><a href="news.php?gid=1">活动新闻</a></li>
 </ul>
</div>



<div class="ny_right">
 
 <div class="title"><img src="images/pic1.jpg" width="706" height="113" /></div>
 
 <div class="cont">
 
 <?
if (isset($_REQUEST['nid']) && $_REQUEST['nid']>0)
{
	$nid = $_REQUEST['nid'];
	$newsRs = $maindb->Execute("SELECT * FROM t_news WHERE IsShow=1 AND id=?",array($nid));
	if ($newsRs->RecordCount() >0)
	{
		$maindb->Execute("UPDATE t_news SET Hits=Hits+1 WHERE id=?",array($nid));
		$newsObj = $newsRs->FetchObject();
		?>
<div class="clear">
  <h1 class="newstitle">
    <?=$newsObj->TITLE?>
  </h1>
  <div class="newssubtitle"></div>
  <div>
    <?=$newsObj->CONTENT?>
  </div>
  
</div>
<?
	}
}
?>

 
 </div>



</div>

</div>



</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>