<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('O1',$userRole))
{
	exit();
}

$id = $_REQUEST['id'];
$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_feedback WHERE id=?",array($id));
$obj = $rs->FetchObject();
$obj->LANGUAGE = $SysConfig['language'][$obj->LANGUAGE];

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
    <span style="font-weight:bold">位置：</span>客户留言信息管理 — 客户留言详细内容
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">



      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">客户留言详细内容</td>
    </tr>
    
    <tr>
     <td colspan="4">
    
     <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">


   <?php
            $carlen = explode("<br />",$obj->CONTENT);
			
            for($i=0;$i<count($carlen)-2;$i++){
				if($i%2==0) echo '<tr>';
				$datasoure = explode(":",$carlen[$i]);
				echo '<td width="12%" height="30"  bgcolor="#F6FAFD" align="right">'.$datasoure[0].'：</td>';
				echo '<td width="38%" id="lblPosition" bgcolor="#FFFFFF" style="padding-left:10px;">'.$datasoure[1].'</td>';
				if($i%2==1)  echo '</tr>';
			}
			
			$datasoure = explode(":",$carlen[$i]);
			echo '<tr>
			<td width="12%" height="30"  bgcolor="#F6FAFD" align="right" valign="top" style="padding-top:10px;">'.$datasoure[0].'：</td>
			<td colspan="3" align="left" valign="middle" style="padding:10px;" bgcolor="#FFFFFF" height="30">'.$datasoure[1].'</td>
			</tr>';
			
			
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


