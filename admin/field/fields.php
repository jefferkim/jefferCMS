<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$tableName = $_REQUEST['table'];

$linkList = array();
$jsLinkList = array();

/*$link = new Linker("fieldadd.php?table=".$tableName,"自定义字段添加","btnAdd");
$link->target = "_blank";
$linkList[] = $link;*/

$link = new Linker("###","自定义字段删除","btnDelete");
$linkList[] = $link;

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
var tableName = '<?=$tableName?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="fields.js"></script>
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



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>基础信息管理 — 自定义字段管理
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
 
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
      <thead>
                   <tr>
                    <td width="5%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
                    <td width="5%"  align="center" class="td_title">编号</td>
                    <td width="15%" align="center" class="td_title">描述名称</td>
                    <td width="15%" align="center" class="td_title">字段名称</td>
                    <td width="10%" align="center" class="td_title">数据库类型</td>
                    <td width="10%" align="center" class="td_title">显示类型</td>
                    <td width="30%" align="center" class="td_title">默认值</td>
                    <td width="10%" align="center" >操作</td>
                    </tr>
              <thead>
               <tbody></tbody>

    </table>
  
 </div>
  
    </td>
  </tr>
</table>




</body>

</html>


