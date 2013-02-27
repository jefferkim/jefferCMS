<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

$editMode = false;
$position = "";
$specialty = "";
$age = "";
$currentSex = '不限';
$nums = "";
$educational = "";
$salary = "";
$experience = "";
$endTime = date("Y-m-d");
$currentShow = 1;
$currentLan = "cn";
$orderBy = 1;
$memo = "";

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];
$sexArr = array(
	'不限' => '不限',
	'男' => '男',
	'女' => '女'
);

$custdb = $SysConfig['customerdb'];
$jobRs = $custdb->Execute("SELECT * FROM t_job ORDER BY OrderBy DESC LIMIT 0,1");
if ($jobRs->RecordCount() == 1)
{
	$orderBy = $jobRs->fields['OrderBy']+1;
}

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = "";
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}

$text_customerFieldArr = array();
$text_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' and UiType='textarea' ORDER BY id");
while (!$text_fieldRs->EOF)
{
	$text_fieldObj = $text_fieldRs->FetchObject();
	$text_fieldObj->SETVALUE = "";
	$text_customerFieldArr[] = $text_fieldObj;
	$text_fieldRs->MoveNext();
}


$deltext_customerFieldArr = array();
$deltext_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' and UiType<>'textarea' ORDER BY id");
while (!$deltext_fieldRs->EOF)
{
	$deltext_fieldObj = $deltext_fieldRs->FetchObject();
	$deltext_fieldObj->SETVALUE = "";
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
<link rel="stylesheet" type="text/css" href="<?=$SysConfig['jsroot']?>/ui.datepicker.css" />
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/ui.datepicker.js"></script>
<script src="<?=$SysConfig['jsroot']?>/ui.datepicker-zh-CN.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="../js/jquery_select.js"></script>
<script>
var editMode = false;

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
	var position = $("input[name=position]").val();
	if (position == "")
	{
		alert('请填写招聘职位');
		$("input[name=position]").focus();
		return;
	}
	var orderBy = $("input[name=orderby]").val();

	var language = '';
	$("input[name=language]").each(function()
	{
		if ($(this).attr("checked"))
		{
			if (language == '')
			{
				language = $(this).val();
			}
			else
			{
				language += ',' + $(this).val();
			}
		}
	});


	if (language == "")
	{
		alert("请选择语言");
		return;
	}

	var customerData = getCustomerData();
	var data = $.param({
		action:'add',
		position:position,
		specialty:$("input[name=specialty]").val(),
		age:$("input[name=age]").val(),
		sex:$("input[name=sex]").val(),
		nums:$("input[name=nums]").val(),
		educational:$("input[name=educational]").val(),
		experience:$("input[name=experience]").val(),
		salary:$("input[name=salary]").val(),
		endtime:$("input[name=endtime]").val(),
		isshow:$("input[name=isshow]").val(),
		orderby:$("input[name=orderby]").val(),
		language:language,
		memo:$("textarea[name=memo]").val()
	});
	data = data +"&"+ customerData;

	AjaxSet("jobsave.php",data,function(data)
	{
	    alert(data['result']);
		var endtime = $("input[name=endtime]").val()
		ClearInput();
		orderBy++;
		$("input[name=orderby]").val(orderBy);
		$("input[name=endtime]").val(endtime);
	});
}

$(function()
{
	$("input[name=endtime]").datepicker();
	
	$("input[type=submit]").click(check);
	$("input[type=reset]").click(ClearInput);
});

$(function(){
	$("#sex").sBox({animated:true});
	$("#isshow").sBox({animated:true});
	
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
if (!UserIsInRole('K1',$userRole))
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
    <span style="font-weight:bold">位置：</span>招聘信息管理 — 招聘信息添加
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">

  <?include_once("jobeditview.php")?>
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>

</html>


