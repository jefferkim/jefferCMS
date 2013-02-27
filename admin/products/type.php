<?php
include_once("../config.php");
include_once("products.function.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('F12',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_protype","分类自定义字段","btnField");
	$link->target = "";
	$linkList[] = $link;
}
if (UserIsInRole('F7',$userRole))
{
	$link = new Linker("typeadd.php","分类添加","btnAdd");
	$link->target = "_blank";
	$linkList[] = $link;
}*/
if (UserIsInRole('F8',$userRole))
{
	$link = new Linker("###","分类修改","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('F9',$userRole))
{
	$link = new Linker("###","分类删除","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('F10',$userRole))
{
	$link = new Linker("###","设置显示","btnShow");
	$linkList[] = $link;
	$link = new Linker("###","设置隐藏","btnUnShow");
	$linkList[] = $link;
}

$lanArr = $SysConfig['customerLanguage'];

$typeArr = array(''=>'全部分类','0'=>'无大类');
$subTypeArr = GetSubType($SysConfig['customerdb'],0);
$typeArr = $typeArr + $subTypeArr;
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
<script src="type.js"></script>
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
if (!UserIsInRole('F6',$userRole))
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
    <span style="font-weight:bold">位置：</span>产品信息管理 — 产品分类列表<em id="total" style="font-weight:bold"></em>
   </div>
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0"  >

     <thead>
     <tr>

    <td align="right">语言： <?HtmlSelect('language',$lanArr,"cn","style='vertical-align:middle'")?></td>

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
            <td width="8%"  align="center" class="td_title">编号</td>
            <td width="38%"  align="left"  style="padding-left:10px;" class="td_title">产品分类名称</td>
            <td width="10%" align="center" class="td_title">是否显示</td>
            <td width="10%" align="center" class="td_title">语言</td>
            <td width="10%"  align="center" class="td_title">父类路径</td>
            <td width="8%"  align="center" class="td_title">排序</td>
            <td width="12%"  align="center" >操作</td>
            </tr>
            </thead>
             <tbody></tbody>
      <thead>
 <tr>
  
      <td colspan="8" height="30"  align="center" class="btn_line">
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
