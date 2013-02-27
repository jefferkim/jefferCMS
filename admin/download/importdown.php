<?
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

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
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script>
$(function()
{
	$("#btnSave").click(function()
	{
		var outputLan = $("select[name=outputLan]").val();

		var importLan = $("select[name=importLan]").val();

		if (outputLan == importLan)
		{
			alert("不能在同一个语言内导接图片分类");
			return;
		}

		var q = $.param({
			outputLan : outputLan,
			importLan : importLan
		});
		
		AjaxSet("importdownsave.php",q,function(data)
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
            <td width="395" height="36" align="left" valign="middle" class="le"> 下载导接</td>
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
					<td>导出的下载：</td>
					<td>语言：<?HtmlSelect("outputLan",$lanArr,"cn")?></td>
				</tr>
				<tr>
					<td>导入的下载：</td>
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
