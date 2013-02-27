<?php
include_once("../config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<link media="screen" rel="stylesheet" href="../colorbox/colorbox.css" />
<script src="../js/ps_jquery.js"></script>
<script src="../colorbox/js/jquery.colorbox.js"></script>
<script>
	$(document).ready(function(){
	$(".example6").colorbox({iframe:true, innerWidth:770, innerHeight:400});
	});
</script>     
<style>
div{ overflow:visible;}
</style>
</head>


<body style="background:#FFF;">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>系统公告信息 — 系统公告信息查看
   </div>
  <div id="box" style="overflow-y:auto; vertical-align:top; margin-top:5px;">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>

     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
     
      <thead>
      
          <tr>
            <td width="4%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="4%"  align="center" class="td_title">编号</td>
            <td width="54%" align="center" class="td_title">新闻标题</td>
            <td width="10%"  align="center" class="td_title">是否推荐</td>
            <td width="16%" align="center" class="td_title">更新时间</td>
            <td width="12%" align="center" >操作</td>
            </tr>
            </thead>
            
    <?
$linkurl = $_SERVER['PHP_SELF']."?";
$page = 1;
$pageCounts = 10;
$where = "WHERE 1=1";
if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
{
	$page = $_REQUEST['page'];
}
$newsRs = $SysConfig['maindb']->Execute("SELECT COUNT(*) FROM t_news ".$where);
$counts = $newsRs->fields[0];
$start = ($page - 1) * $pageCounts;
$newsRs = $SysConfig['maindb']->Execute("SELECT * FROM t_news $where ORDER BY NoteTime DESC LIMIT $start,$pageCounts");
?>

 <?
 $i=0;
while (!$newsRs->EOF)
{
$newsObj = $newsRs->FetchObject();
if($i%2==0){
	?>        
<tr>
<td valign="middle" align="center"><input type="checkbox" name="chk<?=$newsObj->ID?>" value="<?=$newsObj->ID?>"></td>

<td valign="middle" height="30" align="center"><?=$newsObj->ID?></td>
<td valign="middle" align="left" style="padding-left:10px;"><a class="example6" href="sys_newsd.php?nid=<?=$newsObj->ID?>"><?=$newsObj->TITLE?></a></td>
<td valign="middle" align="center"><?if($newsObj->ISCOMMEND==1){echo "是";}else{echo "否";}?></td>
<td valign="middle" align="center"><?=$newsObj->NOTETIME?></td>
<td valign="middle" align="center"><a class="example6" href="sys_newsd.php?nid=<?=$newsObj->ID?>">查看</a></td>
</tr>


<?
}else{
?>

<tr class="two_tr">
<td valign="middle" align="center"><input type="checkbox" name="chk<?=$newsObj->ID?>" value="<?=$newsObj->ID?>"></td>

<td valign="middle" height="30" align="center"><?=$newsObj->ID?></td>
<td valign="middle" align="left" style="padding-left:10px;"><a class="example6" href="sys_newsd.php?nid=<?=$newsObj->ID?>"><?=$newsObj->TITLE?></a></td>
<td valign="middle" align="center"><?if($newsObj->ISCOMMEND==1){echo "是";}else{echo "否";}?></td>
<td valign="middle" align="center"><?=$newsObj->NOTETIME?></td>
<td valign="middle" align="center"><a class="example6" href="sys_newsd.php?nid=<?=$newsObj->ID?>">查看</a></td>
</tr>

            
  <?
}
	$newsRs->MoveNext();
	$i++;
}
?>        

<?
$pager = new Pager($linkurl,$counts,$page,$pageCounts);
$pager->setPrevText('上一页');
$pager->style=2;
$pager->setNextText('下一页');


?> 
      <thead>
 <tr>
      <td colspan="11" height="30"  align="center" class="btn_line">
      
     
<div id="pager" class="pagination1"><?=$pager->render();?></div>
</td>
</tr>
</thead>
    </table>
  
 </div>
  
    </td>
  </tr>
</table>



</body>

</html>




