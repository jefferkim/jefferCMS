<?
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('F11',$userRole))
{
	echo '没有权限访问';
	exit();
}

$linkList = array();
$jsLinkList = array();

$link = new Linker("fieldadd.php","自定义字段添加","btnAdd");
$link->target = "_blank";
$linkList[] = $link;

$link = new Linker("###","自定义字段删除","btnDelete");
$linkList[] = $link;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<style type="text/css">
<!--
@import url("../css.css");
-->
</style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="fields.js"></script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="36" align="left" valign="bottom" background="../images/451115_6.jpg" class="cn"><table border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="middle">
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
		  <td width="100" height="34" valign="middle"><a href="<?=$link->link?>"<?=$id?><?=$target?>><?=$link->name?></a></td>
          <td width="1" valign="middle"><img src="../images/451115_9.jpg" width="1" height="32"></td>
		  <?
		  }	  
		  ?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="cn">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center" valign="middle">
            <td width="18" height="36">&nbsp;</td>
            <td width="23" height="36"><img src="../images/icon_arow_list.gif" width="7" height="7"></td>
            <td width="395" height="36" align="left" valign="middle" class="le"> 自定义字段管理 <input type="button" id="btnRefresh" value="刷新" class="btnstyle"></td>
            <td width="341" align="right" valign="middle">
			<table>
			<tr>
			<td>
			  </td>
			  <td>
			  </td>
			</tr>
			</table>
			</td>
          </tr>
          <tr align="center" valign="middle">
            <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr align="left" valign="top" class="cn">
                  <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr align="center" valign="middle">
                        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cn">
                            <tr>
                              <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="table1">
                                  <thead>
								  <tr align="center" valign="middle" class="bfd">
                                    <td width="22" height="25" valign="middle"></td>
                                    <td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="68" height="25"> 编号 </td>
                                    <td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="271" height="25">描述名称</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="10%" height="25">字段名称</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="10%" height="25">数据库类型</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="10%" height="25">显示类型</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="271" height="25">默认值</td>
                                  </tr>
								  </thead>
								  <tbody>
								  </tbody>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </td>
  </tr>
  <tr>
  	<td>
		<div id="pager" class="pagination"></div>
	</td>
  </tr>
</table>
</body>
</html>
