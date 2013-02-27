<?
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$linkList = array();
$link = new Linker("###","删除","btnDelete");
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
var rooturl = "<? echo globalpath()?>";
</script>

<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="../js/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="stat.js"></script>

</head>

<body style="background:#FFF;">

<?
if (!UserIsInRole('P0',$userRole))
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
    <span style="font-weight:bold">位置：</span>SEO信息管理 — 网站访问数据分析
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
   
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
        <thead>
       <tr>
         
            <td width="5%"   align="center" class="td_title" >编号</td>
            <td width="10%"  align="center" class="td_title">IP地址</td>
            <td width="25%"  align="center" class="td_title">访问页面</td>
            <td width="40%"  align="center" class="td_title">来源页面</td>
            <td width="10%"  align="center" class="td_title">操作系统</td>
            <td width="10%"  align="center" class="td_title">浏览器版本</td>

       </tr>
      </thead>
      <tbody></tbody>
    
  <thead>
    <tr>
      <td colspan="6" height="30"  align="center" class="btn_line">
      
         
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