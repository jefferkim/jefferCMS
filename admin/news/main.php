<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('E11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_news","新闻自定义字段","btnFields");
	$linkList[] = $link;
}
if (UserIsInRole('E0',$userRole))
{
	$link = new Linker("newstype.php","新闻分类","btnCategory");
	$linkList[] = $link;
}
if (UserIsInRole('E5',$userRole))
{
	$link = new Linker("newsadd.php","添加新闻","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}
*/
$link = new Linker("javascript:;","刷新新闻","btnRefresh");
$linkList[] = $link;

if (UserIsInRole('E6',$userRole))
{
	$link = new Linker("javascript:;","修改新闻","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('E7',$userRole))
{
	$link = new Linker("javascript:;","删除新闻","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('E9',$userRole))
{
	$link = new Linker("javascript:;","设置显示","btnShow");
	$linkList[] = $link;
	$link = new Linker("javascript:;","设置隐藏","btnUnShow");
	$linkList[] = $link;
}
if (UserIsInRole('E10',$userRole))
{
	$link = new Linker("javascript:;","设置推荐","btnCommend");
	$linkList[] = $link;
	$link = new Linker("javascript:;","取消推荐","btnUnCommend");
	$linkList[] = $link;
}

$link = new Linker("javascript:;","修改排序","btnOrder");
$linkList[] = $link;

//$link = new Linker("javascript:;","复制新闻","btnImport");
//$linkList[] = $link;

$lanArr = $SysConfig['customerLanguage'];


$typeArr = array(''=>'请选择');

$custdb = $SysConfig['customerdb'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<script>
var g_language = '<? echo $SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="news.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});	   
});
</script>

</head>

<body style="background:#FFF;">
<?
if (!UserIsInRole('E4',$userRole))
{
    echo '<script>';
	echo 'alert("您没有权限访问！");';
	echo '</script>';
	exit();
}

?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>新闻信息管理 — 新闻信息列表<em id="total" style="font-weight:bold"></em>
   </div>
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">

     <thead>
     <tr> 
     <td style="width:auto">语言： <?HtmlSelect('language',$lanArr,"cn","style='vertical-align:middle'")?></td>
     <td style="width:auto">新闻分类： <?HtmlSelect('type',$typeArr,"","style='vertical-align:middle'")?></td>
 
  
            </tr>

                </thead>

</table>
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top; margin-top:5px;">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
  

          
 
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
     
      <thead>
          <tr>
            <td width="4%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="4%"  align="center" class="td_title">编号</td>
            <td width="8%"  align="center" class="td_title">排序</td>
            <td width="30%" align="left" class="td_title" style="padding-left:10px;">新闻标题</td>
            <td width="8%" align="center"  class="td_title">新闻类别</td>
            <td width="6%"  align="center" class="td_title">语言</td>
            <td width="7%"  align="center" class="td_title">是否显示</td>
            <td width="7%"  align="center" class="td_title">是否推荐</td>
            <td width="8%" align="center" class="td_title">更新时间</td>
            <td width="5%" align="center"  class="td_title">排序</td>
            <td width="13%" align="center" >操作</td>
            </tr>
            </thead>
             <tbody></tbody>
      <thead>
 <tr>
      <td colspan="11" height="30"  align="center" class="btn_line">
       <div class="pl_set" id="pl_set_bg">
         <?php
		  foreach($linkList as $link)
		  {
			  $id = "";
			  if ($link->id != "")
				$id = ' id="'.$link->id.'"';
			  $target = "";
			  if ($link->target != "")
				  $target = ' target="'.$link->target.'"';
		  ?>
                <span>
                <a href="<?=$link->link?>"<?=$id?><?=$target?>><?=$link->name?></a>
                </span>
               <?php
		  		}
			   ?>     
      
      </div>

</td>
</tr>

<tr>
      <td colspan="11" height="30"  align="center" class="btn_line">
      
<div id="pager" class="pagination">&nbsp;</div>
</td>
</tr>
</thead>
    </table>
  
 </div>
  
    </td>
  </tr>
</table>



</body>


</html>


