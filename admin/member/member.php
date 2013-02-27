<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('J11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_user","自定义字段","btnField");
	$linkList[] = $link;
}
if (UserIsInRole('J1',$userRole))
{
	$link = new Linker("memberadd.php","添加会员","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}
*/
if (UserIsInRole('J2',$userRole))
{
	$link = new Linker("javascript:;","修改会员","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('J3',$userRole))
{
	$link = new Linker("javascript:;","删除会员","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('J4',$userRole))
{
	$link = new Linker("javascript:;","设置锁定","btnLock");
	$linkList[] = $link;
	$link = new Linker("javascript:;","解除锁定","btnUnLock");
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
var g_language = '<?=$SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="../js/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery-impromptu.js"></script>
<script src="../js/linker.js"></script>
<script src="member.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});	   
});

</script>

<style>
#language{ width:auto;}

</style>
</head>

<body style="background:#FFF;">
<?
if (!UserIsInRole('J0',$userRole))
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
    <span style="font-weight:bold">位置：</span>会员信息管理 — 会员信息列表<em id="total" style="font-weight:bold"></em>
   </div>
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0"  >

     <thead>
      <tr>
      <td>语言： <?HtmlSelect('language',$lanArr,"cn","style=")?></td>
      <td>用户名： <input type="text" name="username" class="sys_input"> <a href="javascript:;" id="btnSelect" style="padding-left:10px;">
        <img src="../images/search.gif" width="72" height="24" border="0" style="vertical-align:middle;"></a></td>

               
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
            <td width="30%"  align="center" class="td_title">用户名</td>
            <td width="10%" align="center" class="td_title">姓名</td>
            <td width="10%" align="center" class="td_title">是否锁定</td>
            <td width="20%"  align="center" class="td_title">公司名称</td>
            <td width="10%"  align="center" class="td_title">注册时间</td>
            <td width="12%"  align="center" >操作</td>
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
