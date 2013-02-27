<?
include_once("../../config.php");
LoginCheck($SysConfig['rooturl']."webadmin/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

$id = $_REQUEST['id'];
$memberRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_kg WHERE id=?",array($id));
$memberObj = $memberRs->FetchObject();
$called = $memberObj->NAME;
$cardnum = $memberObj->CARDNUM;
$zy = $memberObj->ZY;
$cj = $memberObj->Cj;

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_kg' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $memberRs->fields[$fieldObj->FIELDNAME];
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
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
<script src="<?=$SysConfig['rooturl']?>js/jquery.js"></script> 
<script src="<?=$SysConfig['rooturl']?>js/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['rooturl']?>js/linker.js"></script>
<script>
function getCustomerData()
{
	return $.param({<?
	$arr = array();
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
		$arr[] = $fieldObj->FIELDNAME.':$("'.$type.'[name='.$fieldObj->FIELDNAME.']").val()';
	}
	echo implode(",",$arr);
	?>});
}

function check()
{
	var name = $("input[name=called]").val();
	var cardnum = $("input[name=cardnum]").val();
	var zy = $("select[name=zy]").val();
	var cj = $("input[name=cj]").val();

	if (name == "")
	{
		alert("姓名不能为空");
		return;
	}
	if (cardnum == "")
	{
		alert("准考证号不能为空");
		return;
	}
	if (zy == "")
	{
		alert("专业不能为空");
		return;
	}
	if (cj == "")
	{
		alert("成绩不能为空");
		return;
	}

	var data = $.param({
		action:'edit',
		id:$("input[name=id]").val(),
		name:name,
		cardnum:cardnum,
		zy:zy,
		cj:cj
	});

	data = data + "&" + getCustomerData();

	AjaxSet("membersave.php",data,function(data)
	{
		alert(data['result']);
		if (data['result'] == "修改成功")
		{
			window.close();
		}
	});
}

$(function()
{
	$("input[type=submit]").click(check);

	$("input[type=reset]").click(ClearInput);
});
</script>

</head>
<body>
<input type="hidden" name="id" value="<?=$id?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="left" valign="top" class="cn">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center" valign="middle">
            <td width="18" height="36">&nbsp;</td>
            <td width="23" height="36"><img src="../images/icon_arow_list.gif" width="7" height="7"></td>
            <td width="395" height="36" align="left" valign="middle" class="le"> 信息修改</td>
            <td width="341" align="right" valign="middle">
			</td>
          </tr>
          <tr align="center" valign="middle">
            <td colspan="4">
			<table width="90%">
			<tr>
				<td>
				<div class="blueborder">
				<?include_once("membereditview.php")?>
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
