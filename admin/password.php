<?
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
if (isset($_POST['oldpassword']))
{
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$result = "原始密码错误";

	$db = $SysConfig['maindb'];

	$rs = $db->Execute("select PassWord from t_admin where Id=?",array($_SESSION['SWEBADMIN_USERID']));
	if ($rs->RecordCount() > 0)
	{
		$obj = $rs->FetchObject();
		if ($oldpassword == $obj->PASSWORD)
		{
			$db->Execute("update t_admin set PassWord=? where Id=?",array($newpassword,$_SESSION['SWEBADMIN_USERID']));
			$result = "密码修改成功";
		}
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?echo $SysConfig['title'];?></title>
<style type="text/css">
<!--
@import url("css.css");
-->
</style>
<script src="<?echo $SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.ui.js"></script>
<script language="javascript">
$(function()
{
	$("#btnChange").click(function()
	{
		if ($("input[name='oldpassword']").val() == "")
		{
			alert('请填写原始密码！');
			$("input[name='oldpassword']").focus();
			return;
		}
		if ($("input[name='newpassword']").val() == "")
		{
			alert('请填写新密码！');
			$("input[name='newpassword']").focus();
			return;
		}
		if ($("input[name='newpassword']").val() != $("input[name='newpasswordagain']").val())
		{
			alert("新密码不一致！");
			$("input[name='newpassword']").focus();
			return;
		}

		$("form[name='form']").submit();
	});

	$("#btnReset").click(function()
	{
		$(":input").val('');
	});
})
</script>


</head>

<body style="overflow:hidden;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9" valign="middle" bgcolor="#0a5c8e"><span class="navPoint" title="关闭/打开左栏" onClick="frameToggle();"><img src="images/main_41.gif" name="img1" width=9 height=52 border="0"></span></td>
    <td align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
      <tr>
        <td height="8" style=" line-height:8px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
          <tr>

            <td width="14"><img src="images/main_24.gif" width="14" height="8"></td>
            <td background="images/main_26.gif" style="line-height:8px;">&nbsp;</td>
            <td width="7"><img src="images/main_28.gif" width="7" height="8"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
          <tr>

            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="images/tab_03.gif" width="12" height="30" /></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>

                <td width="5%"><div align="center"><img src="images/tb.gif" width="16" height="16" /></div></td>
                <td width="95%"><span class="STYLE3">你当前的位置</span>：用户密码设置</td>
              </tr>
            </table></td>
            <td width="70%" align="left">&nbsp;</td>
          </tr>
        </table></td>
        <td width="16"><img src="images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="images/tab_12.gif">&nbsp;</td>
        <td style="padding-left:10px;padding-right:10px;">
        <div class="csh"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="MainTable">
	<form method="post" name="form" action=""><tr align="left" valign="top" class="cn">
	  <td colspan="5"><table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td></td>
		</tr>
	  </table></td>
	</tr>
	<tr align="left" valign="top" class="cn">
	  <td height="40" colspan="5" align="center">
	  <span style="color:red;font-weight:bold;"><?
	  if (isset($result))
	  {
		echo $result;
	  }
	  ?></span>
	  </td>
	  </tr>
	<tr align="left" valign="top" class="cn">
	  <td width="56">&nbsp;</td>
	  <td width="104" height="30" align="right" valign="middle">  &nbsp;原始密码：&nbsp; </td>
	  <td width="240" height="30" valign="middle"><input name="oldpassword" type="password" class="sae" size="20"></td>
	  <td width="91" valign="middle">&nbsp;</td>
	  <td width="286" height="40" valign="middle">&nbsp;</td>
	</tr>
	<tr align="left" valign="top" class="cn">
	  <td>&nbsp;</td>
	  <td height="30" align="right" valign="middle"> &nbsp;新密码：&nbsp;</td>
	  <td height="30" valign="middle"><input name="newpassword" type="password" class="sae" size="20"></td>
	  <td height="40" valign="middle">&nbsp;</td>
	  <td height="40" valign="middle">&nbsp;</td>
	</tr>
	<tr align="left" valign="top" class="cn">
	  <td>&nbsp;</td>
	  <td height="30" align="right" valign="middle"> &nbsp;再输入一次：&nbsp;</td>
	  <td height="30" valign="middle"><input name="newpasswordagain" type="password" class="sae" size="20"></td>
	  <td height="40" valign="middle">&nbsp;</td>
	  <td height="40" valign="middle">&nbsp;</td>
	</tr>
	<tr align="left" valign="top" class="cn">
	  <td>&nbsp;</td>
	  <td height="40" colspan="4" align="left" valign="middle"><table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr align="center" valign="middle">
		  <td width="104">&nbsp;</td>
		  <td width="78" align="left"><table width="51" height="24" border="0" cellpadding="0" cellspacing="0" class="an">
			<tr>
			  <td align="center" valign="middle"><a href="#" id="btnChange">确定</a></td>
			</tr>
		  </table></td>
		  <td width="418" align="left"><table width="51" height="24" border="0" cellpadding="0" cellspacing="0" class="an">
			<tr>
			  <td align="center" valign="middle"><a href="#" id="btnReset">清空</a></td>
			</tr>
		  </table></td>
		</tr>
	  </table></td>
	</tr></form>
  </table></div>
        </td>
        <td width="8" background="images/tab_15.gif">&nbsp;</td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="images/tab_18.gif" width="12" height="35" /></td>
        <td>&nbsp;</td>
        <td width="16"><img src="images/tab_20.gif" width="16" height="35" /></td>
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
            <td width="14" height="12"><img src="images/main_46.gif" width="14" height="12"></td>
            <td background="images/main_48.gif" style="line-height:12px;">&nbsp;</td>
            <td width="7"><img src="images/main_50.gif" width="7" height="12"></td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</html>
