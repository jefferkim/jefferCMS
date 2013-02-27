<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('G5',$userRole))
{
	echo '没有权限访问';
	exit();
}

$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('G12',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_pictype","自定义字段管理","btnField");
	$linkList[] = $link;
}
if (UserIsInRole('G6',$userRole))
{
	$link = new Linker("typeadd.php","添加图片分类","btnAdd");
	$link->target = '_blank';
	$linkList[] = $link;
}*/
if (UserIsInRole('G7',$userRole))
{
	$link = new Linker("###","修改图片分类","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('G8',$userRole))
{
	$link = new Linker("###","删除图片分类","btnDelete");
	$linkList[] = $link;
}

$lanArr = $SysConfig['customerLanguage'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<style type="text/css">
<!--
@import url("../css.css");
-->
</style>
<script>
var g_language = '<?echo $SysConfig['currentLan'];?>';
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

<body style="overflow:hidden;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9" valign="middle" bgcolor="#0a5c8e"><span class="navPoint" title="关闭/打开左栏" onClick="frameToggle();"><img src="../images/main_41.gif" name="img1" width=9 height=52 border="0"></span></td>
    <td align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
      <tr>
        <td height="8" style=" line-height:8px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
          <tr>

            <td width="14"><img src="../images/main_24.gif" width="14" height="8"></td>
            <td background="../images/main_26.gif" style="line-height:8px;">&nbsp;</td>
            <td width="7"><img src="../images/main_28.gif" width="7" height="8"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
          <tr>

            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>

                <td width="5%"><div align="center"><img src="../images/tb.gif" width="16" height="16" /></div></td>
                <td width="95%"><span class="STYLE3">你当前的位置</span>：图片分类管理</td>
              </tr>
            </table></td>
            <td width="70%" align="left"><table align="right">
			<tr>
            <?
		  foreach($linkList as $link)
		  {
			  $id = "";
			  if ($link->id != "")
				$id = ' id="'.$link->id.'"';
			  $target = "";
			  if ($link->target != "")
				  $target = ' target="'.$link->target.'"';
		  ?>
		 <td style="padding:0 10px;"><img src="../images/002.gif" width="10" height="10"><a href="<?=$link->link?>"<?=$id?><?=$target?>>&nbsp;<?=$link->name?></a></td>
		  <?php
		  }	  
		  ?>
			  <td style="padding:0 10px;">语言：
			  <?HtmlSelect('language',$lanArr,"cn")?>
			  </td>
			  <td style="padding:0 10px;">
			  <a href="javascript:;" id="btnSelect">
              <img src="../images/02.gif" width="39" height="21" border="0">
			  </a>
			  </td>
			</tr>
			</table></td>
          </tr>
        </table></td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td style="padding-left:10px;padding-right:10px;">
        <div class="csh">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" id="tablist">
        <thead>
          <tr>
           <td width="8%" align="center" valign="middle" background="../images/bg.gif"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="14%" height="23" align="center" valign="middle" background="../images/bg.gif">编号</td>
            <td width="38%" align="left" valign="middle" background="../images/bg.gif">&nbsp;名称</td>
            <td width="11%" align="center" valign="middle" background="../images/bg.gif">语言</td>
            <td width="29%" align="center" valign="middle" background="../images/bg.gif">添加时间</td>
            </tr>
            <thead>
             <tbody></tbody>
                  </table></td>
            </tr>
          </table>
        </div>
        </td>
        <td width="8" background="../images/tab_15.gif">&nbsp;</td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="../images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="../images/tab_18.gif" width="12" height="35" /></td>
        <td align="center" style="text-align:center;"><div id="pager" class="pagination"></div></td>
        <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table></td>
            <td width="3" style="width:3px; background:#0a5c8e;">&nbsp;</td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td height="12" style="line-height:12px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
          <tr>
            <td width="14" height="12"><img src="../images/main_46.gif" width="14" height="12"></td>
            <td background="../images/main_48.gif" style="line-height:12px;">&nbsp;</td>
            <td width="7"><img src="../images/main_50.gif" width="7" height="12"></td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</html>