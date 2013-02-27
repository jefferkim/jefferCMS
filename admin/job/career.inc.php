<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('K5',$userRole))
{
	echo '没有权限访问';
	exit();
}
$id = $_REQUEST['id'];
$rs = $SysConfig['customerdb']->Execute("SELECT * FROM `t_career` WHERE id=?",array($id));
$obj = $rs->FetchObject();

$obj->LANGUAGE = $SysConfig['language'][$obj->LANGUAGE];

$carlen = explode("<br>",$obj->CONTENT);

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
    <span style="font-weight:bold">位置：</span>招聘信息管理 — 人才简历信息
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">



      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">人才简历信息</td>
    </tr>
    
    <tr>
     <td colspan="4">
    
     <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">

        <?php
            for($i=0;$i<count($carlen)-1;$i++){
				if($i%2==0) echo '<tr>';
				$datasoure = explode(":",$carlen[$i]);
				echo '<td width="16%" height="30"  bgcolor="#F6FAFD" align="right">'.$datasoure[0].'：</td>';
				echo '<td width="34%" id="lblPosition" bgcolor="#FFFFFF" style="padding-left:10px;">'.$datasoure[1].'</td>';
				if($i%2==1)  echo '</tr>';
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

