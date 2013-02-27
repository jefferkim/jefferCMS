<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

$id = $_REQUEST['id'];
$memberRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_user WHERE id=?",array($id));
$memberObj = $memberRs->FetchObject();
$userName = $memberObj->USERNAME;
$password = $memberObj->PASSWORD;
$isLock = $memberObj->ISLOCK;
$called = $memberObj->CALLED;
$company = $memberObj->COMPANY;
$tel = $memberObj->TEL;
$mobile = $memberObj->MOBILE;
$mail = $memberObj->MAIL;
$language = $memberObj->LANGUAGE;

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $memberRs->fields[$fieldObj->FIELDNAME];
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}

$text_customerFieldArr = array();
$text_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' and UiType='textarea' ORDER BY id");
while (!$text_fieldRs->EOF)
{
	$text_fieldObj = $text_fieldRs->FetchObject();
	$text_fieldObj->SETVALUE = $memberRs->fields[$text_fieldObj->FIELDNAME];
	$text_customerFieldArr[] = $text_fieldObj;
	$text_fieldRs->MoveNext();
}


$deltext_customerFieldArr = array();
$deltext_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' and UiType<>'textarea' ORDER BY id");
while (!$deltext_fieldRs->EOF)
{
	$deltext_fieldObj = $deltext_fieldRs->FetchObject();
	$deltext_fieldObj->SETVALUE = $memberRs->fields[$deltext_fieldObj->FIELDNAME];
	$deltext_customerFieldArr[] = $deltext_fieldObj;
	$deltext_fieldRs->MoveNext();
}
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
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>  
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="../js/jquery_select.js"></script>
<script>
function getCustomerData()
{
	return $.param({<?
	$arr = array();
	foreach($customerFieldArr as $fieldObj)
	{
		$type = "";
		switch($fieldObj->UITYPE)
		{
			case "text":
				$type = "input";
				break;
			case "textarea":
				$type = "textarea";
				break;
			case "select":
				$type = "select";
				break;
		}
		if($type=="select"){
			$arr[] = $fieldObj->FIELDNAME.':$("input[name='.$fieldObj->FIELDNAME.']").val()';
			
		}else{
		
		$arr[] = $fieldObj->FIELDNAME.':$("'.$type.'[name='.$fieldObj->FIELDNAME.']").val()';
		}
	}
	echo implode(",",$arr);
	?>});
}

function check()
{
	var userName = $("input[name=username]").val();
	var password = $("input[name=password]").val();

	if (userName == "")
	{
		alert('请填写用户名');
		$("input[name=username]").focus();
		return;
	}
	if (password == "")
	{
		alert("请填写密码");
		$("input[name=password]").focus();
		return;
	}

	var data = $.param({
		action:'edit',
		id:$("input[name=id]").val(),
		username:userName,
		password:password,
		called:$("input[name=called]").val(),
		tel:$("input[name=tel]").val(),
		mobile:$("input[name=mobile]").val(),
		mail:$("input[name=mail]").val(),
		company:$("input[name=company]").val(),
		islock:$("select[name=islock]").val(),
		language:$("select[name=language]").val()
	});

	data = data + "&" + getCustomerData();

	AjaxSet("membersave.php",data,function(data)
	{
		alert(data['result']);
		if (data['result'] == "修改成功")
		{
			//window.close();
			window.back();
		}
	});
}

$(function()
{
	$("input[type=submit]").click(check);

	$("input[type=reset]").click(ClearInput);
});

$(function(){
	$("#islock").sBox({animated:true});
	$("#language").sBox({animated:true});
	<?
	foreach($customerFieldArr as $fieldObj)
	{
		if($fieldObj->UITYPE=="select"){
			?>
			
			
			$("#<?=$fieldObj->FIELDNAME?>").sBox({animated:true});
			
			<?	
		}
		
	}
	?>
})
</script>
</head>

<body style="background:#FFF;">

<?
if (!UserIsInRole('J2',$userRole))
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
    <span style="font-weight:bold">位置：</span>会员信息管理 — 会员信息修改
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
    <input type="hidden" name="id" value="<?=$id?>">
          <?include_once("membereditview.php")?>
 </div>
  
    </td>
    
  </tr>
  
</table>
</body>
</html>


