<?
include_once("../../config.php");
LoginCheck($SysConfig['rooturl']."webadmin/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('CU1',$userRole))
{
	echo '没有权限访问';
	exit();
}

$linkList = array();
$jsLinkList = array();

if (UserIsInRole('CU6',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_user","自定义字段","btnField");
	$linkList[] = $link;
}
if (UserIsInRole('CU2',$userRole))
{
	$link = new Linker("###","删除会员","btnDelete");
	$linkList[] = $link;
}
if (UserIsInRole('CU3',$userRole))
{
	$link = new Linker("###","设置锁定","btnLock");
	$linkList[] = $link;
	$link = new Linker("###","解除锁定","btnUnLock");
	$linkList[] = $link;
}
if (UserIsInRole('CU4',$userRole))
{
	$link = new Linker("###","设置推荐","btnCommend");
	$linkList[] = $link;
	$link = new Linker("###","解除推荐","btnUnCommend");
	$linkList[] = $link;
}
if (UserIsInRole('CU5',$userRole))
{
	$link = new Linker("###","设置优秀","btnExcellent");
	$linkList[] = $link;
	$link = new Linker("###","解除优秀","btnUnExcellent");
	$linkList[] = $link;
}

$lanArr = $SysConfig['customerLanguage'];
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
<script src="<?=$SysConfig['rooturl']?>js/jquery-impromptu.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/linker.js"></script>
<script src="member.js"></script>

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
            <td width="395" height="36" align="left" valign="middle" class="le"> 会员管理 <input type="button" value="刷新" id="btnRefresh" class="btnstyle"></td>
            <td width="341" align="right" valign="middle">
			<table>
			<tr>
			<td>
              语言：
			  <?HtmlSelect('language',$lanArr,"cn")?>
			  用户名：
			  <input type="text" name="username">
			  </td>
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
                                    <td width="22" height="25" valign="middle"><input type="checkbox" value='全选' name="chk" id="chk"></td>
                                    <td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="68" height="25"> 编号 </td>
                                    <td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="120" height="25">用户名</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="120" height="25">姓名</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="50" height="25">是否锁定</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="50" height="25">是否推荐</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="50" height="25">是否优秀</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="271" height="25">公司名称</td>
									<td width="8" height="25"><img src="../images/anga.jpg" width="1" height="18"></td>
                                    <td width="80" height="25">注册时间</td>
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
<div id="details" style="display:none;">
	<table cellspacing="1" cellpadding="4" class="styletable" width="500">
	<tr>
		<td width="120">用户名：</td>
		<td id="lblUserName"></td>
	</tr>
	<tr>
		<td>联系人：</td>
		<td id="lblName"></td>
	</tr>
	<tr>
		<td>联系电话：</td>
		<td id="lblTel"></td>
	</tr>
	<tr>
		<td>传真：</td>
		<td id="lblFax"></td>
	</tr>
	<tr>
		<td>手机：</td>
		<td id="lblMobil"></td>
	</tr>
	<tr>
		<td>电子邮件：</td>
		<td id="lblMail"></td>
	</tr>
	<tr>
		<td>公司名称：</td>
		<td id="lblCompany"></td>
	</tr>
	<tr>
		<td>公司地址：</td>
		<td id="lblAddress"></td>
	</tr>
	</table>
</div>
</body>
</html>
