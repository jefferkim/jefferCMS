<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('L0',$userRole))
{
	exit();
}

$id = $_REQUEST['id'];
$orderRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_order WHERE id=?",array($id));
$orderObj = $orderRs->FetchObject();
$orderObj->LANGUAGE = $SysConfig['language'][$orderObj->LANGUAGE];
if($orderObj->ISPROCESS==0){
	
	$record = array(
		'IsProcess' => 1,
        );
	   $SysConfig['customerdb']->AutoExecute("t_order",$record,"UPDATE","id=".$orderObj->ID);
}

	


$customerArray = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_order' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$customerArray[] = array($fieldObj->CALLED,$orderRs->fields[$fieldObj->FIELDNAME]);
	$fieldRs->MoveNext();
}

$detailRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_orderdetail WHERE OrderID=? ORDER BY id",array($id));

$detailArr = array();
while (!$detailRs->EOF)
{
	$detailObj = $detailRs->FetchObject();
	$detailArr = $detailObj;
	$detailRs->MoveNext();
}
/*$result = array(
	'order' => $orderObj,
	'customer' => $customerArray,
	'details' => $detailArr
);

//echo json_encode($result);
*/
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



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>产品信息管理 — 产品订单详细内容
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">



      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">客户联系方式</td>
    </tr>
    
    <tr>
    
     <td colspan="4">
    
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
      
    <tr>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">姓名：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->NAME?></td>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">电子邮件：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->MAIL?></td>
    </tr>
    
    <tr>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">联系电话：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->TEL?></td>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">手机：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->MOBILE?></td>
    </tr>
    
      <tr>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">下单时间：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->NOTETIME?></td>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">语言：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->LANGUAGE?></td>
    </tr>
    
    
   <tr>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">公司名称：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->COMPANY?></td>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">公司地址：</td>
    <td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=$orderObj->ADDRESS?></td>
    </tr>
    
      <tr>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right" valign="top" style="padding-top:10px;">备注：</td>
    <td width="88%" height="30" colspan="3" bgcolor="#FFFFFF" valign="top" style="padding:10px;"><?=$orderObj->MEMO?></td>
 
    </tr>

    </table>
    </td>
    </tr>
    
   <tr class="table_title">
		<td  colspan="4" class="td_one">订购产品列表：</td>
	</tr>
    
 <tr>
  <td colspan="4" valign="top">   
     <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
     	
		<tr>
			<td width="25%" align="center" bgcolor="#F6FAFD" height="30">产品名称</td>
			<td width="25%" align="center" bgcolor="#F6FAFD" height="30">订购数量</td>
			<td width="25%" align="center" bgcolor="#F6FAFD" height="30">产品单价</td>
			<td width="25%" align="center" bgcolor="#F6FAFD" height="30">备注</td>
		</tr>
      
    
    <?
	$detailRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_orderdetail WHERE OrderID=? ORDER BY id",array($id));
	
    while(!$detailRs->EOF)
		{
		$detailObj = $detailRs->FetchObject();	

	?>
    

		<tr>
		  <td width="25%" align="center" height="30" bgcolor="#FFFFFF"><?php echo $detailObj->PRODUCTNAME;?></td>
		  <td width="25%" align="center" height="30" bgcolor="#FFFFFF"><?php echo $detailObj->NUMS;?></td>
		  <td width="25%" align="center" height="30" bgcolor="#FFFFFF"><?php echo $detailObj->PRICE;?></td>
		  <td width="25%" align="center"  height="30" bgcolor="#FFFFFF"><?php echo $detailObj->MEMO;?></td>
	  </tr>

    <?php
	$detailRs->MoveNext();
    }
	?>
    
    
  </table>  
  </td>  
  </tr>  
    
    </table>
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>



</body>
</html>

