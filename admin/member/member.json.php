<?php
include_once("../config.php");

$id = $_REQUEST['id'];
$memberRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_user WHERE id=?",array($id));
$obj = $memberRs->FetchObject();

$customerArray = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$customerArray[] = array($fieldObj->CALLED,$memberRs->fields[$fieldObj->FIELDNAME]);
	$fieldRs->MoveNext();
}

/*$result = array(
	'member' => $obj,
	'customer' => $customerArray
);
*/
//echo json_encode($result);
?>
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
                <td width="95%"><span class="STYLE3">你当前的位置</span>：查看会员信息</td>
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
        	<div style="padding:15px 0;height:300px; overflow-y:scroll;">
        	<table width="97%" align="left" cellpadding="4" cellspacing="1" class="styletable">
	<tr>
		<td width="120" height="30">用户名：</td>
		<td id="lblUserName"><?php echo  $obj->USERNAME?></td>
	</tr>
	<tr>
		<td height="30">密码：</td>
		<td id="lblPassword"><?php echo  $obj->PASSWORD?></td>
	</tr>
	<tr>
		<td height="30">姓名：</td>
		<td id="lblName"><?php echo  $obj->CALLED?></td>
	</tr>
	<tr>
		<td height="30">联系电话：</td>
		<td id="lblTel"><?php echo  $obj->TEL?></td>
	</tr>
	<tr>
		<td height="30">手机：</td>
		<td id="lblMobil"><?php echo  $obj->MOBILE?></td>
	</tr>
	<tr>
		<td height="30">电子邮件：</td>
		<td id="lblMail"><?php echo  $obj->MAIL?></td>
	</tr>
	<tr>
		<td height="30">公司名称：</td>
		<td id="lblCompany"><?php echo  $obj->COMPANY?></td>
	</tr>
    <?php
    if(count($customerArray)>0){
		foreach($customerArray as $val){
			echo '<tr><td width="120" height="30">'.$val[0].'：</td>';
			echo '<td id="lblUserName">'.$val[1].'</td></tr>';
		}
	}
	?>
	</table>
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
