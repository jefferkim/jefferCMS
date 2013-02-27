<?php
	include_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<style>
body{background:url(images/login_bj.jpg) repeat-x left top #0063aa; margin:0 auto; padding:0px; font-size:12px;}
</style>
</head>

<script src="<?echo $SysConfig['jsroot']?>/jquery.js"></script>
<script>
$(function(){
	
	$("form[name=form1]").submit(Login);
	$("#btnCancel").click(function(){
		$("#username").val('').focus();
		$("#password").val('');
	});

	$(document).keydown(function(event){
		if (event.keyCode == 13)
		{
			Login();
		}
	});

	function Login()
	{
		if ($("#username").val() == "")
		{
			alert('请填写用户名！');
			$("#username").focus();
			return false;
		}
		if ($("#password").val() == "")
		{
			alert("请填写密码！");
			$("#password").focus();
			return false;
		}

		$("form[name=form1]").submit();
	}
})
</script>

<body>
<form name="form1" method="post" action="loginvalidate.php">


<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle">
    
    <div class="login_bj">
    <span class="login_top"></span>
 
    <div class="login_left">
       
      <span> <input type="text" name="username" id="username" class="login_input" /></span>
    
    
      <span class="login_two_span"> <input type="password" name="password" id="password"  class="login_input" /></span>
    
    
    </div>
    
    <div class="login_right_btn">
    
    
    <input type="submit" name="submit" value="" class="login_btn" />
    
    
    
    </div>
    
    <br style="clear:both" />
    
    <span class="login_foot">版权所有：浙江派桑网络有限公司</span>
    
    
    </div>
    
    
    </td>
  </tr>
</table>
</form>
</body>
</html>
