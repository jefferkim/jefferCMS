<?include_once("../config.php")?>
<?UserLoginCheck("index.php","请先登陆")?>


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

<div class="ny_member_one">
 
 <div class="ny_left">
  <div class="title"><img src="images/member_title.jpg" width="720" height="110" /></div>
 
  <div class="cont">
  
  <?
$where = "WHERE Language='cn' AND Called='"."活动介绍"."'";
$contentRs = $maindb->Execute("SELECT * FROM t_content ".$where);
if ($contentRs->RecordCount() > 0)
{
	$contentObj = $contentRs->FetchObject();
	echo $contentObj->CONTENT;
}?>

  
  </div>
 
 
 </div>
 
 <form action="login.php" method="post">

 <div class="ny_right">
  <div class="title"><img src="images/member_r_title.jpg" width="212" height="74" /></div>
   <span class="span_input"><input type="text" name="username" class="m_input" /></span>
   <span class="span_input" style="margin-top:20px;"><input type="text" name="username" class="m_input" /></span>
   <span class="span_input" style="margin-top:20px;"><input type="submit" name="sub" class="m_btn" value="" /></span>
   
   
   <span class="span_input" style="text-align:center; padding-top:11px;"><a href="#" style="padding-right:20px;">注册新用户</a> <a href="#">忘记密码？</a></span>
   
   <img src="images/right_foot.jpg" width="212" height="11" style="display:block;" />
   
 </div>

</form>
</div>


<div class="ny_member_two">

 <div class="title"><img src="images/hylp.jpg" width="948" height="77" /></div>

 <div class="cont">
 
 
 <div id="pic_s">
 
<?
$linkurl = $_SERVER["PHP_SELF"]."?";
$where = "WHERE IsShow=1 AND IsCommend=1 AND Language='cn'";
$sqlPara = array();
$page = 1;
$pageLines = 6;
$pageCols = 2;
if (isset($config['productlines']) && $config['productlines']['value']>0)
{
	$pageLines = $config['productlines']['value'];
}
if (isset($config['productcols']) && $config['productcols']['value']>0)
{
	$pageCols = $config['productcols']['value'];
}
$pageCounts = $pageLines * $pageCols;
$typeName = "产品展示";
$seoLink = "<a href='".BuildUrl("products.php","products",array(),$SysConfig["UseRewrite"])."'>产品展示</a>";
$mainType = "会员礼品";
$typeid = "";
if ($mainType != "")
{
	$rd = $maindb->Execute("SELECT * FROM t_protype WHERE Called=? AND Language='cn'",array($mainType));
	if ($rd->RecordCount() == 1)
	{
		$typeid = $rd->fields['id'];
	}
}
if (isset($_REQUEST['tid']) && $_REQUEST['tid']!="")
{
	$typeid = $_REQUEST['tid'];
}
if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if ($typeid!="")
{
	$tid = GetTypeId($maindb,$typeid,"cn");
	$where .= " AND TypeID in (".implode(",",$tid).")";
	$linkurl .= "&tid=".$typeid;
 $rd = $maindb->Execute("SELECT * FROM t_protype WHERE id=?", array($typeid));
 if ($rd->RecordCount() > 0)
 {
 	$typeName_show = $rd->fields['Called'];
		$typeName = (isset($rd->fields["page_name"]) && $rd->fields["page_name"]!="")?$rd->fields["page_name"]:$rd->fields["Called"];
 	$parentPath = $rd->fields['ParentPath'];
 	$typeLink = "";
 	if ($parentPath != "")
 	{
 		$tid_array = explode("-", $parentPath);
 		foreach($tid_array as $tmpid)
 		{
 			$rd = $maindb->Execute("SELECT * FROM t_protype WHERE id=?", array($tmpid));
 			if ($rd->RecordCount() == 1)
 			{
 				$seoLink .= "&nbsp;&gt;&nbsp;<a href='".BuildUrl("products.php",(isset($rd->fields["page_name"]) && $rd->fields["page_name"]!="") ? $rd->fields["page_name"] : $rd->fields['Called'],array("tid"=>$tmpid), $SysConfig['UseRewrite'])."'>".$rd->fields['Called']."</a>";
 			}
 		}
 	}
 	$seoLink .= "&nbsp;&gt;&nbsp;".$typeName_show;
 }
}
if (isset($_REQUEST['keyword']) && $_REQUEST['keyword']!="")
{
	$where .= " AND (ProName like ? OR Memo like ?)";
	$sqlPara[] = "%".$_REQUEST['keyword']."%";
	$sqlPara[] = "%".$_REQUEST['keyword']."%";
	$linkurl .= "&keyword=".$_REQUEST['keyword'];
}
$sql = "SELECT COUNT(*) FROM t_products ".$where;
$proRs = $maindb->Execute($sql,$sqlPara);
$counts = $proRs->fields[0];
if (isset($config['productorder']) && $config['productorder']['value']==true)
{
	$sql = "SELECT * FROM t_products ".$where." ORDER BY OrderBy LIMIT ?,?";
}
else
{
	$sql = "SELECT * FROM t_products ".$where." ORDER BY OrderBy DESC LIMIT ?,?";
}
$sqlPara[] = ($page - 1) * $pageCounts;
$sqlPara[] = intval($pageCounts);
$proRs = $maindb->Execute($sql,$sqlPara);

?>
<table width="100%" align="center">
  <?
for($i=0; $i<$pageLines; $i++)
{
?>
  <tr>
    <?
for($j=0; $j<$pageCols; $j++)
{
if (!$proRs->EOF)
{
	$proObj = $proRs->FetchObject();
?>
    <td valign="top" style="padding:5px;" align="center"><table>
      <?
if (isset($config['productshowpic']) && $config['productshowpic']['value']=="true")
{
?>
      <tr>
        <td><?
	if (isset($config['productopentype']))
	{
		$popupLocation = array();
		if (isset($config['productpoptop']))
			$popupLocation['top'] = $config['productpoptop']['value'];
		if (isset($config['productpopleft']))
			$popupLocation['left'] = $config['productpopleft']['value'];
		if (isset($config['productpopwidth']))
			$popupLocation['width'] = $config['productpopwidth']['value'];
		if (isset($config['productpopheight']))
			$popupLocation['height'] = $config['productpopheight']['value'];
		if (isset($config['productopentype']))
			GetLinkHref($config['productopentype']['value'],BuildUrl("productsd.php", (isset($proObj->PAGE_NAME) && $proObj->PAGE_NAME!="") ? $proObj->PAGE_NAME : $proObj->PRONAME, array("pid"=>$proObj->ID),$SysConfig["UseRewrite"]),$popupLocation);
		else
			GetLinkHref("new",BuildUrl("productsd.php", (isset($proObj->PAGE_NAME) && $proObj->PAGE_NAME!="") ? $proObj->PAGE_NAME : $proObj->PRONAME, array("pid"=>$proObj->ID),$SysConfig["UseRewrite"]));
	}
?>
              <img src="../upload/<?=$proObj->SMALLPIC?>" border="0"><?echo "</a>"?></td>
      </tr>
      <?
}
if (isset($config['productshowname']) && $config['productshowname']['value']=="true")
{
?>
      <tr>
        <td align="center"><?
	if (isset($config['productopentype']))
	{
		$popupLocation = array();
		if (isset($config['productpoptop']))
			$popupLocation['top'] = $config['productpoptop']['value'];
		if (isset($config['productpopleft']))
			$popupLocation['left'] = $config['productpopleft']['value'];
		if (isset($config['productpopwidth']))
			$popupLocation['width'] = $config['productpopwidth']['value'];
		if (isset($config['productpopheight']))
			$popupLocation['height'] = $config['productpopheight']['value'];
		if (isset($config['productopentype']))
			GetLinkHref($config['productopentype']['value'],BuildUrl("productsd.php", $proObj->PRONAME, array("pid"=>$proObj->ID),$SysConfig["UseRewrite"]),$popupLocation);
		else
			GetLinkHref("new",BuildUrl("productsd.php", $proObj->PRONAME, array("pid"=>$proObj->ID),$SysConfig["UseRewrite"]));
	}
?>
              <?=$proObj->PRONAME?>
          <?echo "</a>";?></td>
      </tr>
      <?
}
if (isset($config['productshowmemo']) && $config['productshowmemo']['value']=="true")
{
?>
      <tr>
        <td><?=$proObj->MEMO?>
          &nbsp;</td>
      </tr>
      <?
}
if (isset($config['productshowcontent']) && $config['productshowcontent']['value']=="true")
{
?>
      <tr>
        <td><?=$proObj->CONTENT?>
          &nbsp;</td>
      </tr>
      <?
}	
?>
    </table></td>
    <?
	$proRs->MoveNext();
}
}
?>
  </tr>
  <?
}
?>
</table>

 </div>
 
 </div>


</div>



</div>





</div>

<? require_once('footer.php');?>

</body>

<script language="javascript" src="js/MSClass.js"></script>
<script language="javascript">
var marquee1 = new Marquee("pic_s")	
		marquee1.Direction = "left";	
		marquee1.Step = 2;
		marquee1.Width =879;
		marquee1.Height = 365;
		marquee1.Timer = 50;
		marquee1.DelayTime =0;
		marquee1.WaitTime = 0;
		marquee1.ScrollStep = 52;
		marquee1.Start();
</script>
</html>
<?include_once("bottom.php")?>