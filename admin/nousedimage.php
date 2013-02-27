<?php
include_once("config.php");
include_once(ROOTDIR."lib/folder.class.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

if ($_SESSION['SWEBADMIN_USERNAME']=="")
{
	exit;
}


echo ROOTDIR.$_SESSION['SWEBADMIN_USERNAME']."/upload";
$folder = new Folder();
$arr = $folder->readFolder("../upload");
$fileArr = $arr[1];
$nousedFileArr = array();

$len = count($fileArr);
for ($i=0; $i<$len; $i++)
{
	if (NoUsedFile($SysConfig['customerdb'],$fileArr[$i]))
	{
		$nousedFileArr[] = $fileArr[$i];
	}
}

if (isset($_GET['action']) && $_GET['action']=="delall")
{
	$len = count($nousedFileArr);
	for ($i=0; $i<$len; $i++)
	{
		unlink(ROOTDIR.$_SESSION['SWEBADMIN_USERNAME']."/upload/".$nousedFileArr[$i]);
	}
	$nousedFileArr = array();
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
@import url("css.css");
-->
</style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script>
function delall()
{
	if (window.confirm("确定要全部删除吗?"))
	{
		location.href="nousedimage.php?action=delall";
	}
}
</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="center" valign="middle">
  <td width="23" height="50">&nbsp;</td>
  <td width="32"><img src="images/icon_arow_list.gif" width="7" height="7"></td>
  <td width="507" align="left" valign="middle" class="le"> 无效图片管理</td>
  <td width="215" align="left"><input type="button" value="全部删除" onclick="delall();"></td>
</tr>
<tr align="center" valign="middle">
  <td colspan="4">
  <div class="blueborder">
  <table width="100%" cellspacing="1" cellpadding="4" class="styletable">
	<?
	$len = count($nousedFileArr);
	for ($i=0; $i<$len; $i++)
	{
	?>
	<tr>
		<td><a href="../upload/<?=$nousedFileArr[$i]?>" target="_blank"><?=$fileArr[$i]?></a></td>
		<td><a href="../upload/<?=$nousedFileArr[$i]?>" target="_blank"><img src="../upload/<?=$nousedFileArr[$i]?>" height="30" width="30" border="0"></a></td>
		<td><a href="delnousedimage.php?file=<?=$nousedFileArr[$i]?>">删除</a></td>
	</tr>
	<?
	}
	?>
  </table>
  </div>
  </td>
</tr>
</table>
</body>
</html>
<?
function NoUsedFile($db,$file)
{
	$tableRs = $db->Execute("SHOW TABLES");
	while(!$tableRs->EOF)
	{
		$table = $tableRs->fields[0];
		
		$where = array();
		$fieldRs = $db->Execute("SHOW FIELDS FROM ".$table);
		while (!$fieldRs->EOF)
		{
			$fieldType = $fieldRs->fields['Type'];
			if ($fieldType == 'longtext' || $fieldType == 'text' || $fieldType == 'tinytext' || strpos($fieldType,'varchar') !== false)
			{
				if ($fieldRs->fields['Field'] != 'Language')
					$where[] = $fieldRs->fields['Field']." LIKE '%".$file."%'";
			}
			$fieldRs->MoveNext();
		}
		if (count($where) > 0)
		{
			$where = implode(" OR ",$where);
			$rs = $db->Execute("SELECT COUNT(*) FROM ".$table." WHERE ".$where);
			if ($rs->fields[0] > 0)
				return false;
		}

		$tableRs->MoveNext();
	}

	return true;
}
?>