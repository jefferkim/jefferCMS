<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('K11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_job","自定义字段管理","btnField");
	$link->target = '';
	$linkList[] = $link;
}
if (UserIsInRole('K1',$userRole))
{
	$link = new Linker("jobadd.php","添加招聘","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}
*/
$link = new Linker("javascript:;","刷新招聘","btnRefresh");
$linkList[] = $link;

if (UserIsInRole('K2',$userRole))
{
	$link = new Linker("javascript:;","修改招聘","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('K3',$userRole))
{
	$link = new Linker("javascript:;","删除招聘","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('K4',$userRole))
{
	$link = new Linker("javascript:;","设置显示","btnShow");
	$linkList[] = $link;
	$link = new Linker("javascript:;","设置隐藏","btnHide");
	$linkList[] = $link;
}
if (UserIsInRole('K13',$userRole))
{
	$link = new Linker("javascript:;","设置推荐","btnCommend");
	$linkList[] = $link;
	$link = new Linker("javascript:;","取消推荐","btnUnCommend");
	$linkList[] = $link;
}
/*if (UserIsInRole('K5',$userRole))
{
	$link = new Linker("career.php","查看简历","btnCareer");
	$linkList[] = $link;
}
//$link = new Linker("javascript:;","复制招聘","btnImport");
//$linkList[] = $link;
*/
$lanArr = $SysConfig['customerLanguage'];
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
<script src="../js/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery-impromptu.js"></script>
<script src="../js/linker.js"></script>
<script src="job.js"></script>
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
if (!UserIsInRole('K0',$userRole))
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
    <span style="font-weight:bold">位置：</span>招聘信息管理 — 招聘信息列表<em id="total" style="font-weight:bold"></em>
   </div>
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0" >

     <thead>
      <tr>     
      
      <td align="right">语言： <?HtmlSelect('language',$lanArr,$lan,"style='vertical-align:middle'")?></td>
          
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
            <td width="20%"  align="center" class="td_title">招聘职位</td>
            <td width="8%" align="center" class="td_title">语言</td>
            <td width="8%" align="center" class="td_title">是否显示</td>
            <td width="8%"  align="center" class="td_title">是否推荐</td>
            <td width="14%"  align="center" class="td_title">更新时间</td>
            <td width="10%"  align="center" class="td_title">结束时间</td>
            <td width="6%" align="center" class="td_title">排序</td>
            <td width="18%"  align="center" >操作</td>
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


