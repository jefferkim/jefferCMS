<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('K0',$userRole))
{
	exit();
}

$id = $_REQUEST['id'];
$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_job WHERE id=?",array($id));
$obj = $rs->FetchObject();
$obj->LANGUAGE = $SysConfig['language'][$obj->LANGUAGE];

//echo json_encode($obj);
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
                <td width="95%"><span class="STYLE3">你当前的位置</span>：查看招聘</td>
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
        <td style="padding-left:10px;padding-right:10px; background-color:#FFF;">
        	<div style="padding:15px 0;">
        	<table width="100%" align="center" cellpadding="4" cellspacing="1" class="styletable">
	<tr>
		<td width="20%" height="30">招聘职位：</td>
		<td width="30%" id="lblPosition"><?php echo $obj->POSITION?></td>
		<td width="20%">专业：</td>
		<td width="30%" id="lblSpecialty"><?php echo $obj->SPECIALTY?></td>
	</tr>
	<tr>
		<td height="30">要求年龄：</td>
		<td id="lblAge"><?php echo $obj->AGE?></td>
		<td>性别：</td>
		<td id="lblSex"><?php echo $obj->SEX?></td>
	</tr>
	<tr>
		<td height="30">招聘人数：</td>
		<td id="lblNum"><?php echo $obj->NUM?></td>
		<td>学历：</td>
		<td id="lblEducational"><?php echo $obj->EDUCATIONAL?></td>
	</tr>
	<tr>
		<td height="30">工作经验：</td>
		<td id="lblExperience"><?php echo $obj->EXPERIENCE?></td>
		<td>薪水要求：</td>
		<td id="lblSalary"><?php echo $obj->SALARY?></td>
	</tr>
	<tr>
		<td height="30">结束时间：</td>
		<td id="lblEndtime"><?php echo $obj->ENDTIME?></td>
		<td>排序：</td>
		<td id="lblOrderby"><?php echo $obj->ORDERBY?></td>
	</tr>
	<tr>
		<td height="30">语言：</td>
		<td id="lblLanguage"><?php echo $obj->LANGUAGE?></td>
		<td>是否显示：</td>
		<td id="lblShow"><?php echo $obj->ISSHOW?></td>
	</tr>
	<tr>
		<td height="30">其它要求：</td>
		<td colspan="3" align="left" valign="top">
        <div style="line-height:20px;"><?php echo $obj->MEMO?></div>
        </td>
	</tr>
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
