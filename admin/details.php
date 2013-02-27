<?php
include_once("config.php");
include_once(ROOTDIR."lib/folder.class.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$maindb = $SysConfig['maindb'];

$adminRs = $maindb->Execute("SELECT * FROM t_admin WHERE id=?",array($_SESSION['SWEBADMIN_USERID']));
if ($adminRs->RecordCount() > 0)
{
	$adminObj = $adminRs->FetchObject();
	$usedSpace = 0;
	$usedDatabase = 0;

	$folder = new Folder();
	$usedSpace = $folder->calc(ROOTDIR.$adminObj->USERNAME);

	$rs = $maindb->Execute("SHOW TABLE STATUS FROM ".$adminObj->USERNAME);
	while (!$rs->EOF)
	{
		$usedDatabase += $rs->fields['Data_length'];
		$rs->MoveNext();
	}
	$usedDatabase = round($usedDatabase/(1024*1024),2);
}

$IndustryArr = array('0'=>'未选择');
$IndustryRs = $maindb->Execute("SELECT * FROM t_dict WHERE Type=5 AND IsShow=1 ORDER BY OrderBy");
while(!$IndustryRs->EOF)
{
	$IndustryArr[$IndustryRs->fields['Code']] = $IndustryRs->fields['Called'];
	$IndustryRs->MoveNext();
}

$typeArr = array('0'=>'未选择');
$typeRs = $maindb->Execute("SELECT * FROM t_dict WHERE Type=3 AND IsShow=1 ORDER BY OrderBy");
while(!$typeRs->EOF)
{
	$typeArr[$typeRs->fields['Code']] = $typeRs->fields['Called'];
	$typeRs->MoveNext();
}

$boolArr = array('0'=>'否','1'=>'是');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<style type="text/css">
<!--
@import url("css.css");
-->
</style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form method="post" name="form" action="">
<tr align="center" valign="middle">
  <td width="23" height="50">&nbsp;</td>
  <td width="32"><img src="images/icon_arow_list.gif" width="7" height="7"></td>
  <td width="507" align="left" valign="middle" class="le"> 网站基本信息</td>
  <td width="215" align="left">&nbsp;</td>
</tr>
<tr align="center" valign="middle">
  <td colspan="4"><table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr align="left" valign="top" class="cn">
	  <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td>
		  <div class="titlelist">
			<?
	if (isset($adminObj))
	{
	?>
	<table width="98%" cellspacing="1" cellpadding="4">
	<!--<tr>
		<td align="right">公司名称:</td>
		<td><?=$adminObj->USERCALLED?></td>
		<td align="right">网站类型:</td>
		<td><?=$typeArr[$adminObj->SITETYPE]?></td>
	</tr>
	<tr>
		<td align="right">行业:</td>
		<td><?=$IndustryArr[$adminObj->INDUSTRY]?></td>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td align="right">网站金额:</td>
		<td><?=$adminObj->AMOUNT?></td>
		<td align="right">域名:</td>
		<td><?=$adminObj->ISPOINTING?></td>
	</tr>-->
	<!--<tr>
		<td align="right">网站容量:</td>
		<td><?=$adminObj->SPACE?>MB</td>
		<td align="right">数据库容量:</td>
		<td><?=$adminObj->DATABASE?>MB</td>
	</tr>
	<tr>
		<td align="right">已用网站容量:</td>
		<td><?=$usedSpace?>MB</td>
		<td align="right">已用数据库容量:</td>
		<td><?=$usedDatabase?>MB</td>
	</tr>
	<tr>
		<td align="right">开始时间:</td>
		<td><?=$adminObj->SERVICESTART?></td>
		<td align="right">结束时间:</td>
		<td><?=$adminObj->SERVICEEND?></td>
	</tr>-->
	</table>
	<?
	}
	?>
		  </div>
		  </td>
		</tr>
	  </table></td>
	</tr>
  </table></td>
</tr>
</form>
</table>
</body>
</html>