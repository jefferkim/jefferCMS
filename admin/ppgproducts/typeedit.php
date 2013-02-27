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
$currentLan = "";
$currentShow = 1;
$memo = "";
$currentType = "";
$editMode = true;

$id = $_REQUEST['id'];
$typeRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_ppgprotype WHERE id=?",array($id));
if ($typeRs->RecordCount() >0)
{
	$typeObj = $typeRs->FetchObject();
	$called = $typeObj->CALLED;
	$orderBy = $typeObj->ORDERBY;
	$currentLan = $typeObj->LANGUAGE;
	$currentShow = $typeObj->ISSHOW;
	$memo = $typeObj->MEMO;
	$currentType = $typeObj->PID;
}

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];

$typeArr = array(0=>'无父类');
$subTypeArr = GetSubType($SysConfig['customerdb'],0,$id,$currentLan);
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
var editMode = true;
</script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/linker.js"></script>
<script src="typesave.js"></script>

</head>
<body>
<input type="hidden" name="action" value="edit">
<input type="hidden" name="id" value="<?=$id?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="left" valign="top" class="cn">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center" valign="middle">
            <td width="18" height="36">&nbsp;</td>
            <td width="23" height="36"><img src="../images/icon_arow_list.gif" width="7" height="7"></td>
            <td width="395" height="36" align="left" valign="middle" class="le"> 产品分类修改</td>
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
