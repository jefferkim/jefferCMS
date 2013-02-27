<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$editMode = false;
$called = "";
$currentLan = "";
$memo = "";
$lanArr = $SysConfig['customerLanguage'];

$customerFieldArr = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_pictype' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = "";
	$customerFieldArr[] = $fieldObj;
	$fieldRs->MoveNext();
}


$text_customerFieldArr = array();
$text_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_pictype' and UiType='textarea' ORDER BY id");
while (!$text_fieldRs->EOF)
{
	$text_fieldObj = $text_fieldRs->FetchObject();
	$text_fieldObj->SETVALUE = "";
	$text_customerFieldArr[] = $text_fieldObj;
	$text_fieldRs->MoveNext();
}


$deltext_customerFieldArr = array();
$deltext_fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_pictype' and UiType<>'textarea' ORDER BY id");
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
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script src="typesave.js"></script>

<?
$count=count($customerFieldArr);
if($count>0){
?>
<script src="../js/jquery_select.js"></script>
<script type="text/javascript">
$(document).ready(function()         
         {
var h=$(window).height()-40; //浏览器当前窗口可视区域高度

$("#box").css("height",h+"px");

}
         )
		 
$(function(){
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
<?
}
?>

</head>

<body style="background:#FFF;">

<?
if (!UserIsInRole('G6',$userRole))
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
    <span style="font-weight:bold">位置：</span>图片信息管理 — 图片分类添加
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
<input type="hidden" name="action" value="add">
          <input type="hidden" name="id" value="">
          <?include_once("typeeditview.php")?>
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>



</html>