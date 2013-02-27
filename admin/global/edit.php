<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

if (!UserIsInRole('D2',$userRole))
{
	echo '没有权限访问';
	exit();
}

$contentId = $_REQUEST['id'];
$contentRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_global WHERE id=?",array($contentId));
$content = $contentRs->FetchObject();

$webname = $content->WEBNAME;
$title = $content->TITLE;
$keywords = $content->KEYWORDS;
$description = $content->DESCRIPTION;
$beian = $content->BEIAN;
$upload = $content->UPLOAD;
$web = $content->WEB;
$currentLan = $content->LANGUAGE;

$content = FckReplace($content->CONTENT,$SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/",false);
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
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="../js/jquery_select.js"></script>
<script src="../lib/fckeditor/fckeditor.js"></script>
<script src="save.js"></script>
<script type="text/javascript">
$(function(){

	$("#lan").sBox({animated:true});
})

</script>
</head>

<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>站点管理 — 系统基本参数修改
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">

        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?=$contentId?>">
        <?include_once("editview.php")?>
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>
</html>
