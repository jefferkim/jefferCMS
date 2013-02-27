<?
include_once("../../config.php");
include_once("products.function.php");
include_once("products.var.php");
LoginCheck($SysConfig['rooturl']."webadmin/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$lanArr = $SysConfig['customerLanguage'];
$typeArr = GetSubType($SysConfig['customerdb'],0);
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
$(function()
{
	$("#btnSave").click(function()
	{
		var outputLan = $("select[name=outputLan]").val();

		var importLan = $("select[name=importLan]").val();

		if (outputLan == importLan)
		{
			alert("不能在同一个语言内导接产品");
			return;
		}

		var q = $.param({
			outputLan : outputLan,
			importLan : importLan
		});
		
		AjaxSet("productimporttypesave.php",q,function(data)
		{
			alert(data['result']);
			if (data['result']=='导入成功')
			{
				window.close();
			}
		});
	});
})
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="left" valign="top" class="cn">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center" valign="middle">
            <td width="18" height="36">&nbsp;</td>
            <td width="23" height="36"><img src="../images/icon_arow_list.gif" width="7" height="7"></td>
            <td width="395" height="36" align="left" valign="middle" class="le"> 产品导接</td>
            <td width="341" align="right" valign="middle">
			</td>
          </tr>
          <tr align="center" valign="middle">
            <td colspan="4">
			<table width="90%">
			<tr>
				<td>
				<div class="blueborder">
				<table>
				<tr>
					<td>导出的产品：</td>
					<td>语言：<?HtmlSelect("outputLan",$lanArr,"cn")?></td>
				</tr>
				<tr>
					<td>导入产品位置：</td>
					<td>语言：<?HtmlSelect("importLan",$lanArr,"cn")?></td>
				</tr>
				</table>
				<input type="button" id="btnSave" value="开始导接" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close()">
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
