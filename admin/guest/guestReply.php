<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$id = trim($_GET['id']);
$guestRs = $SysConfig['customerdb']->Execute("SELECT * FROM  t_guestbook WHERE id=?",array($id));
$guest = $guestRs->FetchObject();
$reply=$guest->REPLY;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
<script>
var g_language = '<? echo $SysConfig['currentLan'];?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery-impromptu.js"></script>
<script src="../js/linker.js"></script>

<script language="javascript">
$(function(){
	$("#btnReset").click(function(){
		$("textarea[name=reply]").val('');						  
	});
	
	$("#btnChange").click(function(){
		var id = $("#box").find("input[name=id]").val();
		var reply = $("#box").find("textarea[name=reply]").val();
		if(reply==""){
			alert("请填写回复！");
			return false;
		}
		
		AjaxSet("guestset.php",$.param({action:'reply',id:id,reply:reply}),function(data)
		{
			alert(data['result']);
			$("#box").find("textarea[name=reply]").val('');
			window.location.href = 'main.php?language=<?=$_REQUEST['language']?>';
		});
	});
});
</script>
</head>

<body style="background:#FFF;">

<?
if (!UserIsInRole('I0',$userRole))
{
    echo '<script>';
	echo 'alert("您没有权限访问！");';
	echo '</script>';
	exit();
}

?>


<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>留言信息管理 — 留言信息回复
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">留言信息回复</td>
    </tr>
    <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
   
				
  <tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right" valign="top" style="padding-top:10px;">回复内容：</td>
	<td width="88%" height="30" colspan="3" bgcolor="#FFFFFF" style="padding:10px;">
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <textarea name="reply" rows="7" cols="50" class="txt"><?=$reply?></textarea></td>
   
</tr>

 <tr>
 
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit" id="btnChange"> <input type="reset" value="" class="sys_reset" id="btnReset"> </td>
  </tr>
  
  </table>
  </td>
  </tr>
  
</table>

          
 </div>
  
    </td>
    
  </tr>
  
</table>

</body>


</html>




