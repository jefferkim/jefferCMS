<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('H11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_download","自定义字段管理","btnField");
	$link->target = '';
	$linkList[] = $link;
}
if (UserIsInRole('H5',$userRole))
{
	$link = new Linker("type.php","下载分类","btnCategory");
	$linkList[] = $link;
}
if (UserIsInRole('H1',$userRole))
{
	$link = new Linker("downloadadd.php","添加下载","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}
*/
$link = new Linker("javascript:;","刷新下载","btnRefresh");
$linkList[] = $link;

if (UserIsInRole('H2',$userRole))
{
	$link = new Linker("javascript:;","修改下载","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('H3',$userRole))
{
	$link = new Linker("javascript:;","删除下载","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('H4',$userRole))
{
	$link = new Linker("javascript:;","设置显示","btnShow");
	$linkList[] = $link;
	$link = new Linker("javascript:;","设置隐藏","btnHide");
	$linkList[] = $link;
}
if (UserIsInRole('H13',$userRole))
{
	$link = new Linker("javascript:;","设置推荐","btnCommend");
	$linkList[] = $link;
	$link = new Linker("javascript:;","取消推荐","btnUnCommend");
	$linkList[] = $link;
}
//$link = new Linker("javascript:;","复制下载","btnImport");
//$linkList[] = $link;

$lanArr = $SysConfig['customerLanguage'];
$typeArr = array(''=>'请选择');
$typeRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_downloadtype ORDER BY id");
while (!$typeRs->EOF)
{
	$typeObj = $typeRs->FetchObject();
	$typeArr[$typeObj->ID] = $typeObj->CALLED;
	$typeRs->MoveNext();
}
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
<script src="../js/linker.js"></script>
<script src="download.js"></script>
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
if (!UserIsInRole('H0',$userRole))
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
    <span style="font-weight:bold">位置：</span>下载信息管理 — 下载信息列表<em id="total" style="font-weight:bold"></em>
   </div>
   
   <div id="search">
   <table width="100%" border="0" cellpadding="0" cellspacing="0" >

     <thead>
     <tr>
     <td>语言： <?HtmlSelect('language',$lanArr,"cn","style='vertical-align:middle'")?></td>
     <td>下载分类： <?HtmlSelect('type',$typeArr,"","style='vertical-align:middle'")?></td>

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
            <td width="5%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="6%"  align="center" class="td_title">编号</td>
            <td width="25%"  align="center" class="td_title">标题</td>
            <td width="8%" align="center" class="td_title">语言</td>
            <td width="8%" align="center"  class="td_title">是否显示</td>
            <td width="8%"  align="center" class="td_title">是否推荐</td>
            <td width="10%"  align="center" class="td_title">下载文件</td>
            <td width="8%"  align="center" class="td_title">文件大小</td>
            <td width="6%" align="center"  class="td_title">排序</td>
            <td width="16%" align="center" >操作</td>
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

</html>


