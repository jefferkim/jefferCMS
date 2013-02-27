<?php
include_once("../config.php");
include_once("products.function.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('F11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_products","自定义字段管理","btnZdy");
	$linkList[] = $link;
}

if (UserIsInRole('F6',$userRole))
{
	$link = new Linker("type.php","分类管理","btnCategory");
	$linkList[] = $link;
}
if (UserIsInRole('F1',$userRole))
{
	$link = new Linker("productadd.php","产品添加","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}
*/
$link = new Linker("javascript:;","刷新产品","btnRefresh");
$linkList[] = $link;
	
if (UserIsInRole('F2',$userRole))
{
	$link = new Linker("javascript:;","产品修改","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('F3',$userRole))
{
	$link = new Linker("javascript:;","产品删除","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('F4',$userRole))
{
	$link = new Linker("javascript:;","设置显示","btnShow");
	$linkList[] = $link;
	$link = new Linker("javascript:;","设置隐藏","btnUnShow");
	$linkList[] = $link;
}
if (UserIsInRole('F5',$userRole))
{
	$link = new Linker("javascript:;","设置推荐","btnCommend");
	$linkList[] = $link;
	$link = new Linker("javascript:;","取消推荐","btnUnCommend");
	$linkList[] = $link;
}
$link = new Linker("javascript:;","保存修改","btnOrder");
$linkList[] = $link;
//$link = new Linker("###","复制产品","btnImport");
//$linkList[] = $link;


$lanArr = $SysConfig['customerLanguage'];
$typeArr = array(''=>'请选择');
$typeArr = $typeArr + GetSubType($SysConfig['customerdb'],0);

$showArr = array(''=>'请选择') + $SysConfig['yesnoarray'];
$commendArr = $showArr;
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
var rooturl = "<?echo globalpath();?>";
g_language = '<? echo $SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="../dialog/dialogpro.js"></script>
<script src="../js/ps_jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery-impromptu.js"></script>
<link media="screen" rel="stylesheet" href="../colorbox/colorbox.css" />

<script src="../colorbox/js/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
$(".example6").colorbox({iframe:true, innerWidth:770, innerHeight:400});
});
</script>     
<script src="../js/linker.js"></script>
<script src="products.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});
	$("#selstyl").find("select").css({width:"120px",overflow:"hidden"});
});

</script>
</head>

<body style="background:#FFF;">
<?
if (!UserIsInRole('F0',$userRole))
{
    echo '<script>';
	echo 'alert("您没有权限访问！");';
	echo '</script>';
	exit();
}

?>

<style>

div{ overflow:visible}

</style>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <div style="float:left">
    <span style="font-weight:bold">位置：</span>产品信息管理 — 产品信息列表<em id="total" style="font-weight:bold"></em>
    </div>
    <div style="float:right">
    <a href="photo.php" class="example6"><img src="../images/plsc.jpg" width="84" height="24"  style="padding-top:1px; padding-right:15px;"/></a></div>
   </div>
   
 
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">

     <thead>
     <tr>
     
   
     
      <td>语言： <?HtmlSelect('language',$lanArr,"cn","style='vertical-align:middle'")?> </td>
      <td>产品分类： <?HtmlSelect('type',$typeArr,"","style='vertical-align:middle'")?> </td>
      <td>是否显示： <?HtmlSelect('selShow',$showArr,'',"style='vertical-align:middle'")?></td>
      <td>是否推荐： <?HtmlSelect('selCommend',$commendArr,'',"style='vertical-align:middle'")?></td>
      <td><input type="hidden" size="3" name="productnums" value="15">关键字：
   <input type="text" name="keyword" size="10" style="width:auto; height:22px; border:solid 1px #D0D0D0; vertical-align:middle; line-height:22px;"></td>

<td>  
      <a href="javascript:;" id="btnSelect" style="padding-left:5px;">
 <img src="../images/search.gif" width="72" height="24" border="0" style="vertical-align:top;"></a></td>
     
     
            </tr>
                
              
            
                
                
                </thead>

</table>
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
  

          
 
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
     
      <thead>
          <tr>
            <td width="4%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="8%"  align="center" class="td_title">编号</td>
            <td width="8%"  align="center" class="td_title">排序</td>
            <td width="15%" align="center" class="td_title">产品名称</td>
            <td width="15%" align="center" class="td_title">产品小图片</td>
            <td width="6%"  align="center" class="td_title">语言</td>
            <td width="8%"  align="center" class="td_title">是否显示</td>
            <td width="8%"  align="center" class="td_title">是否推荐</td>
            <td width="6%"  align="center" class="td_title">排序</td>
            <td width="22%"  align="center" >操作</td>
            </tr>
            </thead>
             <tbody></tbody>
      <thead>
 <tr>
      <td colspan="10" height="30"  align="center" class="btn_line">
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
      <td colspan="10" height="30"  align="center" class="btn_line">
      
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