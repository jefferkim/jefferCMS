<?php
include_once("../config.php");
include_once("stat_function.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('P0',$userRole))
{
	echo '没有权限访问';
	exit();
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



</head>
<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>统计中心 — 数据统计
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">



      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">数据统计</td>
    </tr>
    
    
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
    <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">产品统计：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_products")?></span> 个产品信息</td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">订单统计：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_order")?></span> 份产品订单信息</td>
    </tr>
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">新闻统计：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_news")?></span> 条新闻信息</td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">下载统计：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_download")?></span> 条下载信息</td>
    </tr>
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">图片统计：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_pic")?></span> 张图片信息</td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">会员统计：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_user")?></span> 人注册会员</td>
    </tr>
    
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">招聘统计：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_job")?></span> 条招聘信息</td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">应聘统计：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_career")?></span> 人应聘您的职位</td>
    </tr>
    
     <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">留言统计：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_guestbook")?></span> 条网站留言信息</td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">反馈统计：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><span style="color:#F00; font-weight:bold"><?=stat_num("t_feedback")?></span> 条客户反馈信息</td>
    </tr>
    
      <tr>
    
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right">网站总访问量：</td>
    <td width="35%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;">总共有 <span style="color:#F00; font-weight:bold"><?=stat_num("t_flow")?></span> 人访问您的网站</td>
    <td width="13%" height="30" bgcolor="#F6FAFD" align="right">网站日访问量：</td>
    <td width="40%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;">今天总共有 <span style="color:#F00; font-weight:bold"><?=day_num("t_flow")?></span> 人访问您的网站</td>
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