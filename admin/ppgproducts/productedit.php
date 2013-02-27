<?
include_once("../../config.php");
include_once("products.function.php");
include_once("products.var.php");
LoginCheck($SysConfig['rooturl']."webadmin/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

if (!UserIsInRole('N2',$userRole))
{
	echo '没有权限访问';
	exit();
}

$id = $_REQUEST['id'];

$proRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_ppgproducts WHERE id=?",array($id));
$proObj = $proRs->FetchObject();

$called = $proObj->PRONAME;
$orderBy = $proObj->ORDERBY;
$currentLan = $proObj->LANGUAGE;
$currentShow = $proObj->ISSHOW;
$currentCommend = $proObj->ISCOMMEND;
$currentType = $proObj->TYPEID;
$memo = $proObj->MEMO;
$editMode = true;

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];
$typeArr = GetSubType($SysConfig['customerdb'],0,"",$currentLan);

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_ppgproductfield ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $proRs->fields[$fieldObj->FIELDNAME];
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}

$colorRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_ppgcolors WHERE ProductId=?",array($id));
$colorArr = array();
while(!$colorRs->EOF)
{
	$colorObj = $colorRs->FetchObject();
	$colorArr[] = $colorObj;
	$colorRs->MoveNext();
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
var rooturl = "<?=$SysConfig['rooturl']?>";
var uploadUser = "<?=$_SESSION['SWEBADMIN_USERNAME']?>";
var uploadurl = "<?=$SysConfig['swfupload']?>";
var editMode = true;

//color def
var colorName = Array();
var colorImg = Array();
var colorSPic = Array();
var colorMPic = Array();
var colorBPic = Array();

<?
$len = count($colorArr);
for ($i=0; $i<$len; $i++)
{
	$colorObj = $colorArr[$i];
	echo 'colorName.push("'.$colorObj->NAME.'");';
	echo 'colorImg.push("'.$colorObj->PICTURE.'");';
	echo 'colorSPic.push(Array());';
	echo 'colorMPic.push(Array());';
	echo 'colorBPic.push(Array());';

	$picRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_ppgpictures WHERE ColorId=?",array($colorObj->ID));
	while(!$picRs->EOF)
	{
		$picObj = $picRs->FetchObject();
		echo 'colorSPic['.$i.'].push("'.$picObj->SMALLPIC.'");';
		echo 'colorMPic['.$i.'].push("'.$picObj->MIDDLEPIC.'");';
		echo 'colorBPic['.$i.'].push("'.$picObj->BIGPIC.'");';
		$picRs->MoveNext();
	}
}
?>

function getCustomerData()
{
	return $.param({<?
	foreach($customerFieldArr as $fieldObj)
	{
		$type = "";
		switch($fieldObj->UITYPE)
		{
			case "text":
				$type = "input";
				break;
			case "textarea":
				$type = "textarea";
				break;
			case "select":
				$type = "select";
				break;
		}
		echo $fieldObj->FIELDNAME.':$("'.$type.'[name='.$fieldObj->FIELDNAME.']").val(),';
	}
	?>});
}
</script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/jquery.progressbar.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/swfupload/swfupload.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/linker.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/uploadhandler.js"></script>
<script src="<?=$SysConfig['rooturl']?>lib/fckeditor/fckeditor.js"></script>
<script src="productsave.js"></script>

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
            <td width="395" height="36" align="left" valign="middle" class="le"> 产品修改</td>
            <td width="341" align="right" valign="middle">
			</td>
          </tr>
          <tr align="center" valign="middle">
            <td colspan="4">
			<table width="90%">
			<tr>
				<td>
				<div class="blueborder">
				<?include_once("producteditview.php")?>
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
