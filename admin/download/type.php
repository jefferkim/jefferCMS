<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$linkList = array();
$jsLinkList = array();

if (UserIsInRole('H12',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_downloadtype","自定义字段管理","btnField");
	$link->target = '';
	$linkList[] = $link;
}
/*if (UserIsInRole('H6',$userRole))
{
	$link = new Linker("typeadd.php","添加下载分类","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}*/
if (UserIsInRole('H7',$userRole))
{
	$link = new Linker("###","修改分类","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('H8',$userRole))
{
	$link = new Linker("###","删除分类","btnDelete");
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
<script language="javascript">
	var g_language = '<?=$SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="../js/jquery.pagination.js"></script>
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
if (!UserIsInRole('H5',$userRole))
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
    <span style="font-weight:bold">位置：</span>下载信息管理 — 下载分类列表<em id="total" style="font-weight:bold"> </em>
   </div>
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0"  >

     <thead>
     <tr>
             <td align="right">语言：<?HtmlSelect('language',$lanArr,$lan,"style='vertical-align:middle'")?></td>
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
            <td width="70%"  align="center" class="td_title">名称</td>
            <td width="8%" align="center" class="td_title">语言</td>
            <td width="14%" align="center" >操作</td>
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


</body>
</html>


