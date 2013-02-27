<?php
include_once("../config.php");
include_once("products.function.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];


$called = "";
$orderBy = 1;
$currentLan = "";
$currentShow = 1;
$memo = "";
$currentType = "";
$oldpic = "";
$editMode = false;

$id = $_REQUEST['id'];
$typeRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_protype WHERE id=?",array($id));
if ($typeRs->RecordCount() >0)
{
	$typeObj = $typeRs->FetchObject();
	$called = $typeObj->CALLED;
	$orderBy = $typeObj->ORDERBY;
	$currentLan = $typeObj->LANGUAGE;
	$currentShow = $typeObj->ISSHOW;
	$oldpic = $typeObj->PICURL;
	$memo = FckReplace($typeObj->MEMO,$SysConfig['PHPUPLOADDIR'].$_SESSION['SWEBADMIN_USERNAME']."/",false);
	$currentType = $typeObj->PID;
}
   $currentLanguage = $typeObj->LANGUAGE;

$showArr = $SysConfig['yesnoarray'];
$lanArr = $SysConfig['customerLanguage'];

$typeArr = array(0=>'无父类');
$subTypeArr = GetSubType($SysConfig['customerdb'],0,$id,$currentLan,$customerLanArr);
$typeArr = $typeArr + $subTypeArr;


$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_protype' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $typeRs->fields[$fieldObj->FIELDNAME];
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}


$text_customerFieldArr = array();
$text_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_protype' and UiType='textarea' ORDER BY id");
while (!$text_fieldRs->EOF)
{
	$text_fieldObj = $text_fieldRs->FetchObject();
	$text_fieldObj->SETVALUE = $typeRs->fields[$text_fieldObj->FIELDNAME];
	$text_customerFieldArr[] = $text_fieldObj;
	$text_fieldRs->MoveNext();
}


$deltext_customerFieldArr = array();
$deltext_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_protype' and UiType<>'textarea' ORDER BY id");
while (!$deltext_fieldRs->EOF)
{
	$deltext_fieldObj = $deltext_fieldRs->FetchObject();
	$deltext_fieldObj->SETVALUE = $typeRs->fields[$deltext_fieldObj->FIELDNAME];
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
var rooturl = "<?echo globalpath();?>";
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
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ocupload-1.1.2.js"></script>
<script src="typesave.js"></script>
<script src="../js/jquery_select.js"></script>
<script type="text/javascript">
		 
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
if (!UserIsInRole('F7',$userRole))
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
    <span style="font-weight:bold">位置：</span>产品信息管理 — 产品分类修改
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">

   <input type="hidden" name="action" value="edit">
		<input type="hidden" name="id" value="<?=$id?>">
          <?include_once("typeeditview.php")?>
   
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>

</html>