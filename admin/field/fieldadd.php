<?php
include_once("../config.php");
include_once("field.var.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$tableName = $_REQUEST['table'];
$called = "";
$fieldname = "";
$currentDataType = 'varchar';
$currentUiType = 'input';
$defaultValue = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<script>
	var tableName = '<?=$tableName?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/jquery_select.js"></script>
<script src="../js/linker.js"></script>
<script src="fieldsave.js"></script>

<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
  

<script>
$(function(){

	$("#datatype").sBox({animated:true});
	$("#uitype").sBox({animated:true});
})
</script>
</head>


<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>基础信息管理 — 自定义字段管理
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">

  <input type="hidden" name="action" value="add">
          <?include_once("fieldeditview.php")?>
          
 </div>
  
    </td>
    
  </tr>
  
</table>




</body>




</html>

