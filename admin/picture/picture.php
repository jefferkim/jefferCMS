<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('G11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_pic","自定义字段管理","#");
	$linkList[] = $link;
}
if (UserIsInRole('G5',$userRole))
{
	$link = new Linker("type.php","图片分类","btnCategory");
	$linkList[] = $link;
}
if (UserIsInRole('G1',$userRole))
{
	$link = new Linker("picadd.php","添加图片","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}*/
$link = new Linker("javascript:;","刷新图片","btnRefresh");
$linkList[] = $link;

if (UserIsInRole('G2',$userRole))
{
	$link = new Linker("javascript:;","修改图片","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('G3',$userRole))
{
	$link = new Linker("javascript:;","删除图片","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('G4',$userRole))
{
	$link = new Linker("javascript:;","设置显示","btnShow");
	$linkList[] = $link;
	$link = new Linker("javascript:;","设置隐藏","btnHide");
	$linkList[] = $link;
}
if (UserIsInRole('G13',$userRole))
{
	$link = new Linker("javascript:;","设置推荐","btnCommend");
	$linkList[] = $link;
	$link = new Linker("javascript:;","取消推荐","btnUnCommend");
	$linkList[] = $link;
}

$link = new Linker("javascript:;","保存修改","btnOrder");
$linkList[] = $link;

//$link = new Linker("javascript:;","复制图片","btnImport");
//$linkList[] = $link;

$lanArr = $SysConfig['customerLanguage'];
$custdb = $SysConfig['customerdb'];
$typeArr = array(''=>'请选择');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<style>

div{ overflow:visible;}
</style>
<script>
var rooturl = "<?echo globalpath()?>";
var g_language = '<? echo $SysConfig['currentLan'];?>';
//var g_user = '<?echo $_SESSION["SWEBADMIN_USERNAME"]?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="../dialog/dialog.js"></script>
<script src="../js/ps_jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="picture.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});	   
});

</script>
<link media="screen" rel="stylesheet" href="../colorbox/colorbox.css" />

<script src="../colorbox/js/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
$(".example6").colorbox({iframe:true, innerWidth:770, innerHeight:400});
});
</script>     


</head>

<body style="background:#FFF;">
<?
if (!UserIsInRole('G0',$userRole))
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
    <span style="font-weight:bold">位置：</span>图便信息管理 — 图片信息列表<em id="total" style="font-weight:bold"></em>
   </div>
   
   <div id="search">
   
   <table width="100%" border="0" cellpadding="0" cellspacing="0">

     <thead>
     <tr>
     <td><a href="photo.php" class="example6"><img src="../images/plsc.jpg" width="84" height="24" /></a></td>
     
    <td>语言： <?HtmlSelect('language',$lanArr,"cn","style='vertical-align:middle'")?></td>
    
    <td>图片分类： <?HtmlSelect('type',$typeArr,"","style='vertical-align:middle'")?></td>
             
    
        
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
            <td width="4%"  align="center" class="td_title">编号</td>
            <td width="7%"  align="center" class="td_title">排序</td>
            <td width="10%" align="center" class="td_title">图片名称</td>
            <td width="8%" align="center"  class="td_title">图片类别</td>
            <td width="6%"  align="center" class="td_title">语言</td>
            <td width="8%"  align="center" class="td_title">是否显示</td>
            <td width="8%"  align="center" class="td_title">是否推荐</td>
            <td width="14%" align="center" class="td_title">小图片</td>
            <td width="5%" align="center"  class="td_title">排序</td>
            <td width="12%" align="center" >操作</td>
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