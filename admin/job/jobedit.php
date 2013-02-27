<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$_SESSION['PHPUPLOADDIR'] = $SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/upload/";

$editMode = true;
$id = $_REQUEST['id'];
$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_job WHERE id=?",array($id));
$obj = $rs->FetchObject();
$position = $obj->POSITION;
$specialty = $obj->SPECIALTY;
$age = $obj->AGE;
$currentSex = $obj->SEX;
$nums = $obj->NUM;
$educational = $obj->EDUCATIONAL;
$salary = $obj->SALARY;
$experience = $obj->EXPERIENCE;
$endTime = $obj->ENDTIME;
$currentShow = $obj->ISSHOW;
$currentLan = $obj->LANGUAGE;
$orderBy = $obj->ORDERBY;
$memo = $obj->MEMO;

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];
$sexArr = array(
	'不限' => '不限',
	'男' => '男',
	'女' => '女'
);

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $rs->fields[$fieldObj->FIELDNAME];
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}

$text_customerFieldArr = array();
$text_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' and UiType='textarea' ORDER BY id");
while (!$text_fieldRs->EOF)
{
	$text_fieldObj = $text_fieldRs->FetchObject();
	$text_fieldObj->SETVALUE = $rs->fields[$text_fieldObj->FIELDNAME];
	$text_customerFieldArr[] = $text_fieldObj;
	$text_fieldRs->MoveNext();
}


$deltext_customerFieldArr = array();
$deltext_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_job' and UiType<>'textarea' ORDER BY id");
while (!$deltext_fieldRs->EOF)
{
	$deltext_fieldObj = $deltext_fieldRs->FetchObject();
	$deltext_fieldObj->SETVALUE = $rs->fields[$deltext_fieldObj->FIELDNAME];
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
<script src="<?=$SysConfig['jsroot']?>/ui.datepicker.js"></script>
<script src="<?=$SysConfig['jsroot']?>/ui.datepicker-zh-CN.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="../js/jquery_select.js"></script>
<script>
var editMode = true;

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

	var customerData = getCustomerData();
	var data = $.param({
		action:'edit',
		id:$("input[name=id]").val(),
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
		language:$("input[name=language]").val(),
		memo:$("textarea[name=memo]").val()
	});
	data = data +"&"+ customerData;

	AjaxSet("jobsave.php",data,function(data)
	{
		alert(data['result']);
		if (data['result'] == '修改成功')
		{
			window.close();
		}
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
    <span style="font-weight:bold">位置：</span>招聘信息管理 — 招聘信息修改
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">

 <input type="hidden" name="id" value="<?=$id?>">
          <?include_once("jobeditview.php")?>
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>

</body>
</html>


