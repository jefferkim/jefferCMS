<?php
/********************************************************
修改下载信息
**********************************************************/
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$editMode = false;
$id = $_REQUEST['id'];
$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_download WHERE id=?",array($id));
$downObj = $rs->FetchObject();
$called = $downObj->CALLED;
$currentLan = $downObj->LANGUAGE;
$currentShow = $downObj->ISSHOW;
$currentType = $downObj->TYPEID;
$fileUrl = $downObj->FILEURL;
$memo = $downObj->MEMO;
$currentLanguage = $downObj->LANGUAGE;

$lanArr = $SysConfig['customerLanguage'];
$showArr = $SysConfig['yesnoarray'];



$typeRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_downloadtype WHERE Language=? ORDER BY id",array($currentLan));
while (!$typeRs->EOF)
{
	$typeObj = $typeRs->FetchObject();
	$typeObj->LANGUAGE = $SysConfig['customerLanguage'][$typeObj->LANGUAGE];
	$typeArr[$typeObj->ID] = $typeObj->CALLED."(".$typeObj->LANGUAGE.")";
	$typeRs->MoveNext();
}

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_download' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $rs->fields[$fieldObj->FIELDNAME];
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}

$text_customerFieldArr = array();
$text_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_download' and UiType='textarea' ORDER BY id");
while (!$text_fieldRs->EOF)
{
	$text_fieldObj = $text_fieldRs->FetchObject();
	$text_fieldObj->SETVALUE = $rs->fields[$text_fieldObj->FIELDNAME];
	$text_customerFieldArr[] = $text_fieldObj;
	$text_fieldRs->MoveNext();
}


$deltext_customerFieldArr = array();
$deltext_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_download' and UiType<>'textarea' ORDER BY id");
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
<script>
var rooturl = "<?echo globalpath()?>";
//var uploadUser = "<?=$_SESSION['SWEBADMIN_USERNAME']?>";
var uploadurl = "<?=$SysConfig['swfupload']?>";
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
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ocupload-1.1.2.js"></script>
<script src="downloadsave.js"></script>
<script src="../js/jquery_select.js"></script>
<script>

$(function(){
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
if (!UserIsInRole('H2',$userRole))
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
    <span style="font-weight:bold">位置：</span>下载信息管理 — 下载信息修改
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
     <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?=$id?>">
        <?include_once("downloadeditview.php")?>
   
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>


</html>


