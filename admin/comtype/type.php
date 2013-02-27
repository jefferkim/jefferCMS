<?
include_once("../../config.php");
include_once("type.function.php");
LoginCheck($SysConfig['rooturl']."webadmin/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('CT1',$userRole))
{
	echo '没有权限访问';
	exit();
}

$linkList = array();
$jsLinkList = array();

if (UserIsInRole('CT5',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_comtype","分类自定义字段","btnField");
	$link->target = "";
	$linkList[] = $link;
}
if (UserIsInRole('CT2',$userRole))
{
	$link = new Linker("typeadd.php","分类添加","btnAdd");
	$link->target = "_blank";
	$linkList[] = $link;
}
if (UserIsInRole('CT3',$userRole))
{
	$link = new Linker("###","分类修改","btnEdit");
	$linkList[] = $link;
}
if (UserIsInRole('CT4',$userRole))
{
	$link = new Linker("###","分类删除","btnDelete");
	$linkList[] = $link;
}

$lanArr = $SysConfig['customerLanguage'];

$typeArr = array(''=>'全部分类','0'=>'无大类');
$subTypeArr = GetSubType($SysConfig['customerdb'],0);
$typeArr = $typeArr + $subTypeArr;
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
<script>
var g_language = '<?echo $SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.pagination.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/linker.js"></script>
<script src="type.js"></script>
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
            <td width="395" height="36" align="left" valign="middle" class="le"> 行业分类管理 <input type="button" id="btnRefresh" value="刷新" class="btnstyle"></td>
            <td width="341" align="right" valign="middle">
			<table>
			<tr>
			<td>
			语言：
			  <?HtmlSelect('language',$lanArr,"cn")?>
			<!--分类:
			  <?HtmlSelect('type',$typeArr,"")?>
			  --></td>
			  <td>
			  <a href="javascript:;" id="btnSelect">
              <img src="../images/02.gif" width="39" height="21" border="0">
			  </a>
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
                                    <td width="22" height="25" valign="middle"><input type="checkbox" name="chk" id="chk"></td>
                                    <td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="68" height="25"> 编号 </td>
                                    <td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="271" height="25">名称</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="10%" height="25">语言</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="250" height="25">父类路径</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="50" height="25">排序</td>
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
