<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$Arr = array("reply","show");
$id = $_REQUEST['id'];
$ation = $Arr[$_POST['action']];

$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_guestbook WHERE id=?",array($id));
$obj = $rs->FetchObject();
$obj->LANGUAGE = $SysConfig['language'][$obj->LANGUAGE];


$customerArray = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_guestbook' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$fieldObj->SETVALUE = $rs->fields[$fieldObj->FIELDNAME];
	$customerArray[] =$fieldObj;
	$fieldRs->MoveNext();
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

div{ overflow:visible;}

</style>

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
    <span style="font-weight:bold">位置：</span>客户留言信息管理 — 客户留言详细内容
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">



      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">客户留言详细内容</td>
    </tr>
    
    
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
    <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">留言主题：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$obj->SUBJECT?></td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">用户姓名：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$obj->USERNAME?></td>
    </tr>
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">公司名称：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$obj->COMPANY?></td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">电子邮件：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$obj->MAIL?></td>
    </tr>
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">网站地址：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$obj->WEB?></td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">留言时间：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$obj->NOTETIME?></td>
    </tr>
    
    
   <?
	$i=0;
	$j=1;
	$count=count($customerArray);
    foreach($customerArray as $fieldObj){
	  
	  if($count%2!=0 && $j==$count){
	  
  ?>
  <tr>

  	<td height="30" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td height="30" colspan="3" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$fieldObj->SETVALUE?></td>
    </tr>
    
 <?
	  }else{
 ?>   
    
    
   <?
if($i%2==0){
?>

<tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td height="30"  bgcolor="#FFFFFF" style="padding-left:10px;"><?=$fieldObj->SETVALUE?></td>
    
<?
}else{
?>    
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$fieldObj->SETVALUE?></td>
</tr> 
    
    
  <?
      }
	  }
 $i++;
 $j++;
  }
  ?>  
  

    
    
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">客户IP：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" colspan="3" style="padding-left:10px;"><?=$obj->IP?></td>

    </tr>
    
      <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">留言内容：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" colspan="3" style="padding-left:10px;"><?=$obj->CONTENT?></td>

    </tr>
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">留言回复：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" colspan="3" style="padding-left:10px;"><?php 
		if($obj->REPLY!="")
			echo $obj->REPLY;
		else
			echo '<font color="#FF0000">暂无回复！</font>';
		?></td>

    </tr>
    

    

    </table>
    
    
    </table>
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>



</body>
</html>