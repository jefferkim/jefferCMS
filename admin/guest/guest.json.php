<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('I0',$userRole))
{
	exit();
}

$Arr = array("reply","show");
$id = $_REQUEST['id'];
$ation = $Arr[$_POST['action']];

$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_guestbook WHERE id=?",array($id));
$obj = $rs->FetchObject();
$obj->LANGUAGE = $SysConfig['language'][$obj->LANGUAGE];

$customerArray = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_guestbook' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$customerArray[] = array($fieldObj->CALLED,$rs->fields[$fieldObj->FIELDNAME]);
	$fieldRs->MoveNext();
}

/*$result = array(
	'guest' => $obj,
	'customer' => $customerArray
);

echo json_encode($result);
*/?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="../images/tab_03.gif" width="12" height="30" /></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="70%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="5%"><div align="center"><img src="../images/tb.gif" width="16" height="16" /></div></td>
                <td width="95%"><span class="STYLE3">你当前的位置</span>：网站留言</td>
              </tr>
            </table></td>
            <td width="30%" align="left"><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><div class="topmenu"><img src="../images/002.gif" width="10" height="10"><a href="javascript:closeBg();"> 关闭</a></div></td>

              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="16"><img src="../images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="../images/tab_12.gif">&nbsp;</td>
        <td style="background-color:#FFF;">
        	<div style="padding:15px 0;height:300px; overflow:hidden;">
        	<? if($ation =='show'){?>
            <table width="97%" cellpadding="4" cellspacing="1" class="styletable">
	<tr>
		<td width="15%" height="25">主题：</td>
		<td width="41%" id="lblSubject"><?php echo  $obj->SUBJECT;?></td>
		<td width="16%">用户姓名：</td>
		<td width="28%" id="lblUsername"><?php echo  $obj->USERNAME;?></td>
	</tr>
	<tr>
		<td height="25">公司名称：</td>
		<td id="lblCompany"><?php echo  $obj->COMPANY;?></td>
		<td>电子邮件：</td>
		<td id="lblEmail"><?php echo  $obj->MAIL;?></td>
	</tr>
	<tr>
		<td height="25">网站地址：</td>
		<td id="lblWeb"><?php echo  $obj->WEB;?></td>
		<td>留言时间：</td>
		<td><?php echo  $obj->NOTETIME;?></td>
	</tr>
	<tr>
		<td height="25">留言内容：</td>
		<td><?php echo  $obj->CONTENT;?></td>
		<td>IP:</td>
		<td><?php echo  $obj->IP;?></td>
	</tr>
	<tr>
		<td height="25">留言回复：</td>
		<td colspan="3" style="padding:5px;text-align:left;"><?php 
		if($obj->REPLY!="")
			echo  '<textarea name="textarea" id="textarea" cols="40" rows="8">'.$obj->REPLY.'</textarea>';
		else
			echo '<font color="#FF0000">暂无回复！</font>';
		?></td>
	</tr>
	</table>
    <?}?>
</div>
            </div>
        </td>
        <td width="8" background="../images/tab_15.gif">&nbsp;</td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="../images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="../images/tab_18.gif" width="12" height="35" /></td>
        <td>&nbsp;</td>
        <td width="16"><img src="../images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table>
