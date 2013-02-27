<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$customRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_custom WHERE id=1");
$custom = $customRs->FetchObject();
$custom1 = $custom->CUSTOM1;
$custom2 = $custom->CUSTOM2;	


$linkList = array();

 //内容自定义字段添加   
if (UserIsInRole('D4',$userRole))
{	
	$link = new Linker("t_content","内容管理","btnZdy");
	$link->target = "";
	$linkList[] = $link;
	
}

//产品
if (UserIsInRole('F11',$userRole))
{
	$link = new Linker("t_products","产品管理","btnZdy");
	$linkList[] = $link;
}
//产品分类
if (UserIsInRole('F12',$userRole))
{
	$link = new Linker("t_protype","产品分类","btnField");
	$link->target = "";
	$linkList[] = $link;
}
//求购
if (UserIsInRole('CB3',$userRole))
{
	$link = new Linker("t_buy","求购管理","btnZdy");
	$linkList[] = $link;
}
//下载
if (UserIsInRole('H11',$userRole))
{
	$link = new Linker("t_download","下载管理","btnField");
	$link->target = '';
	$linkList[] = $link;
}
//下载分类
if (UserIsInRole('H11',$userRole))
{
	$link = new Linker("t_downloadtype","下载分类","btnField");
	$link->target = '';
	$linkList[] = $link;
}
//人才招聘
if (UserIsInRole('K11',$userRole))
{
	$link = new Linker("t_job","人才招聘","btnField");
	$link->target = '';
	$linkList[] = $link;
}
//会员
if (UserIsInRole('J11',$userRole))
{
	$link = new Linker("t_user","会员管理","btnAdd");
	$link->target = "_blank";
	$linkList[] = $link;
}
//图片
if (UserIsInRole('G11',$userRole))
{
	$link = new Linker("t_pic","图片管理","#");
	$linkList[] = $link;
}
//图片分类
if (UserIsInRole('G11',$userRole))
{
	$link = new Linker("t_pictype","图片分类","btnField");
	$linkList[] = $link;
}
//新闻
if (UserIsInRole('E11',$userRole))
{
	$link = new Linker("t_news","新闻管理","btnFields");
	$linkList[] = $link;
}
//新闻分类
if (UserIsInRole('E11',$userRole))
{
	$link = new Linker("t_newtype","新闻分类","btnFields");
	$link->target = "";
	$linkList[] = $link;
}

//留言管理
if (UserIsInRole('I4',$userRole))
{
	$link = new Linker("t_guestbook","留言管理","btnFields");
	$link->target = "";
	$linkList[] = $link;
}
if (UserIsInRole('B3',$userRole))
{
	$link = new Linker("t_custom1","".$custom1."管理","btnFields");
	$link->target = "";
	$linkList[] = $link;
}

if (UserIsInRole('B7',$userRole))
{
	$link = new Linker("t_custom2","".$custom2."管理","btnFields");
	$link->target = "";
	$linkList[] = $link;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>

</head>

<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>基础信息管理 — 自定义字段管理
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
    <?php
         if(count($linkList)>0)
		 {
		 ?>
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" >
         <tr>
            <td width="7%" align="center" class="td_title"><input type="checkbox" value='' name="chk"></td>
            <td width="78%"  class="td_title" style="padding-left:10px;">名称</td>
            <td width="15%" align="center">操作</td>
        </tr>
    <?php
	  $i=0;
		  foreach($linkList as $link)
		  {
			  $id = "";
			  if ($link->id != "")
				$id = ' id="'.$link->id.'"';
			  $target = "";
			  if ($link->target != "")
				  $target = ' target="'.$link->target.'"';
	
			if($i%2!=0){	  
		  ?>
     <tr class="two_tr">
     	    <td width="7%" height="30" align="center"><input type="checkbox" value='' name="chk"></td>
            <td width="78%" height="30" class="title_td"><?php echo $link->name;?></td>
            <td width="15%" height="30" align="center" class="title_td"> 
            <a href="fieldadd.php?table=<?php echo $link->link;?>"><img src="../images/22.gif" width="14" height="14" class="img_ico">添加</a>&nbsp;&nbsp;
            <a href="fields.php?table=<?php echo $link->link;?>"><img src="../images/33.gif" width="14" height="14" class="img_ico">管理</a></td>
    </tr>
    
    <?php
			}else{
	?>
    
    <tr>
     	    <td width="7%" height="30" align="center"><input type="checkbox" value='' name="chk"></td>
            <td width="78%" height="30" class="title_td"><?php echo $link->name;?></td>
            <td width="15%" height="30" align="center" class="title_td"> 
            <a href="fieldadd.php?table=<?php echo $link->link;?>"><img src="../images/22.gif" width="14" height="14" class="img_ico">添加</a>&nbsp;&nbsp;
            <a href="fields.php?table=<?php echo $link->link;?>"><img src="../images/33.gif" width="14" height="14" class="img_ico">管理</a></td>
    </tr>
    
    <?php
			}
	$i++;
		  }
	?>
    
    </table>
    <?
	
		 }
	?>
 </div>
  
    </td>
  </tr>
</table>




</body>
</html>


