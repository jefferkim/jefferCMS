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


<?
 $linkurl = $_SERVER["PHP_SELF"]."?";
 $typename="";
 $typeID=$_REQUEST['gid']?$_REQUEST['gid']:0;
 
switch($typeID){
 case 0:
	  $typename="公司新闻";
	  break;
 case 1:
	  $typename="活动新闻";
  break;
}
 ?>  

<div class="ny_right">
 
 <div class="title"><img src="images/pic1.jpg" width="706" height="113" /></div>
 
 <div class="cont">
 
 <ul class="news_list">
 
 <?
$linkurl = $_SERVER['PHP_SELF']."?";
$newsType = "$typename";
$newsTypeId = 0;
$page = 1;
$pageCounts = 5;
if (isset($config['newslines']) && $config['newslines']['value']>0)
{
	$pageCounts = $config['newslines']['value'];
}
if ($newsType != "")
{
	$newsTypeRs = $maindb->Execute("SELECT * FROM t_newtype WHERE Called=? AND Language=?",array($newsType,"cn"));
	if ($newsTypeRs->RecordCount() > 0)
	{
		$newsTypeId = $newsTypeRs->fields['id'];
	}
}
if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0)
{
	$page = $_REQUEST['page'];
}
if (isset($_REQUEST['newstype']) && $_REQUEST['newstype']!="")
{
	$newsTypeId = $_REQUEST['newstype'];
	$linkurl .= "&newstype=".$_REQUEST['newstype'];
}
$where = " WHERE IsShow=1 AND Language='cn'";
if ($newsTypeId >= 0)
{
	$where .= " AND NewType='".$newsTypeId."'";
}
$newsRs = $maindb->Execute("SELECT count(*) FROM t_news ".$where);
$counts = $newsRs->fields[0];
$start = ($page - 1) * $pageCounts;
if (isset($config['newsorder']) && $config['newsorder']['value'])
{
	$newsRs = $maindb->Execute("SELECT * FROM t_news $where ORDER BY OrderBy LIMIT $start,$pageCounts");
}
else
{
	$newsRs = $maindb->Execute("SELECT * FROM t_news $where ORDER BY OrderBy DESC LIMIT $start,$pageCounts");
}
?>
  <?
while (!$newsRs->EOF)
{
	$newsObj = $newsRs->FetchObject();	?>
  <li>
  <span><?echo date("Y-m-d",strtotime($newsObj->NOTETIME));?></span>
    <?
	if (isset($config['newsopentype']))
	{
		$popupLocation = array();
		if (isset($config['newspoptop']))
			$popupLocation['top'] = $config['newspoptop']['value'];
		if (isset($config['newspopleft']))
			$popupLocation['left'] = $config['newspopleft']['value'];
		if (isset($config['newspopwidth']))
			$popupLocation['width'] = $config['newspopwidth']['value'];
		if (isset($config['newspopheight']))
			$popupLocation['height'] = $config['newspopheight']['value'];
		if (isset($config['newsopentype']))
			GetLinkHref($config['newsopentype']['value'],BuildUrl("newsd.php", (isset($newsObj->PAGE_NAME) && $newsObj->PAGE_NAME!="")?$newsObj->PAGE_NAME:$newsObj->TITLE,array("nid"=>$newsObj->ID),$SysConfig["UseRewrite"]),$popupLocation);
		else
			GetLinkHref("new",BuildUrl("newsd.php", (isset($newsObj->PAGE_NAME) && $newsObj->PAGE_NAME!="")?$newsObj->PAGE_NAME:$newsObj->TITLE,array("nid"=>$newsObj->ID),$SysConfig["UseRewrite"]));
	}
?>
    <?=substr_for_gb2312($newsObj->TITLE,0,100)?>
    <?echo "</a>";?></li>
  <?
	$newsRs->MoveNext();
}
?>

<?
$pager = new Pager($linkurl,$counts,$page,$pageCounts);
$pager->setFirstText('首页');
$pager->setPrevText('上一页');
$pager->setNextText('下一页');
$pager->setLastText('尾页');
$pager->lanAll = "共有";
$pager->lanItems = "条";
if ($SysConfig['UseRewrite'])
{
$php_self = $_SERVER['PHP_SELF'];
$self_arr = explode("/",$php_self);
$html = $self_arr[count($self_arr)-1];
$html = str_replace(".php","",$html);
	$pager->useRewrite = $html;
}
?>

 <!-- 
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 <li><span>2012-08-19</span><a href="#">公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻公司新闻</a></li>
 -->
 
 </ul>
 
 <br class="clear_cs" />
 
 <div class="pager clear">
  <?=$pager->render();?>
</div>
 
 </div>



</div>

</div>



</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>