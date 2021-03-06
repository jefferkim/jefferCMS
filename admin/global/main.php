<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('D0',$userRole))
{
	echo '没有权限访问';
	exit();
}

$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('D1',$userRole))
{
	$link = new Linker("add.php","添加内容","btnAdd");
	$link->target = "_blank";
	$linkList[] = $link;
}
*/


if (UserIsInRole('D3',$userRole))
{
	$link = new Linker("javascript:;","删除站点","btnDelete");
	$linkList[] = $link;
}

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
var g_language = '<?echo $SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="main.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});	   
});
</script>
<script type="text/javascript">
$(document).ready(function()         
         {
var h=$(window).height()-40; //浏览器当前窗口可视区域高度

$("#box").css("height",h+"px");

}
         )
</script>
</head>

<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>站点管理 — 系统基本参数列表
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
   
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
        <thead>
       <tr>
            <td width="5%"   align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="5%"   align="center" class="td_title" >编号</td>
            <td width="40%"  class="td_title" style="padding-left:10px;">站点名称</td>
            <td width="10%"  align="center" class="td_title">语言</td>
            <td width="20%"  align="center" class="td_title">网站备案号</td>
            <td width="20%"  align="center" >操作</td>
       </tr>
      </thead>
      <tbody></tbody>
    
   <thead>
    <tr>
      <td colspan="6" height="30"  align="center" class="btn_line">
      
      <div class="pl_set" id="pl_set_bg">
      
       <span>
                <a href="add.php" target="main">添加站点</a>
                </span>
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
   <thead>
    </table>
 
 </div>
  
    </td>
  </tr>
</table>




</body>
</html>