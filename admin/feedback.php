<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$maindb = $SysConfig['maindb'];

if (isset($_POST['feedcontent']) && trim($_POST['feedcontent'])!="")
{
	$content = $_POST['feedcontent'];
	$customerId = $_SESSION['SWEBADMIN_USERID'];

	$rs = $maindb->Execute("SELECT Status FROM t_admin WHERE id=?",array($customerId));
	$status = $rs->fields['Status'];

	$record['CustomerID'] = $customerId;
	$record['Content'] = $content;
	$record['StatusID'] = $status;
	$record['EnterDate'] = date("Y-m-d H:i:s");
	$maindb->AutoExecute('t_feedback',$record,'INSERT');
}

$pagelink = "feedback.php";
$querystring = GetRequestString(array("page"));
$pagelink = $pagelink."?".$querystring;

$page = 1;
if (isset($_REQUEST['page']) && $_REQUEST['page'] >1)
	$page = $_REQUEST['page'];
$lines = 5;
$start = ($page - 1) * $lines;

$feedbackRs = $maindb->Execute("SELECT count(id) FROM t_feedback WHERE CustomerID=?",array($_SESSION['SWEBADMIN_USERID']));
$counts = $feedbackRs->fields[0];

$feedbackRs = $maindb->Execute("SELECT * FROM t_feedback WHERE CustomerID=? ORDER BY id DESC LIMIT ?,?",array($_SESSION['SWEBADMIN_USERID'],$start,$lines));

$pager = new Pager($pagelink,$counts,$page);
$pager->setLines($lines);
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
$(function()
{
	$("#btnSave").click(function()
	{
		if ($("textarea[name='feedcontent']").val() == "")
		{
			alert("请填写反馈内容");
			return false;
		}

		return true;
	});
})
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form method="post" name="form" action="">
<tr align="center" valign="middle">
  <td width="23" height="50">&nbsp;</td>
  <td width="32"><img src="images/icon_arow_list.gif" width="7" height="7"></td>
  <td width="507" align="left" valign="middle" class="le"> 网站信息反馈</td>
  <td width="215" align="left">&nbsp;</td>
</tr>
<tr align="center" valign="middle">
  <td colspan="4"><table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr align="left" valign="top" class="cn">
	  <td>
	    <div class="blueborder">
		<?
		while (!$feedbackRs->EOF)
		{
			$feedbackObj = $feedbackRs->FetchObject();
		?>
		<pre><?=$feedbackObj->CONTENT;?><br />反馈时间：<?=$feedbackObj->ENTERDATE?>
		</pre>
		<?
			$feedbackRs->MoveNext();
		}

		if ($counts > $lines)
		{
			echo "<div class='pager'>".$pager->render()."</div>";
		}
		?>
		</div>
		<div>
		<form action="" method="post" name="feedform">
		反馈内容：<br />
		<textarea name="feedcontent" rows="6" cols="60"></textarea><br />
		<input type="submit" id="btnSave" value="提交" class="btnstyle"><input type="reset" value="重填" class="btnstyle">
		</form>
		</div>
	  </td>
	</tr>
  </table></td>
</tr>
</form>
</table>
</body>
</html>