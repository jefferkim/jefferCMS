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
  <div class="case_title"><img src="images/case_title.jpg" width="948" height="104" /></div>
 
   <div class="case_cont">
   <?
$linkurl = $_SERVER['PHP_SELF']."?";
 $page = 1;
 $pageLines = 3;
 $pageCols = 3;
if (isset($config['picturelines']) && $config['picturelines']['value']>0)
{
	$pageLines = $config['picturelines']['value'];
}
if (isset($config['picturecols']) && $config['picturecols']['value']>0)
{
	$pageCols = $config['picturecols']['value'];
}
$pageCounts = $pageLines * $pageCols;
 $picType = "案例展示";
 $picTypeId = 0;
 $where = " WHERE IsShow=1 AND Language='cn'";
 if ($picType != "")
 {
	$picTypeRs = $maindb->Execute("SELECT * FROM t_pictype WHERE Called=? AND Language=?",array($picType,"cn"));
	if ($picTypeRs->RecordCount() >0)
	{
		$picTypeId = $picTypeRs->fields['id'];
	}
 }
 if (isset($_REQUEST['pictype']) && $_REQUEST['pictype']!="")
 {
	$picTypeId = $_REQUEST['pictype'];
 }
 if ($picTypeId > 0)
 {
	$where .= " AND TypeID='".$picTypeId."'";
 }
 if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
 {
	$page = $_REQUEST['page'];
 }
 $picRs = $maindb->Execute("SELECT count(*) FROM t_pic ".$where);
 $counts = $picRs->fields[0];
 $start = ($page - 1) * $pageCounts;
if (isset($config['pictureorder']) && $config['pictureorder']['value']=="true")
	$picRs = $maindb->Execute("SELECT * FROM t_pic $where ORDER BY OrderBy LIMIT $start,$pageCounts");
else
	$picRs = $maindb->Execute("SELECT * FROM t_pic $where ORDER BY OrderBy DESC LIMIT $start,$pageCounts");
 ?>
<table align="center">
  <?
for($i=0; $i<$pageLines; $i++)
{
?>
  <tr>
    <?
for($j=0; $j<$pageCols; $j++)
{
if (!$picRs->EOF)
{
	$picObj = $picRs->FetchObject();
	?>
    <td style="padding:20px;"><table cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><?
	if (isset($config['pictureopentype']))
	{
		$popupLocation = array();
		if (isset($config['picturepoptop']))
			$popupLocation['top'] = $config['picturepoptop']['value'];
		if (isset($config['picturepopleft']))
			$popupLocation['left'] = $config['picturepopleft']['value'];
		if (isset($config['picturepopwidth']))
			$popupLocation['width'] = $config['picturepopwidth']['value'];
		if (isset($config['picturepopheight']))
			$popupLocation['height'] = $config['picturepopheight']['value'];
		if (isset($config['pictureopentype']))
			GetLinkHref($config['pictureopentype']['value'],"../upload/".$picObj->BIGURL,$popupLocation);
		else
			GetLinkHref("new","../upload/".$picObj->BIGURL);
	}
?>
          <img src="../upload/<?=$picObj->PICURL?>" /><?echo "</a>"?></td>
      </tr>
      <tr>
        <td align="center"><?=$picObj->PICNAME?></td>
      </tr>
    </table></td>
    <?
	$picRs->MoveNext();
}
}
?>
  </tr>
  <?
}
?>
</table>
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
<div class="pager clear">
  <?=$pager->render();?>
</div>

   <?php /*?>  <?
$where = "WHERE Language='cn' AND Called='"."案例展示"."'";
$contentRs = $maindb->Execute("SELECT * FROM t_content ".$where);
if ($contentRs->RecordCount() > 0)
{
	$contentObj = $contentRs->FetchObject();
	echo $contentObj->CONTENT;
}?>
<?php */?>
   
   
   </div>

</div>



</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>