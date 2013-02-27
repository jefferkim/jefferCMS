<?
include_once("../../config.php");
include_once("products.function.php");
LoginCheck($SysConfig['rooturl']."webadmin/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('N7',$userRole))
{
	echo '没有权限访问';
	exit();
}

$called = "";
$orderBy = 1;
$currentLan = "cn";
$currentShow = 1;
$memo = "";
$currentType = "";
$editMode = false;

$showArr = $SysConfig['yesnoarray'];


$lanArr = $SysConfig['customerLanguage'];

$typeArr = array(0=>'无父类');

$typeRs = $SysConfig['customerdb']->Execute("SELECT OrderBy FROM t_ppgprotype ORDER BY OrderBy DESC LIMIT 0,1");
if ($typeRs->RecordCount() >0)
{
	$orderBy = $typeRs->fields['OrderBy'] + 1;
}
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
var editMode = false;
</script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/linker.js"></script>
<script src="typesave.js"></script>

</head>
<body>
<input type="hidden" name="action" value="add">
<input type="hidden" name="id" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="left" valign="top" class="cn">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center" valign="middle">
            <td width="18" height="36">&nbsp;</td>
            <td width="23" height="36"><img src="../images/icon_arow_list.gif" width="7" height="7"></td>
            <td width="395" height="36" align="left" valign="middle" class="le"> 产品分类添加</td>
            <td width="341" align="right" valign="middle">
			</td>
          </tr>
          <tr align="center" valign="middle">
            <td colspan="4">
			<table width="90%">
			<tr>
				<td>
				<div class="blueborder">
				<?include_once("typeeditview.php")?>
				</div>
				</td>
			</tr>
			</table>
			</td>
          </tr>
        </table>
      </td>
  </tr>
  <tr>
  	<td>
		
	</td>
  </tr>
</table>
</body>
</html>
