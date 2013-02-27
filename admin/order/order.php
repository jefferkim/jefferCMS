<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$linkList = array();
$jsLinkList = array();

/*if (UserIsInRole('L11',$userRole))
{
	$link = new Linker("../field/fields.php?table=t_order","自定义字段","btnField");
	$linkList[] = $link;
}
*/
if (UserIsInRole('L1',$userRole))
{
	$link = new Linker("javascript:;","删除订单","btnDelete");
	$linkList[] = $link;
}

$lanArr = $SysConfig['customerLanguage'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<script>
var g_language = '<? echo $SysConfig['currentLan'];?>';
</script>
<link rel="stylesheet" type="text/css" href="<?=$SysConfig['jsroot']?>/ui.datepicker.css" />
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<link media="screen" rel="stylesheet" href="../colorbox/colorbox.css" />
<script src="../js/ps_jquery.js"></script>
<script src="../colorbox/js/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
$(".example6").colorbox({iframe:true, innerWidth:770, innerHeight:400});
});
</script>  
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/ui.datepicker.js"></script>
<script src="<?=$SysConfig['jsroot']?>/ui.datepicker-zh-CN.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery-impromptu.js"></script>
<script src="../js/linker.js"></script>
<script src="../js/jquery_select.js"></script>
<script src="order.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});	   
});

$(function(){

	$("#language").sBox({animated:true});
	
})
</script>

<style>

div{ overflow:visible}

</style>
</head>


<body style="background:#FFF;">
<?
if (!UserIsInRole('L0',$userRole))
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
    <span style="font-weight:bold">位置：</span>产品信息管理 — 产品订单信息<em id="total" style="font-weight:bold">
    
       <?
$where = "WHERE 1=1";
$orderRs = $SysConfig['customerdb']->Execute("SELECT COUNT(*) FROM t_order ".$where);
$counts = $orderRs->fields[0];

echo "【共有:".$counts."条记录】";
?>
</em>
   </div>
  <div id="box" style="overflow-y:auto; vertical-align:top">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>

     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
     
      <thead>
     
          <tr>
          
            <td width="4%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="4%"  align="center" class="td_title">编号</td>
            <td width="10%"  align="center" class="td_title">姓名</td>
            <td width="20%" align="center" class="td_title">公司名称</td>
            <td width="18%" align="center" class="td_title">联系电话</td>
            <td width="18%" align="center" class="td_title">电子邮件</td>
            <td width="14%" align="center" class="td_title">下单时间</td>
            <td width="12%" align="center" >操作</td>
            </tr>
            </thead>
             <tbody>
             
             
               <?
$linkurl = $_SERVER['PHP_SELF']."?";
$page = 1;
$pageCounts = 10;

$where = "WHERE 1=1";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
{
	$page = $_REQUEST['page'];
}
$orderRs = $SysConfig['customerdb']->Execute("SELECT COUNT(*) FROM t_order ".$where);
$counts = $orderRs->fields[0];
$start = ($page - 1) * $pageCounts;
$orderRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_order $where ORDER BY NoteTime DESC LIMIT $start,$pageCounts");
?>

 <?
 $i=0;
while (!$orderRs->EOF)
{
$orderObj = $orderRs->FetchObject();
if($i%2==0){
	?>        
<tr>
<td valign="middle" align="center"><input type="checkbox" name="chk<?=$orderObj->ID?>" value="<?=$orderObj->ID?>"></td>
<td valign="middle" height="30" align="center"><?=$orderObj->ID?></td>
<td valign="middle" align="center"><a class="example6" href="order.json.php?id=<?=$orderObj->ID?>"><?=$orderObj->NAME?></a></td>
<td valign="middle" align="center"><?=$orderObj->COMPANY?></td>
<td valign="middle" align="center"><?=$orderObj->TEL?></td>
<td valign="middle" align="center"><?=$orderObj->MAIL?></td>
<td valign="middle" align="center"><?=$orderObj->NOTETIME?></td>
<td valign="middle" align="center">
<a class="example6" href="order.json.php?id=<?=$orderObj->ID?>">查看</a>  
<a href="javascript:;" onclick="Del_id('<?=$orderObj->ID?>')">删除</a> 
</td>
</tr>


<?
}else{
?>

<tr class="two_tr">
<td valign="middle" align="center"><input type="checkbox" name="chk<?=$feedbackObj->ID?>" value="<?=$feedbackObj->ID?>"></td>
<td valign="middle" height="30" align="center"><?=$orderObj->ID?></td>
<td valign="middle" align="center"><a class="example6" href="guestsd.php?id=<?=$orderObj->ID?>"><?=$orderObj->NAME?></a></td>
<td valign="middle" align="center"><?=$orderObj->COMPANY?></td>
<td valign="middle" align="center"><?=$orderObj->TEL?></td>
<td valign="middle" align="center"><?=$orderObj->MAIL?></td>
<td valign="middle" align="center"><?=$orderObj->NOTETIME?></td>
<td valign="middle" align="center">
<a class="example6" href="order.json.php?id=<?=$orderObj->ID?>">查看</a>  
<a href="javascript:;" onclick="Del_id('<?=$orderObj->ID?>')">删除</a> 
</td>
</tr>          
  <?
}
	$orderRs->MoveNext();
	$i++;
}
?>        

<?
$pager = new Pager($linkurl,$counts,$page,$pageCounts);
$pager->setPrevText('上一页');
$pager->style=2;
$pager->setNextText('下一页');


?>  
             
             </tbody>
      <thead>
 <tr>
      <td colspan="11" height="30"  align="center" class="btn_line">
       <div class="pl_set" id="pl_set_bg">
         <?php
		  foreach($linkList as $link)
		  {
			  $id = "";
			  if ($link->id != "")
				$id = ' id="'.$link->id.'"';
			  $target = "";
			  if ($link->target != "")
				  $target = ' target="'.$link->target.'"';
		  ?>
                <span>
                <a href="<?=$link->link?>"<?=$id?><?=$target?>><?=$link->name?></a>
                </span>
               <?php
		  		}
			   ?>     
      
      </div>
      
      
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


